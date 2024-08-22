<?php

namespace App\Livewire\Account;

use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Rekening Admin')]
class Index extends Component
{

    public function mount()
    {

        if (! privilegeViewAdminAccount()) {

            return abort(403, 'Akses Dilarang');
        }
    }

    public function render()
    {
        return view('livewire.account.index');
    }
}
