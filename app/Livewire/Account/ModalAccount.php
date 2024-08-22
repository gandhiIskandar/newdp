<?php

namespace App\Livewire\Account;

use App\Livewire\Forms\AccountForm;
use App\Models\Account;
use App\Models\Bank;
use Exception;
use Livewire\Component;

class ModalAccount extends Component
{
    public $account;

    public AccountForm $form;

    public $banks;

    public $edit = false;

    public function render()
    {
        $this->banks = Bank::all();

        //  $this->getAccounts();
        return view('livewire.account.modal-account');
    }

    public function proccedAccount()
    {

        $this->form->balance = str_replace('.', '', $this->form->balance);

        //  dd("ttst");

        if (! $this->edit) {
            $this->insertAccount();
        } else {
            $this->updateAccount();
        }

    }

    #[\Livewire\Attributes\On('deleteAccountConfirm')]
    public function confirmDeleteTransaction($account)
    {

        $this->dispatch('deleteAccountConfirmJS', account: $account);

    }

    #[\Livewire\Attributes\On('removeAccount')]
    public function removeAccount($account)
    {

        Account::destroy($account['id']);

        $admin = auth()->user();

        insertLog($admin->name, request()->ip(), 'Hapus Rekening', $account['under_name'], 'Hapus Rekening '.$account['bank']['name'], 2);

        $this->dispatch('reloadPowerGridAccount');

    }

    #[\Livewire\Attributes\On('showModalAccountEdit')]
    public function showModalInputEditState($account_id)
    {

        $this->edit = true; //aktifkan state edit

        $this->account = Account::find($account_id);

        //inisiasi nilai form agar sesuai dengan data yang mau diedit

        $this->form->bank_id = $this->account->bank_id;
        $this->form->balance = $this->account->balance;

        $this->form->number = $this->account->number;

        $this->form->under_name = $this->account->under_name;
        //end inisiasi

        $this->dispatch('showModalAccountJS');
    }

    public function updateAccount()
    {

        try {

            $this->form->update($this->account);

            flash('Data rekening berhasil diubah', 'alert-success');

            $this->dispatch('reloadPowerGridAccount');
        } catch (Exception $e) {

        }

    }

    #[\Livewire\Attributes\On('showModalNonEditStateAccount')]
    public function showModalNonEditState()
    {

        $this->form->reset();

        $this->edit = false;

        $this->dispatch('showModalAccountJS');
    }

    public function insertAccount()
    {

        $this->form->insert();

        $this->dispatch('reloadPowerGridAccount');

    }
}
