<?php

namespace App\Livewire\Website;

use App\Models\Website;
use Livewire\Component;

class Option extends Component
{
    public $website_id;

    public $websites;

    public function render()
    {

        $this->website_id = session('website_id');

        $this->websites = Website::all();

        return view('livewire.website.option');
    }

    public function setWebsite()
    {
        session()->put('website_id', $this->website_id);

        $this->redirectRoute('dashboard');

        // $route = Route::currentRouteName();

        // $this->redirectRoute($route);

    }
}
