<?php

namespace App\Http\Controllers;

use App\Models\Residents;

class DashboardController extends Controller
{
    public function index()
    {
        $total = Residents::count();

        $desilCounts = [
            'Desil 1' => Residents::where('pendapatan', '<800.000')->count(),
            'Desil 2' => Residents::where('pendapatan', '800.000 - 1,2jt')->count(),
            'Desil 3' => Residents::where('pendapatan', '1,2jt - 1,8jt')->count(),
            'Desil 4' => Residents::where('pendapatan', '1,8jt - 2,4jt')->count(),
            'Desil 5' => Residents::where('pendapatan', '>2,4jt')->count(),
        ];

        $statusRumah = Residents::select('status_kepemilikan_rumah')
            ->selectRaw('count(*) as total')
            ->groupBy('status_kepemilikan_rumah')
            ->pluck('total', 'status_kepemilikan_rumah');

        // Pastikan semua dikirim ke view
        return view('pages.dashboard.index', [
            'total' => $total,
            'desilCounts' => $desilCounts,
            'statusRumah' => $statusRumah,
        ]);
    }
}
