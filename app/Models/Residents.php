<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residents extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_kk',
        'nama_kepala_keluarga',
        'alamat',
        'status_kepemilikan_rumah',
        'jumlah_keluarga',
        'jenis_lantai',
        'jenis_dinding',
        'jenis_atap',
        'sumber_air_minum',
        'daya_listrik',
        'id_meter_pln',
        'bahan_bakar_memasak',
        'fasilitas_bab',
        'jenis_kloset',
        'pembuangan_tinja',
        'kepemilikan_aset',
        'longitude',
        'latitude',
    ];
}
