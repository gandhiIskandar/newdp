<?php

namespace App\Livewire\Transfer;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Transfer')]
class Index extends Component
{
    public $isTTAtas = true;

    public function mount()
    {

        if (privilegeViewTTAtas() || privilegeViewPinjamAtas() ) {

            if(request()->is('pinjam-atas')){

                if(!privilegeViewPinjamAtas()){
                    return abort(403, 'Akses Dilarang');
                    
                }
            }else{
                if(!privilegeViewTTAtas()){
                    return abort(403, 'Akses Dilarang');
                    
                }
            }

        }else{
            return abort(403, 'Akses Dilarang');

        }
    }

    public function render()
    {
        if (request()->is('pinjam-atas')) {

            $this->isTTAtas = false;

           
        }

        // if(request()->isTTAtas){
        //     dd(request()->isTTAtas);
        // }

        return view('livewire.transfer.index');
    }
}
