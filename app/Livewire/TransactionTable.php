<?php

namespace App\Livewire;

use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class TransactionTable extends Component
{
    public $rekap = 0;

    public $transactions;

    public $default = true;

    public $start;

    public $end;

    //jika rekap = 1 maka akan menampilkan data rekap
    //jika rekap = 0 maka akan menampilkan data log

    public function render()
    {
        $this->getData();

        return view('livewire.transaction-table');
    }

    #[On('tessee')]
    public function getDataByRange($start, $end)
    {
        $this->default = false;

        // Create a DateTime object from the string
        $start_dateTime = Carbon::parse($start)->timezone('Asia/Jakarta');

        // // Format the date to get only the date part
        $start_onlyDate = $start_dateTime->format('Y-m-d');

        $end_dateTime = Carbon::parse($end)->timezone('Asia/Jakarta');

        // // Format the date to get only the date part
        $end_onlyDate = $end_dateTime->format('Y-m-d');

        $this->start = Carbon::parse($start_onlyDate)->startOfDay();
        $this->end = Carbon::parse($end_onlyDate)->endOfDay();

        $this->transactions = Transaction::with(['member', 'type'])->whereBetween('created_at', [$this->start, $this->end])->latest()->get();

        $this->transactions->map(function ($transaction) {
            $transaction->date = Carbon::parse($transaction->created_at)->translatedFormat('d F Y');
            $transaction->amount = $this->toRupiah($transaction->amount);
        });

        $this->dispatch('filterTable', transactions: $this->transactions);
    }

    public function toRupiah($amount)
    {

        return 'Rp '.number_format($amount, 0, ',', '.');
    }

    #[On('reloadTransaction')]
    public function test($transaction)
    {
        $this->getData();
        $this->dispatch('localan', transactions: $this->transactions);
    }

    public function getData()
    {
        $currentDate = Carbon::now()->toDateString();

        if ($this->default) {
            $this->transactions = Transaction::with(['member', 'type'])->whereDate('created_at', $currentDate)->orderBy('created_at', 'desc')->get();

        } else {

            $this->transactions = Transaction::with(['member', 'type'])->whereBetween('created_at', [$this->start, $this->end])->latest()->get();

        }
        $this->transactions->map(function ($transaction) {
            $transaction->date = Carbon::parse($transaction->created_at)->translatedFormat('d F Y');
            $transaction->amount = $this->toRupiah($transaction->amount);
        });

    }
}
