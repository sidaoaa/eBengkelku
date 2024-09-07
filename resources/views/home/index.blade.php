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
              <div class="col-md-3">&nbsp;</div>
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
          </div>
        </div>
      </div>
    </div>
    <div class="header-shape">
      <img src="{{ asset('template/assets/images/header-shape.svg') }}" alt="shape" style="margin-bottom: -5px;">
    </div>
  </div>

  <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="text-primary">
            <i class='fa-regular fa-calendar-alt'></i> Latest Event
          </h4>
          <p>&nbsp;</p>
        </div>

        @if ($event->isEmpty())
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
            @foreach ($event as $data_event)
              @php
                $harga = $data_event->tipe_harga == 1 ? 'Free' : 'Rp. ' . number_format($data_event->harga);
              @endphp

              <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                <a href="{{ url()->current() }}?visit={{ $data_event->id_event }}" class="text-dark text-decoration-none">
                  <div class="card h-100 d-flex flex-column">
                    <img src="{{ $data_event->image_cover }}" class="card-img-top" alt="{{ $data_event->nama_event }}"
                      style="width: 100; height: auto;">
                    <div class="card-body">
                      <h5 class="card-title">{{ $data_event->nama_event }}</h5>
                      <p id="ellipsis">
                        <i class="fa-regular fa-calendar-alt"></i>
                        {{ date('d F', strtotime($data_event->event_start_date)) }} -
                        {{ date('d F Y', strtotime($data_event->event_end_date)) }}
                      </p>
                      <p id="ellipsis">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $data_event->alamat_event }}
                      </p>
                      <p id="ellipsis">
                        <strong>{{ $harga }}</strong>
                      </p>
                    </div>
                    <p>&nbsp;</p>
                  </div>
                </a>
              </div>
            @endforeach
          </div>

          <div class="d-flex justify-content-center">
            {{ $event->links() }}
          </div>
        @endif
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
                <div class="card-body text-center">
                  <img src="{{ asset('logos/empty.png') }}" style="width: 150px;">
                  <p>Data saat ini tidak ditemukan.</p>
                </div>
              </div>
            </div>
          </div>
        @else
          <div class="row">
            @foreach ($bengkel as $data_bengkel)
              <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                <a href="{{ route('workshop', ['visit' => $data_bengkel->id_bengkel]) }}" class="text-decoration-none">
                  <div class="card h-100 d-flex flex-column">
                    <img class="card-img-top" src="{{ $data_bengkel->foto_bengkel }}" alt="Image"
                      style="width: 100; height: auto;">
                    <div class="card-body">
                      <p id="ellipsis">
                        <b>{{ $data_bengkel->nama_bengkel }}</b><br>
                        <small><i>{{ $data_bengkel->tagline_bengkel }}</i></small>
                      </p>
                    </div>
                  </div>
                </a>
              </div>
            @endforeach
          </div>
          <div class="col-md-12 text-center">
            <p>&nbsp;</p>
            <a href="{{ route('workshop') }}" class="btn btn-sm btn-primary">More Workshop</a>
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
            @foreach ($spare_part as $data_spare_part)
              <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                <a href="{{ route('product', ['visit' => $data_spare_part->id_barang]) }}" class="text-decoration-none">
                  <div class="card h-100 d-flex flex-column">
                    @if (is_null($data_spare_part->gambar))
                      <img class="card-img-top" src="{{ asset('images/image.png') }}" alt="Image"
                        style="width:100; height: auto;">
                      <div class="card-body">
                        <p id="ellipsis"><b>{{ $data_spare_part->nama_barang }}</b></p>
                        <p class="mb-0">Rp. {{ number_format($data_spare_part->harga_jual) }}</p>
                      @else
                        <img class="card-img-top" src="{{ $data_spare_part->gambar }}" alt="Image"
                          style="width:100; height: auto;">
                        <div class="card-body">
                          <p id="ellipsis"><b>{{ $data_spare_part->nama_barang }}</b></p>
                          <p class="mb-0">Rp. {{ number_format($data_spare_part->harga_jual) }}</p>
                    @endif

                    &nbsp
                  </div>
              </div>
              </a>
          </div>
        @endforeach
      </div>
      <div class="col-md-12 text-center">
        <p>&nbsp;</p>
        <a href="{{ route('product', ['jenis' => '1']) }}" class="btn btn-sm btn-primary">More Spare
          Parts</a>
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
            <i class='fa-solid fa-dolly'></i> New Product
          </h4>
          <p>&nbsp;</p>
        </div>

        @if ($product->isEmpty())
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body text-center">
                  <img src="{{ url('logos/empty.png') }}" style="width: 150px;">
                  <p>Data saat ini tidak ditemukan.</p>
                </div>
              </div>
            </div>
          </div>
        @else
          <div class="row">
            @foreach ($product as $data_product)
              <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                <a href="{{ route('product', ['visit' => $data_product->id_barang]) }}" class="text-decoration-none">
                  <div class="card h-100 d-flex flex-column">
                    <img class="card-img-top" src="{{ $data_product->img_cover }}" alt="Image"
                      style="width: 100%; height: auto;">
                    <div class="card-body">
                      <p class="mb-0"><b>{{ $data_product->nama_barang }}</b></p>
                      <p class="mb-0">Rp. {{ number_format($data_product->harga_jual) }}</p>
                      <p>&nbsp;</p>
                    </div>
                  </div>
                </a>
              </div>
            @endforeach
          </div>
          <div class="col-md-12 text-center">
            <p>&nbsp;</p>
            <a href="{{ route('product', ['jenis' => '3']) }}" class="btn btn-sm btn-primary">More Product</a>
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
                        <p id="ellipsis"><b>{{ $data_used_car->jenis_mobil }} {{ $data_used_car->nama_mobil }}</b>
                        </p>
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
