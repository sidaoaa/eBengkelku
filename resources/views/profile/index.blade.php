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

    .boxOrder a {
      display: block;
      padding: 10px;
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
          <h4 class="text-primary">Profile</h4>
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
        <a href="" class="text-primary">Change Password</a>
        </br>
        <div class="d-grid gap-2 d-md-block">
          <a href="{{ route('dashboard') }}" class="btn btn-primary" type="button">Dashboard</a>
          <a href="" class="btn btn-warning" type="button">Edit Profile</a>
        </div>
      </div>

      <div class="col-md-8 d-flex flex-column profile-section">
        <div class="tab-content" id="profileTabsContent">
          <div class="tab-pane fade show active" id="personal-details" role="tabpanel"
            aria-labelledby="personal-details-tab">
            <div class="row">
              <!-- Nama -->
              <div class="col-md-12 mb-3">
                <div class="form-group">
                  <label for="nama">Full Name</label>
                  <input type="text" name="nama" class="form-control" id="nama"
                    value="{{ $data_pelanggan->nama_pelanggan }}" disabled>
                </div>
              </div>
              <!-- Email -->
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" value="{{ $data_pelanggan->email_pelanggan }}"
                    disabled>
                </div>
              </div>
              <!-- Mobile -->
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <label for="telp">Phone Number</label>
                  <input type="text" class="form-control" id="telp" value="{{ $data_pelanggan->telp_pelanggan }}"
                    disabled>
                </div>
              </div>
              <!-- Alamat -->
              <div class="col-md-12 mb-3">
                <div class="form-group">
                  <label for="address">Address</label>
                  <textarea class="form-control no-resize" id="address" rows="3" disabled></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  @php
    $status = request()->get('stat', '');
    $where = ['t_order_online.id_customer' => session('id_pelanggan')];
    if ($status) {
        $statusMap = [
            'pending' => 'WAITING_PAYMENT',
            'confirmed' => 'PAYMENT_CONFIRMED',
            'shipping' => 'DIKIRIM',
            'done' => 'SELESAI',
            'cancel' => 'CANCEL',
        ];
        $where['t_order_online.status_order'] = $statusMap[$status] ?? '';
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
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
          <div class="mb-3 border rounded p-2">
            <div class="row justify-content-center">
              @php
                $tabs = [
                    'all' => 'Semua',
                    'pending' => 'Belum Bayar',
                    'confirmed' => 'Dikemas',
                    'shipping' => 'Dikirim',
                    'done' => 'Selesai',
                    'cancel' => 'Dibatalkan',
                ];
              @endphp

              @foreach ($tabs as $key => $label)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                  <div class="boxOrder text-center">
                    <a href="?stat={{ $key }}" class="{{ request()->query('stat') == $key ? 'active' : '' }}">
                      {{ $label }}
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
                <img src="{{ url('logos/empty.png') }} "style="width: 350px;" alt="No Data Found">
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
                        <p class="mb-1">{{ $order->nama_outlet }} | {{ date('Y-m-d', strtotime($order->tanggal)) }}
                        </p>
                        <span
                          class="badge {{ $order->status_order == 'PAYMENT_CONFIRMED' ? 'badge-success' : 'badge-warning' }}">
                          {{ $order->status_order == 'PAYMENT_CONFIRMED' ? 'Pesanan diproses' : 'Menunggu pembayaran' }}
                        </span>
                        <p class="mt-3" style="font-size: 22px; font-weight: bold;">{{ $order->nama_barang }}</p>
                        <p>{{ $order->qty }} barang x Rp.{{ number_format($order->harga) }}</p>
                      </div>
                      <div class="order-actions">
                        <p class="order-total">Total pesanan: Rp.{{ number_format($order->subtotal) }}</p>
                        @if ($order->status_order == 'WAITING_PAYMENT')
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
@endsection
