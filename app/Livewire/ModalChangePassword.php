<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ModalChangePassword extends Component
{
    #[Rule(['required'])]
    public string $password = '';

    #[Rule(['required', 'email'])]
    public string $email = '';

    #[Rule(['required'])]
    public $newPassword = '';

    #[Rule(['required'])]
    public $confirmPassword = '';

    public function render()
    {
        return view('livewire.modal-change-password');
    }

    public function changePassword()
    {

        if ($this->newPassword != $this->confirmPassword) {
            flash('Password tidak sama, mohon periksa kembali', 'alert-danger');

            return null;
        }
        $user = Auth::user();

        $this->email = $user->email; // ambil email dari data user agar digunakan untuk Auth attempt, karena wajib menggunakan email dan password

        if (Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ])) {

            $user = User::find($user->id);

            $user->password = bcrypt($this->newPassword);

            $user->save();

            $this->reset();

            flash('Berhasil ganti password', 'alert-success');

        } else {

            flash('Mohon periksa kembali password lama', 'alert-danger');

        }
    }
}
