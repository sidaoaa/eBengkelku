@extends('layouts.app')


@section('title')
  eBengkelku - Cart
@endsection

@section('content')
  @push('css')
    <style>
      .cart-total p {
        margin-bottom: 10px;
      }

      .quantity {
        display: flex;
        align-items: center;
      }

      .quantity-input {
        width: 50px;
        height: 30px;
        text-align: center;
        border: 1px solid #ced4da;
        border-radius: 3px;
      }

      .quantity-minus,
      .quantity-plus {
        background-color: #007bff;
        color: #fff;
        border: none;
        cursor: pointer;
        padding: 5px 10px;
        font-size: 14px;
      }

      .quantity-minus {
        border-radius: 5px 0 0 5px;
      }

      .quantity-plus {
        border-radius: 0 5px 5px 0;
      }

      .quantity-minus:hover,
      .quantity-plus:hover {
        background-color: #0056b3;
      }

      #accordionExample {
        border-top: 2px solid black;
        border-bottom: 2px solid black;
      }
    </style>
  @endpush
  @php
    $search = request()->get('search', '');
  @endphp

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
          <h4 class="text-primary">What's In The Cart</h4>
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

      <div>

        <div class="container">
          <div class="row">
            <div class="col-md-12">
              @if ($getCart->isNotEmpty())
                <div class="row">
                  <div class="col-lg-8">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Produk</th>
                          <th>Harga</th>
                          <th>Kuantitas</th>
                          <th>Total</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $subtotal = 0; @endphp
                        @foreach ($getCart as $cart)
                          <tr>
                            <td>
                              <img src="{{ $cart->image_url }}" alt="{{ $cart->nama_barang }}" width="100px">
                              <span>{{ $cart->nama_barang }}</span>
                            </td>
                            <td>Rp. {{ number_format($cart->harga) }}</td>
                            <td>
                              <div class="quantity">
                                <button class="quantity-minus"
                                  onclick="updateQuantity({{ $cart->id_order_item_online }}, 'decrease')">-</button>
                                <input type="text" class="quantity-input" value="{{ $cart->qty }}"
                                  id="valQty{{ $cart->id_order_item_online }}"
                                  oninput="updateQuantity({{ $cart->id_order_item_online }}, 'input')">
                                <button class="quantity-plus"
                                  onclick="updateQuantity({{ $cart->id_order_item_online }}, 'increase')">+</button>
                              </div>
                            </td>
                            <td>Rp. <span
                                id="stc{{ $cart->id_order_item_online }}">{{ number_format($cart->subtotal) }}</span>
                            </td>
                            <td>
                              <a href="{{ route('delete.order_item', $cart->id_order_item_online) }}"
                                class="text-danger">
                                <i class="fas fa-trash-alt"></i>
                              </a>
                            </td>
                          </tr>
                          @php $subtotal += $cart->subtotal; @endphp
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <div class="col-lg-4">
                    <div class="card">
                      <div class="card-header">
                        <h4>Total Cart</h4>
                      </div>
                      <div class="card-body">
                        <div class="row cart-total">
                          <div class="col-lg-6">
                            <p>Subtotal</p>
                            <p>Pengiriman</p>
                            <p>Total</p>
                          </div>
                          <div class="col-lg-6">
                            <p>Rp. <span id="subtotalAll">{{ number_format($subtotal) }}</span></p>
                            <p>Rp. 0</p>
                            <p>Rp. <span id="subtotalFix">{{ number_format($subtotal) }}</span></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <form action="{{ route('cart.method_payment', $idOrder) }}" method="post">
                      @csrf
                      <input type="hidden" name="total_harga" value="{{ $subtotal }}">
                      <input type="hidden" name="total_qty" value="{{ $getCart->count() }}">
                      <div class="row mt-3">
                        <div class="col-lg-12">
                          <button type="submit" class="btn btn-primary btn-block">Checkout</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              @else
                <div class="text-center">
                  <img src="{{ asset('logos/empty.png') }}" style="width: 350px;">
                  <p>Opps.. Still empty.</p>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
  </section>

  <script>
    function updateQuantity(id_barang, action) {
      let valQty = document.getElementById('valQty' + id_barang);
      let currentValue = parseInt(valQty.value);

      if (action === 'increase') {
        valQty.value = currentValue + 1;
      } else if (action === 'decrease' && currentValue > 1) {
        valQty.value = currentValue - 1;
      }

      // Update via AJAX
      const token = "{{ csrf_token() }}";
      const qty = valQty.value;
      const id_order = '{{ $idOrder }}';

      $.ajax({
        url: "{{ route('product.add_qty') }}",
        method: "POST",
        data: {
          qty: qty,
          _token: token,
          brg: id_barang,
          ord: id_order
        },
        success: function(response) {
          if (response.status === 'success') {
            document.getElementById('stc' + id_barang).textContent = formatRupiah(response.subtotal);
            document.getElementById('subtotalAll').textContent = formatRupiah(response.subOrder);
            document.getElementById('subtotalFix').textContent = formatRupiah(response.subOrder);
          }
        }
      });
    }

    function formatRupiah(value) {
      return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
      }).format(value).replace('Rp', 'Rp. ');
    }
  </script>

@endsection
