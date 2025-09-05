<?php

namespace App\Http\Controllers;

use App\Models\FamilyMember;
use App\Models\Residents;
use Illuminate\Http\Request;

class FamilyMemberController extends Controller
{
    public function store(Request $request, Residents $resident)
    {
        $request->validate([
            'nik' => 'nullable|string',
            'nama' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:L,P',
            'hubungan_keluarga' => 'nullable|string|max:100',
            'pendidikan' => 'nullable|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
        ]);

        $resident->familyMembers()->create($request->all());

        return redirect()->route('residents.show', $resident->id)
            ->with('success', 'Anggota keluarga berhasil ditambahkan.');
    }


    public function destroy(Residents $resident, FamilyMember $familyMember)
    {
        $familyMember->delete();

        return redirect()->route('residents.show', $resident->id)
            ->with('success', 'Anggota keluarga berhasil dihapus.');
    }
}
