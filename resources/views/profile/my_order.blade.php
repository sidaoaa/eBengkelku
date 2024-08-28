@extends('layouts.app')

@section('title', 'eBengkelku - My Order')

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
          <h4 class="text-primary">My Order</h4>
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


  <section class="section bg-light vh-100 d-flex align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
          <!-- Navigation Buttons -->
          <div class="d-flex justify-content-center mb-4 mt-4">
            <a href="{{ route('dashboard') }}"
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
          {{-- 
          <style>
            #navOrder {
              border: 1px solid #007bff;    
              border-radius: 5px;
            }

            .boxOrder {
              min-height: 60px;
            }

            .boxOrder p {
              font-size: 14px;
              padding: 18px;
              color: #007bff;
            }
          </style> --}}

          {{-- <style>
            #navOrder {
              border: 1px solid #007bff;
              border-radius: 5px;
              padding: 5px;
              background-color: #f8f9fa;
            }

            .boxOrder {
              min-height: 60px;
              display: flex;
              align-items: center;
              justify-content: center;
            }

            .boxOrder a {
              font-size: 14px;
              color: #007bff;
              text-decoration: none;
              padding: 10px 20px;
              border-radius: 5px;
              transition: background-color 0.3s, color 0.3s;
            }

            .boxOrder a.active,
            .boxOrder a:hover {
              background-color: #007bff;
              color: white;
            }

            .card img.thumbnail {
              width: 100%;
              max-width: 200px;
              object-fit: cover;
              margin-right: 20px;
            }

            .order-card-body {
              display: flex;
              flex-wrap: wrap;
              align-items: center;
            }

            .order-details {
              flex-grow: 1;
              padding-left: 20px;
            }

            .order-status {
              margin-top: 10px;
            }

            .order-total {
              font-size: 16px;
              font-weight: bold;
            }

            .order-actions {
              margin-top: 20px;
              text-align: right;
            }

            .order-actions a {
              margin-left: 10px;
            }
          </style> --}}
          <div>

            <div class="container mb-3 border rounded p-2">
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
          </div>


          <!-- Orders List -->
          @if ($getOrder->isEmpty())
            <div class="row justify-content-center">
              <div class="col-12 col-md-8 col-lg-6 text-center">
                <img src="{{ url('logos/empty.png') }}" alt="No Data Found">
                <p>Data saat ini tidak ditemukan.</p>
              </div>
            </div>
          @else
            <div class="row">
              @foreach ($getOrder as $order)
                <div class="col-12">
                  <div class="card mb-3">
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


  </section>


@endsection
