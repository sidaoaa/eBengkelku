@extends('layouts.app')

@section('title')
  eBengkelku - Service, Spare Part & Smart Tools
@endsection
@section('content')
  @php

    $bengkel = DB::table('tb_bengkel')
        ->join('tb_pelanggan', 'tb_bengkel.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
        ->where([['tb_bengkel.delete_bengkel', 'N']])
        ->orderBy('tb_bengkel.id_bengkel', 'DESC')
        ->paginate(12);

    $event = DB::table('tb_event')
        ->where([['tb_event.delete_event', 'N']])
        ->orderBy('tb_event.id_event', 'DESC')
        ->paginate(12);

    $spare_part = DB::table('m_barang')
        ->join('m_outlet', 'm_outlet.id_outlet', '=', 'm_barang.id_outlet')
        ->join('tb_bengkel', 'tb_bengkel.id_bengkel', '=', 'm_outlet.id_bengkel')
        ->where('m_barang.is_delete', 'N')
        ->where('m_barang.id_jenis_barang', '1')
        ->orderBy('m_barang.id_barang', 'DESC')
        ->paginate(12);

    $product = DB::table('m_barang')
        ->join('tb_bengkel', 'tb_bengkel.id_bengkel', '=', 'm_barang.id_outlet')
        ->join('tb_pelanggan', 'tb_bengkel.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
        ->where([['m_barang.is_delete', 'N']])
        ->where([['m_barang.id_jenis_barang', 3]])
        ->orderBy('m_barang.id_barang', 'DESC')
        ->paginate(12);

    $used_car = DB::table('tb_mobil')
        ->join('tb_pelanggan', 'tb_mobil.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
        ->where([['tb_mobil.delete_mobil', 'N']])
        ->where('status_mobil', 'Available')
        ->orderBy('tb_mobil.id_mobil', 'DESC')
        ->paginate(6);
  @endphp
  <div id="home" class="header-hero bg_cover" style="background-image: url('{{ asset('logos/wallpaper.png') }}')">

    <div class="container">

      <div class="row justify-content-center">

        <div class="col-xl-8 col-lg-10">

          <div class="header-content text-center" style="padding-top: 10em;">

            <div class="row">

              <div class="col-md-3">
                &nbsp;
              </div>

              <div class="col-md-6">
                <img src="{{ asset('logos/logo.png') }}" style="max-width: 100%;">
              </div>

            </div>

            <center>
              <h4>
                <p>&nbsp;</p>
                <b style="color: #3a6fb0;">Saling Support</b>
              </h4>
            </center>

            <ul class="header-btn">
              @if (Session::has('id_pelanggan'))
                <li>
                  <a class="main-btn btn-one" href="{{ route('profile') }}">
                    <i class='fa-regular fa-user'></i> PROFILE
                  </a>
                </li>
              @else
                <li>
                  <a class="main-btn btn-one" href="{{ route('login', ['register' => 'data']) }}">
                    REGISTER NOW
                  </a>
                </li>
              @endif

              <li>
                <a class="main-btn btn-two video-popup" href="https://www.youtube.com/watch?v=r44RKWyfcFw">
                  OUR VIDEO <i class='fa-regular fa-circle-play'></i>
                </a>
              </li>
            </ul>

          </div> <!-- header content -->

        </div>

      </div> <!-- row -->

    </div> <!-- container -->

    <div class="header-shape">
      <img src="{{ asset('template/assets/images/header-shape.svg') }}" alt="shape" style="margin-bottom: -5px;">
    </div>

  </div>

  <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="text-primary">
            <i class='fa-regular fa-calendar'></i> Latest Event
          </h4>
          <p>&nbsp;</p>
        </div>

        @if ($event->isEmpty())
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <center>
                    <img src="{{ asset('logos/empty.png') }}" style="width: 150px;">
                    <p>Data saat ini tidak ditemukan.</p>
                  </center>
                </div>
              </div>
            </div>
          </div>
        @else
          <div class="col-md-12">
            <div class="row">
              @foreach ($event as $data_event)
                @php
                  $harga = $data_event->tipe_harga == 1 ? 'Free' : 'Rp. ' . number_format($data_event->harga);
                @endphp

                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                  <a href="{{ route('event', ['visit' => $data_event->id_event]) }}" style="color: #ffffff;">
                    <div class="card">
                      <img class="card-img-top" src="{{ $data_event->image_cover }}" alt="Image" style="width: 100%;">
                      <div class="card-body">
                        <h5>
                          <b>{{ $data_event->nama_event }}</b>
                        </h5>
                        <p>&nbsp;</p>
                        <p>
                          <i class="fa-regular fa-calendar"></i>
                          <small>{{ \Carbon\Carbon::parse($data_event->event_start_date)->format('d F') }} -
                            {{ \Carbon\Carbon::parse($data_event->event_end_date)->format('d F Y') }}</small>
                        </p>
                        <p><small>{{ $harga }}</small></p>
                      </div>
                    </div>
                    <p>&nbsp;</p>
                  </a>
                </div>
              @endforeach
            </div>
          </div>

          <div class="col-md-12 text-center">
            <p>&nbsp;</p>
            <button type="button" class="btn btn-sm btn-primary">
              More Event
            </button>
          </div>
        @endif
      </div>
    </div>
  </section>
  <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="text-primary">
            <i class='fa-solid fa-city'></i> Latest Workshop
          </h4>
          <p>&nbsp;</p>
        </div>

        @if ($bengkel->isEmpty())
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <center>
                    <img src="{{ asset('logos/empty.png') }}" style="width: 150px;">
                    <p>Data saat ini tidak ditemukan.</p>
                  </center>
                </div>
              </div>
            </div>
          </div>
        @else
          <div class="col-md-12">
            <div class="row">
              @foreach ($bengkel as $data_bengkel)
                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                  <div class="card">
                    <img class="card-img-top" src="{{ $data_bengkel->foto_bengkel }}" alt="Image"
                      style="width: 100%;">
                    <div class="card-body">
                      <p id="ellipsis">
                        <b>{{ $data_bengkel->nama_bengkel }}</b>
                      </p>
                      <p id="ellipsis">
                        {{ $data_bengkel->tagline_bengkel }}
                      </p>
                      <p>&nbsp;</p>
                      <a href="{{ route('workshop', ['visit' => $data_bengkel->id_bengkel]) }}" style="color: #ffffff;">
                        <button type="button" class="btn btn-sm btn-primary">
                          Visit
                        </button>
                      </a>
                    </div>
                  </div>
                  <p>&nbsp;</p>
                </div>
              @endforeach
            </div>
          </div>

          <div class="col-md-12 text-center">
            <p>&nbsp;</p>
            <a href="{{ route('workshop') }}">
              <button type="button" class="btn btn-sm btn-primary">
                More Workshop
              </button>
            </a>
          </div>
        @endif
      </div>
    </div>
  </section>
  <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="text-primary">
            <i class='fa-solid fa-boxes-stacked'></i> Spare Parts
          </h4>
          <p>&nbsp;</p>
        </div>

        @if ($spare_part->isEmpty())
          <div class="col-md-12">
            <div class="card">
              <div class="card-body text-center">
                <img src="{{ url('logos/empty.png') }}" style="width: 150px;">
                <p>Data saat ini tidak ditemukan.</p>
              </div>
            </div>
          </div>
        @else
          <div class="col-md-12">
            <div class="row">
              @foreach ($spare_part as $data_spare_part)
                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                  <div class="card">
                    @if (is_null($data_spare_part->gambar))
                      <img class="card-img-top" src="{{ asset('images/image.png') }}" alt="Image"
                        style="width: 100%;">
                    @else
                      <img class="card-img-top" src="{{ $data_spare_part->gambar }}" alt="Image"
                        style="width: 100%;">
                    @endif

                    <div class="card-body">
                      <p id="ellipsis">{{ $data_spare_part->nama_barang }}</p>
                      <h4 id="ellipsis">Rp. {{ number_format($data_spare_part->harga_jual) }}</h4>
                      <p>&nbsp;</p>
                      <p id="ellipsis" style="font-size: 12px; color: #9f9f9f;">
                        <a href="javascript:;">
                          <i class="bx bxs-car-garage"></i> {{ $data_spare_part->nama_bengkel }}
                        </a>
                      </p>
                      <a href="{{ route('product.detail', ['id' => $data_spare_part->id_barang, 'ps' => 2]) }}"
                        class="btn btn-sm btn-primary">
                        <i class="bx bx-cart-alt"></i> Shop Now
                      </a>
                    </div>
                  </div>
                  <p>&nbsp;</p>
                </div>
              @endforeach
            </div>
          </div>

          <div class="col-md-12 text-center">
            <p>&nbsp;</p>
            <a href="{{ route('product', ['spare_parts' => 'data']) }}">
              <button type="button" class="btn btn-sm btn-primary">
                More Spare Parts
              </button>
            </a>
          </div>
        @endif
      </div>
    </div>
  </section>
  <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="text-primary">
            <i class='fa-solid fa-dolly'></i> Product
          </h4>
          <p>&nbsp;</p>
        </div>

        @if ($product->isEmpty())
          <div class="col-md-12">
            <div class="card">
              <div class="card-body text-center">
                <img src="{{ url('logos/empty.png') }}" style="width: 150px;">
                <p>Data saat ini tidak ditemukan.</p>
              </div>
            </div>
          </div>
        @else
          <div class="col-md-12">
            <div class="row">
              @foreach ($product as $data_product)
                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                  <div class="card">
                    <img class="card-img-top" src="{{ $data_product->foto_produk }}" alt="Image"
                      style="width:100%;">
                    <div class="card-body">
                      <p id="ellipsis">{{ $data_product->nama_produk }}</p>
                      <h4 id="ellipsis">Rp. {{ number_format($data_product->harga_produk) }}</h4>
                      <p>&nbsp;</p>
                      <p id="ellipsis" style="font-size: 12px; color: #9f9f9f;">
                        <a href="javascript:;">
                          <i class="bx bxs-car-garage"></i> {{ $data_product->nama_bengkel }}
                        </a>
                      </p>
                      <a href="{{ route('product.detail', ['id' => $data_product->id_produk, 'ps' => 1]) }}"
                        class="btn btn-sm btn-primary">
                        <i class="bx bx-cart-alt"></i> Shop Now
                      </a>
                    </div>
                  </div>
                  <p>&nbsp;</p>
                </div>
              @endforeach
            </div>
          </div>

          <div class="col-md-12 text-center">
            <p>&nbsp;</p>
            <a href="{{ route('product') }}">
              <button type="button" class="btn btn-sm btn-primary">
                More Product <i class='bx bx-right-arrow-alt'></i>
              </button>
            </a>
          </div>
        @endif
      </div>
    </div>
  </section>
  <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="text-primary">
            <i class='fa-solid fa-car-side'></i> Test Drive Now
          </h4>
          <p>&nbsp;</p>
        </div>

        @if ($used_car->isEmpty())
          <div class="col-md-12">
            <div class="card">
              <div class="card-body text-center">
                <img src="{{ url('logos/empty.png') }}" style="width: 150px;">
                <p>Data saat ini tidak ditemukan.</p>
              </div>
            </div>
          </div>
        @else
          <div class="col-md-12">
            <div class="owl-carousel owl-theme">
              @foreach ($used_car as $data_used_car)
                <div class="item">
                  <div class="card" style="cursor: pointer;">
                    <a href="{{ route('used_car.item', $data_used_car->id_mobil) }}">
                      <img class="card-img-top" src="{{ $data_used_car->foto_mobil ?: url('logos/produk/car.png') }}"
                        alt="Car Image" style="width:100%;">
                    </a>
                    <div class="card-body">
                      <a href="{{ route('used_car.item', $data_used_car->id_mobil) }}">
                        <p id="ellipsis"><b>{{ $data_used_car->jenis_mobil }} {{ $data_used_car->nama_mobil }}</b></p>
                      </a>
                      <p class="card-text" id="ellipsis">Rp. {{ number_format($data_used_car->harga_mobil) }}</p>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif

        <div class="col-md-12 text-center">
          <p>&nbsp;</p>
          <a href="{{ route('used_car') }}">
            <button type="button" class="btn btn-sm btn-primary">
              More Used Car
            </button>
          </a>
        </div>
      </div>
    </div>
  </section>


@endsection
