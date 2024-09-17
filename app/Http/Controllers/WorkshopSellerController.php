<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bengkel;
use App\Models\Outlet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class WorkshopSellerController extends Controller
{
    public function index() {
        return view('profile.dashboard.workshopSET.workshop.index');
    }

    public function pagination(Request $request) {
        return view('profile.dashboard.workshopSET.workshop.pagination');
    }

    public function create() {
        return view('profile.dashboard.workshopSET.workshop.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama_bengkel' => 'required|string|max:255',
            'tagline_bengkel' => 'required|string|max:255',
            'foto_bengkel' => 'nullable|image',
            'foto_cover_bengkel' => 'nullable|image',
            'alamat_bengkel' => 'required|string',
            'kodepos_bengkel' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:15',
            'instagram' => 'nullable|string',
            'tiktok' => 'nullable|string',
            'open_time' => 'required|string',
            'close_time' => 'required|string',
            // 'lokasi_bengkel' => 'nullable|string', // Jika Anda masih memiliki lokasi_bengkel
            // 'lat_bengkel' => 'nullable|numeric', // Hapus jika tidak diperlukan
            // 'long_bengkel' => 'nullable|numeric', // Hapus jika tidak diperlukan
            // 'status_bengkel' => 'nullable|string',
            // 'create_bengkel' => 'nullable|string',
            // 'delete_bengkel' => 'nullable|string',
        ]);

        $pelanggan = Session::get('id_pelanggan');

        $getPelanggan = DB::table('tb_pelanggan')->where('id_pelanggan', $pelanggan)->get();

        $nama = $request->nama;
        $tagline = $request->tagline;
        $alamat = $request->alamat;
        $kodepos = preg_replace('/\D/', '', $request->kodepos);
        $lokasi = $request->lokasi;
        $lat = $request->lat;
        $long = $request->long;
        $status = 'Active';
        $create = date('Y-m-d H:i:s');
        $foto = url('logos/image.png');

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'foto_' . date('Ymd_His') . '.' . $file->getClientOriginalExtension();
            $path = public_path('images/' . $filename);

            // Resize image
            $this->resizeImage($file->getRealPath(), $path, 500, 500);

            $foto = url('images/' . $filename);
        }

        $foto_cover = url('logos/image.png');

        if ($request->hasFile('foto_cover')) {
            $file_cover = $request->file('foto_cover');
            $filename_cover = 'foto_cover_bengkel_' . date('Ymd_His') . '.' . $file_cover->getClientOriginalExtension();
            $path_cover = public_path('images/' . $filename_cover);

            $foto_cover = url('images/' . $filename_cover);
        }

        // Coba tanpa validasi
        DB::table('tb_bengkel')->insert([
            'id_pelanggan' => $pelanggan,
            'nama_bengkel' => $request->nama_bengkel,
            'tagline_bengkel' => $request->tagline_bengkel,
            'foto_bengkel' => 'default.jpg', // Ganti sesuai kebutuhan
            'foto_cover_bengkel' => 'default_cover.jpg',
            'alamat_bengkel' => $request->alamat_bengkel,
            'kodepos_bengkel' => $request->kodepos_bengkel,
            'whatsapp' => $request->whatsapp,
            'instagram' =>  $request->instagram,
            'tiktok' =>  $request->tiktok,
            'open_time' => $request->open_time,
            'close_time' =>  $request->close_time,
            'status_bengkel' => 'Active',
            'create_bengkel' => $request->create_bengkel ?? null, // Tangani nilai null jika perlu
            'delete_bengkel' => $request->delete_bengkel ?? 'N', // Tangani nilai null jika perlu
            // 'created_at' => now(), // Hapus jika tidak diperlukan
            // 'updated_at' => now(), // Hapus jika tidak diperlukan
        ]);
        
        // Cek apakah insert berhasil
        $bengkel = DB::table('tb_bengkel')->orderBy('id_bengkel', 'desc')->first();
        if (!$bengkel || empty($bengkel->nama_bengkel)) {
            return redirect()->back()->with('error', 'Data bengkel tidak tersimpan dengan benar.');
        }

        dd($bengkel);
        
        DB::table('m_outlet')->insert([
            'id_bengkel' => $bengkel->id_bengkel,
            'nama_outlet' => $bengkel->nama_bengkel ?? 'Default Outlet Name', // Berikan nilai default jika null
            'alamat' => $bengkel->alamat_bengkel,
            'is_active' => 'Y',
            'input_by' => Session::get('id_pelanggan'),
        ]);

        $outlet = DB::table('m_outlet')->orderBy('id_outlet', 'desc')->first();

        $pass = bcrypt('admin');
        DB::table('m_karyawan')->insert([
            'id_pengguna' => Session::get('id_pelanggan'),
            'id_outlet' => $outlet->id_outlet,
            'username' => $getPelanggan[0]->nama_pelanggan,
            'password' => $pass,
            'alias' => 'admin',
            'level' => 'Administrator',
            'nama_lengkap' => $getPelanggan[0]->nama_pelanggan,
            'nomor_telepon' => $getPelanggan[0]->telp_pelanggan,
            'email' => $getPelanggan[0]->email_pelanggan,
            'status' => 'Enable'
        ]);

        $where = array(
            'id_pelanggan' => Session::get('id_pelanggan'),
            'delete_pelanggan' => 'N',
        );

        $values = array(
            'role_pelanggan' => 'penjual',
        );

        if (Session::get('role_pelanggan') != 'penjual') {
            DB::table('tb_pelanggan')->where($where)->update($values);
        }

        return redirect()->route('workshop_seller.store')->with('success', 'Data berhasil disimpan');
    }

    public function update(Request $request)
    {
        $id = $request->update;

        $bengkel = Bengkel::where([
            ['delete_bengkel', 'N'],
            ['id_pelanggan', Session::get('id_pelanggan')],
            ['id_bengkel', $id]
        ])->first();

        if (!$bengkel) {
            return back();
        }

        $nama = $request->nama;
        $tagline = $request->tagline;
        $alamat = $request->alamat;
        $kodepos = preg_replace('/\D/', '', $request->kodepos);
        $lokasi = $request->lokasi;
        $lat = $request->lat;
        $long = $request->long;

        $foto = $bengkel->foto_bengkel;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->storeAs('public/images', 'foto_' . now()->format('Ymd_His') . '.' . $request->file('foto')->getClientOriginalExtension());
            $foto = Storage::url($foto);
        }

        $foto_cover = $bengkel->foto_cover_bengkel;
        if ($request->hasFile('foto_cover')) {
            $foto_cover = $request->file('foto_cover')->storeAs('public/images', 'foto_cover_bengkel_' . now()->format('Ymd_His') . '.' . $request->file('foto_cover')->getClientOriginalExtension());
            $foto_cover = Storage::url($foto_cover);
        }

        $bengkel->update([
            'nama_bengkel' => $nama,
            'tagline_bengkel' => $tagline,
            'foto_bengkel' => $foto,
            'foto_cover_bengkel' => $foto_cover,
            'alamat_bengkel' => $alamat,
            'kodepos_bengkel' => $kodepos,
            'whatsapp' => $request->whatsapp,
            'instagram' =>  $request->instagram,
            'tiktok' =>  $request->tiktok,
            'open_time' => $request->open_time,
            'close_time' =>  $request->close_time,
            'lokasi_bengkel' => $lokasi,
            'lat_bengkel' => $lat,
            'long_bengkel' => $long,
        ]);

        Outlet::where('id_bengkel', $id)->update([
            'nama_outlet' => $nama,
            'alamat' => $alamat,
        ]);

        return back()->with('alert', 'success_Success to update your workshop.');
    }

    public function delete(Request $request)
    {
        $id = $request->delete;

        Bengkel::where([
            'id_bengkel' => $id,
            'id_pelanggan' => Session::get('id_pelanggan'),
            'delete_bengkel' => 'N',
        ])->update(['delete_bengkel' => 'Y']);

        return back();
    }
}
