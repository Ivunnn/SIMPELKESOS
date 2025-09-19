<?php

namespace App\Http\Controllers;

use App\Models\Residents;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ResidentsImport;
use App\Models\FamilyMember;
use App\Exports\ResidentsExport;

class ResidentsController extends Controller
{
    public function index(Request $request)
    {
        $query = Residents::query();

        // 🔑 Batasi data jika role kecamatan
        if (auth()->user()->role === 'pendamping') {
            $query->where('kecamatan', auth()->user()->kecamatan);
        }

        // Filter pencarian KK
        if ($request->filled('search')) {
            $query->where('no_kk', 'like', '%' . $request->search . '%');
        }

        // Filter kecamatan
        if ($request->filled('kecamatan') && $request->kecamatan !== 'all') {
            if (auth()->user()->role === 'admin') {
                $query->where('kecamatan', $request->kecamatan);
            }
        }

        // Filter pendapatan
        if ($request->filled('pendapatan') && $request->pendapatan !== 'all') {
            $query->where('pendapatan', $request->pendapatan);
        }

        $residents = $query->orderBy('created_at', 'desc')->paginate(10);
        $residents->appends($request->all());

        // Daftar kecamatan
        if (auth()->user()->role === 'admin') {
            $kecamatanList = Residents::select('kecamatan')->distinct()->pluck('kecamatan');
        } else {
            $kecamatanList = collect([auth()->user()->kecamatan]);
        }

        return view('pages.residents.index', compact('residents', 'kecamatanList'));
    }

    public function create()
    {
        return view('pages.residents.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // ✅ Logika bansos lain-lain
        if ($request->bansos === 'Lain - Lain') {
            $data['bansos'] = $request->bansos_lain;
        }

        // Upload foto
        if ($request->hasFile('foto_rumah')) {
            $data['foto_rumah'] = $request->file('foto_rumah')->store('uploads/residents', 'public');
        }
        if ($request->hasFile('foto_tampak_dalam')) {
            $data['foto_tampak_dalam'] = $request->file('foto_tampak_dalam')->store('uploads/residents', 'public');
        }
        if ($request->hasFile('foto_kamar_mandi')) {
            $data['foto_kamar_mandi'] = $request->file('foto_kamar_mandi')->store('uploads/residents', 'public');
        }

        Residents::create($data);

        return redirect()->route('residents.index')->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function show(Residents $resident)
    {
        $resident->load('familyMembers');
        return view('pages.residents.show', compact('resident'));
    }

    public function edit(Residents $resident)
    {
        return view('pages.residents.edit', compact('resident'));
    }

    public function update(Request $request, Residents $resident)
    {
        $request->validate([
            'no_kk' => 'required|unique:residents,no_kk,' . $resident->id,
            'nama_kepala_keluarga' => 'required|string|max:255',
        ]);

        $data = $request->all();

        // ✅ Logika bansos lain-lain
        if ($request->bansos === 'Lain - Lain') {
            $data['bansos'] = $request->bansos_lain;
        }

        // Upload foto baru
        if ($request->hasFile('foto_rumah')) {
            $data['foto_rumah'] = $request->file('foto_rumah')->store('uploads/residents', 'public');
        }
        if ($request->hasFile('foto_tampak_dalam')) {
            $data['foto_tampak_dalam'] = $request->file('foto_tampak_dalam')->store('uploads/residents', 'public');
        }
        if ($request->hasFile('foto_kamar_mandi')) {
            $data['foto_kamar_mandi'] = $request->file('foto_kamar_mandi')->store('uploads/residents', 'public');
        }

        $resident->update($data);

        return redirect()->route('residents.index')->with('success', 'Data penduduk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $resident = Residents::findOrFail($id);
        $resident->delete();

        return redirect()->route('residents.index')->with('success', 'Data penduduk berhasil dihapus.');
    }

    public function downloadPdf(Residents $resident)
    {
        $pdf = Pdf::loadView('pages.residents.pdf', compact('resident'))
            ->setPaper('a4', 'portrait');
        return $pdf->download('resident-' . $resident->id . '.pdf');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        Excel::import(new ResidentsImport, $request->file('file'));

        return redirect()->route('residents.index')->with('success', 'Data penduduk berhasil diimport.');
    }

    public function exportExcel(Request $request)
    {
        $query = Residents::query();

        if ($request->filled('kecamatan') && $request->kecamatan !== 'all') {
            $query->where('kecamatan', $request->kecamatan);
        }
        if ($request->filled('pendapatan') && $request->pendapatan !== 'all') {
            $query->where('pendapatan', $request->pendapatan);
        }

        $data = $query->get();
        return Excel::download(new \App\Exports\ResidentsExport($data), 'residents.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Residents::query();

        if ($request->filled('kecamatan') && $request->kecamatan !== 'all') {
            $query->where('kecamatan', $request->kecamatan);
        }
        if ($request->filled('pendapatan') && $request->pendapatan !== 'all') {
            $query->where('pendapatan', $request->pendapatan);
        }

        $data = $query->get();
        $pdf = Pdf::loadView('pages.residents.export-pdf', compact('data'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('residents.pdf');
    }
}
