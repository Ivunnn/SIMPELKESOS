<?php

namespace App\Http\Controllers;

use App\Models\Residents;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Query dasar
        $query = Residents::query();

        // Kalau bukan admin, filter berdasarkan kecamatan user
        if ($user->role !== 'admin') {
            $query->where('kecamatan', $user->kecamatan);
        }

        // Total penduduk
        $total = $query->count();

        // Hitung desil (dengan query clone supaya filter kecamatan ikut)
        $desilCounts = [
            'Desil 1' => (clone $query)->where('pendapatan', '<800.000')->count(),
            'Desil 2' => (clone $query)->where('pendapatan', '800.000 - 1,2jt')->count(),
            'Desil 3' => (clone $query)->where('pendapatan', '1,2jt - 1,8jt')->count(),
            'Desil 4' => (clone $query)->where('pendapatan', '1,8jt - 2,4jt')->count(),
            'Desil 5' => (clone $query)->where('pendapatan', '>2,4jt')->count(),
        ];

        // Status kepemilikan rumah
        $statusRumah = (clone $query)
            ->select('status_kepemilikan_rumah')
            ->selectRaw('count(*) as total')
            ->groupBy('status_kepemilikan_rumah')
            ->pluck('total', 'status_kepemilikan_rumah');

        return view('pages.dashboard.index', [
            'total' => $total,
            'desilCounts' => $desilCounts,
            'statusRumah' => $statusRumah,
        ]);
    }
}
