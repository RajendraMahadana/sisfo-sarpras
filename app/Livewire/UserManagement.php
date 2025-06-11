<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class UserManagement extends Component
{
    use WithPagination;
    public $user_id;
    public $name;
    public $email;
    public $password;
    public $role;
    public $users = [];
    public $password_confirmation;
    public $showCreateForm = false;
    public $confirmingBulkDelete = false;
    public $userToDelete = null;
    public $confirmingDeleteId = null;
    public $usersSelected = [];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user_id),
            ],
            'password' => $this->user_id ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'admin_id' => auth()->id(),
        ];

        // hanya tambahkan password jika diisi
        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        $user = User::updateOrCreate(
            ['id' => $this->user_id],
            $data
        );

        session()->flash('message', $user->wasRecentlyCreated ? 'User created successfully!' : 'User updated successfully!');
        $this->users = User::all();
        $this->resetFields();
    }

    public function edit($id)
    {
        $user = User::find($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = '';
        $this->showCreateForm = true;
    }

    public function confirmDeletePrompt($id)
    {
        $this->userToDelete = User::findOrFail($id);
        $this->confirmingDeleteId = $id;
    }

    public function confirmDelete() {
        $user = User::where('admin_id', auth()->id())->find($this->confirmingDeleteId);
        
        if (! $user) {
            session()->flash('error', 'Item tidak ditemukan atau sudah dihapus.');
            // reset state
            $this->confirmingDeleteId = null;
            $this->userToDelete   = null;
            return $this->resetPage();
        }

        $user->delete();
        session()->flash('message', 'User berhasil dihapus.');
        $this->confirmingDeleteId = null;
        $this->userToDelete   = null;
        $this->resetPage();
    }

    public function deleteSelected()
    {
        if (empty($this->usersSelected)) {
            session()->flash('error', 'Tidak ada User yang dipilih.');
            return;
        }

        $deleted = User::whereIn('id', $this->usersSelected)
            ->where('admin_id', auth()->id())
            ->delete();

        if ($deleted) {
            session()->flash('message', 'User terpilih berhasil dihapus.');
        } else {
            session()->flash('error', 'Gagal menghapus User.');
        }

        $this->usersSelected = [];
        $this->confirmingBulkDelete = false;
    }

    public function confirmBulkDelete()
    {
        if (empty($this->usersSelected)) {
            session()->flash('error', 'Tidak ada user yang dipilih.');
            return;
        }

        $this->confirmingBulkDelete = true;
    }

    public function resetFields()
    {
        $this->user_id = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = 'user'; // Default role
    }
    
    public function render()
    {
        return view('livewire.user-management', [
            'user' => User::where('admin_id', auth()->id())->paginate(5),
        ]);
    }
}
