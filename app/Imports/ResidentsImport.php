<?php

namespace App\Imports;

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
                'no_nik_kepala_keluarga' => $row['no_nik_kepala_keluarga']
                    ?? 'NIK' . rand(100000, 999999), // handle kosong
                'nama_kepala_keluarga' => $row['nama_kepala_keluarga'] ?? null,
                'usaha' => $row['usaha'] ?? null,
                'alamat' => $row['alamat'] ?? null,
                'kelurahan' => $row['kelurahan'] ?? null,
                'kecamatan' => $row['kecamatan'] ?? null,
                'status_kepemilikan_rumah' => $row['status_kepemilikan_rumah'] ?? null,
                'jumlah_keluarga' => isset($row['jumlah_keluarga']) ? (int) $row['jumlah_keluarga'] : null,
                'jenis_lantai' => $row['jenis_lantai'] ?? null,
                'jenis_dinding' => $row['jenis_dinding'] ?? null,
                'jenis_atap' => $row['jenis_atap'] ?? null,
                'sumber_air_minum' => $row['sumber_air_minum'] ?? null,
                'daya_listrik' => $row['daya_listrik'] ?? null,
                'id_meter_pln' => $row['id_meter_pln'] ?? null,
                'bahan_bakar_memasak' => $row['bahan_bakar_memasak'] ?? null,
                'fasilitas_bab' => $row['fasilitas_bab'] ?? null,
                'jenis_kloset' => $row['jenis_kloset'] ?? null,
                'pembuangan_tinja' => $row['pembuangan_tinja'] ?? null,
                'asset_bergerak' => $row['asset_bergerak'] ?? null,
                'asset_tidak_bergerak' => $row['asset_tidak_bergerak'] ?? null,
                'ternak' => $row['ternak'] ?? null,
                'pendapatan' => $row['pendapatan'] ?? null,
                'latitude' => $row['latitude'] ?? null,
                'longitude' => $row['longitude'] ?? null,
            ]
        );
    }
}
