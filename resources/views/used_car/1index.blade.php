@extends('layouts.app')


@section('title')
  eBengkelku - Used Car
@endsection
@php

  $search = request('search', '');
  // $search = request('search', '');
  $merkFilter = request('merkFilter', '');
  $hargaFilter = request('hargaFilter', '');
  $tahunFilter = request('tahunFilter', '');
@endphp
@section('content')
  <section class="section section-white"
    style="position: relative;overflow: hidden;padding-top: 100px;padding-bottom: 20px;">

    <div
      style="background-image: url(<?= url('logos/wallpaper.png') ?>);background-size: cover;background-position: center;background-attachment: fixed;background-repeat: no-repeat;position: absolute;width: 100%;top: 0;bottom: 0;left: 0;right: 0;">
    </div>
    <div class="bg-white" style="position: absolute;width: 100%;top: 0;bottom: 0;left: 0;right: 0;opacity: 0.7;"></div>

    <div class="container">

      <div class="row">
        <div class="col-md-12" align="center">
          <h4 class="text-primary">See Our Used Car</h4>
        </div>
      </div>
    </div>
  </section>

  <section class="section bg-white" style="padding-top: 50px;padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <form method="GET" action="{{ route('used_car') }}">
            <div class="input-group">
              <input type="text" name="search" value="{{ $search }}" required maxlength="255"
                placeholder="Ketik kata kunci ..." class="form-control">
              <div class="input-group-append">
                <button type="submit" class="btn btn-sm btn-primary">
                  <i class='bx bx-search-alt'></i>
                </button>
              </div>
            </div>
          </form>
          <p>&nbsp;</p>
        </div>
        @if (Session::has('id_pelanggan'))
          <div class="col-md-2">
            <div align="right">
              <a href="{{ route('profile') }}?state=used_car&create=data" class="btn btn-sm btn-outline-primary"
                style="white-space: nowrap;background-color: #22577A;border: 1px solid #22577A;">
                <span class="text-light">Sell Used Car &nbsp; <i class='bx bx-add-to-queue'></i></span>
              </a>
            </div>
          </div>
        @endif
      </div>
      <div class="row">
        <div class="col-md-2">
          <p class="mb-2">Filter <i class="bx bx-filter"></i></p>
          <input type="hidden" name="merkFilter" id="merkFilter" value="{{ $merkFilter }}">
          <input type="hidden" name="hargaFilter" id="hargaFilter" value="{{ $hargaFilter }}">
          <input type="hidden" name="tahunFilter" id="tahunFilter" value="{{ $tahunFilter }}">
          <div class="table-responsive">
            <h5 class="mb-3">Merk dan Model</h5>
            @foreach (['Honda', 'Toyota', 'Daihatsu', 'Mitsubishi', 'Suzuki', 'BMW', 'Mercedes-Benz', 'Wuling', 'KIA'] as $data_merk)
              <button type="button" class="btn btn-sm btn-outline-primary btn-block d-block"
                onclick="filterByJenis('{{ $data_merk }}')">
                {{ $data_merk }}
              </button>
            @endforeach
            <p>&nbsp;</p>
          </div>
          <div class="table-responsive">
            <h5 class="mb-3">Harga</h5>
            @foreach (['< 100 Juta', '100 - 150 Juta', '150 - 200 Juta', '200 - 250 Juta', '250 - 300 Juta', '> 300 Juta'] as $data_harga)
              <button type="button" class="btn btn-sm btn-outline-primary btn-block d-block"
                onclick="filterByHarga('{{ $data_harga }}')">
                {{ $data_harga }}
              </button>
            @endforeach
            <p>&nbsp;</p>
          </div>
          <div class="table-responsive">
            <h5 class="mb-3">Tahun</h5>
            @foreach (['3 tahun terakhir', '5 tahun terakhir', '10 tahun terakhir'] as $data_tahun)
              <button type="button" class="btn btn-sm btn-outline-primary btn-block d-block"
                onclick="filterByTahun('{{ $data_tahun }}')">
                {{ $data_tahun }}
              </button>
            @endforeach
            <p>&nbsp;</p>
          </div>
          <p>&nbsp;</p>
        </div>
        <div class="col-md-10">
          <div class="row" id="filters">
            @if ($usedCars->isEmpty())
              <div class="col-md-12 textOld">
                <div class="card">
                  <div class="card-body">
                    <center>
                      <img src="{{ url('logos/empty.png') }}" style="width: 150px;">
                      <p>Data saat ini tidak ditemukan.</p>
                    </center>
                  </div>
                </div>
              </div>
            @else
              @foreach ($usedCars as $data_used_car)
                <div class="col-6 col-sm-6 col-md-4 col-lg-3 textOld">
                  <div class="card">
                    <a href="{{ route('used_car.item', $data_used_car->id_mobil) }}">
                      <img class="card-img-top" src="{{ $data_used_car->foto_mobil ?: url('logos/produk/car.png') }}"
                        alt="Image" style="width:100%;">
                    </a>
                    <div class="card-body">
                      <p id="ellipsis">
                        <a href="{{ route('used_car.item', $data_used_car->id_mobil) }}">
                          <b>{{ $data_used_car->jenis_mobil }} {{ $data_used_car->nama_mobil }}</b>
                        </a>
                      </p>
                      <h5 id="ellipsis">
                        Rp. {{ number_format($data_used_car->harga_mobil) }}
                      </h5>
                      <br>
                      <p id="ellipsis">
                        <small>{{ $data_used_car->lokasi_mobil }}</small>
                      </p>
                      <p>
                        <small>{{ $data_used_car->create_date }}</small>
                      </p>
                    </div>
                  </div>
                  <p>&nbsp;</p>
                </div>
              @endforeach
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            @if ($usedCars->isEmpty())
              <div class="card">
                <div class="card-body">
                  <center>
                    <img src="{{ url('logos/empty.png') }}" style="width: 150px;">
                    <p>Data saat ini tidak ditemukan.</p>
                  </center>
                </div>
              </div>
            @else
              <!-- Code to display used cars -->
            @endif
            {{ $usedCars->links() }}
          </div>
        </div>
      </div>

    </div>
  </section>
  <section class="section bg-white" style="padding-top: 10px;padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div id="mycarousel" class="carousel slide" data-ride="carousel" data-interval="10000">
            <ol class="carousel-indicators">
              @php
                $foto_mobil = $foto_mobil ?? collect(); // Ensure it's always a collection
              @endphp
              @if (isset($used_car))
                <h3 style="margin: 0px;">
                  {{ $used_car->jenis_mobil }} {{ $used_car->nama_mobil }} ({{ $used_car->tahun_mobil }})
                </h3><br>
              @else
                <p>Car details are not available.</p>
              @endif


              <!-- Carousel indicators -->
              @if ($foto_mobil->isNotEmpty())
                @foreach ($foto_mobil as $index => $foto)
                  <li data-target="#mycarousel" data-slide-to="{{ $index }}"
                    class="{{ $index == 0 ? 'active' : '' }}"></li>
                @endforeach
              @else
                <li data-target="#mycarousel" data-slide-to="0" class="active"></li>
              @endif
              @if (session('debug'))
                <pre>{{ print_r(session('debug'), true) }}</pre>
              @endif

            </ol>

            <div class="carousel-inner">
              @if ($foto_mobil->isNotEmpty())
                @foreach ($foto_mobil as $index => $foto)
                  <div class="carousel-item {{ $index == 0 ? 'active' : '' }}" align="center"
                    style="background-color: #3a3a3a;">
                    <img src="{{ asset('storage/' . $foto->file_foto_mobil) }}" class="d-block w-50"
                      alt="{{ $foto->description ?? 'Car image' }}" loading="lazy">
                  </div>
                @endforeach
              @else
                <div class="carousel-item active" align="center" style="background-color: #3a3a3a;">
                  <img src="{{ asset('images/image.png') }}" class="d-block w-50" alt="Default image" loading="lazy">
                </div>
              @endif
            </div>

            <a class="carousel-control-prev" href="#mycarousel" role="button" data-slide="prev">
              <div class="banner-icons"> <i class='bx bx-chevron-left'></i> </div>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#mycarousel" role="button" data-slide="next">
              <div class="banner-icons"> <i class='bx bx-chevron-right'></i> </div>
              <span class="sr-only">Next</span>
            </a>
          </div>
          <br>

          @if (isset($used_car))
            <div class="col-md-8">
              <div class="card">
                <div class="card-body">
                  <h3 style="margin: 0px;">
                    {{ $used_car->jenis_mobil }} {{ $used_car->nama_mobil }} ({{ $used_car->tahun_mobil }})
                  </h3><br>
                  <span><i class='bx bx-gas-pump' style="font-size: 18px;"></i>
                    {{ $used_car->bahan_bakar_mobil }}</span>
                  &nbsp; | &nbsp;
                  <span>{{ number_format($used_car->km_mobil) }} KM</span> &nbsp; | &nbsp;
                  <span><i class='bx bx-sitemap' style="font-size: 18px;"></i>
                    {{ $used_car->jenis_transmisi_mobil }}</span>
                </div>
              </div>
            </div>
          @else
            <div class="col-md-8">
              <div class="card">
                <div class="card-body">
                  <p>Car details are not available.</p>
                </div>
              </div>
            </div>
          @endif
          <p>&nbsp;</p>
        </div>
        @if (isset($used_car))
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <center>
                  <h3>Rp. {{ number_format($used_car->harga_mobil) }}</h3>
                </center>
              </div>
            </div>
            <p>&nbsp;</p>
          </div>
        @else
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <center>
                  <p>Price not available.</p>
                </center>
              </div>
            </div>
            <p>&nbsp;</p>
          </div>
        @endif

        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <h3 style="margin: 0px;">Informasi</h3>
              <div style="border-bottom: 1px solid rgba(0,47,52,.2);"></div><br>
              <div class="row">
                <div class="col-md-4">
                  <table>
                    <tr>
                      <th><span align="center"><i class='bx bxs-user' style="font-size: 30px;"></i> Penjual</span></th>
                    </tr>
                    <tr>
                      <td style="padding-left: 10px">
                        @isset($used_car)
                          {{ $used_car->nama_pelanggan }}
                        @else
                          <p>Pelanggan not available.</p>
                        @endisset
                      </td>
                    </tr>

                  </table>
                </div>
                <div class="col-md-4">
                  <table>
                    <tr>
                      <th>
                        <span align="center"><i class='bx bxs-map' style="font-size: 30px;"></i> Lokasi</span>
                      </th>
                    </tr>
                    <tr>
                      <td style="padding-left: 10px">
                        @isset($used_car)
                          {{ $used_car->lokasi_mobil }}
                        @else
                          <p>Lokasi not available.</p>
                        @endisset
                      </td>
                    </tr>
                  </table>
                </div>
                <div class="col-md-4">
                  <table>
                    <tr>
                      <th>
                        <span align="center"><i class='bx bxs-steam'></i> Kapasitas Mesin</span>
                      </th>
                    </tr>
                    <tr>
                      <td style="padding-left: 10px">
                        @isset($used_car)
                          {{ $used_car->kapasitas_mesin_mobil }}
                        @else
                          <p>Lokasi not available.</p>
                        @endisset
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <p>&nbsp;</p>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('scripts')
  <script>
    $(document).ready(function() {
      // CSRF Token Setup
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      window.filterByJenis = function(jenis) {
        $.ajax({
          url: '{{ route('filter.car') }}',
          type: 'POST',
          data: {
            car: jenis,
            harga: $('#hargaFilter').val(),
            tahun: $('#tahunFilter').val()
          },
          success: function(response) {
            $('#filters').html('');
            if (response.status === 'success') {
              response.data.forEach(function(car) {
                $('#filters').append(`
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3 textOld">
                                    <div class="card">
                                        <a href="/used-cars/${car.id_mobil}">
                                            <img class="card-img-top" src="${car.foto_mobil || '/logos/produk/car.png'}" alt="Image" style="width:100%;">
                                        </a>
                                        <div class="card-body">
                                            <p id="ellipsis">
                                                <a href="/used-cars/${car.id_mobil}">
                                                    <b>${car.jenis_mobil} ${car.nama_mobil}</b>
                                                </a>
                                            </p>
                                            <h5 id="ellipsis">
                                                Rp. ${numberWithCommas(car.harga_mobil)}
                                            </h5>
                                            <br>
                                            <p id="ellipsis">
                                                <small>${car.lokasi_mobil}</small>
                                            </p>
                                            <p>
                                                <small>${car.create_date}</small>
                                            </p>
                                        </div>
                                    </div>
                                    <p>&nbsp;</p>
                                </div>
                            `);
              });
            }
          }
        });
      }

      window.filterByHarga = function(harga) {
        $('#hargaFilter').val(harga);
        filterByJenis($('#merkFilter').val());
      }

      window.filterByTahun = function(tahun) {
        $('#tahunFilter').val(tahun);
        filterByJenis($('#merkFilter').val());
      }

      function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }
    });
  </script>
@endsection
