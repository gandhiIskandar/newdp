<?php

namespace App\Livewire\Whitelist;

use App\Models\Whitelist;
use Livewire\Component;

class ModalWhitelist extends Component
{
    public $ip_address = '';

    public $whitelists;

    public function render()
    {

        $this->getWhitelists();

        return view('livewire.whitelist.modal-whitelist');
    }

    public function insertWhitelist()
    {

        if ($this->ip_address != '') {

            Whitelist::create([
                'ip_address' => $this->ip_address,

            ]);

            flash('Berhasil Tambah IP Address', 'alert-success');

        } else {
            flash('Gagal Tambah IP Address', 'alert-danger');
        }

    }

    public function deleteWhitelist($id)
    {

        Whitelist::destroy($id);

        flash('Berhasil Hapus IP Address', 'alert-success');

        //$this->getWhitelists();

    }

    public function getWhitelists()
    {
        $this->whitelists = Whitelist::all();
    }
}
