<?php

// app/Exports/ResidentsExport.php
namespace App\Exports;

use App\Models\Residents;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResidentsExport implements FromCollection, WithHeadings
{
    protected $kecamatan;
    protected $pendapatan;
    protected $no_kk;

    public function __construct($kecamatan = null, $pendapatan = null, $no_kk = null)
    {
        $this->kecamatan = $kecamatan;
        $this->pendapatan = $pendapatan;
        $this->no_kk = $no_kk;
    }

    public function collection()
    {
        $query = Residents::query();

        if ($this->kecamatan && $this->kecamatan !== 'all') {
            $query->where('kecamatan', $this->kecamatan);
        }

        if ($this->pendapatan && $this->pendapatan !== 'all') {
            $query->where('pendapatan', $this->pendapatan);
        }

        if ($this->no_kk) {
            $query->where('no_kk', $this->no_kk);
        }

        return $query->select([
            'no_kk', 'nama_kepala_keluarga', 'pendapatan', 'alamat', 'kelurahan', 'kecamatan'
        ])->get();
    }

    public function headings(): array
    {
        return ['no_kk', 'nama_kepala_keluarga', 'pendapatan', 'alamat', 'kelurahan', 'kecamatan'];
    }
}
