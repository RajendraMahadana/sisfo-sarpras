@extends('layout.main_layout')

@section('content')
<div class="container">
    <h1>{{ isset($user) ? 'Edit User' : 'Tambah User' }}</h1>
    <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST">
        @csrf
        @if(isset($user))
        @method('PUT')
        @endif
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
            <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="admin" {{ isset($user) && $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ isset($user) && $user->role === 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Perbarui' : 'Simpan' }}</button>
    </form>
</div>
@endsection