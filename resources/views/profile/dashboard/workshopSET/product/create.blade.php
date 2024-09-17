@extends('layouts.dashboard')
@section('content')
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    confirmButtonColor: "#3085d6",
                    text: '{{ session('success') }}'
                });
            });
        </script>
    @endif
    <div class="mt-8">
        <div class="flex justify-center">
            <div class="w-full bg-white shadow-lg rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6 text-center">Add New Product</h2>

                    <div class="flex flex-wrap">
                        <div class="w-full flex justify-center items-center">
                            <img src="{{ url('logos/add.png') }}" class="max-w-52">
                        </div>
                        <div class="w-full">
                            <form action="{{ route('product_seller.save') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-lg font-medium text-gray-700">Select
                                        Workshop</label>
                                    <select name="bengkel"
                                        class="mt-1 block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                        @php
                                            $bengkel = DB::table('tb_bengkel')
                                                ->join(
                                                    'tb_pelanggan',
                                                    'tb_bengkel.id_pelanggan',
                                                    '=',
                                                    'tb_pelanggan.id_pelanggan',
                                                )
                                                ->where([
                                                    ['tb_bengkel.delete_bengkel', 'N'],
                                                    ['tb_bengkel.id_pelanggan', Session::get('id_pelanggan')],
                                                ])
                                                ->orderBy('tb_bengkel.nama_bengkel', 'ASC')
                                                ->get();
                                        @endphp

                                        @if ($bengkel->isEmpty())
                                            <option value="">Data not found </option>
                                        @else
                                            <option value="">Choose your Workshop</option>
                                            @foreach ($bengkel as $data_bengkel)
                                                <option value="{{ $data_bengkel->id_bengkel }}">
                                                    {{ $data_bengkel->nama_bengkel }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-lg font-medium text-gray-700">Select
                                        Category</label>
                                    <select name="kategori"
                                        class="mt-1 block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                        @php
                                            $kategori = DB::table('tb_kategori_spare_part')
                                                ->where('tb_kategori_spare_part.deleted_kategori_spare_part', '=', 'N')
                                                ->orderBy('tb_kategori_spare_part.id_kategori_spare_part', 'ASC')
                                                ->get();
                                        @endphp

                                        @if ($kategori->isEmpty())
                                            <option value="">- Data not found -</option>
                                        @else
                                            <option value="">Choose Category Spare Part</option>
                                            @foreach ($kategori as $data_kategori)
                                                <option value="{{ $data_kategori->id_kategori_spare_part }}">
                                                    {{ $data_kategori->nama_kategori_spare_part }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-lg font-medium text-gray-700">Select Quality</label>
                                    <select name="kualitas"
                                        class="mt-1 block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                        @php
                                            $kualitas = DB::table('tb_kualitas_spare_part')
                                                ->where('tb_kualitas_spare_part.delete_kualitas_spare_part', '=', 'N')
                                                ->orderBy('tb_kualitas_spare_part.id_kualitas_spare_part', 'ASC')
                                                ->get();
                                        @endphp
                                        @if ($kualitas->isEmpty())
                                            <option value="">Data not found</option>
                                        @else
                                            <option value="">Choose Quality Spare Parts</option>
                                            @foreach ($kualitas as $data_kualitas)
                                                <option value="{{ $data_kualitas->id_kualitas_spare_part }}">
                                                    {{ $data_kualitas->nama_kualitas_spare_part }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-lg font-medium text-gray-700">Select Merk</label>
                                    <select name="merk"
                                        class="mt-1 block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                        @php
                                            $merk_sparepart = DB::table('tb_merk_spare_part')
                                                ->where('tb_merk_spare_part.deleted_merk_spare_part', '=', 'N')
                                                ->orderBy('tb_merk_spare_part.id_merk_spare_part', 'ASC')
                                                ->get();
                                        @endphp
                                        @if ($merk_sparepart->isEmpty())
                                            <option value="">Data not found</option>
                                        @else
                                            <option value="">Choose your Workshop</option>
                                            @foreach ($merk_sparepart as $data_merk_sparepart)
                                                <option value="{{ $data_merk_sparepart->id_merk_spare_part }}">
                                                    {{ $data_merk_sparepart->nama_merk_spare_part }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-lg font-medium text-gray-700">Product Name</label>
                                    <input type="text" name="nama" required maxlength="255"
                                        placeholder="Silahkan isi nama Product"
                                        class="mt-1 block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-lg font-medium text-gray-700">Price</label>
                                    <input type="number" name="harga" required maxlength="255" id="input-number"
                                        placeholder="Silahkan isi detail Price"
                                        class="mt-1 block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-lg font-medium text-gray-700">Description</label>
                                    <textarea name="keterangan" cols="30" rows="7" placeholder="Silahkan isi Deskripsi"
                                        class="mt-1 block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-lg font-medium text-gray-700">Stock</label>
                                    <input type="number" name="stok" required maxlength="255"
                                        placeholder="Silahkan isi Stock"
                                        class="mt-1 block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="mb-4">
                                    <label for="file-1" class="block text-lg font-medium text-gray-700 cursor-pointer">
                                        Upload Picture
                                        <img src="{{ asset('logos/image.png') }}" id="image-1"
                                            style="width: 150px; border-radius: 5px;">
                                        <input type="file" accept="image/*" name="foto" id="file-1" class="hidden"
                                            onchange="previewImage('image-1', 'file-1')">
                                    </label>
                                </div>
                                <div class="flex justify-start mr-2 font-medium text-sm space-x-4">
                                    <button type="button"
                                        class="bg-yellow-400 text-white font-bold py-2 px-4 rounded hover:bg-yellow-500"
                                        id="kembali">
                                        <i class='bx bx-arrow-back'></i> Back
                                    </button>

                                    <button type="submit"
                                        class="mr-2 bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600">
                                        <i class='bx bx-check-double'></i> Done
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImage(imageId, inputId) {
            const file = document.getElementById(inputId).files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(imageId).src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
