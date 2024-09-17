<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AccessHistoryController extends Controller
{
    public function showHistory()
    {
        $bulan = $request->input('bulan', date('Y-m')); // Default ke bulan sekarang jika tidak ada parameter bulan
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $logCounts = [];

        foreach ($days as $day) {
            $logCount = DB::table('tb_pelanggan')
                ->join('tb_log_pelanggan', 'tb_log_pelanggan.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
                ->where('tb_log_pelanggan.delete_log_pelanggan', '=', 'N')
                ->whereRaw('date_format(tb_log_pelanggan.tgl_log_pelanggan, \'%Y-%m\') = ?', [$bulan])
                ->whereRaw('date_format(tb_log_pelanggan.tgl_log_pelanggan, \'%a\') = ?', [$day])
                ->where('tb_log_pelanggan.id_pelanggan', '=', Session::get('id_pelanggan'))
                ->count();

            $logCounts[$day] = $logCount; // Simpan hasil perhitungan ke array
        }

        // Kirim data ke view
        return view('profile.dashboard.2index', [
            'logCounts' => $logCounts,
            'daysOfWeek' => $days
        ]);
    }
}

