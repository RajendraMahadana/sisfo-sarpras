<?php
namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LocationDetail;
use Illuminate\Http\Request;

class LocationDetailController extends Controller
{
    // Menampilkan daftar detail lokasi
    public function index()
    {
        $details = LocationDetail::where('admin_id', auth()->id())->get(); // Filter berdasarkan admin
        return view('admin.location_details.index', compact('details'));
    }

    // Menampilkan halaman tambah detail lokasi
    public function create()
    {
        $locations = Location::where('admin_id', auth()->id())->get();
        return view('admin.location_details.create', compact('locations'));
    }

    // Menyimpan data detail lokasi baru
    public function store(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'name' => 'required|string|max:255',
        ]);

        LocationDetail::create([
            'location_id' => $request->location_id,
            'name' => $request->name,
            'description' => $request->description,
            'admin_id' => auth()->id(), // Mengaitkan detail lokasi dengan admin
        ]);

        return redirect()->route('location-details.index')->with('success', 'Detail lokasi berhasil ditambahkan.');
    }

    // Menampilkan detail lokasi
    public function show(LocationDetail $detail)
    {
        if ($detail->admin_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke detail lokasi ini.');
        }
        return view('admin.location_details.show', compact('detail'));
    }

    // Menampilkan halaman edit detail lokasi
    public function edit(LocationDetail $detail)
    {
        if ($detail->admin_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke detail lokasi ini.');
        }
        return view('admin.location_details.edit', compact('detail'));
    }

    // Memperbarui data detail lokasi
    public function update(Request $request, LocationDetail $detail)
    {
        if ($detail->admin_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke detail lokasi ini.');
        }

        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'name' => 'required|string|max:255',
        ]);

        $detail->update([
            'location_id' => $request->location_id,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('location-details.index')->with('success', 'Detail lokasi berhasil diperbarui.');
    }

    // Menghapus detail lokasi
    public function destroy(LocationDetail $detail)
    {
        if ($detail->admin_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke detail lokasi ini.');
        }

        $detail->delete();
        return redirect()->route('location-details.index')->with('success', 'Detail lokasi berhasil dihapus.');
    }
}