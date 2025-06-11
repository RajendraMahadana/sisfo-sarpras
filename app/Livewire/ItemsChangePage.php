<?php

namespace App\Livewire;

use Livewire\Component;

class ItemsChangePage extends Component
{
    public $page = 'home';

    public function goTo($page)
    {
        $this->page = $page;
    }

    public function render()
    {
        return view('livewire.items-change-page', [
        ]);
    }
}
