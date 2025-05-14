@extends('layout.main_layout')
@section('header-title', 'Items')
@section('content')
    @include('admin.component.sidebar')

    <main class="main" id="main">
        <div class="m-4 p-5 rounded-xl shadow-md">
            @livewire('items-manager')
        </div>
    </main>
@endsection