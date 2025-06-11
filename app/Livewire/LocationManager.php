<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Location;
use Livewire\WithPagination;

class LocationManager extends Component
{
    use WithPagination;
    public $location_id;
    public $name;
    public $locations = [];
    public $locationsSelected = [];
    public $showCreateForm = false;
    public $confirmingBulkDelete = false;
    public $locationToDelete = null;
    public $confirmingDeleteId = null;

    public $rules = [
        'name' => 'required|string|max:255|unique:locations,name',
    ];

    public function save()
    {
        $this->validate();

        $location = Location::updateOrCreate(
            ['id' => $this->location_id],
            [
            'name' => $this->name,
            'admin_id' => auth()->id(),
        ]);

        session()->flash('message',
        $location->wasRecentlyCreated
          ? 'Data berhasil ditambahkan!'
          : 'Data berhasil diperbarui!'
    );
        $this->locations = Location::all(); 
        $this->resetFields();
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);
        $this->location_id = $location->id;
        $this->name = $location->name;
        
        $this->showCreateForm = true;
    }

    public function confirmDeletePrompt($id)
    {
        $this->locationToDelete         = Location::findOrFail($id);
        $this->confirmingDeleteId   = $id;
    }

    public function confirmDelete()
    {
       $location = Location::where('admin_id', auth()->id())
                    ->find($this->confirmingDeleteId);

        if (! $location) {
            session()->flash('error', 'Item tidak ditemukan atau sudah dihapus.');
            // reset state
            $this->confirmingDeleteId = null;
            $this->locationToDelete   = null;
            return $this->resetPage();
        }

        $location->delete();
        session()->flash('message', 'Lokasi berhasil dihapus.');
        $this->confirmingDeleteId = null;
        $this->locationToDelete   = null;
        $this->resetPage();
    }

    public function deleteSelected()
    {
        if (empty($this->locationsSelected)) {
            session()->flash('error', 'Tidak ada lokasi yang dipilih.');
            return;
        }

        $deleted = Location::whereIn('id', $this->locationsSelected)
            ->where('admin_id', auth()->id())
            ->delete();

        if ($deleted) {
            session()->flash('message', 'Lokasi terpilih berhasil dihapus.');
        } else {
            session()->flash('error', 'Gagal menghapus lokasi.');
        }

        $this->locationsSelected = [];
        $this->confirmingBulkDelete = false;
    }

    public function confirmBulkDelete()
    {
        if (empty($this->locationsSelected)) {
            session()->flash('error', 'Tidak ada lokasi yang dipilih.');
            return;
        }

        $this->confirmingBulkDelete = true;
    }


    public function resetFields() {
        $this->location_id = null;
        $this->name = '';
    }

    public function render()
    {
        return view('livewire.location-manager', [
            'location' => Location::where('admin_id', auth()->id())->paginate(5),
        ]);
    }
}         
