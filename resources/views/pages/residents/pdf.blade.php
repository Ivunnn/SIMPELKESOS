<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Data Penduduk</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #000; padding: 8px; }
        th { background: #f2f2f2; text-align: left; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Detail Data Penduduk</h2>
    <table>
        <tr><th>Nomor Kartu Keluarga</th><td>{{ $resident->no_kk }}</td></tr>
        <tr><th>Nama Kepala Keluarga</th><td>{{ $resident->nama_kepala_keluarga }}</td></tr>
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
    </table>
</body>
</html>
