@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ubah Data Penduduk</h1>
</div>

<div class="row">
    <div class="col">
        <form action="{{ route('residents.update', $resident->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">

                    <div class="form-group mb-3">
                        <label for="no_kk">Nomor Kartu Keluarga</label>
                        <input type="text" class="form-control" id="no_kk" name="no_kk" 
                               value="{{ old('no_kk', $resident->no_kk) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="nama_kepala_keluarga">Nama Kepala Keluarga</label>
                        <input type="text" class="form-control" id="nama_kepala_keluarga" 
                               name="nama_kepala_keluarga" 
                               value="{{ old('nama_kepala_keluarga', $resident->nama_kepala_keluarga) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat">{{ old('alamat', $resident->alamat) }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="status_kepemilikan_rumah">Status Kepemilikan Rumah</label>
                        <select class="form-control" name="status_kepemilikan_rumah">
                            @foreach(['Milik Sendiri','Kontrak/Sewa','Menumpang'] as $status)
                                <option value="{{ $status }}" {{ old('status_kepemilikan_rumah', $resident->status_kepemilikan_rumah) == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="jumlah_keluarga">Jumlah Keluarga</label>
                        <input type="number" class="form-control" id="jumlah_keluarga" name="jumlah_keluarga"
                               value="{{ old('jumlah_keluarga', $resident->jumlah_keluarga) }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="jenis_lantai">Jenis Lantai</label>
                        <select class="form-control" name="jenis_lantai">
                            @foreach(['Marmer/Granit','Keramik','Kayu/Papan','Semen/Bata Merah','Tanah'] as $lantai)
                                <option value="{{ $lantai }}" {{ old('jenis_lantai', $resident->jenis_lantai) == $lantai ? 'selected' : '' }}>{{ $lantai }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="jenis_dinding">Jenis Dinding</label>
                        <select class="form-control" name="jenis_dinding">
                            @foreach(['Tembok','Kayu/Papan','Anyaman Bambu'] as $dinding)
                                <option value="{{ $dinding }}" {{ old('jenis_dinding', $resident->jenis_dinding) == $dinding ? 'selected' : '' }}>{{ $dinding }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="jenis_atap">Jenis Atap</label>
                        <select class="form-control" name="jenis_atap">
                            @foreach(['Genteng','Seng','Asbes','Bambu','Kayu/Sirap'] as $atap)
                                <option value="{{ $atap }}" {{ old('jenis_atap', $resident->jenis_atap) == $atap ? 'selected' : '' }}>{{ $atap }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="sumber_air_minum">Sumber Air Minum</label>
                        <select class="form-control" name="sumber_air_minum">
                            @foreach(['Air Kemasan','Sumur','Leding','Mata Air','Air Hujan'] as $air)
                                <option value="{{ $air }}" {{ old('sumber_air_minum', $resident->sumber_air_minum) == $air ? 'selected' : '' }}>{{ $air }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="daya_listrik">Daya Listrik</label>
                        <select class="form-control" name="daya_listrik">
                            @foreach(['450 VA','900 VA','1300 VA','2200 VA'] as $listrik)
                                <option value="{{ $listrik }}" {{ old('daya_listrik', $resident->daya_listrik) == $listrik ? 'selected' : '' }}>{{ $listrik }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="id_meter_pln">ID Meter PLN</label>
                        <input type="text" class="form-control" id="id_meter_pln" name="id_meter_pln"
                               value="{{ old('id_meter_pln', $resident->id_meter_pln) }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="bahan_bakar_memasak">Bahan Bakar Memasak</label>
                        <select class="form-control" name="bahan_bakar_memasak">
                            @foreach(['Gas Elpiji','Listrik','Kayu Bakar','Arang','Tidak Memasak'] as $bakar)
                                <option value="{{ $bakar }}" {{ old('bahan_bakar_memasak', $resident->bahan_bakar_memasak) == $bakar ? 'selected' : '' }}>{{ $bakar }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="fasilitas_bab">Fasilitas BAB</label>
                        <select class="form-control" name="fasilitas_bab">
                            @foreach(['Sendiri','Bersama','MCK Umum','Tidak Ada'] as $bab)
                                <option value="{{ $bab }}" {{ old('fasilitas_bab', $resident->fasilitas_bab) == $bab ? 'selected' : '' }}>{{ $bab }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="jenis_kloset">Jenis Kloset</label>
                        <select class="form-control" name="jenis_kloset">
                            @foreach(['Leher Angsa','Plengsengan','Cemplung'] as $kloset)
                                <option value="{{ $kloset }}" {{ old('jenis_kloset', $resident->jenis_kloset) == $kloset ? 'selected' : '' }}>{{ $kloset }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="pembuangan_tinja">Pembuangan Akhir Tinja</label>
                        <select class="form-control" name="pembuangan_tinja">
                            @foreach(['Tangki Septik','Lubang Tanah','IPAL','Sungai'] as $tinja)
                                <option value="{{ $tinja }}" {{ old('pembuangan_tinja', $resident->pembuangan_tinja) == $tinja ? 'selected' : '' }}>{{ $tinja }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="asset_bergerak">Asset Bergerak</label>
                        <textarea class="form-control" id="asset_bergerak" name="asset_bergerak">{{ old('asset_bergerak', $resident->asset_bergerak) }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="asset_tidak_bergerak">Asset Tidak Bergerak</label>
                        <textarea class="form-control" id="asset_tidak_bergerak" name="asset_tidak_bergerak">{{ old('asset_tidak_bergerak', $resident->asset_tidak_bergerak) }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="ternak">Ternak</label>
                        <textarea class="form-control" id="ternak" name="ternak">{{ old('ternak', $resident->ternak) }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="pendapatan">Pendapatan per-kapita/bulan</label>
                        <select class="form-control" name="pendapatan">
                            @foreach(['<800.000','800.000 - 1,2jt','1,2jt - 1,8jt','1,8jt - 2,4jt'] as $income)
                                <option value="{{ $income }}" {{ old('pendapatan', $resident->pendapatan) == $income ? 'selected' : '' }}>{{ $income }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="latitude">Latitude</label>
                        <input type="text" class="form-control" id="latitude" name="latitude" 
                               value="{{ old('latitude', $resident->latitude) }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="longitude">Longitude</label>
                        <input type="text" class="form-control" id="longitude" name="longitude" 
                               value="{{ old('longitude', $resident->longitude) }}">
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end" style="gap: 10px;">
                        <a href="{{ route('residents.index') }}" class="btn btn-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
