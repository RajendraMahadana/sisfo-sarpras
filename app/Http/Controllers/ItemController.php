<?php

namespace App\Http\Controllers;


use App\Models\Item;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin'); // Middleware untuk memastikan hanya admin yang dapat mengakses fitur ini
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::where('admin_id', auth()->id())->get();
        return view('admin.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil kategori yang dimiliki oleh admin yang sedang login
        $locations = Location::where('admin_id', auth()->id())->get();
        $categories = Category::where('admin_id', auth()->id())->get();
        return view('admin.items.create', compact('categories', 'locations'));
    }   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
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
        ]);
    
        // Pastikan kategori dimiliki oleh admin yang sedang login
        $category = Category::where('id', $request->category_id)
                            ->where('admin_id', auth()->id())
                            ->first();
    
        if (!$category) {
            return redirect()->back()->with('error', 'Kategori tidak valid atau tidak dapat diakses.');
        }
    
        // Simpan gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('item_images', 'public');
        }
    
        // Simpan data barang
        Item::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'location_id' => $request->location_id,
            'location_detail_id' => $request->location_detail_id,
            'description' => $request->description,
            'condition' => $request->condition ?? 'new',
            'purchase_date' => $request->purchase_date,
            'serial_number' => $request->serial_number,
            'image_path' => $imagePath,
            'admin_id' => auth()->id(),
            'category_id' => $request->category_id,
        ]);

    
        return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return view('admin.items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        // Pastikan item dimiliki oleh admin yang sedang login
        if ($item->admin_id !== auth()->id()) {
            return redirect()->route('items.index')->with('error', 'Anda tidak memiliki izin untuk mengedit barang ini.');
        }
    
        // Ambil kategori yang dimiliki oleh admin yang sedang login
        $categories = Category::where('admin_id', auth()->id())->get();
        return view('admin.items.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        if ($item->admin_id !== auth()->id()) {
            return redirect()->route('items.index')->with('error', 'Anda tidak memiliki izin untuk mengubah barang ini.');
        }
    
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:0',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Simpan gambar baru jika ada
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('item_images', 'public');
        } else {
            $imagePath = $item->image_path; // Tetap gunakan gambar lama jika tidak ada perubahan
        }
    
        $item->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'quantity' => $request->quantity,
            'image_path' => $imagePath,
        ]);
    
        return redirect()->route('items.index')->with('success', 'Barang berhasil diperbarui.');
    }
    
    public function destroy(Item $item)
    {
        if ($item->admin_id !== auth()->id()) {
            return redirect()->route('items.index')->with('error', 'Anda tidak memiliki izin untuk menghapus barang ini.');
        }
    
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function getLocationDetails($locationId)
    {
        $location = Location::with('locationDetails')->find($locationId);
        return response()->json($location ? $location->locationDetails : []);
    }
}