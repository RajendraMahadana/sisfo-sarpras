<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin');
    }

    /**
     * Display a listing of the resource.
     */ 
    public function index()
    {
        $categories = Category::where('admin_id', auth()->id())->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:categories',
    ]);

    Category::create([
        'name' => $request->name,
        'admin_id' => auth()->id(), // Simpan ID admin yang membuat kategori
    ]);

    return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
}

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if ($category->admin_id !== auth()->id()) {
            return redirect()->route('categories.index')->with('error', 'Anda tidak memiliki izin untuk mengubah kategori ini.');
        }
    
        $category->update([
            'name' => $request->name,
        ]);
    
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }
    
    public function destroy(Category $category)
    {
        if ($category->admin_id !== auth()->id()) {
            return redirect()->route('categories.index')->with('error', 'Anda tidak memiliki izin untuk menghapus kategori ini.');
        }
    
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}