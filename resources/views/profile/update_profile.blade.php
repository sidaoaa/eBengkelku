@extends('layouts.app')

@section('content')
  <style>
    body {
      background-color: #f8f9fa;
    }

    .profile-img {
      width: 150px;
      height: 150px;
    }

    .form-control:disabled {
      background-color: #e9ecef;
      cursor: not-allowed;
    }

    .nav-tabs .nav-link.active {
      color: #495057;
      background-color: #e9ecef;
      border-color: #dee2e6 #dee2e6 #fff;
    }

    .tab-pane {
      padding: 1.5rem;
    }

    .no-resize {
      resize: none;
      overflow: hidden;
    }
  </style>

  <section class="section section-white"
    style="position: relative; overflow: hidden; padding-top: 100px; padding-bottom: 20px;">
    <div
      style="background-image: url('{{ url('logos/wallpaper.png') }}'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat; position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0;">
    </div>
    <div class="bg-white" style="position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0; opacity: 0.7;">
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <h4 class="text-primary">Edit Profile</h4>
        </div>
      </div>
    </div>
  </section>

  <section class="container-fluid vh-50 d-flex flex-column">
    <div class="row flex-grow-1">
      <div class="col-md-4 d-flex flex-column align-items-center justify-content-center profile-section">
        <img
          src="{{ $data_pelanggan->foto_pelanggan ? url($data_pelanggan->foto_pelanggan) : asset('images/default-user.png') }}"
          alt="Profile Picture" class="img-fluid rounded-circle profile-img mb-3">
        <h5 class="mb-1">{{ $data_pelanggan->nama_pelanggan }}</h5>
        <a href="{{ route('password.change') }}" class="text-primary">Change Password</a>
        </br>
        <div class="d-grid gap-2 d-md-block">
          <a href="{{ route('dashboard') }}" class="btn btn-primary" type="button">Dashboard</a>
        </div>
      </div>

      <div class="col-md-8 d-flex flex-column profile-section">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="tab-content" id="profileTabsContent">
            <div class="tab-pane fade show active" id="personal-details" role="tabpanel"
              aria-labelledby="personal-details-tab">
              <div class="row">
                <!-- Nama -->
                <div class="col-md-12 mb-3">
                  <div class="form-group">
                    <label for="nama">Full Name</label>
                    <input type="text" name="nama" class="form-control" id="nama"
                      value="{{ $data_pelanggan->nama_pelanggan }}" required>
                  </div>
                </div>
                <!-- Email -->
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email"
                      value="{{ $data_pelanggan->email_pelanggan }}" required>
                  </div>
                </div>
                <!-- Mobile -->
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label for="telp">Phone Number</label>
                    <input type="text" name="telp" class="form-control" id="telp"
                      value="{{ $data_pelanggan->telp_pelanggan }}" required>
                  </div>
                </div>
                <!-- Alamat -->
                <div class="col-md-12 mb-3">
                  <div class="form-group">
                    <label for="address">Address</label>
                    <textarea name="address" class="form-control no-resize" id="address" rows="3" required>{{ $data_pelanggan->alamat_pelanggan }}</textarea>
                  </div>
                </div>
                <!-- Profile Picture -->
                <div class="col-md-12 mb-3">
                  <div class="form-group">
                    <label for="foto_pelanggan">Profile Picture</label>
                    <input type="file" name="foto_pelanggan" class="form-control-file" id="foto_pelanggan">
                  </div>
                </div>
                <div class="col-md-12 text-center">
                  <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
@endsection
