<?php

namespace App\Livewire;

use Livewire\Component;

#[\Livewire\Attributes\Title('Transactions')]
class Transactions extends Component
{
    public $jenisTabel = 1;

    //jenisTabel 1->Log
    //jenisTabel 2->Rekap

    public function mount()
    {
     
       
        if (! privilegeViewTransaction()) {
            return abort(403, 'Akses Dilarang');
        }
    }

    public function render()
    {

     
        return view('livewire.transactions');
    }
}
