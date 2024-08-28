@extends('layouts.app')


@section('title')
  eBengkelku - Profile
@endsection

@section('content')
  @php
    // Fetch customer data
    $pelanggan = DB::table('ebengkel_new_database_pkl.tb_pelanggan')
        ->where('delete_pelanggan', 'N')
        ->where('id_pelanggan', Session::get('id_pelanggan'))
        ->first();

    if (!$pelanggan) {
        return Redirect::route('logout.submit');
    }
    $page = request('state', '');
  @endphp

  <section class="section section-white"
    style="position: relative;overflow: hidden;padding-top: 100px;padding-bottom: 20px;">

    <div
      style="background-image: url(<?= url('logos/wallpaper.png') ?>);background-size: cover;background-position: center;background-attachment: fixed;background-repeat: no-repeat;position: absolute;width: 100%;top: 0;bottom: 0;left: 0;right: 0;">
    </div>
    <div class="bg-white" style="position: absolute;width: 100%;top: 0;bottom: 0;left: 0;right: 0;opacity: 0.7;"></div>

    <div class="container">

      <div class="row">
        <div class="col-md-12" align="center">
          <h4 class="text-primary">User Dashboard</h4>
        </div>
      </div>
    </div>
  </section>

  <section class="section bg-light vh-100 d-flex align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
          <!-- Navigation Buttons -->
          <div class="d-flex justify-content-center mb-4">
            <a href="{{ route('dashboard') }}" 2
              class="btn btn-sm {{ $page == 'dashboard' ? 'btn-primary' : 'btn-outline-primary' }} mx-2">
              <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('profile') }}"
              class="btn btn-sm {{ $page == '' ? 'btn-primary' : 'btn-outline-primary' }} mx-2">
              <i class="fas fa-user"></i> Profile
            </a>
            <a href="{{ route('my_order') }}"
              class="btn btn-sm {{ $page == 'my_order' ? 'btn-primary' : 'btn-outline-primary' }} mx-2">
              <i class="fas fa-dolly"></i> My Orders
            </a>
          </div>

          <!-- Content -->
          @if ($page == 'dashboard')
            @include('dashboard.index')
          @elseif($page == 'my_order')
            @include('profile.my_order')
          @else
            <div class="card shadow-sm">
              <div class="card-body text-center">
                <h5 class="card-title font-weight-bold mb-4">Profile</h5>

                <!-- Alert Handling -->
                @if (session()->has('alert'))
                  @php
                    $explode = explode('_', session()->get('alert'));
                  @endphp
                  <div class="alert alert-{{ $explode[0] }} alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle"></i> {{ $explode[1] }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif

                <!-- Profile Picture -->
                <img
                  src="{{ $data_pelanggan->foto_pelanggan ? url($data_pelanggan->foto_pelanggan) : asset('images/default-user.png') }}"
                  id="user-photo" class="rounded-circle img-thumbnail mb-3 shadow" alt="User Photo"
                  style="width: 150px; height: 150px; cursor: pointer;">

                <!-- Profile Information -->
                <div class="table-responsive mt-4">
                  <table class="table table-borderless text-start">
                    <tbody>
                      <tr>
                        <th scope="row" class="text-muted">Full Name</th>
                        <td>: {{ $data_pelanggan->nama_pelanggan }}</td>
                      </tr>
                      <tr>
                        <th scope="row" class="text-muted">Phone</th>
                        <td>: {{ $data_pelanggan->telp_pelanggan }}</td>
                      </tr>
                      <tr>
                        <th scope="row" class="text-muted">Email</th>
                        <td>: {{ $data_pelanggan->email_pelanggan }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout.submit') }}" class="mt-4">
                  @csrf
                  <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-sign-out-alt"></i> Logout
                  </button>
                </form>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>







@endsection
