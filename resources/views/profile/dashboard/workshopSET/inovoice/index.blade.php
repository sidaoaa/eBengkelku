@extends('layouts.dashboard')
@section('content')
    @php
        $getInvoice = DB::table('t_invoice')->where('id_customer', Session::get('id_pelanggan'))->get();
        // dd($getInvoice);
    @endphp
    <div class="flex flex-col sm:flex-row justify-between items-center mt-8">
        <div class="mb-4 mt-10 flex-1">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Card Header -->
                <div class="card-body p-4 border-b border-gray-200">
                    <div class="text-lg font-bold">List Invoice</div>
                </div>
                <!-- Card Body -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-bold text-xs uppercase tracking-wider">
                                    No Invoice
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                    Nominal Invoice
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                    Jatuh Tempo
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                    Status Invoice
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($getInvoice as $invoice)
                                <tr>
                                    <td class="px-6 py-4 text-left">
                                        #{{ date('Ym', strtotime($invoice->jatuh_tempo)) . $invoice->id }}
                                    </td>
                                    <td class="px-6 py-4 text-left">
                                        Rp. {{ number_format($invoice->nominal_transfer) }}
                                    </td>
                                    <td class="px-6 py-4 text-left">
                                        {{ $invoice->jatuh_tempo }}
                                    </td>
                                    <td class="px-6 py-4 text-left">
                                        {{ $invoice->status_invoice }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
