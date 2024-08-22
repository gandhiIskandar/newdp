<?php

namespace App\Livewire;

use App\Models\CashBook;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class RecapCashbookTable extends Component
{
    public $cashBooks;

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

        return view('livewire.recap-cashbook-table');
    }

    public function toRupiah($amount)
    {

        return 'Rp '.number_format($amount, 0, ',', '.');
    }

    #[On('cashBookCreated')]
    public function refreshTable()
    {
        $this->getData();
        $this->dispatch('returnDataCashBooks', cashBooks: $this->cashBooks);
    }

    #[On('changeTypeRecapCashbook')]
    public function changeType($type)
    {

        $this->rekap_type = $type;

        $this->getData();

        $this->dispatch('returnDataCashBooks', cashBooks: $this->cashBooks);
    }

    public function getDataQuery($timeCostum)
    {

        return CashBook::where('website_id', session('website_id'))->select(

            //type_id 3 = pengeluaran
            //type_id 4 = pemasukan

            DB::raw($timeCostum),
            DB::raw('CAST(SUM(CASE WHEN type_id = 4 THEN amount ELSE 0 END) AS SIGNED) as total_pemasukan'),
            DB::raw('CAST(SUM(CASE WHEN type_id = 3 THEN amount ELSE 0 END) AS SIGNED) as total_pengeluaran'),

        )
            ->groupBy('date');
    }

    public function getData()
    {
        $currentDate = Carbon::now()->toDateString();

        if ($this->rekap_type == 1) {

            if ($this->default_day) {

                $this->cashBooks = $this->getDataQuery('DATE(created_at) as date')->whereDate('created_at', $currentDate)->latest()->get();
                $this->remapCashbookDaily();
            } else {

                $query = 'DATE(created_at) as date';
                $this->cashBooks = $this->getDataQuery($query)->whereBetween('created_at', [$this->start_daily, $this->end_daily])->latest()->get();
                $this->remapCashbookDaily();

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
            $this->cashBooks = $this->getDataQuery($query)->whereBetween('created_at', [$startObj, $endObj])->latest()->get();

            $this->remapCashbookMonth();

            //  TODO tentukan dulu tanggal default awalnya;

        }

        // $this->remapTransactions();
    }

    #[On('filterRangeCashBooks')]
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
            $this->cashBooks = $this->getDataQuery('DATE(created_at) as date')->whereBetween('created_at', [$this->start_daily, $this->end_daily])->latest()->get();

            $this->remapCashbookDaily();
        } elseif ($this->rekap_type == 2) {

            $this->default_month = false;

            $this->start_month = $start;
            $this->end_month = $end;

            $startObj = Carbon::createFromFormat('m-Y', $this->start_month)->startOfMonth();
            $endObj = Carbon::createFromFormat('m-Y', $this->end_month)->endOfMonth();

            $query = "DATE_FORMAT(created_at, '%m-%Y') AS date";
            $this->cashBooks = $this->getDataQuery($query)->whereBetween('created_at', [$startObj, $endObj])->latest()->get();

            $this->remapCashbookMonth();
        }

        $this->dispatch('returnDataCashBooks', cashBooks: $this->cashBooks);
    }

    public function remapCashbookMonth()
    {

        $this->cashBooks->map(function ($value) {

            $parsed = Carbon::parse('1-'.$value->date);
            $formatBulanTahun = $parsed->translatedFormat('F Y');

            $value->date = $formatBulanTahun;

            $value->pkp = toBaht($value->total_pemasukan - $value->total_pengeluaran);
            $value->total_pemasukan = toBaht($value->total_pemasukan);
            $value->total_pengeluaran = toBaht($value->total_pengeluaran);

        });
    }

    public function remapCashbookDaily()
    {

        $this->cashBooks->map(function ($value) {

            $value->date = Carbon::parse($value->date)->timezone('Asia/Jakarta')->translatedFormat('d F Y');

            $value->pkp = toBaht($value->total_pemasukan - $value->total_pengeluaran);
            $value->total_pemasukan = toBaht($value->total_pemasukan);
            $value->total_pengeluaran = toBaht($value->total_pengeluaran);
        });
    }
}
