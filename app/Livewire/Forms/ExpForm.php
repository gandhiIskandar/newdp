<?php

namespace App\Livewire\Forms;

use App\Models\Expenditure;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Form;

class ExpForm extends Form
{
    #[Rule(['required'])]
    public $amount;

    #[Rule(['required'])]
    public $detail = '';

    #[Rule(['required'])]
    public $account_id = '';

    #[Rule(['required'])]
    public $currency_id = '';

    public function create()
    {

        $this->amount = changeToDot($this->amount);

        if ($this->validate()) {

            $user = Auth::user();

            $expenditure = Expenditure::create([
                'user_id' => $user->id,
                'detail' => $this->detail,
                'amount' => $this->amount,
                'account_id' => $this->account_id,
                'currency_id' => $this->currency_id,
                'website_id' => session('website_id'),

            ]);
            
            flash('Berhasil Tambah Catatan Pengeluaran', 'alert-success');
            
            // dd($expenditure);
            
            //          $admin = Auth::user();
            
            $currency = $expenditure->currency->name;
            
            $formattedAmount = $currency.' '.number_format($expenditure->amount, 0, ',', '.');
            
            insertLog($user->name, request()->ip(), 'Insert Pengeluaran', '-', "$expenditure->detail $formattedAmount", 2);
            
            $this->reduceBalance($this->account_id, $this->amount);
            $this->reset();
            
            return $expenditure;
        }
    }

    public function update($expenditure)
    {

        $oldAmount = $expenditure->amount;
        $newAmount = $this->amount;

        //TODO nanti buatkan pengecekan bahwa yang berhak mengedit adalah user yang membuat kas itu sendiri
        $currency = $expenditure->currency->name;

        $formattedOldAmount = $currency.' '.number_format($expenditure->amount, 0, ',', '.');

        if ($this->validate()) {
            //user id akan tetap sama dan tidak bisa diubah

            $expenditure->detail = $this->detail;
            $expenditure->amount = changeToDot($newAmount);
            $expenditure->account_id = $this->account_id;
            $expenditure->currency_id = $this->currency_id;

            $expenditure->save();
            $admin = Auth::user();

            $formattedNewAmount = $currency.' '.number_format($expenditure->amount, 0, ',', '.');

            insertLog($admin->name, request()->ip(), 'Update Pengeluaran', $expenditure->detail, "From $formattedOldAmount to $formattedNewAmount", 2);

            $this->updateBalance($this->account_id, $oldAmount, $newAmount);

            flash('Berhasil Edit Catatan Pengeluaran', 'alert-success');
        }
    }

    public function reduceBalance($account_id, $amount){
        $account = Account::find($account_id);

        $account->balance -= $amount;

        $account->save();
    }

    public function updateBalance($account_id, $oldAmount, $newAmount){
        $account = Account::find($account_id);

        $account->balance -= $oldAmount; 
        $account->balance += $newAmount; 

        $account->save();
    }
}
