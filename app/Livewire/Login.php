<?php

namespace App\Livewire;

use App\Livewire\Forms\LoginForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')] //mengatur master template/layout
class Login extends Component
{
    public LoginForm $form;

    public function login()
    {
        $this->form->store();
    }

    public function render()
    {

        return view('livewire.login');
    }
}
