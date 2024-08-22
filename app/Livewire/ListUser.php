<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Users')]
class ListUser extends Component
{
    public function render()
    {

        return view('livewire.list-user');
    }
}
