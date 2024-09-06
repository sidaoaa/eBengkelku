@extends('layouts.app')

@section('title', 'eBengkelku - Event')

@section('content')
  @php
    $search = request('search', '');
    $visit = request('visit');

    $event = null;

    if ($visit) {
        $event = DB::table('tb_event')->where('id_event', $visit)->where('delete_event', 'N')->first();
    }

    if (!$event) {
        $events = DB::table('tb_event')->where('delete_event', 'N')->orderByDesc('id_event')->paginate(12);
    }

  @endphp

  @if ($visit && $event)
    <section class="section section-white"
      style="position: relative; overflow: hidden; padding-top: 100px; padding-bottom: 20px;">
      <div
        style="background-image: url('{{ asset('logos/wallpaper.png') }}'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat; position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0;">
      </div>
      <div class="bg-white" style="position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0; opacity: 0.7;">
      </div>

      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <h4 class="text-primary">Event Detail</h4>
          </div>
        </div>
      </div>
    </section>

    <section class="position-relative">
      <div class="bg-cover bg-center"
        style="background-image: url('{{ $event->image_cover ?? url('images/image.png') }}');   width: 100%;
        height: 100vh; /* Tinggi penuh layar */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;">
        <div class="overlay"
          style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5);"></div>
        <div class="container h-100 d-flex justify-content-center align-items-center">
          <div class="text-center text-white" style="backdrop-filter: blur(25px); padding: 20px; border-radius: 10px;">
            <h1 class="display-4">{{ $event->nama_event }}</h1>
            <p><i class="fas fa-calendar-alt"></i> {{ date('d F', strtotime($event->event_start_date)) }} -
              {{ date('d F Y', strtotime($event->event_end_date)) }}</p>
            <p><i class="fas fa-map-marker-alt"></i> {{ $event->alamat_event }}</p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="mb-4">
              <div class="card-body" style="color: white; background-color: white ">
                <h3>Deskripsi</h3>
                <hr style="border-color: black">
                <p>{!! nl2br(e($event->deskripsi)) !!}</p>
              </div>
            </div>

            @if ($event->event_start_date > now())
              <div class="text-center">
                <a href="{{ route('event.register', $event->id_event) }}" class="btn btn-primary btn-lg">Register</a>
              </div>
            @endif
          </div>
        </div>
      </div>
    </section>
  @else
    <section class="section section-white"
      style="position: relative; overflow: hidden; padding-top: 100px; padding-bottom: 20px;">
      <div
        style="background-image: url('{{ asset('logos/wallpaper.png') }}'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat; position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0;">
      </div>
      <div class="bg-white" style="position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0; opacity: 0.7;">
      </div>

      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <h4 class="text-primary">What's In The Event</h4>
          </div>
        </div>
      </div>
    </section>


    <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="d-flex justify-content-center align-items-center" style="min-height: 50px;">
              <form method="GET" action="{{ request()->url() }}" style="width: 60%;">
                <div class="input-group">
                  @if (request()->has('event'))
                    <input type="hidden" name="event" value="data">
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
        </div>

        @if ($events->isEmpty())
          <div class="text-center">
            <img src="{{ url('logos/empty.png') }}" class="mb-4" style="width: 150px;">
            <p>Data saat ini tidak ditemukan.</p>
          </div>
        @else
          <div class="row">
            @foreach ($events as $data_event)
              @php
                $harga = $data_event->tipe_harga == 1 ? 'Free' : 'Rp. ' . number_format($data_event->harga);
              @endphp

              <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                <a href="{{ url()->current() }}?visit={{ $data_event->id_event }}"
                  class="text-dark text-decoration-none">
                  <div class="card h-100">
                    <img src="{{ $data_event->image_cover }}" class="card-img-top" alt="{{ $data_event->nama_event }}"
                      style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                      <h5 class="card-title">{{ $data_event->nama_event }}</h5>
                      <p class="card-text">
                        <i class="fas fa-calendar"></i>
                        {{ date('d F', strtotime($data_event->event_start_date)) }} -
                        {{ date('d F Y', strtotime($data_event->event_end_date)) }}
                      </p>
                      <p class="card-text">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $data_event->alamat_event }}
                      </p>
                      <p class="card-text">
                        <strong>{{ $harga }}</strong>
                      </p>
                    </div>
                  </div>
                </a>
              </div>
            @endforeach
          </div>

          <div class="d-flex justify-content-center">
            {{ $events->links() }}
          </div>

        @endif
      </div>
    </section>
  @endif
@endsection
