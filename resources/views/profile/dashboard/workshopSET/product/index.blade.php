@extends('layouts.dashboard')
@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-center mt-8">
        <div class="mb-4 mt-10 flex-1">
            <input type="text" id="search" class="h-10 px-4 w-full max-w-md border rounded-md" placeholder="Search">
        </div>
        <div class="mb-4 mt-10">
            <a href="{{ route('product.create') }}"
                class="bg-sky-400 text-white flex items-center px-4 font-medium text-xs sm:text-sm md:text-base py-1 sm:py-2 rounded-lg shadow-lg">
                Add Product
            </a>
        </div>
    </div>
    <div class="w-full flex justify-center items-center">
        <img src="{{ url('logos/add.png') }}" class="max-w-56">
    </div>
    <div class="mt-2">
        <p class="text-center text-sm text-gray-500">Tidak ada Product yang tersedia.</p>
    </div>
@endsection
