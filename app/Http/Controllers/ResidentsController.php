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
    /**
     * Display a listing of the residents.
     */
    public function index(Request $request)
    {
        $query = Residents::query();

        // Jika ada pencarian berdasarkan no_kk
        if ($request->has('search') && $request->search != '') {
            $query->where('no_kk', 'like', '%' . $request->search . '%');
        }

        $residents = $query->orderBy('created_at', 'desc')->paginate(10);

        // Biar pagination tetap bawa query pencarian
        $residents->appends($request->only('search'));

        return view('pages.residents.index', compact('residents'));
    }


    /**
     * Show the form for creating a new resident.
     */
    public function create()
    {
        return view('pages.residents.create');
    }

    /**
     * Store a newly created resident in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // Upload foto jika ada
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


    /**
     * Display the specified resident.
     */
    public function show(Residents $resident)
    {
        $resident->load('familyMembers'); // eager loading

        return view('pages.residents.show', compact('resident'));
    }


    /**
     * Show the form for editing the specified resident.
     */
    public function edit(Residents $resident)
    {
        return view('pages.residents.edit', compact('resident'));
    }

    /**
     * Update the specified resident in storage.
     */
    public function update(Request $request, Residents $resident)
    {
        $request->validate([
            'no_kk' => 'required|unique:residents,no_kk,' . $resident->id,
            'nama_kepala_keluarga' => 'required|string|max:255',
        ]);

        $resident->update($request->all());

        return redirect()->route('residents.index')
            ->with('success', 'Data penduduk berhasil diperbarui.');
    }

    /**
     * Remove the specified resident from storage.
     */
    public function destroy(Residents $resident)
    {
        $resident->delete();

        return redirect()->route('residents.index')
            ->with('success', 'Data penduduk berhasil dihapus.');
    }

    /**
     * Download detail resident as PDF.
     */
    public function downloadPdf(Residents $resident)
    {
        $pdf = Pdf::loadView('pages.residents.pdf', compact('resident'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('resident-' . $resident->id . '.pdf');
    }

    /**
     * Import data from Excel/CSV.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        Excel::import(new ResidentsImport, $request->file('file'));

        return redirect()->route('residents.index')
            ->with('success', 'Data penduduk berhasil diimport.');
    }

}
