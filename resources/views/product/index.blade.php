@extends('layouts.app')

@section('title', 'eBengkelku - Product & Spare Parts')

@section('content')
  @php
    $page = request()->has('spareparts') ? 'spareparts' : 'product';
    $search = request()->get('search', '');
    $categories = DB::table('m_category')->where('is_delete', 'N')->get();
  @endphp

  <section class="section section-white"
    style="position: relative; overflow: hidden; padding-top: 100px; padding-bottom: 20px;">
    <div
      style="background-image: url({{ url('logos/wallpaper.png') }}); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat; position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0;">
    </div>
    <div class="bg-white" style="position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0; opacity: 0.7;">
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <h4 class="text-primary">Product & Spare Parts</h4>
        </div>
      </div>
    </div>
  </section>

  @push('css')
    <style>
      .form-control {
        border-radius: 20px 0 0 20px;
      }

      .btn-primary {
        border-radius: 0 20px 20px 0;
      }
    </style>
  @endpush

  <!-- Bagian Kategori -->

  <!-- Menu Navigasi -->

  <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">
      <div class="row mb-4">
        <div class="col-md-12">
          <ul class="nav nav-tabs justify-content-center">
            <li class="nav-item">
              <a class="nav-link {{ $page == 'product' ? 'active' : '' }}" href="{{ route('product') }}">Product</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ $page == 'spareparts' ? 'active' : '' }}" href="?spareparts=data">Spare
                Part</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card h-100;">
              <div class="card-body">
                <div class="card-title text-primary">
                  <strong>Categories</strong>
                </div>
                <p>&nbsp;</p>
                <ul class="list-group">
                  @foreach ($categories as $category)
                    <li class="list-group-item list-group-item-action d-flex align-items-center">
                      <img src="{{ url('logos/icon.png') }}" class="me-2" style="width: 25px;">
                      <a href="#" class="stretched-link text-decoration-none text-dark" id="ellipsis">
                        {{ $category->nama_category }}
                      </a>
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>
            <p>&nbsp;</p>
          </div>
        </div>

        @if (request()->has('spareparts'))
          @include('product.spareparts')
        @endif
      </div>
  </section>
@endsection
