<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;
use App\Models\Category;
use App\Models\Location;
use Livewire\WithFileUploads;
use App\Models\LocationDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class ItemsManager extends Component
{
    use WithFileUploads;
    use WithPagination;

    // Form fields
    public $itemId;
    public $name;
    public $brand;
    public $price;
    public $quantity;
    public $location_id;
    public $location_detail_id;
    public $description;
    public $image_path;
    public $condition = 'new';
    public $purchase_date;
    public $serial_number;
    public $category_id;
    public $keyword;

    // Dropdown data
    public $locations = [];
    public $locationDetails = [];
    public $categories = [];

    public $showCreateForm = false;
    public $confirmingBulkDelete = false;
    public $itemToDelete = null;
    public $confirmingDeleteId = null;

    // Daftar items
    public $items = [];
    public $itemsSelected = [];

    public $rules = [
        'name' => 'required|string|max:255',
        'brand' => 'nullable|string|max:255',
        'price' => 'nullable|numeric|min:0',
        'quantity' => 'required|integer|min:1',
        'location_id' => 'nullable|exists:locations,id',
        'location_detail_id' => 'nullable|exists:location_details,id',
        'description' => 'nullable|string',
        'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'condition' => 'nullable|in:new,used,damaged',
        'purchase_date' => 'nullable|date',
        'serial_number' => 'nullable|string|max:255',
        'category_id' => 'required|exists:categories,id',
    ];

    public function updatedLocationID() {
        $this->location_detail_id = null;
    }

    // Simpan data baru atau update
    public function save()
    {
        $this->validate();

        // Upload gambar jika ada
        if ($this->image_path) {
            $imageName = $this->image_path->store('images', 'public');
        } 

        // Simpan atau update data
        $item = Item::updateOrCreate(
            ['id' => $this->itemId],
            [
                'name'                => $this->name,
                'brand'               => $this->brand,
                'price'               => $this->price,
                'quantity'            => $this->quantity,
                'location_id'         => $this->location_id ?: null,
                'location_detail_id'  => $this->location_detail_id ?: null,
                'description'         => $this->description,
                'image_path'          => $imageName ?? null,
                'condition'           => $this->condition,
                'purchase_date'       => $this->purchase_date,
                'serial_number'       => $this->serial_number,
                'category_id'         => $this->category_id,
                'admin_id'            => auth()->id(),
            ]
        );

        session()->flash('message',
        $item->wasRecentlyCreated
          ? 'Data berhasil ditambahkan!'
          : 'Data berhasil diperbarui!'
    );
        $this->items = Item::all(); // Refresh daftar
        $this->resetFields();
    }

    // Edit data
    public function edit($id)
    {
        $item = Item::find($id);
        $this->itemId = $item->id;
        $this->name = $item->name;
        $this->brand = $item->brand;
        $this->price = $item->price;
        $this->quantity = $item->quantity;
        $this->location_id = $item->location_id;
        $this->location_detail_id = $item->location_detail_id;
        $this->description = $item->description;
        $this->condition = $item->condition;
        $this->purchase_date = $item->purchase_date;
        $this->serial_number = $item->serial_number;
        $this->category_id = $item->category_id;

        $this->showCreateForm = true;
    }

    public function confirmDeletePrompt($id)
    {
        $this->itemToDelete         = Item::findOrFail($id);
        $this->confirmingDeleteId   = $id;
    }

    public function confirmDelete()
    {
       $item = Item::where('admin_id', auth()->id())
                    ->find($this->confirmingDeleteId);

        if (! $item) {
            session()->flash('error', 'Item tidak ditemukan atau sudah dihapus.');
            // reset state
            $this->confirmingDeleteId = null;
            $this->itemToDelete       = null;
            return $this->resetPage();
        }

        $item->delete();
        session()->flash('message', 'Kategori berhasil dihapus.');
        $this->confirmingDeleteId = null;
        $this->itemToDelete       = null;
        $this->resetPage();
    }

    public function deleteSelected()
    {
        if (empty($this->itemsSelected)) {
            session()->flash('error', 'Tidak ada kategori yang dipilih.');
            return;
        }

        $deleted = Item::whereIn('id', $this->itemsSelected)
            ->where('admin_id', auth()->id())
            ->delete();

        if ($deleted) {
            session()->flash('message', 'Kategori terpilih berhasil dihapus.');
        } else {
            session()->flash('error', 'Gagal menghapus kategori.');
        }

        $this->itemsSelected = [];
        $this->confirmingBulkDelete = false;
    }

    public function confirmBulkDelete()
    {
        if (empty($this->itemsSelected)) {
            session()->flash('error', 'Tidak ada kategori yang dipilih.');
            return;
        }

        $this->confirmingBulkDelete = true;
    }

    // Reset form
    public function resetFields()
    {
        $this->itemId = null;
        $this->name = '';
        $this->brand = '';
        $this->price = '';
        $this->quantity = '';
        $this->location_id = '';
        $this->location_detail_id = '';
        $this->description = '';
        $this->image_path = '';
        $this->condition = '';
        $this->purchase_date = '';
        $this->serial_number = '';
        $this->category_id = '';
    }

    public function render()
    {

        $query = Item::where('admin_id', auth()->id());

        if (!empty($this->keyword)) {
        $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->keyword . '%') // nama produk
                ->orWhereHas('location', function ($q2) {
                    $q2->where('name', 'like', '%' . $this->keyword . '%'); // nama lokasi dari relasi
                })
                ->orWhereHas('category', function ($q3) {
                    $q3->where('name', 'like', '%' . $this->keyword . '%'); // nama kategori
                });
            });
        }
        
        return view('livewire.items-manager', [
            'location' => Location::where('admin_id', auth()->id())->get(),
            'locationdetails' => LocationDetail::where('location_id', $this->location_id)->get(),
            'category' => Category::where('admin_id', auth()->id())->get(),
            'item' => $query->paginate(5),
        ]);
    }

}


