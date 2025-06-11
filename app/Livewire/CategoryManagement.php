<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class CategoryManagement extends Component
{

    use WithPagination;
   
    public $editId;
    public $name, $description;

    public $newName;
    public $newDescription;
    public $keyword;
    public $categoriesSelected = [];
    public $confirmingDeleteId = null;
    public $categoryToDelete = null;
    public $showCreateForm = false;
    public $confirmingBulkDelete = false;
    public $selectAll = false;


    public function create()
    {
        $this->validate([
            'newName' => 'required|string|max:255|',
            'newDescription' => 'nullable|string',
        ]);

        Category::create([
            'name' => $this->newName,
            'description' => $this->newDescription,
            'admin_id' => auth()->id(),
        ]);

        session()->flash('message', 'Kategori berhasil ditambahkan.');
        $this->reset(['newName', 'newDescription']); 
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->editId = $id;
        $this->name = $category->name;
        $this->description = $category->description;
    }

   

    public function update()
    {
        $this->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $category = Category::findOrFail($this->editId);

        if ($category->admin_id !== Auth::id()) {
            session()->flash('error', 'Anda tidak memiliki izin untuk mengubah kategori ini.');
            return;
        }

        $category->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Kategori berhasil diperbarui.');
        $this->resetEdit();
    }

    public function confirmDeletePrompt($id)
    {
        $this->categoryToDelete     = Category::findOrFail($id);
        $this->confirmingDeleteId   = $id;
    }

    public function confirmDelete()
    {
        $category = Category::where('admin_id', auth()->id())
                            ->find($this->confirmingDeleteId);

        if (! $category) {
            session()->flash('error', 'Kategori tidak ditemukan atau sudah dihapus.');
            $this->confirmingDeleteId = null;
            $this->categoryToDelete   = null;
            
            return $this->resetPage();
        }

        $category->delete();
        session()->flash('message', 'Kategori berhasil dihapus.');
        $this->confirmingDeleteId = null;
        $this->categoryToDelete   = null;
        $this->resetPage();
    }

   public function deleteSelected()
    {
        if (empty($this->categoriesSelected)) {
            session()->flash('error', 'Tidak ada kategori yang dipilih.');
            return;
        }

        $deleted = Category::whereIn('id', $this->categoriesSelected)
            ->where('admin_id', auth()->id())
            ->delete();

        if ($deleted) {
            session()->flash('message', 'Kategori terpilih berhasil dihapus.');
        } else {
            session()->flash('error', 'Gagal menghapus kategori.');
        }

        $this->categoriesSelected = [];
        $this->confirmingBulkDelete = false;
    }

    public function confirmBulkDelete()
    {
        if (empty($this->categoriesSelected)) {
            session()->flash('error', 'Tidak ada kategori yang dipilih.');
            return;
        }

        $this->confirmingBulkDelete = true;
    }

    public function resetEdit()
    {
        $this->editId = null;
        $this->name = null;
        $this->description = null;
    }

    public function render()
    {
         $query = Category::where('admin_id', auth()->id());

        if (!empty($this->keyword)) {
            $query->where('name', 'like', '%' . $this->keyword . '%');
        }

        return view('livewire.category-management', [
            'categories' => $query->paginate(5),
        ]);
    }
}
