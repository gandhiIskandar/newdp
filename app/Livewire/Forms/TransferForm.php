<?php

namespace App\Livewire\Forms;

use App\Models\Account; 
use App\Models\Website; 
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

    #[Rule(['required'])]
    public $amount;

    public function insert($isTTAtas)
    {

        if ($this->validate()) {

            if ($isTTAtas) {

               $this->reduceBalanceAccountWeb();

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

            $accounts = Account::with('bank')->whereIn('id',[$this->account_id, $this->account_tt_id])->get();

            
          

            $accountWebsite = $accounts->where('id', $this->account_id)->first();
            $accountTTAtas = $accounts->where('id', $this->account_tt_id)->first();

            
            $detail = $accountTTAtas->bank->name."($accountTTAtas->under_name)". " ke ".$accountWebsite->bank->name."($accountWebsite->under_name)";   
            $keterangan = "Tambah Pinjam Atas";
            if($isTTAtas){
                $detail = $accountWebsite->bank->name."($accountWebsite->under_name)". " ke ".$accountTTAtas->bank->name."($accountTTAtas->under_name)";
                $keterangan = "Tambah TT Atas";
            }
            $user = auth()->user();
            
            insertLog($user->name, request()->ip(), $keterangan, $transfer->website->name, $detail,2);
            
            //insert log ke website yang bersangkutan
            insertLog($user->name, request()->ip(), $keterangan, $transfer->website->name, $detail." ".toRupiah($transfer->amount,true),2,$this->website_id);
            //end
            $this->reset();
            
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

    public function reduceBalanceAccountWeb()
    {

        $account = Account::where('id', $this->account_id)->first();

        $account->balance -= $this->amount;

        $account->save();
    }

   
        
}
