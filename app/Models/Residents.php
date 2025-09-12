<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residents extends Model
{
    use HasFactory;

    protected $fillable = [
    'no_kk',
    'no_nik_kepala_keluarga',
    'nama_kepala_keluarga',
    'alamat',
    'kecamatan',
    'kelurahan',
    'status_kepemilikan_rumah',
    'usaha',
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
    'asset_bergerak',
    'asset_tidak_bergerak',
    'ternak',
    'pendapatan',
    'foto_rumah',
    'foto_tampak_dalam',
    'foto_kamar_mandi',
    'latitude',
    'longitude',
];


    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class, 'resident_id');
    }


}
