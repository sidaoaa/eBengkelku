@extends('layouts.dashboard')
@section('content')
    <div class="mt-8">
        <div class="flex justify-center">
            <div class="w-full bg-white shadow-lg rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6 text-center">Add New Spare Part</h2>

                    <div class="flex flex-wrap">
                        <div class="w-full flex justify-center items-center">
                            <img src="{{ url('logos/add.png') }}" class="max-w-52">
                        </div>

                        <div class="w-full">
                            <form action="{{ route('spare_part_seller.save') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mb-4">
                                    <label for="select_workshop" class="block text-lg font-medium text-gray-700 ">Select
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
                                            <option value="">Data not found</option>
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
                                    <label for="select_category" class="block text-lg font-medium text-gray-700 ">Select
                                        Category</label>
                                    <select name="jenis"
                                        class="mt-1 block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                        @php
                                            $jenis_sparepart = DB::table('m_category')
                                                ->where('m_category.is_delete', '=', 'N')
                                                ->orderBy('m_category.id_category', 'ASC')
                                                ->get();
                                        @endphp

                                        @if ($jenis_sparepart->isEmpty())
                                            <option value="">Data not found</option>
                                        @else
                                            <option value="">Choose your Category</option>
                                            @foreach ($jenis_sparepart as $data_jenis_sparepart)
                                                <option value="{{ $data_jenis_sparepart->id_category }}">
                                                    {{ $data_jenis_sparepart->nama_category }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="select_quality" class="block text-lg font-medium text-gray-700 ">Select
                                        Quality</label>
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
                                            <option value="">Choose your Spare Part</option>
                                            @foreach ($kualitas as $data_kualitas)
                                                <option value="{{ $data_kualitas->id_kualitas_spare_part }}">
                                                    {{ $data_kualitas->nama_kualitas_spare_part }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="select_merk" class="block text-lg font-medium text-gray-700 ">Select
                                        Merk</label>
                                    <select name="merk"
                                        class="mt-1 block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                        @php
                                            $merk_sparepart = DB::table('m_merk')
                                                ->where('m_merk.is_delete', '=', 'N')
                                                ->orderBy('m_merk.id_merk', 'ASC')
                                                ->get();
                                        @endphp

                                        @if ($merk_sparepart->isEmpty())
                                            <option value="">Data not found</option>
                                        @else
                                            <option value="">Choose your Spare Part</option>
                                            @foreach ($merk_sparepart as $data_merk_sparepart)
                                                <option value="{{ $data_merk_sparepart->id_merk }}">
                                                    {{ $data_merk_sparepart->nama_merk }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-lg font-medium text-gray-700">Spare Part Name</label>
                                    <input type="text" name="nama" required maxlength="255"
                                        placeholder="Silahkan di isi nama Spare Part"
                                        class="mt-1 block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-lg font-medium text-gray-700">Description</label>
                                    <input type="text" name="keterangan" required maxlength="255"
                                        placeholder="Silahkan di isi Deskripsi"
                                        class="mt-1 block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-lg font-medium text-gray-700">Stock</label>
                                    <input type="number" name="stok" required maxlength="255"
                                        placeholder="Silahkan di isi jumlah Stock "
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
@endsection
