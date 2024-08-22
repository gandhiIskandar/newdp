<?php

namespace App\Livewire\Forms;

use App\Models\CashBook;
use Livewire\Attributes\Rule;
use Livewire\Form;

class CashBookForm extends Form
{
    #[Rule(['required', 'numeric'])]
    public $type_id = '';

    #[Rule(['required'])]
    public $amount = 0;

    #[Rule(['required'])]
    public $detail = '';

    public function create()
    {
        if ($this->validate()) {

            $cashbook = CashBook::create([
                'user_id' => 1, //untuk dummy data saja
                'detail' => $this->detail,
                'amount' => $this->amount,
                'type_id' => $this->type_id,
                'website_id' => session('website_id'),
            ]);
            $this->reset();

            $admin = Auth()->user();
            $formattedAmount = toBaht($cashbook->amount);

            insertLog($admin->name, request()->ip(), 'Tambah Catatan Kas', $cashbook->type->name, "$cashbook->detail $formattedAmount", 2);

            flash('Berhasil Tambah Catatan Kas', 'alert-success');

            return $cashbook;
        }

    }

    public function update($cashBook)
    {

        //TODO nanti buatkan pengecekan bahwa yang berhak mengedit adalah user yang membuat kas itu sendiri

        if ($this->validate()) {
            //user id akan tetap sama dan tidak bisa diubah

            $formattedOldAmount = toBaht($cashBook->amount);

            $cashBook->detail = $this->detail;
            $cashBook->amount = $this->amount;
            $cashBook->type_id = $this->type_id;

            $admin = Auth()->user();
            $formattedNewAmount = toBaht($cashBook->amount);

            insertLog($admin->name, request()->ip(), 'Update Catatan Kas', $cashBook->type->name, "$cashBook->detail from $formattedOldAmount to $formattedNewAmount", 2);

            $cashBook->save();
        }

    }
}
