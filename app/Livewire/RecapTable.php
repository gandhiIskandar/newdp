<?php

namespace App\Livewire;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class RecapTable extends Component
{
    public $transactions;

    public $rekap_type = 1;

    public $default_month = true;

    public $default_day = true;

    public $start_month;

    public $end_month;

    public $start_daily;

    public $end_daily;

    //rekap_type = 1 -> Harian
    //rekap_type = 2 -> Bulanan

    public function render()
    {

        $this->getData();

        return view('livewire.recap-table');
    }

    public function toRupiah($amount)
    {

        return 'Rp '.number_format($amount, 0, ',', '.');
    }

    #[On('transactionCreated')]
    public function refreshTable()
    {
        $this->getData();
        $this->dispatch('returnData', transactions: $this->transactions);
    }

    #[On('changeType')]
    public function changeType($type)
    {

        $this->rekap_type = $type;

        $this->getData();

        $this->dispatch('returnData', transactions: $this->transactions);
    }

    public function getDataQuery($timeCostum)
    {

        return Transaction::where('website_id', session('website_id'))->select(

            DB::raw($timeCostum),
            DB::raw('CAST(SUM(CASE WHEN type_id = 1 THEN amount ELSE 0 END) AS SIGNED) as total_withdraw'),
            DB::raw('CAST(SUM(CASE WHEN type_id = 1 THEN 1 ELSE 0 END) AS SIGNED) as forms_withdraw'),
            DB::raw('CAST(SUM(CASE WHEN type_id = 2 AND new = 1 THEN amount ELSE 0 END) AS SIGNED) as total_new_deposit'),
            DB::raw('CAST(SUM(CASE WHEN type_id = 2 AND new = 1 THEN 1 ELSE 0 END) AS SIGNED) as forms_new_deposit'),
            DB::raw('CAST(SUM(CASE WHEN type_id = 2 AND new = 0 THEN amount ELSE 0 END) AS SIGNED) as total_redeposit'),
            DB::raw('CAST(SUM(CASE WHEN type_id = 2 AND new = 0 THEN 1 ELSE 0 END) AS SIGNED) as forms_redeposit'),
            DB::raw('CAST(SUM(CASE WHEN type_id = 2 THEN amount ELSE 0 END) AS SIGNED) as total_deposit'),
            DB::raw('CAST(SUM(CASE WHEN type_id = 2 THEN 1 ELSE 0 END) AS SIGNED) as forms_deposit'),
            DB::raw('COUNT(id) as total_forms')

        )
            ->groupBy('date');
    }

    public function getData()
    {
        $currentDate = Carbon::now()->toDateString();

        if ($this->rekap_type == 1) {

            if ($this->default_day) {

                $this->transactions = $this->getDataQuery('DATE(created_at) as date')->whereDate('created_at', $currentDate)->latest()->get();
                $this->remapTransactionDaily();
            } else {

                $query = 'DATE(created_at) as date';
                $this->transactions = $this->getDataQuery($query)->whereBetween('created_at', [$this->start_daily, $this->end_daily])->latest()->get();
                $this->remapTransactionDaily();

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
            $this->transactions = $this->getDataQuery($query)->whereBetween('created_at', [$startObj, $endObj])->latest()->get();

            $this->remapTransactionMonth();

            //  TODO tentukan dulu tanggal default awalnya;

        }

        // $this->remapTransactions();
    }

    #[On('filterRange')]
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
            $this->transactions = $this->getDataQuery('DATE(created_at) as date')->whereBetween('created_at', [$this->start_daily, $this->end_daily])->latest()->get();

            $this->remapTransactionDaily();
        } elseif ($this->rekap_type == 2) {

            $this->default_month = false;

            $this->start_month = $start;
            $this->end_month = $end;

            $startObj = Carbon::createFromFormat('m-Y', $this->start_month)->startOfMonth();
            $endObj = Carbon::createFromFormat('m-Y', $this->end_month)->endOfMonth();

            $query = "DATE_FORMAT(created_at, '%m-%Y') AS date";
            $this->transactions = $this->getDataQuery($query)->whereBetween('created_at', [$startObj, $endObj])->latest()->get();

            $this->remapTransactionMonth();
        }

        $this->dispatch('returnData', transactions: $this->transactions);
    }

    public function remapTransactionMonth()
    {

        $this->transactions->map(function ($value) {

            $parsed = Carbon::parse('1-'.$value->date);
            $formatBulanTahun = $parsed->translatedFormat('F Y');

            $value->date = $formatBulanTahun;

            $value->dkw = $value->total_deposit - $value->total_withdraw;
            $value->total_redeposit = $this->toRupiah($value->total_redeposit);
            $value->total_new_deposit = $this->toRupiah($value->total_new_deposit);
            $value->total_deposit = $this->toRupiah($value->total_deposit);
            $value->total_withdraw = $this->toRupiah($value->total_withdraw);
        });
    }

    public function remapTransactionDaily()
    {

        $this->transactions->map(function ($value) {

            $value->date = Carbon::parse($value->date)->timezone('Asia/Jakarta')->translatedFormat('d F Y');
            $value->dkw = $value->total_deposit - $value->total_withdraw;
            $value->total_redeposit = $this->toRupiah($value->total_redeposit);
            $value->total_new_deposit = $this->toRupiah($value->total_new_deposit);
            $value->total_deposit = $this->toRupiah($value->total_deposit);
            $value->total_withdraw = $this->toRupiah($value->total_withdraw);
        });
    }
}
