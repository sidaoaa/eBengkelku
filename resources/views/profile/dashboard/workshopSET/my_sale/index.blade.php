@extends('layouts.dashboard')
@section('content')
    @php
        $getOutlet = DB::table('tb_bengkel')
            ->join('m_outlet', 'tb_bengkel.id_bengkel', '=', 'm_outlet.id_bengkel')
            ->where('tb_bengkel.id_pelanggan', session('id_pelanggan'))
            ->select('m_outlet.id_outlet')
            ->first();

        if ($getOutlet) {
            $getOrder = DB::table('t_order_item_online')
                ->join('t_order_online', 't_order_online.id', '=', 't_order_item_online.id_order_online')
                ->join('m_barang', 'm_barang.id_barang', '=', 't_order_item_online.id_barang')
                ->join('m_outlet', 'm_barang.id_outlet', '=', 'm_outlet.id_outlet')
                ->where('t_order_online.id_outlet', $getOutlet->id_outlet)
                ->paginate(12);
        } else {
            $getOrder = collect(); // Mengembalikan collection kosong jika outlet tidak ditemukan
        }
    @endphp

    <div class="flex flex-col sm:flex-row justify-between items-center mt-8">
        <div class="mb-4 mt-10 flex-1">
            <div class="card bg-white shadow-md rounded-lg overflow-hidden">
                <div class="card-body p-4">
                    <div class="text-lg font-bold">Payment Confirmation</div>
                </div>
                @if ($getOrder->isEmpty())
                    <div class="flex flex-col items-center">
                        <img src="{{ url('logos/empty.png') }}" class="w-40 mb-2" alt="No Payment Confirmation">
                        <p class="text-gray-500">No Payment Confirmation.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full w-full divide-y divide-gray-200" id="dataTables">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left font-bold text-xs text-gray-500 uppercase tracking-wider">
                                        No</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Sub Total</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Name</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        E-Mail</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($getOrder as $index => $order)
                                    <tr>
                                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4">{{ $order->tanggal }}</td>
                                        <td class="px-6 py-4">{{ number_format($order->total_harga) }}</td>
                                        <td class="px-6 py-4">{{ $order->atas_nama }}</td>
                                        <td class="px-6 py-4">{{ $order->email_pelanggan }}</td>
                                        <td class="px-6 py-4">{{ $order->status_order }}</td>
                                        <td class="px-6 py-4">
                                            <!-- Sesuaikan tombol aksi sesuai dengan status -->
                                            <a href="#" class="btn btn-primary">Action</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-4">
                        {{ $getOrder->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
