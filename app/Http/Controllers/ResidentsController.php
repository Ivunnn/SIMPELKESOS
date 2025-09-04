<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Residents;
use Illuminate\Http\Request;

class ResidentsController extends Controller
{
    /**
     * Display a listing of the residents.
     */
    public function index()
    {
        $residents = Residents::latest()->paginate(10);
        return view('pages.residents.index', compact('residents')); // ✅ benar
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
        // validasi & simpan
        Residents::create($request->all());

        return redirect()->route('residents.index') // ✅ gunakan 'residents.index'
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    /**
     * Display the specified resident.
     */
    public function show(Residents $resident)
    {
        return view('residents.show', compact('resident'));
    }

    /**
     * Show the form for editing the specified resident.
     */
    public function edit(Residents $resident)
    {
        $resident = Residents::findOrFail($resident->id);
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
}
