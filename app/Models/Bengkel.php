<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bengkel extends Model
{
    // Nama tabel yang digunakan
    protected $table = 'tb_bengkel';

    // Primary key dari tabel
    protected $primaryKey = 'id_bengkel';

    // Jika primary key tidak auto-increment
    public $incrementing = true; // Atur ke false jika primary key bukan auto-increment

    // Untuk menghindari timestamps otomatis (created_at dan updated_at) jika tidak diperlukan
    public $timestamps = false; // Atur ke true jika kamu menggunakan timestamps

    // Kolom-kolom yang diizinkan untuk mass assignment
    protected $fillable = [
        'id_pelanggan',
        'nama_bengkel',
        'tagline_bengkel',
        'foto_bengkel',
        'foto_cover_bengkel',
        'alamat_bengkel',
        'kodepos_bengkel',
        'lokasi_bengkel',
        'lat_bengkel',
        'long_bengkel',
        'status_bengkel',
        'create_bengkel',
        'delete_bengkel',
    ];
}
