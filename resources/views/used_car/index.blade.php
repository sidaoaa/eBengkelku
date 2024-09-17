@extends('layouts.app')

@php
  $current_page = request('page', 'all');
  $search = request('search', '');
  $priceRange = request('price', '');
  $brand = request('brand', '');

  $harga = [
      '<100' => '< 100 Juta',
      '100-150' => '100 - 150 Juta',
      '150-200' => '150 - 200 Juta',
      '200-250' => '200 - 250 Juta',
      '>250' => '> 250 Juta',
  ];

  $brands = [
      'toyota' => 'Toyota',
      'suzuki' => 'Suzuki',
      'honda' => 'Honda',
      'daihatsu' => 'Daihatsu',
      'mitsubishi' => 'Mitsubishi',
      'nissan' => 'Nissan',
      'mercy' => 'Mercedes Benz',
      'bmw' => 'BMW',
  ];
@endphp

@section('content')
  <section class="section section-white"
    style="position: relative; overflow: hidden; padding-top: 100px; padding-bottom: 20px;">
    <div
      style="background-image: url('{{ url('logos/wallpaper.png') }}'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat; position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0;">
    </div>
    <div class="bg-white" style="position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0; opacity: 0.7;">
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-12" align="center">
          <h4 class="text-primary">See Our Used Car</h4>
        </div>
      </div>
    </div>
  </section>

  <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="d-flex justify-content-center align-items-center" style="min-height: 50px;">
            <form method="GET" action="{{ url()->current() }}" style="width: 60%;">
              <div class="input-group">
                <input type="text" name="search" value="{{ $search }}" required maxlength="255"
                  placeholder="Ketik kata kunci..." class="form-control" style="border-radius: 20px 0 0 20px;">
                <div class="input-group-append">
                  <button type="submit" class="btn btn-primary" style="border-radius: 0 20px 20px 0;">
                    <i class='fa-solid fa-search'></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
          &nbsp;
        </div>

        <!-- Menu Navigasi Harga -->
        <div class="row mb-4">
          <h4 class="text-primary">Cari Mobil Berdasarkan Harga</h4>
          <div class="col-md-12">
            <ul class="nav nav-tabs">
              @foreach ($harga as $key => $label)
                <li class="nav-item">
                  <a class="nav-link {{ $priceRange === $key ? 'active' : '' }}"
                    href="?search={{ $search }}&price={{ $key }}&brand={{ $brand }}">{{ $label }}</a>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
        <div class="row">
          @forelse($usedCars as $car)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
              <a href="/cars/{{ $car->id_mobil }}" class="text-decoration-none">
                <div class="card shadow h-100 d-flex flex-column" style="border: none;">
                  <img class="card-img-top" src="{{ $car->foto_mobil ?: url('logos/produk/car.png') }}" alt="Image"
                    style="width:100%;">
                  <div class="card-body">
                    <h5 class="card-title text-dark">{{ $car->nama_mobil }}</h5>
                    <p class="card-text text-dark text-truncate" style="max-width: 100%;">
                      Jenis: {{ $car->jenis_mobil }}<br>
                      Harga: Rp{{ number_format($car->harga_mobil, 0, ',', '.') }}
                    </p>
                  </div>
                </div>
              </a>
            </div>
          @empty
            <div class="col-12">
              <p class="text-center">Tidak ada mobil tersedia untuk filter ini.</p>
            </div>
          @endforelse
        </div>
      </div>

      <!-- Menu Navigasi Brand -->
      <div class="row mb-4">
        <h4 class="text-primary">Cari Mobil Berdasarkan Brand</h4>
        <div class="col-md-12">
          <ul class="nav nav-tabs">
            @foreach ($brands as $key => $label)
              <li class="nav-item">
                <a class="nav-link {{ $brand === $key ? 'active' : '' }}"
                  href="?search={{ $search }}&price={{ $priceRange }}&brand={{ $key }}">{{ $label }}</a>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class="row">
        @forelse($usedCars as $car)
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <a href="/cars/{{ $car->id_mobil }}" class="text-decoration-none">
              <div class="card shadow h-100 d-flex flex-column" style="border: none;">
                <img class="card-img-top" src="{{ $car->foto_mobil ?: url('logos/produk/car.png') }}" alt="Image"
                  style="width:100%;">
                <div class="card-body">
                  <h5 class="card-title text-dark">{{ $car->nama_mobil }}</h5>
                  <p class="card-text text-dark text-truncate" style="max-width: 100%;">
                    Jenis: {{ $car->jenis_mobil }}<br>
                    Harga: Rp{{ number_format($car->harga_mobil, 0, ',', '.') }}
                  </p>
                </div>
              </div>
            </a>
          </div>
        @empty
          <div class="col-12">
            <p class="text-center">Tidak ada mobil tersedia untuk filter ini.</p>
          </div>
        @endforelse
      </div>
    </div>
  </section>
@endsection
