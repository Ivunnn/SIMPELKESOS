<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Data Penduduk</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #000; padding: 6px; }
        th { background: #f2f2f2; text-align: left; }
        h2, h3 { text-align: center; margin: 10px 0; }
        img { max-width: 200px; max-height: 150px; margin: 5px 0; }
    </style>
</head>
<body>
    <h2>Detail Data Penduduk</h2>

    <table>
        <tr><th>Nomor Kartu Keluarga</th><td>{{ $resident->no_kk }}</td></tr>
        <tr><th>NIK Kepala Keluarga</th><td>{{ $resident->no_nik_kepala_keluarga }}</td></tr>
        <tr><th>Nama Kepala Keluarga</th><td>{{ $resident->nama_kepala_keluarga }}</td></tr>
        <tr><th>Kepemilikan Usaha</th><td>{{ $resident->usaha }}</td></tr>
        <tr><th>Alamat</th><td>{{ $resident->alamat }}</td></tr>
        <tr><th>Status Kepemilikan Rumah</th><td>{{ $resident->status_kepemilikan_rumah }}</td></tr>
        <tr><th>Jumlah Keluarga</th><td>{{ $resident->jumlah_keluarga }}</td></tr>
        <tr><th>Jenis Lantai</th><td>{{ $resident->jenis_lantai }}</td></tr>
        <tr><th>Jenis Dinding</th><td>{{ $resident->jenis_dinding }}</td></tr>
        <tr><th>Jenis Atap</th><td>{{ $resident->jenis_atap }}</td></tr>
        <tr><th>Sumber Air Minum</th><td>{{ $resident->sumber_air_minum }}</td></tr>
        <tr><th>Daya Listrik</th><td>{{ $resident->daya_listrik }}</td></tr>
        <tr><th>ID Meter PLN</th><td>{{ $resident->id_meter_pln }}</td></tr>
        <tr><th>Bahan Bakar Memasak</th><td>{{ $resident->bahan_bakar_memasak }}</td></tr>
        <tr><th>Fasilitas BAB</th><td>{{ $resident->fasilitas_bab }}</td></tr>
        <tr><th>Jenis Kloset</th><td>{{ $resident->jenis_kloset }}</td></tr>
        <tr><th>Pembuangan Akhir Tinja</th><td>{{ $resident->pembuangan_tinja }}</td></tr>
        <tr><th>Asset Bergerak</th><td>{{ $resident->asset_bergerak }}</td></tr>
        <tr><th>Asset Tidak Bergerak</th><td>{{ $resident->asset_tidak_bergerak }}</td></tr>
        <tr><th>Ternak</th><td>{{ $resident->ternak }}</td></tr>
        <tr><th>Pendapatan Per Kapita / Bulan</th><td>{{ $resident->pendapatan }}</td></tr>
        <tr><th>Latitude</th><td>{{ $resident->latitude }}</td></tr>
        <tr><th>Longitude</th><td>{{ $resident->longitude }}</td></tr>
        <tr>
            <th>Foto Rumah</th>
            <td>
                @if($resident->foto_rumah)
                    <img src="{{ public_path('storage/' . $resident->foto_rumah) }}" alt="Foto Rumah">
                @else
                    Tidak ada foto
                @endif
            </td>
        </tr>
        <tr>
            <th>Foto Dalam Rumah</th>
            <td>
                @if($resident->foto_tampak_dalam)
                    <img src="{{ public_path('storage/' . $resident->foto_tampak_dalam) }}" alt="Foto Dalam">
                @else
                    Tidak ada foto
                @endif
            </td>
        </tr>
        <tr>
            <th>Foto Kamar Mandi</th>
            <td>
                @if($resident->foto_kamar_mandi)
                    <img src="{{ public_path('storage/' . $resident->foto_kamar_mandi) }}" alt="Foto Kamar Mandi">
                @else
                    Tidak ada foto
                @endif
            </td>
        </tr>
    </table>

    <h3>Anggota Keluarga</h3>
    <table>
        <thead>
            <tr>
                <th>NIK</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Hubungan</th>
                <th>Pendidikan</th>
                <th>Pekerjaan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($resident->familyMembers as $member)
                <tr>
                    <td>{{ $member->nik }}</td>
                    <td>{{ $member->nama }}</td>
                    <td>{{ $member->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>{{ $member->hubungan_keluarga }}</td>
                    <td>{{ $member->pendidikan }}</td>
                    <td>{{ $member->pekerjaan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Belum ada anggota keluarga</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
