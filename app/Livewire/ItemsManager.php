<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Item;
use Livewire\Component;
use App\Models\Location;
use Livewire\WithFileUploads;
use App\Models\LocationDetail;
use Illuminate\Support\Facades\Storage;

class ItemsManager extends Component
{
    use WithFileUploads;

    // Data untuk form
    public $name, $brand, $price, $quantity, $location_id, $location_detail_id, $description, $image_path, $condition, $purchase_date, $serial_number, $category_id;
    public $locations = [];
    public $locationDetails = [];
    public $categories;

    // Untuk edit
    public $itemId;

    // Validasi
    protected $rules = [
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

    // Daftar items
    public $items = [];

    public function mount()
    {
        $this->locations = Location::where('admin_id', auth()->id())->get();
        $this->locationDetails = LocationDetail::where('admin_id', auth()->id())->get();
        $this->categories = Category::where('admin_id', auth()->id())->get();
        $this->items = Item::where('admin_id', auth()->id())->get();
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
        Item::updateOrCreate(
            ['id' => $this->itemId],
            [
                'name' => $this->name,
                'brand' => $this->brand,
                'price' => $this->price,
                'quantity' => $this->quantity,
                'location_id' => $this->location_id,
                'location_detail_id' => $this->location_detail_id,
                'description' => $this->description,
                'image_path' => $imageName ?? null,
                'condition' => $this->condition,
                'purchase_date' => $this->purchase_date,
                'serial_number' => $this->serial_number,
                'category_id' => $this->category_id,
                'admin_id' => auth()->id(),
            ]
        );

        $this->resetFields();
        $this->items = Item::all(); // Refresh daftar
        session()->flash('success', $this->itemId ? 'Data berhasil diperbarui!' : 'Data berhasil ditambahkan!');
    }

    public function updatedLocationId($value)
    {
        if ($value) {
            // Ambil detail lokasi berdasarkan location_id yang dipilih
            $this->locationDetails = LocationDetail::where('location_id', $value)->get();
        } else {
            // Reset detail lokasi jika lokasi tidak dipilih
            $this->locationDetails = [];
            $this->location_detail_id = null;
        }
    }

    public function getLocationDetails()
    {
        return $this->locationDetails;
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
    }

    // Hapus data
    public function delete($id)
    {
        $item = Item::find($id);
        if ($item->image_path) {
            Storage::disk('public')->delete($item->image_path);
        }
        $item->delete();
        $this->items = Item::all(); // Refresh daftar
        session()->flash('success', 'Data berhasil dihapus!');
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
        return view('livewire.items-manager');
    }

}
