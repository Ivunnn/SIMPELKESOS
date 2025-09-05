<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'nik',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'hubungan_keluarga',
        'pendidikan',
        'pekerjaan',
        'keterangan'
    ];

    // app/Models/Residents.php
    public function familyMembers()
    {
        return $this->hasMany(\App\Models\FamilyMember::class, 'resident_id');
    }

}
