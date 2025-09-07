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
        $query = Residents::select('id', 'no_kk', 'nama_kepala_keluarga', 'alamat', 'pendapatan', 'latitude', 'longitude');

        if ($request->has('no_kk') && $request->no_kk != '') {
            $query->where('no_kk', 'like', '%' . $request->no_kk . '%');
        }

        return response()->json($query->get());
    }

}
