<?php

namespace App\Http\Controllers;

use App\Models\Residents;
use Illuminate\Http\Request;

class MapController extends Controller
{
    // Halaman peta
    public function index()
    {
        return view('pages.map.index');
    }

    // API data marker
    public function getResidents(Request $request)
    {
        $query = Residents::query()
            // Pastikan kolom koordinat dipilih agar bisa dibaca di view
            ->select('id', 'no_kk', 'nama_kepala_keluarga', 'alamat', 'kecamatan', 'kelurahan', 'pendapatan', 'latitude', 'longitude');

        if ($request->has('no_kk')) {
            $query->where('no_kk', $request->no_kk);
        }

        // Tambahkan filter kecamatan
        if ($request->has('kecamatan') && $request->kecamatan !== 'all') {
            $query->where('kecamatan', $request->kecamatan);
        }

        // Anda bisa menambahkan filter pendapatan di sini juga untuk performa yang lebih baik
        // if ($request->has('pendapatan') && $request->pendapatan !== 'all') {
        //     $query->where('pendapatan', $request->pendapatan);
        // }

        return response()->json($query->get());
    }

    // API data kecamatan dari GeoJSON
    public function getKecamatanList()
    {
        $geojsonPath = public_path('geojson/kecamatan.geojson');
        $geojson = json_decode(file_get_contents($geojsonPath), true);

        $kecamatanList = collect($geojson['features'])
            // Mengambil properti yang tepat dari file GeoJSON
            ->pluck('properties.nm_kecamatan')
            ->unique()
            ->sort()
            ->values();

        return response()->json($kecamatanList);
    }
}