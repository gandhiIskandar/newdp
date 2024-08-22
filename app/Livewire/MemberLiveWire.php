<?php

namespace App\Livewire;

use Livewire\Component;

#[\Livewire\Attributes\Title('Members')]
class MemberLiveWire extends Component
{
    public $jenisTabel = 2;

    public function mount()
    {
        if (! privilegeViewMember()) {
            return abort(403, 'Akses Dilarang');
        }
    }

    public function render()
    {
        return view('livewire.member-livewire');
    }
}
