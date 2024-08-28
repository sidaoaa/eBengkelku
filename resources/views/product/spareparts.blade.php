@php

  // Handle search query
  $search = request()->get('search', '');

  // Query to get spare parts
  $spare_parts = DB::table('m_barang')
      ->join('m_outlet', 'm_outlet.id_outlet', '=', 'm_barang.id_outlet')
      ->join('tb_bengkel', 'tb_bengkel.id_bengkel', '=', 'm_outlet.id_bengkel')
      ->where('m_barang.is_delete', 'N')
      ->where('m_barang.id_jenis_barang', '1')
      ->when($search, function ($query, $search) {
          return $query->where('m_barang.nama_barang', 'like', '%' . $search . '%');
      })
      ->orderBy('m_barang.id_barang', 'DESC')
      ->paginate(12)
      ->withQueryString();

  $spare_parts->withPath('/product?spare_parts=data');

  // Fetch categories
  $categories = DB::table('m_category')->where('is_delete', 'N')->get();
@endphp

@if ($spare_parts->count() < 1)
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
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-9">
          <div class="row">
            @foreach ($spare_parts as $spare_part)
              <div class="col-6 col-sm-6 col-md-4 col-lg-4">
                <div class="card">
                  @if (is_null($spare_part->gambar))
                    <img class="card-img-top" src="{{ asset('images/image.png') }}" alt="Image" style="width:100%;">
                  @else
                    <img class="card-img-top" src="{{ $spare_part->gambar }}" alt="Image" style="width:100%;">
                  @endif
                  <div class="card-body">
                    <p id="ellipsis"><strong>{{ $spare_part->nama_barang }}</strong></p>
                    <p id="ellipsis">
                      Rp. {{ number_format($spare_part->harga_jual, 0, ',', '.') }}
                    </p>
                    <p id="ellipsis" style="font-size: 12px; color: #9f9f9f;">
                      <a href="javascript:;">
                        <i class="bx bxs-car-garage"></i> {{ $spare_part->nama_bengkel }}
                      </a>
                    </p>
                    <a href="{{ route('product.detail', ['id' => $spare_part->id_barang, 'ps' => 2]) }}"
                      class="btn btn-sm btn-primary">
                      <i class="bx bx-cart-alt"></i> Shop Now
                    </a>
                  </div>
                </div>
                <p>&nbsp;</p>
              </div>
            @endforeach
          </div>
          <div class="d-flex justify-content-center">
            {{ $spare_parts->links() }}
          </div>
        </div>

        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="card-title"><strong>Categories</strong></div>
              <p>&nbsp;</p>
              @foreach ($categories as $category)
                <p id="ellipsis" style="cursor: pointer;">
                  <img src="{{ url('logos/icon.png') }}" style="width: 25px;">
                  {{ $category->nama_category }}
                </p>
                <hr style="border-style: dashed;">
              @endforeach
            </div>
          </div>
          <p>&nbsp;</p>
        </div>
      </div>
    </div>
  </div>
@endif
