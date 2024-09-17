<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class MySaleController extends Controller
{
    public function index() {
        $log = DB::table('ebengkel_new_database.tb_log_pelanggan')
            ->join('ebengkel_new_database.tb_pelanggan', 'ebengkel_new_database.tb_log_pelanggan.id_pelanggan', '=', 'ebengkel_new_database.tb_pelanggan.id_pelanggan')
            ->where([
                ['ebengkel_new_database.tb_log_pelanggan.delete_log_pelanggan', 'N'],
                ['ebengkel_new_database.tb_log_pelanggan.id_pelanggan', Session::get('id_pelanggan')]
            ])
            ->orderBy('ebengkel_new_database.tb_log_pelanggan.tgl_log_pelanggan', 'DESC')
            ->get();
    
        return view('profile.dashboard.workshopSET.my_sale.index', compact('log'));
    }
    public function log(Request $request)
    {
        $log = DB::table('ebengkel_new_database.tb_log_pelanggan')
            ->join('ebengkel_new_database.tb_pelanggan', 'ebengkel_new_database.tb_log_pelanggan.id_pelanggan', '=', 'ebengkel_new_database.tb_pelanggan.id_pelanggan')
            ->where([
                ['ebengkel_new_database.tb_log_pelanggan.delete_log_pelanggan', 'N'],
                ['ebengkel_new_database.tb_log_pelanggan.id_pelanggan', Session::get('id_pelanggan')]
            ])
            ->orderBy('ebengkel_new_database.tb_log_pelanggan.tgl_log_pelanggan', 'DESC')
            ->get();

        $data = $log->map(function($item, $index) {
            $item->no = $index + 1;
            $item->tgl_log_pelanggan = date('j F Y, H:i', strtotime($item->tgl_log_pelanggan));
            return $item;
        });

        return DataTables::of($data)->make(true);
    }
    public function log_sale(Request $request)
  {
      // Dapatkan outlet berdasarkan id_pelanggan dari session
      $getOutlet = Bengkel::join('m_outlet', 'tb_bengkel.id_bengkel', 'm_outlet.id_bengkel')
          ->where('tb_bengkel.id_pelanggan', Session::get('id_pelanggan'))
          ->select('m_outlet.id_outlet')
          ->first();

      // Ambil data order berdasarkan outlet
      $getOrder = OrderOnline::join('tb_pelanggan', 't_order_online.id_customer', 'tb_pelanggan.id_pelanggan')
          ->where('t_order_online.id_outlet', $getOutlet->id_outlet)
          ->orderBy('t_order_online.tanggal', 'DESC')
          ->get();

      // Ambil log pelanggan
      $log = LogPelanggan::where([
              ['delete_log_pelanggan', 'N'], 
              ['id_pelanggan', Session::get('id_pelanggan')]
          ])
          ->orderBy('tgl_log_pelanggan', 'DESC')
          ->get();

      // Mapping data dan buat action buttons
      $no = 1;
      foreach ($getOrder as $data) {
          $action = $this->getActionButtons($data);
          
          $data->no = $no++;
          $data->date = $data->tanggal;
          $data->sub_total = 'Rp. ' . number_format($data->total_harga);
          $data->nama_pelanggan = $data->atas_nama;
          $data->email = $data->email_pelanggan;
          $data->status = $data->status_order;
          $data->action = $action;
      }
      return DataTables::of($getOrder)->escapeColumns([])->make(true);
  }

  /**
   * Fungsi untuk membuat tombol aksi berdasarkan status order
   */
  private function getActionButtons($data)
  {
      if ($data->status_order == 'PAYMENT_CONFIRMED') {
          return $this->createButtonSet($data->id, ['like', 'cancel', 'search']);
      } else if ($data->status_order == 'DIKEMAS') {
          return $this->createButtonSet($data->id, ['dislike', 'truck', 'cancel', 'search']);
      } else if ($data->status_order == 'DIKIRIM') {
          return $this->createButtonSet($data->id, ['dislike', 'truck-secondary', 'cancel', 'search']);
      } else if ($data->status_order == 'CANCEL') {
          return $this->createButtonSet($data->id, ['search']);
      } else if ($data->status_order == 'PENDING') {
          return $this->createButtonSet($data->id, ['cancel', 'search']);
      }
      return $this->createButtonSet($data->id, ['cancel', 'search']);
  }

  /**
   * Fungsi untuk membuat tombol aksi
   */
  private function createButtonSet($orderId, $actions)
  {
      $buttonMap = [
          'like' => '<button type="button" class="btn btn-sm btn-warning ml-1 mb-1" onclick="modal(' . $orderId . ')"><i class="bx bx-like"></i></button>',
          'cancel' => '<a href="?state=cancel&update=' . htmlspecialchars($orderId) . '"><button type="button" class="btn btn-sm btn-danger ml-1 mb-1"><i class="bx bx-trash"></i></button></a>',
          'search' => '<a href="?state=workshop&update=' . htmlspecialchars($orderId) . '"><button type="button" class="btn btn-sm btn-primary ml-1 mb-1"><i class="bx bx-search"></i></button></a>',
          'dislike' => '<a href="?state=workshop&update=' . htmlspecialchars($orderId) . '"><button type="button" class="btn btn-sm btn-warning ml-1 mb-1"><i class="bx bx-dislike"></i></button></a>',
          'truck' => '<a href="#" onclick="shipping(' . $orderId . ', 1)" data-toggle="modal" data-target="#modalShipping"><button type="button" class="btn btn-sm btn-info ml-1 mb-1"><i class="bx bxs-truck"></i></button></a>',
          'truck-secondary' => '<a href="#" onclick="shipping(' . $orderId . ', 2)" data-toggle="modal" data-target="#modalShipping"><button type="button" class="btn btn-sm btn-secondary ml-1 mb-1"><i class="bx bxs-truck"></i></button></a>',
      ];

      $output = '';
      foreach ($actions as $action) {
          $output .= $buttonMap[$action] ?? '';
      }

      return $output;
  }

}
