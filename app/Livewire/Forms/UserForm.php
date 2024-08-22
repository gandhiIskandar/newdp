<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Form;

class UserForm extends Form
{
    #[Rule(['required'])]
    public $privileges = [];

    #[Rule(['required'])]
    public $role_id;

    #[Rule(['required'])]
    public $name;

    #[Rule(['required'])]
    public $email;

    //pengecekan manual saja untuk create
    public $password = '';

    public function create()
    {
        if ($this->validate() && $this->password != '') {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'role_id' => $this->role_id,
                'password' => bcrypt($this->password),
            ]);

            //TODO nanti gabungkan dari 5 array privileges ke dalam $privileges

            $user->privileges()->attach($this->privileges);

            $this->reset();

            flash('Berhasil Tambah User', 'alert-success');

            return $user;

        }

        return null;
    }

    public function update($user)
    {
        if ($this->validate()) {

            $user->name = $this->name;
            $user->email = $this->email;
            $user->role_id = $this->role_id;
            $user->save();

            //TODO nanti gabungkan dari 5 array privileges ke dalam $privileges

            //gunakan sync memastikan privileges hanya yang dipilih, agar tidak double input
            $user->privileges()->sync($this->privileges);

            flash('Berhasil Update Data User', 'alert-success');

        }
    }
}
