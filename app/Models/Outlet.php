<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    // Nama tabel yang digunakan
    protected $table = 'm_outlet';

    // Primary key dari tabel
    protected $primaryKey = 'id_outlet';

    // Jika primary key tidak auto-increment
    public $incrementing = true; // Atur ke false jika primary key bukan auto-increment

    // Untuk menghindari timestamps otomatis (created_at dan updated_at) jika tidak diperlukan
    public $timestamps = false; // Atur ke true jika kamu menggunakan timestamps

    // Kolom-kolom yang diizinkan untuk mass assignment
    protected $fillable = [
        'id_bengkel',
        'nama_outlet',
        'alamat',
        'no_telp',
        'is_active',
        'is_trial',
        'input_by',
        'input_date',
        'is_delete',
    ];
}
