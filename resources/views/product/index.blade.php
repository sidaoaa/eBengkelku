@extends('layouts.app')

@section('title', 'eBengkelku - Product & Spare Parts')

@section('content')
  @php
    $page = request()->has('spareparts') ? 'spareparts' : 'product';
    $search = request()->get('search', '');
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
  <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="d-flex justify-content-center align-items-center" style="min-height: 50px;">
            <form method="GET" action="{{ request()->url() }}" style="width: 60%;">
              <div class="input-group">
                @if (request()->has('spareparts'))
                  <input type="hidden" name="spareparts" value="data">
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

      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <a href="{{ route('product') }}">
              <button type="button" class="btn btn-sm {{ $page == 'product' ? 'btn-primary' : 'btn-outline-primary' }}">
                Product
              </button>
            </a>
            <a href="{{ request()->url() }}?spareparts=data">
              <button type="button"
                class="btn btn-sm {{ $page == 'spareparts' ? 'btn-primary' : 'btn-outline-primary' }}">
                Spare Parts
              </button>
            </a>
            <p>&nbsp;</p>
          </div>
        </div>
      </div>

      @if ($page === 'spareparts')
        @include('product.spareparts')
      @endif
    </div>
  </section>
@endsection
