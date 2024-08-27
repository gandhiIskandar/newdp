<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use App\Models\Privilege;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class ModalInputUser extends Component
{
    public UserForm $form;

    public $edit;

    public $user;

    public function render()
    {

        $privileges = Privilege::all();
        $roles = Role::all();

        return view('livewire.modal-input-user', compact(['privileges', 'roles']));
    }

    //fungsi inisiasi data user untuk edit
    #[\Livewire\Attributes\On('showModalUserEdit')]
    public function showModalInputEditState($user_id)
    {

        $this->edit = true; //aktifkan state edit

        $this->user = User::with('privileges')->find($user_id);

        $privilegesUser = $this->user->privileges;

        //inisiasi nilai form agar sesuai dengan data yang mau diedit

        $this->form->name = $this->user->name;
        $this->form->email = $this->user->email;
        $this->form->role_id = $this->user->role_id;

        $this->form->privileges = $privilegesUser->pluck('id');

        //end inisiasi

        $this->dispatch('showModalUserJS');
    }

    #[\Livewire\Attributes\On('showModalNonEditStateUser')]
    public function showModalNonEditState()
    {
        $this->form->reset();

        $this->edit = false;

        $this->dispatch('showModalUserJS');
    }

    #[\Livewire\Attributes\On('removeConfirmUser')]
    public function removeConfirm($user_id)
    {

        $this->dispatch('removeConfirmUserJS', user_id: $user_id);
    }

    #[\Livewire\Attributes\On('removeUser')]
    public function removeUser($user_id)
    {

        $user = User::where('id', $user_id)->first();

        $user->delete();

        $this->dispatch('reloadPowerGridUser');

    }

    public function proceedUser()
    {

        if (! $this->edit) {
            $this->insertUser();
            $msg = "Berhasil Tambah User";
        } else {
            $this->updateUser();
            $msg = "Berhasil Update User";
            
        }

        
        $this->dispatch('closeModal', message:$msg)->self();
    }

    public function updateUser()
    {

        $this->form->update($this->user);

       

        $this->dispatch('reloadPowerGridUser');

    }

    public function insertUser()
    {

     $this->form->create();

        $this->dispatch('reloadPowerGridUser');
    }
}
