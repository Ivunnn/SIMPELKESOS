@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Data Penduduk</h1>
    <div>
        <a href="{{ route('residents.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('residents.pdf', $resident->id) }}" class="btn btn-danger">Download PDF</a>
    </div>
</div>


<div class="row">
    <div class="col">
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Nomor Kartu Keluarga</th>
                        <td>{{ $resident->no_kk }}</td>
                    </tr>
                    <tr>
                        <th>Nama Kepala Keluarga</th>
                        <td>{{ $resident->nama_kepala_keluarga }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $resident->alamat }}</td>
                    </tr>
                    <tr>
                        <th>Status Kepemilikan Rumah</th>
                        <td>{{ $resident->status_kepemilikan_rumah }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Keluarga</th>
                        <td>{{ $resident->jumlah_keluarga }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Lantai</th>
                        <td>{{ $resident->jenis_lantai }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Dinding</th>
                        <td>{{ $resident->jenis_dinding }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Atap</th>
                        <td>{{ $resident->jenis_atap }}</td>
                    </tr>
                    <tr>
                        <th>Sumber Air Minum</th>
                        <td>{{ $resident->sumber_air_minum }}</td>
                    </tr>
                    <tr>
                        <th>Daya Listrik</th>
                        <td>{{ $resident->daya_listrik }}</td>
                    </tr>
                    <tr>
                        <th>ID Meter PLN</th>
                        <td>{{ $resident->id_meter_pln }}</td>
                    </tr>
                    <tr>
                        <th>Bahan Bakar Memasak</th>
                        <td>{{ $resident->bahan_bakar_memasak }}</td>
                    </tr>
                    <tr>
                        <th>Fasilitas BAB</th>
                        <td>{{ $resident->fasilitas_bab }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kloset</th>
                        <td>{{ $resident->jenis_kloset }}</td>
                    </tr>
                    <tr>
                        <th>Pembuangan Akhir Tinja</th>
                        <td>{{ $resident->pembuangan_tinja }}</td>
                    </tr>
                    <tr>
                        <th>Asset Bergerak</th>
                        <td>{{ $resident->asset_bergerak }}</td>
                    </tr>
                    <tr>
                        <th>Asset Tidak Bergerak</th>
                        <td>{{ $resident->asset_tidak_bergerak }}</td>
                    </tr>
                    <tr>
                        <th>Ternak</th>
                        <td>{{ $resident->ternak }}</td>
                    </tr>
                    <tr>
                        <th>Pendapatan Per Kapita / Bulan</th>
                        <td>{{ $resident->pendapatan }}</td>
                    </tr>
                    <tr>
                        <th>Latitude</th>
                        <td>{{ $resident->latitude }}</td>
                    </tr>
                    <tr>
                        <th>Longitude</th>
                        <td>{{ $resident->longitude }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
