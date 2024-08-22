<?php

namespace App\Livewire\Account;

use App\Models\Account;
use Livewire\Component;

class ModalMerge extends Component
{
    public $selected = 1;

    public $accounts;

    public function render()
    {
        $this->accounts = Account::with('bank')->where('website_id', session('website_id'))->get();

        return view('livewire.account.modal-merge');
    }

    public function merge()
    {
        $exceptData = $this->accounts->where('id', '!=', $this->selected); //ambil data yang bukan di select untuk kumpulkan saldonya;
        $allBalance = $exceptData->sum('balance');
        $target = $this->accounts->where('id', $this->selected)->first();

        $target->balance += $allBalance;
        $target->save();

        $exceptId = $exceptData->pluck('id');

        Account::whereIn('id', $exceptId)->update(['balance' => 0]);

        flash('Berhasil Gabung Saldo ke Rekening '.$target->bank->name, 'alert-success');

        $this->dispatch('reloadPowerGridAccount');

    }
}
