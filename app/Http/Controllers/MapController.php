<?php

namespace App\Http\Controllers;

use App\Models\Residents;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ResidentsExport;

class MapController extends Controller
{
    // Halaman peta
    public function index()
    {
        return view('pages.map.index');
    }

    // API data marker dengan filter
    public function getResidents(Request $request)
    {
        $query = Residents::query();

        // Filter berdasarkan no_kk
        if ($request->has('no_kk') && $request->no_kk !== null) {
            $query->where('no_kk', $request->no_kk);
        }

        // Filter kecamatan
        if ($request->has('kecamatan') && $request->kecamatan !== 'all') {
            $query->where('kecamatan', $request->kecamatan);
        }

        // Filter pendapatan
        if ($request->has('pendapatan') && $request->pendapatan !== 'all') {
            $query->where('pendapatan', $request->pendapatan);
        }

        // Pastikan hanya data yang punya lat & lng
        $query->whereNotNull('latitude')->whereNotNull('longitude');

        return response()->json($query->get());
    }

    // API data kecamatan dari GeoJSON
    public function getKecamatanList()
    {
        $geojsonPath = public_path('geojson/kecamatan.geojson');
        $geojson = json_decode(file_get_contents($geojsonPath), true);

        $kecamatanList = collect($geojson['features'])
            ->pluck('properties.nm_kecamatan')
            ->unique()
            ->sort()
            ->values();

        return response()->json($kecamatanList);
    }

      public function exportExcel(Request $request)
{
    return Excel::download(new ResidentsExport(
        $request->kecamatan,
        $request->pendapatan,
        $request->no_kk
    ), 'residents.xlsx');
}

public function exportPdf(Request $request)
{
    $query = Residents::query();

    if ($request->kecamatan && $request->kecamatan !== 'all') {
        $query->where('kecamatan', $request->kecamatan);
    }

    if ($request->pendapatan && $request->pendapatan !== 'all') {
        $query->where('pendapatan', $request->pendapatan);
    }

    if ($request->no_kk) {
        $query->where('no_kk', $request->no_kk);
    }

    $residents = $query->get();

    $pdf = PDF::loadView('exports.residents_pdf', compact('residents'));
    return $pdf->download('residents.pdf');
}


}
