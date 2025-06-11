@extends('layout.main_layout')
@section('header-title', 'Category')
@section('content')
@include('admin.component.sidebar')
    <main class="main" id="main">

        @livewire('category-management')
        {{-- <div class="m-4 p-5 shadow-md rounded-xl">
            <div>
                <h1 class="font-semibold text-xl">Data Category</h1>
                <p class="text-xs">List Data Category</p>
            </div>

            <div class="mt-5">
                <table class="overflow-hidden rounded-lg">
                    <thead class=" bg-slate-200">
                        <tr class=" text-xs text-zinc-600">
                            <th class="py-2 px-4 text-start">ID</th>
                            <th class="py-2 px-4 text-start">NO</th>
                            <th class="py-2 px-4 text-start">CATEGORY NAME</th>
                            <th class="py-2 px-4 text-start">TOTAL ITEM</th>
                            <th class="py-2 px-4 text-start">DESCRIPTION</th>
                        </tr>
                    </thead>
                    <tbody class=" text-sm">
                        @foreach ($categories as $index => $category)
                        <tr>
                            <td class="py-2 px-4 text-start text-zinc-400 font-semibold">{{ $category->id }}</td>
                            <td class="py-2 px-4 text-start">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 text-start">{{ $category->name }}</td>
                            <td class="py-2 px-4 text-start">{{ $category->items->sum('quantity') }}</td>
                            <td class="py-2 px-4 text-start">{{ $category->description ?? "-"}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> --}}
    </main>
@endsection