<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index');
    }

    public function detail($id, $is)
    {
        $sparePart = DB::table('m_barang')->where('id_barang', $id)->first();
        $selectBarang = $is;
    
        return view('product.product_detail', compact('sparePart', 'selectBarang'));
    }
    

    public function addToCart($id, $ps, Request $request)
    {
        $iu = Session::get('id_pelanggan', '');

        if ($ps == 2) {
            $barang = DB::table('m_barang')->where('id_barang', $id)->first();

            if (!empty($iu)) {
                $existingOrder = DB::table('t_order_online')
                    ->where('id_customer', $iu)
                    ->where('status_order', 'TEMP')
                    ->first();

                if ($existingOrder) {
                    $existingItem = DB::table('t_order_item_online')
                        ->where('id_barang', $id)
                        ->where('id_order_online', $existingOrder->id)
                        ->first();

                    if ($existingItem) {
                        $newQty = $existingItem->qty + $request->qty;
                        $subtotal = $barang->harga_jual * $newQty;

                        DB::table('t_order_item_online')
                            ->where('id_order_item_online', $existingItem->id_order_item_online)
                            ->update([
                                'tanggal' => now(),
                                'qty' => $newQty,
                                'subtotal' => $subtotal,
                            ]);
                    } else {
                        DB::table('t_order_item_online')->insert([
                            'id_order_online' => $existingOrder->id,
                            'id_outlet' => $barang->id_outlet,
                            'id_barang' => $barang->id_barang,
                            'tanggal' => now(),
                            'qty' => $request->qty,
                            'harga_beli' => $barang->harga_beli,
                            'harga' => $barang->harga_jual,
                            'subtotal' => $barang->harga_jual * $request->qty,
                        ]);
                    }

                    $itemCount = DB::table('t_order_item_online')
                        ->where('id_order_online', $existingOrder->id)
                        ->count();

                    return response()->json(['status' => 'success', 'data' => $itemCount]);
                } else {
                    $totalHarga = $barang->harga_jual * $request->qty;

                    $orderId = DB::table('t_order_online')->insertGetId([
                        'id_outlet' => $barang->id_outlet,
                        'id_customer' => $iu,
                        'tanggal' => now(),
                        'total_qty' => 1,
                        'total_harga' => $totalHarga,
                    ]);

                    DB::table('t_order_item_online')->insert([
                        'id_order_online' => $orderId,
                        'id_outlet' => $barang->id_outlet,
                        'id_barang' => $barang->id_barang,
                        'tanggal' => now(),
                        'qty' => $request->qty,
                        'harga_beli' => $barang->harga_beli,
                        'harga' => $barang->harga_jual,
                        'subtotal' => $totalHarga,
                    ]);

                    $itemCount = DB::table('t_order_item_online')
                        ->where('id_order_online', $orderId)
                        ->count();

                    return response()->json(['status' => 'success', 'data' => $itemCount]);
                }
            } else {
                return response()->json(['status' => 'notlogin']);
            }
        }
    }
}
