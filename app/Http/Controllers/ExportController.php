<?php

use App\Exports\ResidentsExport;
use App\Models\Residents;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ExportController extends Controller
{
    public function exportExcel(Request $request)
{
    return Excel::download(new ResidentsExport(
        $request->kecamatan,
        $request->pendapatan,
        $request->no_kk    ), 'residents.xlsx');
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

    $pdf = PDF::loadView('exports.residents', compact('residents'));
    return $pdf->download('residents.pdf');
}

}
