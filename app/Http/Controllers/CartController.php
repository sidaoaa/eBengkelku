<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $getCart = DB::table('t_order_online')->join('t_order_item_online', 't_order_online.id', 't_order_item_online.id_order_online')->join('m_barang', 't_order_item_online.id_barang', 'm_barang.id_barang')->where('t_order_online.id_customer', Session::get('id_pelanggan'))->where('status_order', 'TEMP')->get();
        $getIdOrder = DB::table('t_order_online')->where('id_customer', Session::get('id_pelanggan'))->where('status_order', 'TEMP')->first();
        $idOrder = @$getIdOrder->id;

        return view('cart.index', compact('getCart', 'idOrder'));
    }
}
