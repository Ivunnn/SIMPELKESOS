@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Penduduk</h1>
    </div>

    <div class="row">
        <div class="col">
            <form action="{{ route('residents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">

                        <div class="form-group mb-3">
                            <label for="no_kk">Nomor Kartu Keluarga</label>
                            <input type="text" class="form-control" id="no_kk" name="no_kk" value="{{ old('no_kk') }}"
                                required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="no_nik_kepala_keluarga">NIK Kepala Keluarga</label>
                            <input type="text" class="form-control" id="no_nik_kepala_keluarga"
                                name="no_nik_kepala_keluarga" value="{{ old('no_nik_kepala_keluarga') }}" required>
                        </div>


                        <div class="form-group mb-3">
                            <label for="nama_kepala_keluarga">Nama Kepala Keluarga</label>
                            <input type="text" class="form-control" id="nama_kepala_keluarga" name="nama_kepala_keluarga"
                                value="{{ old('nama_kepala_keluarga') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="usaha">Kepemilikan Usaha</label>
                            <input type="text" class="form-control" id="usaha" name="usaha" value="{{ old('usaha') }}"
                                required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat">{{ old('alamat') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kelurahan">Kelurahan/Desa</label>
                            <input type="text" class="form-control" id="kelurahan" name="kelurahan" value="{{ old('kelurahan') }}"
                                required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kecamatan">Kecamatan</label>
                            <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}"
                                required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="status_kepemilikan_rumah">Status Kepemilikan Rumah</label>
                            <select class="form-control" name="status_kepemilikan_rumah">
                                <option value="Milik Sendiri">Milik Sendiri</option>
                                <option value="Kontrak/Sewa">Kontrak / Sewa</option>
                                <option value="Menumpang">Menumpang</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="jumlah_keluarga">Jumlah Keluarga</label>
                            <input type="number" class="form-control" id="jumlah_keluarga" name="jumlah_keluarga"
                                value="{{ old('jumlah_keluarga') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="jenis_lantai">Jenis Lantai</label>
                            <select class="form-control" name="jenis_lantai">
                                <option value="Marmer/Granit">Marmer/Granit</option>
                                <option value="Keramik">Keramik</option>
                                <option value="Kayu/Papan">Kayu/Papan</option>
                                <option value="Semen/Bata Merah">Semen/Bata Merah</option>
                                <option value="Tanah">Tanah</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="jenis_dinding">Jenis Dinding</label>
                            <select class="form-control" name="jenis_dinding">
                                <option value="Tembok">Tembok</option>
                                <option value="Kayu/Papan">Kayu/Papan</option>
                                <option value="Anyaman Bambu">Anyaman Bambu</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="jenis_atap">Jenis Atap</label>
                            <select class="form-control" name="jenis_atap">
                                <option value="Genteng">Genteng</option>
                                <option value="Seng">Seng</option>
                                <option value="Asbes">Asbes</option>
                                <option value="Bambu">Bambu</option>
                                <option value="Kayu/Sirap">Kayu / Sirap</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="sumber_air_minum">Sumber Air Minum</label>
                            <select class="form-control" name="sumber_air_minum">
                                <option value="Air Kemasan">Air Kemasan</option>
                                <option value="Sumur">Sumur</option>
                                <option value="Leding">Leding / PDAM</option>
                                <option value="Mata Air">Mata Air</option>
                                <option value="Air Hujan">Air Hujan</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="daya_listrik">Daya Listrik</label>
                            <select class="form-control" name="daya_listrik">
                                <option value="450 VA">450 VA</option>
                                <option value="900 VA">900 VA</option>
                                <option value="1300 VA">1300 VA</option>
                                <option value="2200 VA">2200 VA</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="id_meter_pln">ID Meter PLN</label>
                            <input type="text" class="form-control" id="id_meter_pln" name="id_meter_pln"
                                value="{{ old('id_meter_pln') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="bahan_bakar_memasak">Bahan Bakar Memasak</label>
                            <select class="form-control" name="bahan_bakar_memasak">
                                <option value="Gas Elpiji">Gas Elpiji</option>
                                <option value="Listrik">Listrik</option>
                                <option value="Kayu Bakar">Kayu Bakar</option>
                                <option value="Arang">Arang</option>
                                <option value="Tidak Memasak">Tidak Memasak</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="fasilitas_bab">Fasilitas BAB</label>
                            <select class="form-control" name="fasilitas_bab">
                                <option value="Sendiri">Sendiri</option>
                                <option value="Bersama">Bersama</option>
                                <option value="MCK Umum">MCK Umum</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="jenis_kloset">Jenis Kloset</label>
                            <select class="form-control" name="jenis_kloset">
                                <option value="Leher Angsa">Leher Angsa</option>
                                <option value="Plengsengan">Plengsengan</option>
                                <option value="Cemplung">Cemplung / Cubluk</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="pembuangan_tinja">Pembuangan Akhir Tinja</label>
                            <select class="form-control" name="pembuangan_tinja">
                                <option value="Tangki Septik">Tangki Septik</option>
                                <option value="Lubang Tanah">Lubang Tanah</option>
                                <option value="IPAL">IPAL</option>
                                <option value="Sungai">Sungai / Danau</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="asset_bergerak">Asset bergerak</label>
                            <textarea class="form-control" id="asset_bergerak"
                                name="asset_bergerak">{{ old('asset_bergerak') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="asset_tidak_bergerak">Asset tidak bergerak</label>
                            <textarea class="form-control" id="asset_tidak_bergerak"
                                name="asset_tidak_bergerak">{{ old('asset_tidak_bergerak') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="ternak">Ternak</label>
                            <textarea class="form-control" id="ternak" name="ternak">{{ old('ternak') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="pendapatan">Pendapatan per-kapita/bulan</label>
                            <select class="form-control" name="pendapatan">
                                <option value="<800.000">Kurang dari Rp.800.000 (Desil 1)</option>
                                <option value="800.000 - 1,2jt">Rp.800.000 - Rp.1,2jt (Desil 2)</option>
                                <option value="1,2jt - 1,8jt">Rp.1,2jt - Rp.1,8jt (Desil 3)</option>
                                <option value="1,8jt - 2,4jt">Rp.1,8jt - Rp.2,4jt (Desil 4)</option>
                                <option value=">2,4jt">Lebih dari Rp.2,4jt (Desil 5)</option>
                            </select>
                        </div>


                        <div class="form-group mb-3">
                            <label for="foto_rumah">Foto Rumah (Tampak Depan/Atas)</label>
                            <input type="file" class="form-control" id="foto_rumah" name="foto_rumah" accept="image/*">
                        </div>

                        <div class="form-group mb-3">
                            <label for="foto_tampak_dalam">Foto Dalam Rumah</label>
                            <input type="file" class="form-control" id="foto_tampak_dalam" name="foto_tampak_dalam"
                                accept="image/*">
                        </div>

                        <div class="form-group mb-3">
                            <label for="foto_kamar_mandi">Foto Kamar Mandi</label>
                            <input type="file" class="form-control" id="foto_kamar_mandi" name="foto_kamar_mandi"
                                accept="image/*">
                        </div>

                        <div class="form-group mb-3">
                            <label for="latitude">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude"
                                value="{{ old('latitude') }}">
                        </div>



                        <div class="form-group mb-3">
                            <label for="longitude">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude"
                                value="{{ old('longitude') }}">
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end" style="gap: 10px;">
                            <a href="{{ route('residents.index') }}" class="btn btn-secondary me-2">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection