<?php

namespace App\Imports;

use App\Models\Resident;
use App\Models\Residents;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ResidentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return Residents::updateOrCreate(
            ['no_kk' => $row['no_kk']], // cari berdasarkan no_kk
            [
                'nama_kepala_keluarga' => $row['nama_kepala_keluarga'],
                'alamat' => $row['alamat'],
                'status_kepemilikan_rumah' => $row['status_kepemilikan_rumah'],
                'jumlah_keluarga' => (int) $row['jumlah_keluarga'],
                'jenis_lantai' => $row['jenis_lantai'],
                'jenis_dinding' => $row['jenis_dinding'],
                'jenis_atap' => $row['jenis_atap'],
                'sumber_air_minum' => $row['sumber_air_minum'],
                'daya_listrik' => $row['daya_listrik'],
                'id_meter_pln' => $row['id_meter_pln'],
                'bahan_bakar_memasak' => $row['bahan_bakar_memasak'],
                'fasilitas_bab' => $row['fasilitas_bab'],
                'jenis_kloset' => $row['jenis_kloset'],
                'pembuangan_tinja' => $row['pembuangan_tinja'],
                'asset_bergerak' => $row['asset_bergerak'],
                'asset_tidak_bergerak' => $row['asset_tidak_bergerak'],
                'ternak' => $row['ternak'],
                'pendapatan' => $row['pendapatan'],
                'latitude' => $row['latitude'],
                'longitude' => $row['longitude'],
            ]
        );
    }
}