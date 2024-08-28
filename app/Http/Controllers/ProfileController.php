<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function index()
    {

        $page = request('state', '');
    
        $data_pelanggan = DB::table('ebengkel_new_database_pkl.tb_pelanggan')
            ->where('id_pelanggan', Session::get('id_pelanggan'))
            ->first();
    
        return view('profile.index', compact('data_pelanggan', 'page'));
    }

        // public function myOrder(Request $request)
        // {
        //     // Filtering orders based on status
        //     $status = $request->query('stat', '');
        
        //     $query = OrderOnline::with(['items', 'items.barang', 'items.barang.outlet'])
        //         ->where('id_customer', Session::get('id_pelanggan'));
        
        //     if ($status) {
        //         switch ($status) {
        //             case 'pending':
        //                 $query->where('status_order', 'WAITING_PAYMENT');
        //                 break;
        //             case 'confirmed':
        //                 $query->where('status_order', 'PAYMENT_CONFIRMED');
        //                 break;
        //             case 'shipping':
        //                 $query->where('status_order', 'DIKIRIM');
        //                 break;
        //             case 'done':
        //                 $query->where('status_order', 'SELESAI');
        //                 break;
        //             case 'cancel':
        //                 $query->where('status_order', 'CANCEL');
        //                 break;
        //         }
        //     }
        
        //     $orders = $query->orderBy('tanggal', 'DESC')->paginate(12);
        
        //     return view('profile.my_order', compact('orders'));
        // }
    public function dashboard()
    {
        return view('profile.dashboard.index', ['page' => 'dashboard']);
    }
    
    public function my_order()
    {
        // You can add additional logic here to fetch user orders
        return view('profile.my_order', ['page' => 'my_order']);
    }
    
    
}
