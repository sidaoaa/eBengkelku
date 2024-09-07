<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bengkel;
use App\Models\Karyawan;
use App\Models\Outlet;
use App\Models\Pelanggan;
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
    public function save(Request $request)
    {
        $pelanggan = Session::get('id_pelanggan');

        $getPelanggan = Pelanggan::where('id_pelanggan', $pelanggan)->first();

        $nama = $request->nama;
        $tagline = $request->tagline;
        $alamat = $request->alamat;
        $kodepos = preg_replace('/\D/', '', $request->kodepos);
        $lokasi = $request->lokasi;
        $lat = $request->lat;
        $long = $request->long;
        $status = 'Active';
        $create = now();
        $foto = 'logos/image.png';
        $foto_cover = 'logos/image.png';

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->storeAs('public/images', 'foto_' . now()->format('Ymd_His') . '.' . $request->file('foto')->getClientOriginalExtension());
            $foto = Storage::url($foto);
        }

        if ($request->hasFile('foto_cover')) {
            $foto_cover = $request->file('foto_cover')->storeAs('public/images', 'foto_cover_bengkel_' . now()->format('Ymd_His') . '.' . $request->file('foto_cover')->getClientOriginalExtension());
            $foto_cover = Storage::url($foto_cover);
        }

        $bengkel = Bengkel::create([
            'id_pelanggan' => $pelanggan,
            'nama_bengkel' => $nama,
            'tagline_bengkel' => $tagline,
            'foto_bengkel' => $foto,
            'foto_cover_bengkel' => $foto_cover,
            'alamat_bengkel' => $alamat,
            'kodepos_bengkel' => $kodepos,
            'lokasi_bengkel' => $lokasi,
            'lat_bengkel' => $lat,
            'long_bengkel' => $long,
            'status_bengkel' => $status,
            'create_bengkel' => $create,
        ]);

        $outlet = Outlet::create([
            'id_bengkel' => $bengkel->id_bengkel,
            'nama_outlet' => $bengkel->nama_bengkel,
            'alamat' => $bengkel->alamat_bengkel,
            'is_active' => 'Y',
            'input_by' => $pelanggan,
        ]);

        $pass = bcrypt('admin');
        Karyawan::create([
            'id_pengguna' => $pelanggan,
            'id_outlet' => $outlet->id_outlet,
            'username' => $getPelanggan->nama_pelanggan,
            'password' => $pass,
            'alias' => 'admin',
            'level' => 'Administrator',
            'nama_lengkap' => $getPelanggan->nama_pelanggan,
            'nomor_telepon' => $getPelanggan->telp_pelanggan,
            'email' => $getPelanggan->email_pelanggan,
            'status' => 'Enable',
        ]);

        if (Session::get('role_pelanggan') != 'penjual') {
            Pelanggan::where([
                'id_pelanggan' => $pelanggan,
                'delete_pelanggan' => 'N',
            ])->update(['role_pelanggan' => 'penjual']);
        }

        return redirect()->to('profile?state=workshop');
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
