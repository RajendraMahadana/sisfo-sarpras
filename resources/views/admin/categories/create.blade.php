@extends('layout.main_layout')

@section('content')
<div class="container">
    <h1>{{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori' }}</h1>
    <form action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}" method="POST">
        @csrf
        @if(isset($category))
        @method('PUT')
        @endif
        <div class="mb-3">
            <label for="name" class="form-label">Nama Kategori</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required>
            @error('name')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($category) ? 'Perbarui' : 'Simpan' }}</button>
    </form>
</div>
@endsection