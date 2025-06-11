<?php

namespace App\Livewire;


use App\Models\Item;
use Livewire\Component;

class ItemsShowData extends Component
{
    public $location_id;
    public $detail_location_id;
    public $name;

    public function render()
    {
        return view('livewire.items-show-data', [
            'items' => Item::where('admin_id', auth()->id())->get(),
        ]);
    }
}
