<?php

namespace App\Livewire\Transfer;

use App\Livewire\Forms\TransferForm;
use App\Models\Account;
use App\Models\Transfer;
use App\Models\Website;
use Exception;
use Livewire\Component;

class ModalInput extends Component
{
    public $isTTAtas = true;

    public $edit = false;

    public $websites;

    public $accounts = [];

    public $accounts_tt;

    public TransferForm $form;

    public function render()
    {
        if (request()->is('pinjam-atas')) {
            $this->isTTAtas = false;
        }

        $all_accounts = Account::all();

        if ($this->form->website_id != '') {
            $this->accounts = $all_accounts->where('website_id', '!=', session('website_id'))->where('website_id', $this->form->website_id);
        }

        $this->accounts_tt = $all_accounts->where('website_id', session('website_id'))->values();

        $this->websites = Website::whereIn('id', [1, 2, 3, 4])->get();

        // $this->inisiasiValueAwal();
        return view('livewire.transfer.modal-input');
    }

    // public function inisiasiValueAwal()
    // {

    //     if ($this->websites->count() != 0) {

    //         $this->form->website_id = $this->websites[0]->id;
    //     }

    //     if ($this->accounts->count() != 0) {
    //         $this->form->account_id = $this->accounts[0]->id;
    //     }

    //     if ($this->accounts_tt->count() != 0) {
    //         $this->form->account_tt_id = $this->accounts_tt[0]->id;
    //     }
    // }

    public function procedTransfer()
    {
         //hilankan titik pada angka

         $this->form->amount = str_replace('.', '', $this->form->amount);

        if (! $this->edit) {

            $this->insert();
        }
    }

    public function insert()
    {
        try {
            $this->form->insert($this->isTTAtas);

            $this->dispatch('reloadTransfer');

            //    $this->dispacth('reloadTableTransfer');
        } catch (Exception $e) {

            flash($e->getMessage(), 'alert-danger');
        }
    }

    //fungsi inisiasi data member untuk edit transaksi
    #[\Livewire\Attributes\On('showModalTransferEdit')]
    public function showModalInputEditState($transfer)
    {

        $this->edit = true; //aktifkan state edit

        $this->form->website_id = $transfer->website_id;
        $this->form->account_id = $transfer->account_id;
        $this->form->account_tt_id = $transfer->account_tt_id;
        //end inisiasi

        $this->dispatch('showModalTransferJS');
    }

    #[\Livewire\Attributes\On('showModalTransferNonEdit')]
    public function showModalNonEditState()
    {

        $this->form->reset();

        $this->edit = false;

        $this->dispatch('showModalTransferJS');
    }

    #[\Livewire\Attributes\On('deleteTransferConfirm')]
    public function confirmDeleteTransaction($transfer)
    {

        $this->dispatch('deleteTransferConfirmJS', transfer: $transfer);
    }

    #[\Livewire\Attributes\On('removeTransfer')]
    public function removeTransfer($transfer)
    {

        $transfer = Transfer::with(['account', 'accountTransfer'])->where('id', $transfer['id'])->first();

        $account = $transfer->account ?? null;
        $accountTransfer = $transfer->accountTransfer ?? null;

        //kembalikan saldo ke rekening sebelumnya
        if ($account != null) {
            $amount = $transfer->amount;
            $account->balance = $amount;
            $account->save();
        }
        //kurangi saldo rekening TT Atas
        if ($accountTransfer != null) {
            $accountTransfer->balance -= $amount;
            $accountTransfer->save();
        }
        //end

        $transfer->delete();

        $keterangan = "Hapus Pinjam Atas";
        if($this->isTTAtas){
            $keterangan = "Hapus TT Atas";
        }
        $user = auth()->user();

        insertLog($user->name, request()->ip(), "Hapus Transfer", $transfer->website->name, $keterangan,2);

        $this->dispatch('reloadTransfer');
    }
}
