<?php

namespace App\Livewire\Log;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Log')]
class Index extends Component
{

    public function mount()
    {

        if (! privilegeViewLog()) {

            return abort(403, 'Akses Dilarang');
        }
    }
    public function render()
    {
        return view('livewire.log.index');
    }
}
