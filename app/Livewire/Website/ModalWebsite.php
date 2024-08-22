<?php

namespace App\Livewire\Website;

use App\Models\Website;
use Livewire\Component;

class ModalWebsite extends Component
{
    public $name;

    public $websites;

    public function render()
    {
        $this->getWebsites();

        return view('livewire.website.modal-website');
    }

    public function deleteWebsite($id)
    {

        Website::destroy($id);

        flash('Berhasil Hapus Website', 'alert-success');

    }

    public function insertWebsite()
    {

        if ($this->name != '') {

            Website::create([
                'name' => $this->name,

            ]);

            flash('Berhasil Tambah Situs', 'alert-success');

        } else {
            flash('Gagal Tambah Situs', 'alert-danger');
        }

        $this->name = '';

    }

    public function getWebsites()
    {
        $this->websites = Website::all();
    }
}
