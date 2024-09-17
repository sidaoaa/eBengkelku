@extends('layouts.app')


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

  .boxOrder a {
    display: block;
    padding: 5px;
    border-radius: 0.5rem;
    text-decoration: none;
    color: #333;
  }

  .boxOrder a.active {
    background-color: #007bff;
    color: #fff;
  }

  .order-card-body {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .thumbnail {
    max-width: 100px;
    height: auto;
  }

  .order-details {
    flex: 1;
    margin-left: 10px;
  }

  .order-actions {
    text-align: right;
  }

  .no-resize {
    resize: none;
    /* Disable resizing */
    overflow: hidden;
    /* Hide scrollbars if content exceeds */
  }
</style>

@php
  $current_page = request('page');
  $visit = request('visit', null);
  $stat = request('stat', '');
  // Define page names for navigation or display purposes
  $page_names = [
      'profile' => 'Profile',
      'my_order' => 'My Order',
      'dashboard' => 'Dashboard',
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
        <div class="col-md-12 text-center">
          <h4 class="text-primary">{{ $page_names[$current_page] ?? 'Profile' }}</h4>
        </div>
      </div>
    </div>
  </section>

  <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">
      <!-- Navigation Menu -->
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

      <!-- Content Based on Page -->
      <div class="col">
        @if ($current_page === 'profile')
          <section class="container-fluid vh-50 d-flex flex-column">
            <div class="row flex-grow-1">
              <div class="col-md-4 d-flex flex-column align-items-center justify-content-center profile-section">
                <img
                  src="{{ isset($data_pelanggan) && $data_pelanggan->foto_pelanggan ? url($data_pelanggan->foto_pelanggan) : asset('images/default-user.jpg') }}"
                  alt="Profile Picture" class="img-fluid rounded-circle profile-img mb-3">

                @if (isset($data_pelanggan))
                  <h5 class="mb-1">{{ $data_pelanggan->nama_pelanggan }}</h5>
                  <a href="#" class="text-primary" data-bs-toggle="modal"
                    data-bs-target="#changePasswordModal">Change Password</a>
                @else
                  <h5 class="mb-1">Customer data not found</h5>
                @endif
                <div class="d-grid gap-2 d-md-block">
                  <a href="{{ route('profile.address') }}" class="btn btn-primary">Address</a>
                  <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                    data-bs-target="#update_profile">Edit Profile</button>
                </div>
              </div>

              <div class="col-md-8 d-flex flex-column profile-section">
                <div class="tab-content" id="profileTabsContent">
                  <div class="tab-pane fade show active" id="personal-details" role="tabpanel"
                    aria-labelledby="personal-details-tab">
                    <div class="row">
                      <!-- Full Name -->
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                          <label for="nama">Full Name</label>
                          <input type="text" name="nama" class="form-control" id="nama"
                            value="{{ isset($data_pelanggan) ? htmlspecialchars($data_pelanggan->nama_pelanggan) : '' }}"
                            disabled>
                        </div>
                      </div>
                      <!-- Email -->
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" class="form-control" id="email"
                            value="{{ isset($data_pelanggan) ? htmlspecialchars($data_pelanggan->email_pelanggan) : '' }}"
                            disabled>
                        </div>
                      </div>
                      <!-- Phone Number -->
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label for="telp">Phone Number</label>
                          <input type="text" class="form-control" id="telp"
                            value="{{ isset($data_pelanggan) ? htmlspecialchars($data_pelanggan->telp_pelanggan) : '' }}"
                            disabled>
                        </div>
                      </div>

                      <!-- Address Section -->
                      <div class="col-md-12">
                        <label for="address">Address List</label>
                        <ul class="list-group">
                          @if (isset($addresses) && $addresses->isEmpty())
                            <li class="list-group-item">No address found</li>
                          @else
                            @foreach ($addresses as $address)
                              <div class="card mb-3">
                                <div class="card-body">
                                  <h6 class="card-title">{{ $address->lokasi_alamat_pengiriman }}</h6>
                                  <p class="card-text">
                                    {{ $address->nama_alamat_pengiriman }}<br>
                                    {{ $address->kodepos_alamat_pengiriman }}<br>
                                    <b>Status:</b> {{ $address->status_alamat_pengiriman }}<br>
                                    <b>Coordinates:</b> ({{ $address->lat_alamat_pengiriman }},
                                    {{ $address->long_alamat_pengiriman }})
                                  </p>
                                </div>

                              </div>
                            @endforeach
                          @endif
                        </ul>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        @elseif ($current_page === 'my_order')
          @php
            $statusMap = [
                'pending' => 'BELUM BAYAR',
                'confirmed' => 'DIKEMAS',
                'shipping' => 'DIKIRIM',
                'done' => 'SELESAI',
                'cancel' => 'CANCEL',
            ];

            $where = ['t_order_online.id_customer' => session('id_pelanggan')];
            if (isset($stat)) {
                $where['t_order_online.status_order'] = $statusMap[$stat] ?? '';
            }

            $getOrder = DB::table('t_order_item_online')
                ->join('t_order_online', 't_order_online.id', '=', 't_order_item_online.id_order_online')
                ->join('m_barang', 'm_barang.id_barang', '=', 't_order_item_online.id_barang')
                ->join('m_outlet', 'm_barang.id_outlet', '=', 'm_outlet.id_outlet')
                ->where($where)
                ->orderBy('t_order_online.tanggal', 'DESC')
                ->paginate(12);
          @endphp

          <section class="section bg-light vh-90 d-flex align-items-center">
            <div class="container ">
              <div class="row justify-content-center ">
                <div class="col-12 col-lg-10">
                  <div class="mb-3 border rounded p-2">
                    <div class="row justify-content-center">
                      @foreach ($statusMap as $key => $label)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-2">
                          <div class="boxOrder text-center">
                            <a href="?visit={{ $visit }}&page=my_order&stat={{ $key }}"
                              class="{{ $stat === $key ? 'active' : '' }}">
                              {{ ucfirst($label) }}
                            </a>
                          </div>
                        </div>
                      @endforeach
                    </div>
                  </div>

                  <!-- Orders List -->
                  @if ($getOrder->isEmpty())
                    <div class="row justify-content-center">
                      <div class="col-12 col-md-8 col-lg-6 text-center">
                        <img src="{{ url('logos/empty.png') }}" style="width: 150px;" alt="No Data Found">
                        <p>Data saat ini tidak ditemukan.</p>
                      </div>
                    </div>
                  @else
                    <div class="row">
                      @foreach ($getOrder as $order)
                        <div class="col-12 mb-3">
                          <div class="card">
                            <div class="card-body order-card-body">
                              <img src="{{ $order->gambar }}" alt="Product Image" class="thumbnail">
                              <div class="order-details">
                                <p class="mb-1">{{ $order->nama_outlet }} |
                                  {{ date('Y-m-d', strtotime($order->tanggal)) }}</p>
                                <span
                                  class="badge {{ $order->status_order == 'DIKEMAS' ? 'badge-success' : 'badge-warning' }}">
                                  {{ $order->status_order == 'DIKEMAS' ? 'Pesanan diproses' : 'Menunggu pembayaran' }}
                                </span>
                                <p class="mt-3" style="font-size: 22px; font-weight: bold;">{{ $order->nama_barang }}
                                </p>
                                <p>{{ $order->qty }} barang x Rp.{{ number_format($order->harga) }}</p>
                              </div>
                              <div class="order-actions">
                                <p class="order-total">Total pesanan: Rp.{{ number_format($order->subtotal) }}</p>
                                @if ($order->status_order == 'BELUM BAYAR')
                                  <a href="{{ route('cart.detail', $order->id) }}" class="btn btn-warning">Bayar</a>
                                @else
                                  <a href="{{ route('product.detail', ['id' => $order->id_barang, 'ps' => 2]) }}"
                                    class="btn btn-primary">Beli Lagi</a>
                                @endif
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          {{ $getOrder->links() }}
                        </div>
                      </div>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </section>
        @elseif ($current_page === 'dashboard')
          <!-- Redirect to dashboard page -->
          <meta http-equiv="refresh" content="0;url={{ route('profile.dashboard') }}" />
        @endif
      </div>
  </section>


  <!-- Change Password Modal -->
  <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog"
    aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="changePasswordModalLabel"><b>Change Password</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @if (session()->has('alert'))
            @php
              $explode = explode('_', session()->get('alert'));
            @endphp
            <div class="alert alert-{{ $explode[0] }}">
              <i class="bx bx-error-circle"></i> {{ $explode[1] }}
            </div>
          @endif

          <form method="POST" action="{{ route('profile.change_password') }}">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <label for="old_password">Old Password</label>
                <input type="password" name="old_password" id="old_password" value="{{ old('old_password') }}"
                  class="form-control" required maxlength="255" placeholder="Required ..."><br>
              </div>
              <div class="col-md-6">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password" value="{{ old('new_password') }}"
                  class="form-control" required maxlength="255" placeholder="Required ..."><br>
              </div>
              <div class="col-md-12">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password"
                  value="{{ old('confirm_password') }}" class="form-control" required maxlength="255"
                  placeholder="Required ..."><br>
              </div>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">
              <i class='fa-solid fa-lock-alt'></i> Change Password
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Update Profile Modal -->
  <div class="modal fade" id="update_profile" tabindex="-1" aria-labelledby="updateProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateProfileModalLabel">Update Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" enctype="multipart/form-data" action="{{ route('profile.update_profile') }}">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="update_name" class="form-label">Full Name</label>
              <input type="text" name="nama" id="update_name" class="form-control"
                value="{{ isset($data_pelanggan) ? htmlspecialchars($data_pelanggan->nama_pelanggan) : '' }}" required
                maxlength="255">
            </div>
            <div class="mb-3">
              <label for="update_phone" class="form-label">Phone</label>
              <input type="text" name="telp" id="update_phone" class="form-control"
                value="{{ isset($data_pelanggan) ? htmlspecialchars($data_pelanggan->telp_pelanggan) : '' }}" required
                maxlength="255">
            </div>
            <div class="mb-3">
              <label for="update_email" class="form-label">Email</label>
              <input type="email" name="email" id="update_email" class="form-control"
                value="{{ isset($data_pelanggan) ? htmlspecialchars($data_pelanggan->email_pelanggan) : '' }}" required
                maxlength="255">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
