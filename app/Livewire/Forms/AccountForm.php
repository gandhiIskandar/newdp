<?php

namespace App\Livewire\Forms;

use App\Models\Account;
use Livewire\Attributes\Rule;
use Livewire\Form;

class AccountForm extends Form
{
    #[Rule('required')]
    public $bank_id = 1; //1 adalah default untuk bank bca

    #[Rule('required')]
    public $number;

    #[Rule('required')]
    public $under_name;

    #[Rule('required')]
    public $balance = 0;

    public function insert()
    {
        if ($this->validate()) {
            $account = Account::create([
                'bank_id' => $this->bank_id,
                'website_id' => session('website_id'),
                'number' => $this->number,
                'balance' => $this->balance,
                'under_name' => $this->under_name,
            ]);

            $this->reset();

            $admin = Auth()->user();

            insertLog($admin->name, request()->ip(), 'Tambah Rekening', $account->name, '-', 2);

            flash('Berhasil Tambah Rekening', 'alert-success');

        }
    }

    public function update($account)
    {
        $account->bank_id = $this->bank_id;
        $account->balance = $this->balance;
        $account->number = $this->number;
        $account->under_name = $this->under_name;

        $account->save();

        $admin = Auth()->user();

        insertLog($admin->name, request()->ip(), 'Update Data Rekening', $account->name, '-', 2);

    }
}
