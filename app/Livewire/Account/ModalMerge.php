<?php

namespace App\Livewire\Account;

use App\Models\Account;
use Livewire\Component;

class ModalMerge extends Component
{
    public $selected;

    public $from;

    public $accounts;

    public $amount;

    public $from_accounts;
    public $to_accounts=[];

    public function render()
    {
        $this->accounts = Account::with('bank')->where('website_id', session('website_id'))->get();
        $this->from_accounts = $this->accounts;
       
       

        return view('livewire.account.modal-merge');
    }

    public function updated(){
        $this->from_accounts = $this->accounts->where('id','!=',$this->selected);
        $this->to_accounts = $this->accounts->where('id','!=',$this->from);
    }

    public function merge()
    {

        $this->amount = str_replace('.', '', $this->amount);

      //kurangi saldo dari akun sebelumnya
        $from_account = $this->accounts->where('id', $this->from)->first();

        $from_account->balance -= $this->amount;
        $from_account->save();

//end kurangi

        $target = $this->accounts->where('id', $this->selected)->first();

        $target->balance += $this->amount;
        $target->save();

       


        flash('Berhasil Gabung Saldo ke Rekening '.$target->bank->name, 'alert-success');

        $this->dispatch('reloadPowerGridAccount');
        $this->dispatch('input-succed');
        
        
        $this->reset();
       

    }
}
