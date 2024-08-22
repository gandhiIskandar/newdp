<?php

namespace App\Livewire;

use App\Models\Expenditure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class RecapExpTable extends Component
{
    public $expenditures;

    public $rekap_type = 1;

    public $default_month = true;

    public $default_day = true;

    public $start_month;

    public $end_month;

    public $start_daily;

    public $end_daily;

    //rekap_type = 1 -> Harian sebagai inisiasi awal atau default awal
    //rekap_type = 2 -> Bulanan

    public function render()
    {
        $this->getData();

        // dd($this->expenditures);

        return view('livewire.recap-exp-table');
    }

    #[On('expCreated')]
    public function refreshTable()
    {
        $this->getData();
        $this->dispatch('returnDataExp', expenditures: $this->expenditures);
    }

    #[On('changeTypeRecapExp')]
    public function changeType($type)
    {

        $this->rekap_type = $type;

        $this->getData();

        $this->dispatch('returnDataExp', expenditures: $this->expenditures);
    }

    public function getDataQuery($timeCostum)
    {

        $user = Auth::user();

        return Expenditure::where('website_id', session('website_id'))->
         whereHas('user', function ($query) use ($user) {
             $query->whereHas('role', function ($query) use ($user) {
                $query->where('role_id', $user->role_id);
            });
         })->
        select(

            DB::raw($timeCostum),
            DB::raw('SUM(CASE WHEN currency_id = 1 THEN amount ELSE 0 END) as total_btc'),
            DB::raw('SUM(CASE WHEN currency_id = 2 THEN amount ELSE 0 END) as total_usd'),
            DB::raw('SUM(CASE WHEN currency_id = 3 THEN amount ELSE 0 END) as total_usdt'),
            DB::raw('CAST(SUM(CASE WHEN currency_id = 4 THEN amount ELSE 0 END) AS SIGNED) as total_idr'),

            //jika role_id = 2 maka akan masukan Marketing di column role(column role adalah column buatan sendiri dan tidak ada di tabel) selain dari itu maka akan cetak admin
            $user->role_id == 2 ? DB::raw('"Marketing" as role') : DB::raw('"Admin" as role ')

        )
            ->groupBy('date');
    }

    public function getData()
    {
        $currentDate = Carbon::now()->toDateString();

        if ($this->rekap_type == 1) {

            if ($this->default_day) {

                $this->expenditures = $this->getDataQuery('DATE(created_at) as date')->whereDate('created_at', $currentDate)->latest()->get();
                $this->remapExpDaily();

            } else {

                $query = 'DATE(created_at) as date';
                $this->expenditures = $this->getDataQuery($query)->whereBetween('created_at', [$this->start_daily, $this->end_daily])->latest()->get();
                $this->remapExpDaily();
            }
        } elseif ($this->rekap_type == 2) {
            if ($this->default_month) {

                $startObj = Carbon::now()->startOfMonth();
                $endObj = Carbon::now()->endOfMonth();
            } else {

                $startObj = Carbon::createFromFormat('m-Y', $this->start_month)->startOfMonth();
                $endObj = Carbon::createFromFormat('m-Y', $this->end_month)->endOfMonth();
            }

            $query = "DATE_FORMAT(created_at, '%m-%Y') AS date";
            $this->expenditures = $this->getDataQuery($query)->whereBetween('created_at', [$startObj, $endObj])->latest()->get();

            $this->remapExpMonth();

            //  TODO tentukan dulu tanggal default awalnya;

        }

        // $this->remapTransactions();
    }

    #[On('filterRangeExp')]
    public function getDataByRange($start, $end = null) // end diset null jika type_range ==3 / tahunan
    {

        if ($this->rekap_type == 1) {
            $this->default_day = false;

            $start_dateTime = Carbon::parse($start)->timezone('Asia/Jakarta');

            // // Format the date to get only the date part
            $start_onlyDate = $start_dateTime->format('Y-m-d');

            $end_dateTime = Carbon::parse($end)->timezone('Asia/Jakarta');

            // // Format the date to get only the date part
            $end_onlyDate = $end_dateTime->format('Y-m-d');

            $this->start_daily = Carbon::parse($start_onlyDate)->startOfDay();
            $this->end_daily = Carbon::parse($end_onlyDate)->endOfDay();
            $this->expenditures = $this->getDataQuery('DATE(created_at) as date')->whereBetween('created_at', [$this->start_daily, $this->end_daily])->latest()->get();

            $this->remapExpDaily();
        } elseif ($this->rekap_type == 2) {

            $this->default_month = false;

            $this->start_month = $start;
            $this->end_month = $end;

            $startObj = Carbon::createFromFormat('m-Y', $this->start_month)->startOfMonth();
            $endObj = Carbon::createFromFormat('m-Y', $this->end_month)->endOfMonth();

            $query = "DATE_FORMAT(created_at, '%m-%Y') AS date";
            $this->expenditures = $this->getDataQuery($query)->whereBetween('created_at', [$startObj, $endObj])->latest()->get();

            $this->remapExpMonth();
        }

        $this->dispatch('returnDataExp', expenditures: $this->expenditures);
    }

    public function remapExpMonth()
    {

        $this->expenditures->map(function ($value) {

            $parsed = Carbon::parse('1-'.$value->date);
            $formatBulanTahun = $parsed->translatedFormat('F Y');

            $value->date = $formatBulanTahun;

            $value->total_idr = toRupiah($value->total_idr);
            $value->total_btc = changeToComa($value->total_btc);
            $value->total_usd = changeToComa($value->total_usd);
            $value->total_usdt = changeToComa($value->total_usdt);
        });
    }

    public function remapExpDaily()
    {

        $this->expenditures->map(function ($value) {

            $value->date = Carbon::parse($value->date)->timezone('Asia/Jakarta')->translatedFormat('d F Y');
            $value->total_idr = toRupiah($value->total_idr);
            $value->total_btc = changeToComa($value->total_btc);
            $value->total_usd = changeToComa($value->total_usd);
            $value->total_usdt = changeToComa($value->total_usdt);
        });
    }
}
