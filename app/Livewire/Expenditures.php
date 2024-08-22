<?php

namespace App\Livewire;

use Livewire\Component;

#[\Livewire\Attributes\Title('Expenditures')]
class Expenditures extends Component
{
    public $jenisTabel=1;

    public function mount()
    {
        if (! privilegeViewExpenditure()) {
            return abort(403, 'Akses Dilarang');
        }
    }

    public function render()
    {
        return view('livewire.expenditures');
    }
}
