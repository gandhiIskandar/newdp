<?php

namespace App\Livewire\Forms;

use App\Models\Account;
use App\Models\Transfer;
use Livewire\Attributes\Rule;
use Livewire\Form;

class TransferForm extends Form
{
    #[Rule(['required'])]
    public $website_id;

    #[Rule(['required'])]
    public $account_id;

    #[Rule(['required'])]
    public $account_tt_id;

    public $amount;

    public function insert($isTTAtas)
    {

        if ($this->validate()) {

            if ($isTTAtas) {

                $this->getBalanceAccountWeb();

                $this->transferTTAtas();
            } else {
                if ($this->amount != '') {
                    $this->reduceBalanceAccountTTAtas();
                    $this->transferAccountWeb();
                } else {
                    flash('Mohon masukan jumlah yang ingin di transfer', 'alert-danger');
                }
            }

          $transfer =  Transfer::create([
                'website_id' => $this->website_id,
                'account_id' => $this->account_id,
                'account_tt_id' => $this->account_tt_id,
                'amount' => $this->amount,
                'tt_atas' => $isTTAtas,
            ]);

            $this->reset();

            $keterangan = "Tambah Pinjam Atas";
            if($isTTAtas){
                $keterangan = "Tambah TT Atas";
            }
            $user = auth()->user();

            insertLog($user->name, request()->ip(), "Tambah Transfer", $transfer->website->name, $keterangan,2);

            flash('Transfer Berhasil', 'alert-success');
        } else {
            flash('Mohon lengkapi data', 'alert-danger');
        }
    }

    public function transferTTAtas()
    {
        $tt_account = Account::where('id', $this->account_tt_id)->first();

        $tt_account->balance += $this->amount;

        $tt_account->save();
    }

    public function reduceBalanceAccountTTAtas()
    {
        $tt_account = Account::where('id', $this->account_tt_id)->first();

        $tt_account->balance -= $this->amount;

        $tt_account->save();
    }

    public function transferAccountWeb()
    {

        $account = Account::where('id', $this->account_id)->first();

        $account->balance += $this->amount;

        $account->save();
    }

    public function getBalanceAccountWeb()
    {

        $account = Account::where('id', $this->account_id)->first();

        $this->amount = $account->balance;

        $account->balance = 0;

        $account->save();
    }
}
