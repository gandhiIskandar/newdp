<?php

namespace App\Livewire;

use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Profile Data')]
class AccountSetting extends Component
{
    use WithFileUploads;

    public $user;

    #[Rule(['required'])]
    public $email;

    #[Rule(['required'])]
    public $name;

    #[Validate('image|max:1024')]
    public $photo;

    public $oldImagesName;

    public $role;

    public function mount()
    {

        $this->user = session('user_data');

        $this->email = $this->user->email;
        $this->name = $this->user->name;
        $this->role = $this->user->role->name;
        $this->oldImagesName = $this->user->profile_image_name;

    }

    public function render()
    {
        return view('livewire.account-setting');
    }

    public function updateDataUser()
    {

        if ($this->validate()) {
            $this->user->email = $this->email;
            $this->user->name = $this->name;

            if ($this->photo) {

                $ext = $this->photo->getClientOriginalExtension();

                $this->user->profile_image = $this->photo->storeAs(path: 'profile_images', name: $this->user->id.'.'.$ext);

            }

            $this->user->save();

            session()->put('user_data', $this->user);

            flash('Update Data Berhasil', 'alert-success');

        }

    }
}
