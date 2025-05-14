<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserAdminController extends Controller
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
        // Ambil semua user yang dibuat oleh admin saat ini
        $users = User::where('admin_id', auth()->id())->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tampilkan halaman form untuk membuat user baru
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user',
        ]);

        // Simpan data user baru ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'admin_id' => auth()->id(), // Simpan ID admin yang membuat user
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Cari user berdasarkan ID dan pastikan hanya admin yang membuatnya yang dapat melihatnya
        $user = User::where('id', $id)->where('admin_id', auth()->id())->firstOrFail();
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Cari user berdasarkan ID dan pastikan hanya admin yang membuatnya yang dapat mengeditnya
        $user = User::where('id', $id)->where('admin_id', auth()->id())->firstOrFail();
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Cari user berdasarkan ID dan pastikan hanya admin yang membuatnya yang dapat memperbaruinya
        $user = User::where('id', $id)->where('admin_id', auth()->id())->firstOrFail();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,user',
        ]);

        // Persiapkan data untuk diperbarui
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Jika password diisi, tambahkan ke data
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Perbarui data user
        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari user berdasarkan ID dan pastikan hanya admin yang membuatnya yang dapat menghapusnya
        $user = User::where('id', $id)->where('admin_id', auth()->id())->firstOrFail();

        // Hapus user
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}