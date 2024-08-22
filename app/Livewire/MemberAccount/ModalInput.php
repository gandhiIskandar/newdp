<?php

namespace App\Livewire\MemberAccount;

use App\Livewire\Forms\MemberAccountForm;
use App\Models\Bank;
use App\Models\Member;
use App\Models\MemberAccount;
use Livewire\Component;

class ModalInput extends Component
{
    public $members;

    public $banks;

    public $memberAccount;

    public $edit;

    public MemberAccountForm $form;

    public function render()
    {
        $this->members = Member::all();
        $this->banks = Bank::all();

        return view('livewire.member-account.modal-input');
    }

    public function proccedMemberAccount()
    {

        // dd($this->form->bank_id);

        if ($this->edit == 0) {
            $this->insert();
        } else {
            $this->update();
        }
    }

    public function insert()
    {

        $this->form->create();

        $this->dispatch('reloadMemberAccount');

    }

    public function update()
    {
        $this->form->update($this->memberAccount);

        $this->dispatch('reloadMemberAccount');
    }

    #[\Livewire\Attributes\On('showModalMemberAccountEdit')]
    public function openEditModal($memberAccount_id)
    {
        $this->edit = 1;

        $this->memberAccount = MemberAccount::find($memberAccount_id);

        $this->form->under_name = $this->memberAccount->under_name;
        $this->form->bank_id = $this->memberAccount->bank_id;
        $this->form->number = $this->memberAccount->number;
        $this->form->member_id = $this->memberAccount->member_id;

        $this->dispatch('showModalMemberAccountJS');
    }

    #[\Livewire\Attributes\On('showModalMemberAccountNonEdit')]
    public function openCreateModal()
    {
        $this->edit = 0;

        $this->form->reset();
        $this->dispatch('showModalMemberAccountJS');
    }

    #[\Livewire\Attributes\On('deleteMemberAccountConfirm')]
    public function confirmDeleteMemberAccount($memberAccount)
    {

        $this->dispatch('deleteMemberAccountConfirmJS', memberAccount: $memberAccount);

    }

    #[\Livewire\Attributes\On('removeMemberAccount')]
    public function removeMemberAccount($memberAccount)
    {

        $memberAccount = (object) $memberAccount;

        MemberAccount::destroy($memberAccount->id);

        $admin = auth()->user();

        insertLog($admin->name, request()->ip(), 'Hapus Rekening Member', $memberAccount->member_id, $memberAccount->bank['name'], 0);

        flash('Berhasil Hapus Rekening Member', 'alert-success');

    }
}
