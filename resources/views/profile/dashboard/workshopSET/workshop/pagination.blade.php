@extends('layouts.dashboard')
@section('content')
    {{-- Mengambil data bengkel dan pelanggan --}}
    @php
        $bengkel = DB::table('tb_bengkel')
            ->join('tb_pelanggan', 'tb_bengkel.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
            ->where([['tb_bengkel.delete_bengkel', 'N'], ['tb_bengkel.id_pelanggan', Session::get('id_pelanggan')]])
            ->orderBy('tb_bengkel.id_bengkel', 'DESC')
            ->paginate(12);

        $getPelanggan = DB::table('tb_pelanggan')->where('id_pelanggan', Session::get('id_pelanggan'))->get();
    @endphp

    {{-- Cek jika tidak ada data bengkel --}}
    @if ($bengkel->count() < 1)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ url('logos/empty.png') }}" style="width: 170px;" alt="No Data">
                        <p>Data saat ini tidak ditemukan.</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            @foreach ($bengkel as $data_bengkel)
                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="card">
                        <img class="card-img-top" src="{{ url($data_bengkel->foto_bengkel) }}" alt="Image"
                            style="width:100%;">
                        <div class="card-body">
                            <p id="ellipsis"><b>{{ htmlspecialchars($data_bengkel->nama_bengkel) }}</b></p>
                            <p id="ellipsis">{{ htmlspecialchars($data_bengkel->tagline_bengkel) }}</p>
                            <p>&nbsp;</p>
                            <p>
                                <a
                                    href="{{ url('?state=workshop&update=' . htmlspecialchars($data_bengkel->id_bengkel)) }}">
                                    <button type="button" class="btn btn-sm btn-primary">
                                        <i class='bx bx-edit'></i>
                                    </button>
                                </a>

                                <a href="javascript:;"
                                    onclick="delete_data({{ htmlspecialchars($data_bengkel->id_bengkel) }}, '{{ htmlspecialchars($data_bengkel->nama_bengkel) }}');">
                                    <button type="button" class="btn btn-sm btn-danger">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </a>

                                @php
                                    $id_outlet = DB::table('m_outlet')
                                        ->where('id_bengkel', $data_bengkel->id_bengkel)
                                        ->first();
                                @endphp

                                <a href="https://ebengkelku.com/pos/auth/loginredirect/{{ $id_outlet->id_outlet }}/{{ Session::get('id_pelanggan') }}"
                                    class="btn btn-sm btn-info mt-2" target="_blank">Hubungkan ke POS</a>
                            </p>
                        </div>
                    </div>
                    <p>&nbsp;</p>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    {{ $bengkel->links() }}
                    <p>&nbsp;</p>
                </div>
            </div>
        </div>
    @endif

@endsection
