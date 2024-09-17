@extends('layouts.dashboard')
@section('content')
    @php
        $bengkel = DB::table('tb_bengkel')
            ->join('tb_pelanggan', 'tb_bengkel.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
            ->where('tb_bengkel.delete_bengkel', 'N')
            ->where('tb_bengkel.id_pelanggan', session('id_pelanggan'))
            ->orderByDesc('tb_bengkel.id_bengkel')
            ->get();
    @endphp
    @if ($bengkel->isEmpty())
        <div class="mt-8">
            <div class="flex justify-center">
                <div class="p-6 text-center">
                    <div class="flex flex-col items-center">
                        <img src="{{ url('logos/empty.png') }}" class="max-w-52" alt="Empty">
                        <p class="text-gray-700">Data Bengkel Anda belum ada, silakan tambahkan bengkel Anda dahulu ya...
                        </p>
                    </div>
                    <div class="flex justify-center space-x-4 mt-4">
                        <button type="button"
                            class="py-2 px-4 bg-yellow-500 text-white rounded hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <i class='bx bx-arrow-back'></i> Back
                        </button>
                        <a href="{{ route('workshop.create') }}"
                            class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class='bx bx-plus'></i> Add New Workshop
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="flex justify-center items-center min-h-screen bg-gray-100">
            <div class="w-full max-w-3xl p-6 bg-white rounded-lg shadow-md">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold">Add New Services</h2>
                </div>
                <div class="flex flex-wrap">
                    <div class="w-full md:w-1/2 text-center mb-4 md:mb-0">
                        <img src="{{ url('logos/add.png') }}" class="max-w-xs mx-auto" alt="Add Service">
                    </div>
                    <div class="w-full md:w-1/2">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('services_seller.save') }}">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Bengkel</label>
                                <select name="id_bengkel"
                                    class="form-select block w-full bg-gray-200 border border-gray-300 rounded-lg p-2"
                                    required>
                                    @foreach ($bengkel as $data_bengkel)
                                        <option value="{{ $data_bengkel->id_bengkel }}">
                                            {{ $data_bengkel->nama_bengkel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Services Name</label>
                                <input type="text" name="nama_services"
                                    class="form-input block w-full bg-gray-200 border border-gray-300 rounded-lg p-2"
                                    required maxlength="255" placeholder="Required ...">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Keterangan Service</label>
                                <textarea name="keterangan_services"
                                    class="form-textarea block w-full bg-gray-200 border border-gray-300 rounded-lg p-2" required
                                    placeholder="Required ..."></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Upload Image</label>
                                <label for="file-1" class="flex justify-center items-center cursor-pointer">
                                    <img src="{{ url('logos/image.png') }}" id="image-1"
                                        class="w-36 rounded-md border border-gray-300" alt="Preview">
                                    <input type="file" accept="image/*" name="foto" id="file-1" class="hidden"
                                        onchange="previewImage('image-1', 'file-1')">
                                </label>
                            </div>
                            <div class="flex justify-center space-x-4">
                                <button type="button"
                                    class="py-2 px-4 bg-yellow-500 text-white rounded hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                    <i class='bx bx-arrow-back'></i> Back
                                </button>
                                <button type="submit"
                                    class="py-2 px-4 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                                    <i class='bx bx-check-double'></i> Done
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
