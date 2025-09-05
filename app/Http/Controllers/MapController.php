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
    public function getResidents()
    {
        $residents = Residents::select('id', 'nama_kepala_keluarga', 'alamat','pendapatan', 'latitude', 'longitude')->get();

        return response()->json($residents);
    }
}
