@extends('layouts.app')

@section('title')
  eBengkelku - Workshop
@stop

@section('content')

  @php
    use Illuminate\Support\Facades\DB;

    $search = request('search', '');
    $visit = request('visit', null);
    $current_page = request('page', 'all');

    $bengkel = null;
    $services = null;
    $spareparts = null; // Inisialisasi variabel untuk spare parts

    if ($visit) {
        // Fetch the bengkel details and the corresponding customer (pelanggan) information
        $bengkel = DB::table('tb_bengkel')
            ->join('tb_pelanggan', 'tb_bengkel.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
            ->where('tb_bengkel.id_bengkel', $visit)
            ->select(
                'tb_bengkel.nama_bengkel',
                'tb_bengkel.tagline_bengkel',
                'tb_bengkel.foto_bengkel',
                'tb_bengkel.foto_cover_bengkel',
                'tb_pelanggan.telp_pelanggan',
                'tb_pelanggan.email_pelanggan',
            )
            ->first();

        if ($bengkel) {
            // Fetch services related to this bengkel
            $services = DB::table('tb_services')
                ->join('tb_bengkel', 'tb_services.id_bengkel', '=', 'tb_bengkel.id_bengkel')
                ->where('tb_services.delete_services', 'N')
                ->where('tb_services.id_bengkel', '=', $visit)
                ->orderByDesc('tb_services.id_services')
                ->get();

            // Fetch spare parts related to this bengkel
            $spareparts = DB::table('tb_spare_part')
                ->where('id_bengkel', '=', $visit)
                ->where('delete_spare_part', 'N') // Pastikan kolom ini ada
                ->orderByDesc('id_spare_part')
                ->get();
        }
    } else {
        // Fetch paginated list of bengkel if no specific bengkel is being visited
        $bengkel = DB::table('tb_bengkel')
            ->join('tb_pelanggan', 'tb_bengkel.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
            ->where('tb_bengkel.delete_bengkel', 'N')
            ->orderByDesc('tb_bengkel.id_bengkel')
            ->paginate(12);
    }

    // Define page names for navigation or display purposes
    $page_names = [
        'all' => 'All',
        'service' => 'Service',
        'product' => 'Product',
        'sparepart' => 'Spare Part',
        'ulasan' => 'Ulasan',
    ];
  @endphp

  @push('js')
    <script>
      function copyLink() {
        const link = window.location.href;
        navigator.clipboard.writeText(link).then(() => {
          alert('Profile link copied to clipboard!');
        });
      }
    </script>
  @endpush

  @if ($visit && !$bengkel)
    <script>
      window.location = "{{ route('workshop') }}";
    </script>
  @endif

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
          <h4 class="text-primary">See Our Workshop</h4>
        </div>
      </div>
    </div>
  </section>

  <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">

      @if ($visit && $bengkel)
        <!-- Jika ada parameter 'visit', tampilkan detail bengkel -->
        <div class="row">
          <div class="col-md-12">
            <div class="card mb-4">
              <div class="card-img-top"
                style="width: 100%; height: 300px; overflow: hidden; background-position: center; background-size: cover; background-repeat: no-repeat; background-image: url('{{ $bengkel->foto_cover_bengkel ?: url('images/image.png') }}');">
              </div>
              <div class="card-body text-center">
                <div class="bg-white mx-auto shadow"
                  style="width: 120px; height: 120px; overflow: hidden; background-position: center; background-size: cover; background-repeat: no-repeat; background-image: url('{{ $bengkel->foto_bengkel ?: url('images/image.png') }}'); border-radius: 100%; border: 5px solid #fff; margin-top: -75px; margin-bottom: 15px;">
                </div>
                <h3 class="card-title text-primary">{{ $bengkel->nama_bengkel }}</h3>
                <p class="card-text text-muted"><i>{{ $bengkel->tagline_bengkel }}</i></p>
              </div>
            </div>
          </div>

          <!-- Rating, Operating Hours, Contact, and Share Profile -->
          <div class="col-md-12">
            <div class="card mb-4">
              <div class="card-body">
                <div class="row justify-content-center text-center">
                  <!-- Rating -->
                  <div class="col-6 col-md-3 mb-3">
                    <h5 class="text-primary"><i class="fa-solid fa-star"></i> Rating</h5>
                    &nbsp
                    <p class="card-text text-muted">
                      <i class="fa-solid fa-star text-warning"></i>
                      <i class="fa-solid fa-star text-warning"></i>
                      <i class="fa-solid fa-star text-warning"></i>
                      <i class="fa-solid fa-star text-warning"></i>
                      <i class="fa-solid fa-star-half-alt text-warning"></i>
                      <br>
                      4.5 / 5.0
                    </p>
                  </div>

                  <!-- Operating Hours -->
                  <div class="col-6 col-md-3 mb-3">
                    <h5 class="text-primary"><i class="fa-solid fa-clock"></i> Operating Hours</h5>
                    &nbsp
                    <p class="card-text text-muted">
                      {{ $bengkel->jam_operasional ?? 'Not Available' }}
                    </p>
                  </div>

                  <!-- Contact Information -->
                  <div class="col-6 col-md-3 mb-3">
                    <h5 class="text-primary"><i class="fa-solid fa-phone"></i> Contact</h5>
                    &nbsp
                    <div class="d-grid gap-2 d-md-block">
                      <a href="https://wa.me/{{ $bengkel->telp_pelanggan }}" target="_blank" class="btn btn-success">
                        <i class="fa-brands fa-whatsapp"></i>
                      </a>
                      <a href="mailto:{{ $bengkel->email_pelanggan }}" class="btn btn-secondary">
                        <i class="fa-solid fa-envelope"></i>
                      </a>
                    </div>

                  </div>
                  <div class="col-6 col-md-3 mb-3">
                    <h5 class="text-primary"><i class="fa-solid fa-city"></i> Info</h5>
                    &nbsp
                    <div class="d-grid gap-2 d-md-block">
                      <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#bengkelModal">
                        <i class="fa-solid fa-circle-info"></i>
                      </button>


                      <button class="btn btn-outline-primary" type="button" onclick="copyLink()">
                        <i class="fa-solid fa-copy"></i>
                      </button>

                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Menu Navigasi -->
            <div class="row mb-4">
              <div class="col-md-12">
                <ul class="nav nav-tabs justify-content-center">
                  @foreach ($page_names as $page => $name)
                    <li class="nav-item">
                      <a class="nav-link {{ $current_page === $page ? 'active' : '' }}"
                        href="?visit={{ $visit }}&page={{ $page }}">{{ $name }}</a>
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>

            <!-- Breadcrumb -->
            <div class="row mb-4">
              <div class="col-md-12">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('workshop') }}">Workshop</a></li>
                    <li class="breadcrumb-item"><a href="#">{{ $bengkel->nama_bengkel }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      {{ $page_names[$current_page] ?? '' }}
                    </li>
                  </ol>
                </nav>
              </div>
            </div>

            <!-- Konten Berdasarkan Halaman -->

            <div class="row">
              @if ($current_page === 'all' || $current_page === 'service')
                <div class="col-md-12 mb-3">
                  <h4 class="text-primary"><i class="fa-solid fa-wrench"></i> Service</h4>
                </div>
                @if ($services && count($services) > 0)
                  @foreach ($services as $service)
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                      <div class="card shadow h-100 d-flex flex-column" style="border: none;">
                        <img class="card-img-top" src="{{ $service->foto_services }}" alt="Image"
                          style="width: 100%;">
                        <div class="card-body">
                          <p id="ellipsis"><b>{{ $service->nama_services }}</b></p>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @else
                  <div class="col-md-12">
                    <div class="card shadow h-100 d-flex flex-column" style="border: none;">
                      <div class="card-body text-center">
                        <img src="{{ url('logos/empty.png') }}" style="width: 150px;">
                        <p>Data saat ini tidak ditemukan.</p>
                      </div>
                    </div>
                  </div>
                @endif
              @endif
              @if ($current_page === 'all' || $current_page === 'product')
                <div class="col-md-12 mb-3">
                  <h4 class="text-primary"><i class="fa-solid fa-dolly"></i> Product</h4>
                </div>
                <div class="col-md-12 mb-3">
                  <div class="card shadow h-100 d-flex flex-column" style="border: none;">
                    <div class="card-body text-center">
                      <img src="{{ url('logos/empty.png') }}" style="width: 150px;">
                      <p>Data saat ini tidak ditemukan.</p>
                    </div>
                  </div>
                </div>
              @endif

              @if ($current_page === 'all' || $current_page === 'sparepart')
                <div class="col-md-12 mb-3">
                  <h4 class="text-primary"><i class="fa-solid fa-boxes-stacked"></i> Spare Parts</h4>
                </div>

                @if ($spareparts->isEmpty())
                  <div class="col-md-12">
                    <div class="card shadow h-100 d-flex flex-column" style="border: none;">
                      <div class="card-body text-center">
                        <img src="{{ url('logos/empty.png') }}" style="width: 150px;">
                        <p>Data saat ini tidak ditemukan.</p>
                      </div>
                    </div>
                  </div>
                @else
                  @foreach ($spareparts as $sparepart)
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                      <div class="card shadow h-100 d-flex flex-column" style="border: none;">
                        <img src="{{ asset('storage/' . $sparepart->foto_spare_part) }}" class="card-img-top"
                          alt="{{ $sparepart->nama_spare_part }}">
                        <div class="card-body">
                          <h5 class="card-title">{{ $sparepart->nama_spare_part }}</h5>
                          <p class="card-text">
                            Harga: {{ number_format($sparepart->harga_spare_part, 0, ',', '.') }}<br>

                          </p>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @endif
              @endif
              <!-- Modal -->

              <div class="modal fade " id="bengkelModal" tabindex="-1" aria-labelledby="bengkelModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header ">
                      <h5 class="modal-title" id="bengkelModalLabel">Workshop Description</h5>
                      <h5 class="text-secondary"><i class="fa-solid fa-circle-xmark" data-bs-dismiss="modal"></i>
                      </h5>
                    </div>
                    <div class="modal-body">
                      <h5>{{ $bengkel->nama_bengkel }}</h5>
                      &nbsp
                      <p><strong>Alamat:</strong> {{ $bengkel->alamat ?? 'Alamat belum tersedia' }}</p>
                      </br>
                      <p><strong>Jam Operasional:</strong>
                        {{ $bengkel->jam_operasional ?? 'Jam operasional belum tersedia' }}</p>
                      </br>
                      <p><strong>Kontak:</strong> {{ $bengkel->telp_pelanggan ?? 'Kontak tidak tersedia' }}</p>
                      </br>
                      <p><strong>Email:</strong> {{ $bengkel->email_pelanggan ?? 'Email tidak tersedia' }}</p>
                      </br>
                      <p><strong>Tagline:</strong> <i>{{ $bengkel->tagline_bengkel ?? 'Tidak ada tagline' }}</i></p>
                      </br>

                      <!-- Social Media Links -->
                      <!-- Social Media Icons -->
                      @php
                        $bengkel->facebook = $bengkel->facebook ?? null;
                        $bengkel->instagram = $bengkel->instagram ?? null;
                        $bengkel->twitter = $bengkel->twitter ?? null;
                        $bengkel->linkedin = $bengkel->linkedin ?? null;

                      @endphp
                      <p><strong>Follow Us:</strong></p>
                      <div class="social-media-icons">
                        @if ($bengkel->facebook)
                          <a href="{{ $bengkel->facebook }}" target="_blank" class="me-2">
                            <i class="fab fa-facebook fa-2x"></i>
                          </a>
                        @endif

                        @if ($bengkel->instagram)
                          <a href="{{ $bengkel->instagram }}" target="_blank" class="me-2">
                            <i class="fab fa-instagram fa-2x"></i>
                          </a>
                        @endif

                        @if ($bengkel->twitter)
                          <a href="{{ $bengkel->twitter }}" target="_blank" class="me-2">
                            <i class="fab fa-twitter fa-2x"></i>
                          </a>
                        @endif

                        @if ($bengkel->linkedin)
                          <a href="{{ $bengkel->linkedin }}" target="_blank" class="me-2">
                            <i class="fab fa-linkedin fa-2x"></i>
                          </a>
                        @endif
                      </div>
                    </div>

                  </div>
                </div>
              </div>

            </div>

            <!-- Ulasan Section -->
            @if ($current_page === 'all' || $current_page === 'ulasan')
              <div class="col-md-1` mb-3 mt-3">
                <h4 class="text-primary"><i class="fa-solid fa-comments"></i> Ulasan</h4>
              </div>

              @php
                // Contoh data ulasan, ini bisa diganti dengan data dari database
                $ulasan = [
                    [
                        'nama_pelanggan' => 'John Doe',
                        'rating' => 5,
                        'komentar' => 'Pelayanan sangat baik dan memuaskan!',
                        'tanggal' => '2024-09-05',
                    ],
                    [
                        'nama_pelanggan' => 'Jane Smith',
                        'rating' => 4,
                        'komentar' => 'Bengkel rapi dan bersih, teknisi ramah.',
                        'tanggal' => '2024-09-04',
                    ],
                ];
              @endphp

              @if (!empty($ulasan))
                @foreach ($ulasan as $review)
                  <div class="col-md-1` mb-3">
                    <div class="card shadow h-100 d-flex flex-column" style="border: none;">
                      <div class="card-body">
                        <h5 class="card-title">{{ $review['nama_pelanggan'] }}</h5>
                        <div class="d-flex align-items-center">
                          @for ($i = 0; $i < 5; $i++)
                            <i
                              class="fa-solid fa-star {{ $i < $review['rating'] ? 'text-warning' : 'text-muted' }}"></i>
                          @endfor
                          <span class="ml-2 text-muted">{{ $review['rating'] }} / 5.0</span>
                        </div>
                        <p class="card-text mt-2">{{ $review['komentar'] }}</p>
                        <p class="text-muted"><small>{{ date('d M Y', strtotime($review['tanggal'])) }}</small></p>
                      </div>
                    </div>
                  </div>
                @endforeach
              @else
                <div class="col-md-12">
                  <div class="card shadow h-100 d-flex flex-column" style="border: none;">
                    <div class="card-body text-center">
                      <img src="{{ url('logos/empty.png') }}" style="width: 150px;">
                      <p>Belum ada ulasan.</p>
                    </div>
                  </div>
                </div>
              @endif
            @endif
          </div>
        @else
          <!-- Jika tidak ada parameter 'visit', tampilkan daftar bengkel -->
          @php
            $bengkelCount = count($bengkel);
          @endphp

          @if ($bengkelCount < 1)
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
              <div class="col">
                <div class="d-flex justify-content-center align-items-center" style="min-height: 50px;">
                  <form method="GET" action="{{ request()->url() }}" style="width: 60%;">
                    <div class="input-group">
                      @if (request()->has('workshop'))
                        <input type="hidden" name="workshop" value="data">
                      @endif
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
                <p>&nbsp;</p>
              </div>

              <div class="row">
                @foreach ($bengkel as $b)
                  <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card shadow h-100 d-flex flex-column" style="border: none;">
                      <div class="card-img-top"
                        style="width: 100%; height: 230px; overflow: hidden; background-position: center; background-size: cover; background-repeat: no-repeat; background-image: url('{{ $b->foto_bengkel ?: url('images/image.png') }}');">
                      </div>
                      <div class="card-body">
                        <p id="ellipsis">
                          <b>{{ $b->nama_bengkel }}</b><br>
                          <small><i>{{ $b->tagline_bengkel }}</i></small>
                        </p>
                        <a href="{{ route('workshop', ['visit' => $b->id_bengkel]) }}" class="stretched-link"></a>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>

              <div class="row">
                <div class="col-md-12 text-center">
                  {{ $bengkel->appends(request()->input())->links() }}
                </div>
              </div>
            </div>
          @endif
      @endif

    </div>
  </section>

@endsection
