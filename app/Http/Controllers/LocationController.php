<?php
namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // Menampilkan daftar lokasi
    public function index()
    {
        $locations = Location::where('admin_id', auth()->id())->get(); // Filter berdasarkan admin
        return view('admin.locations.index', compact('locations'));
    }   

    // Menampilkan halaman tambah lokasi
    public function create()
    {
        return view('admin.locations.create');
    }

    // Menyimpan data lokasi baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations',
        ]);

        Location::create([
            'name' => $request->name,
            'admin_id' => auth()->id(), // Mengaitkan lokasi dengan admin
        ]);

        return redirect()->route('locations.index')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    // Menampilkan detail lokasi
    public function show(Location $location)
    {
        if ($location->admin_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke lokasi ini.');
        }
        return view('locations.show', compact('location'));
    }

    // Menampilkan halaman edit lokasi
    public function edit(Location $location)
    {
        if ($location->admin_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke lokasi ini.');
        }
        return view('admin.locations.edit', compact('location'));
    }

    // Memperbarui data lokasi
    public function update(Request $request, Location $location)
    {
        if ($location->admin_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke lokasi ini.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:locations,name,' . $location->id,
        ]);

        $location->update([
            'name' => $request->name,
        ]);

        return redirect()->route('locations.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    // Menghapus lokasi
    public function destroy(Location $location)
    {
        if ($location->admin_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke lokasi ini.');
        }

        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Lokasi berhasil dihapus.');
    }
}