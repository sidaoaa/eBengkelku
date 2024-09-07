@extends('layouts.app')
@php
  $query = Barang::join('m_outlet', 'm_outlet.id_outlet', '=', 'm_barang.id_outlet')
      ->join('tb_bengkel', 'tb_bengkel.id_bengkel', '=', 'm_outlet.id_bengkel')
      ->where('m_barang.is_delete', 'N')
      ->where('m_barang.id_jenis_barang', '3');

  if ($request->has('search')) {
      $query->where('nama_barang', 'like', '%' . $request->input('search') . '%');
  }

  $products = $query->orderBy('m_barang.id_barang', 'DESC')->paginate(12);

@endphp

@section('content')
  <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="text-primary">
            <i class='fa-solid fa-boxes-stacked'></i> Spare Parts
          </h4>
          <p>&nbsp;</p>
        </div>

        @if ($products->isEmpty())
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body text-center">
                  <img src="{{ asset('logos/empty.png') }}" style="width: 150px;">
                  <p>Data saat ini tidak ditemukan.</p>
                </div>
              </div>
            </div>
          </div>
        @else
          <div class="row">
            @foreach ($products as $data_produk)
              <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                <a href="{{ route('product.detail', ['id' => $data_produk->id_barang, 'ps' => 1]) }}"
                  class="text-decoration-none">
                  <div class="card h-100 d-flex flex-column">
                    <img class="card-img-top" src="{{ $data_produk->gambar }}" alt="Image"
                      style="width:100%; height: auto;">
                    <div class="card-body">
                      <p class="mb-1"><b>{{ $data_produk->nama_barang }}</b></p>
                      <p class="mb-1">Rp. {{ number_format($data_produk->harga_jual) }}</p>
                      <p class="text-muted" style="font-size: 12px;">
                        <a href="javascript:;">
                          <i class="fas fa-car"></i> {{ $data_produk->nama_bengkel }}
                        </a>
                      </p>
                      <a href="{{ route('product.detail', ['id' => $data_produk->id_barang, 'ps' => 1]) }}"
                        class="btn btn-sm btn-primary">
                        <i class="fas fa-shopping-cart"></i> Shop Now
                      </a>
                    </div>
                  </div>
                </a>
              </div>
            @endforeach
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="d-flex justify-content-center">
                {{ $products->links() }}
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
  </section>
@endsection
