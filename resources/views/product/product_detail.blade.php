@extends('layouts.app')

@section('title', 'eBengkelku - Detail Product')

@section('content')
  <style>
    .quantity {
      display: flex;
      align-items: center;
    }

    .quantity-input {
      width: 50px;
      text-align: center;
    }

    .quantity-minus,
    .quantity-plus {
      background-color: #007bff;
      color: #fff;
      border: none;
      cursor: pointer;
      padding: 2px 10px;
      font-size: 16px;
      border-radius: 0 3px 3px 0;
    }

    .quantity-minus {
      border-radius: 10px 0 0 10px;
    }

    .quantity-plus {
      border-radius: 0 10px 10px 0;
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
          <h4 class="text-primary">Detail Product</h4>
        </div>
      </div>
    </div>
  </section>

  <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">
      @if ($sparePart)
        <div class="row">
          <div class="col-md-5">
            <img src="{{ $sparePart->gambar ?? asset('images/image.png') }}" class="img-fluid shadow" alt="Product Image">
          </div>
          <div class="col-md-7">
            <h2 class="mb-3">{{ $sparePart->nama_barang ?? $sparePart->nama_produk }}</h2>
            <h3>Rp. {{ number_format($sparePart->harga_jual ?? $sparePart->harga_produk) }}</h3>
            <p class="mt-2">Terjual 20</p>
            <div class="row mt-3">
              <div class="col">
                <div class="quantity">
                  <p class="mr-5">Kuantitas</p>
                  <button class="quantity-minus">-</button>
                  <input type="text" class="quantity-input" value="1">
                  <button class="quantity-plus">+</button>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-lg-8">
                <div class="button-checkout">
                  <button type="button" class="btn btn-primary btn-sm btn-block add-to-cart-btn"
                    style="border-radius: 50px">+ Keranjang</button>
                </div>
              </div>
            </div>
            <div class="row mt-5">
              <div class="col-lg-12">
                <div class="accordion" id="accordionExample">
                  <div class="card">
                    <div class="card-header" id="headingOne">
                      <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                          data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          DESKRIPSI PRODUK
                        </button>
                      </h2>
                    </div>
                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                      <div class="card-body">
                        {{ $sparePart->deskripsi_produk ?? 'Deskripsi tidak tersedia' }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @else
        <p>Produk tidak ditemukan.</p>
      @endif
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Add to cart functionality
      document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
          const qty = document.querySelector('.quantity-input').value;
          const token = "{{ csrf_token() }}";
          const id = "{{ $selectBarang == 2 ? $sparePart->id_barang : $sparePart->id_produk }}";
          const url = "{{ route('product.add_to_cart', ['id' => ':id', 'ps' => $selectBarang]) }}".replace(
            ':id', id);

          $.ajax({
            url: url,
            type: "POST",
            data: {
              qty: qty,
              _token: token
            },
            success: function(response) {
              if (response.status == 'success') {
                $('#countCart').text(response.data);
                Swal.fire('Selamat!', 'Produk berhasil masuk cart!', 'success');
              } else if (response.status == 'notlogin') {
                Swal.fire({
                  icon: 'error',
                  title: 'Harap login terlebih dahulu!',
                  showConfirmButton: false,
                  timer: 5000
                });
                window.location.replace("{{ route('login') }}");
              } else {
                Swal.fire('Maaf!', 'Produk gagal masuk cart!', 'error');
              }
            }
          });
        });
      });

      // Quantity adjustments
      const quantityInput = document.querySelector(".quantity-input");
      const quantityMinus = document.querySelector(".quantity-minus");
      const quantityPlus = document.querySelector(".quantity-plus");

      quantityMinus.addEventListener("click", function() {
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
          quantityInput.value = currentValue - 1;
        }
      });

      quantityPlus.addEventListener("click", function() {
        let currentValue = parseInt(quantityInput.value);
        quantityInput.value = currentValue + 1;
      });
    });
  </script>
@endsection
