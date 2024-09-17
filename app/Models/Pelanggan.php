<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    // Menentukan nama tabel yang benar
    protected $table = 'tb_pelanggan';

    // Jika primary key tidak bernama 'id', tentukan primary key
    protected $primaryKey = 'id_pelanggan';

    // Jika tidak ingin menggunakan timestamps (created_at dan updated_at)
    public $timestamps = false;
}
