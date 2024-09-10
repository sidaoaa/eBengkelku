<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
    public function update_profile(Request $request)
{
    // Ensure the session is active and user ID is retrieved
    $pelanggan = DB::table('ebengkel_new_database_pkl.tb_pelanggan')
        ->where('delete_pelanggan', 'N')
        ->where('id_pelanggan', Session::get('id_pelanggan'))
        ->first();

    // Check if the customer exists
    if (!$pelanggan) {
        return back()->withErrors('User not found.');
    }

    // Validate the request data
    $request->validate([
        'nama' => 'required|string|max:255',
        'telp' => 'required|string|max:15',
        'email' => 'required|email|max:255',
    ]);

    // Format the input
    $nama = $request->input('nama');
    $telp = preg_replace('/\D/', '', $request->input('telp'));
    $email = $request->input('email');
    $alamat = $request->input('alamat');

    // Prepare update data
    $values = [
        'nama_pelanggan' => $nama,
        'telp_pelanggan' => $telp,
        'email_pelanggan' => $email,
        // 'alamat_pelanggan' => $alamat,
    ];

    // Perform the update
    DB::table('ebengkel_new_database_pkl.tb_pelanggan')
        ->where('delete_pelanggan', 'N')
        ->where('id_pelanggan', $pelanggan->id_pelanggan)
        ->update($values);

    return back()->with('alert', 'success_Success to change your profile.');
}
public function change_password(Request $request)
{
    // Validasi input dari form
    $request->validate([
        'old_password' => 'required|string|min:6',
        'new_password' => 'required|string|min:6|confirmed',
    ]);

    // Ambil ID pelanggan dari session
    $id = Session::get('id_pelanggan');

    // Ambil data pelanggan berdasarkan ID dan pastikan status delete_pelanggan 'N'
    $pelanggan = DB::table('tb_pelanggan')
    ->where([
        ['delete_pelanggan', '=', 'N'],
        ['id_pelanggan', '=', $id],
    ])->first();
    if (!$pelanggan) {
        return back()->with('alert', 'danger_Pelanggan tidak ditemukan.')->withInput();
    }
    $fotoPelanggan = $pelanggan->foto_pelanggan ?? 'default-foto.jpg'; // Jika null, gunakan default    


    // Cek apakah pelanggan ditemukan dan password lama cocok
    if (!$pelanggan || !Hash::check($request->old_password, $pelanggan->password_pelanggan)) {
        return back()->with('alert', 'danger_Old password invalid.')->withInput();
    }

    // Update password baru
    DB::table('tb_pelanggan')
        ->where('id_pelanggan', $id)
        ->update([
            'password_pelanggan' => Hash::make($request->new_password),
        ]);

    return back()->with('alert', 'success_Change password success.');
}   
public function showProfile()
{
    // Get the customer ID from session or any other means
    $customerId = Session::get('id_pelanggan');

    // Fetch addresses for the customer
    $addresses = DB::table('tb_alamat_pengiriman')
        ->where('id_pelanggan', $customerId)
        ->where('delete_alamat_pengiriman', 'N')
        ->get();

    // Pass addresses to the view
    return view('profile.address', ['addresses' => $addresses]);
}


 // Save new address
 public function save(Request $request)
 {
     // Validate incoming request data
     $request->validate([
         'nama' => 'required|string|max:255',
         'kodepos' => 'required|string|max:10',
         'lat' => 'nullable|numeric',
         'long' => 'nullable|numeric',
         'lokasi' => 'required|string|max:255',
         'status' => 'required|in:active,inactive',
         'kota' => 'required|integer',
     ]);

     // Retrieve customer ID from session
     $pelanggan = session()->get('id_pelanggan');

     // Prepare values to insert
     $values = [
         'id_pelanggan' => $pelanggan,
         'nama_alamat_pengiriman' => $request->nama,
         'kodepos_alamat_pengiriman' => preg_replace('/\D/', '', $request->kodepos),
         'lat_alamat_pengiriman' => $request->lat,
         'long_alamat_pengiriman' => $request->long,
         'lokasi_alamat_pengiriman' => $request->lokasi,
         'status_alamat_pengiriman' => $request->status,
         'id_kota' => $request->kota,
     ];

     // Insert into database
     DB::table('tb_alamat_pengiriman')->insert($values);

     // Redirect back to profile with address tab active
     return redirect()->to('profile.address');
 }

 // Update existing address
 public function update(Request $request)
 {
     // Validate incoming request data
     $request->validate([
         'update' => 'required|integer',
         'nama' => 'required|string|max:255',
         'kodepos' => 'required|string|max:10',
         'lat' => 'nullable|numeric',
         'long' => 'nullable|numeric',
         'lokasi' => 'required|string|max:255',
         'status' => 'required|in:active,inactive',
         'kota' => 'required|integer',
     ]);

     // Prepare where and value clauses
     $where = [
         'id_alamat_pengiriman' => $request->update,
         'delete_alamat_pengiriman' => 'N',
     ];

     $values = [
         'nama_alamat_pengiriman' => $request->nama,
         'kodepos_alamat_pengiriman' => preg_replace('/\D/', '', $request->kodepos),
         'lat_alamat_pengiriman' => $request->lat,
         'long_alamat_pengiriman' => $request->long,
         'lokasi_alamat_pengiriman' => $request->lokasi,
         'status_alamat_pengiriman' => $request->status,
         'id_kota' => $request->kota,
     ];

     // Update record in the database
     DB::table('tb_alamat_pengiriman')->where($where)->update($values);

     return back()->with('alert', 'success_Berhasil diperbarui.');
 }

 // Soft delete an address
 public function delete(Request $request)
 {
     // Validate the delete request
     $request->validate([
         'delete' => 'required|integer',
     ]);

     // Prepare where and value clauses
     $where = [
         'id_alamat_pengiriman' => $request->delete,
         'delete_alamat_pengiriman' => 'N',
     ];

     $values = [
         'delete_alamat_pengiriman' => 'Y',
     ];

     // Update the record to soft delete
     DB::table('tb_alamat_pengiriman')->where($where)->update($values);

     return back();
 }
}
