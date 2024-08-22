<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cashbook')]
class Cashbooks extends Component
{
    public $jenisTabel = 1;

    public function mount()
    {

        if (! privilegeViewCashBook()) {

            return abort(403, 'Akses Dilarang');
        }
    }

    public function render()
    {

        return view('livewire.cashbooks');
    }
}
