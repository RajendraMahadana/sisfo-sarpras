@extends('layout.main_layout')
@section('header-title', 'Location')
@section('content')
    @include('admin.component.sidebar')

    <main class="main" id="main">
       <div class="m-4 p-5 rounded-xl shadow-md">
            @livewire('user-management')
        </div>
    </main>
@endsection