<?php

namespace App\Livewire\Forms;

use App\Models\MemberAccount;
use Livewire\Attributes\Rule;
use Livewire\Form;

class MemberAccountForm extends Form
{
    #[Rule(['required'])]
    public $member_id = 1; //biasakan kalau select inisiasi default id awalnya, supaya tidak bingung

    #[Rule(['required'])]
    public $bank_id;

    #[Rule(['required'])]
    public $under_name;

    #[Rule(['required'])]
    public $number;

    public function create()
    {

        if ($this->validate()) {

            $admin = auth()->user();

            $account = MemberAccount::create([
                'member_id' => $this->member_id,
                'bank_id' => $this->bank_id,
                'under_name' => $this->under_name,
                'number' => $this->number,

            ]);
            $this->reset();

            //  $formattedAmount = $currency . " " . number_format($expenditure->amount, 0, ',', '.');

            insertLog($admin->name, request()->ip(), 'Insert Rekening Member', $account->member_id, $account->bank->name, 0);

            flash('Berhasil Tambah Rekening Member', 'alert-success');

        }
    }

    public function update($memberAccount)
    {
        $memberAccount->member_id = $this->member_id;
        $memberAccount->bank_id = $this->bank_id;
        $memberAccount->number = $this->number;
        $memberAccount->under_name = $this->under_name;

        $memberAccount->save();

        $admin = auth()->user();

        insertLog($admin->name, request()->ip(), 'Update Rekening Member', $memberAccount->member_id, $memberAccount->bank->name, 0);

        flash('Berhasil Update Rekening Member', 'alert-success');

    }
}
