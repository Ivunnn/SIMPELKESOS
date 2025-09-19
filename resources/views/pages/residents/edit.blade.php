@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4 flex-wrap">
        <h1 class="h3 mb-2 text-gray-800">Edit Data Penduduk</h1>
    </div>

    <div class="row">
        <div class="col-12 mx-auto"> {{-- center di layar besar --}}
            <form action="{{ route('residents.update', $resident->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card shadow-sm w-100 h-100">
                    <div class="card-body">
                        <div class="row">
                            {{-- Nomor KK --}}
                            <div class="col-md-6 mb-3">
                                <label for="no_kk" class="form-label">Nomor Kartu Keluarga</label>
                                <input type="text" class="form-control" id="no_kk" name="no_kk"
                                    value="{{ old('no_kk', $resident->no_kk) }}" required>
                            </div>

                            {{-- NIK Kepala Keluarga --}}
                            <div class="col-md-6 mb-3">
                                <label for="no_nik_kepala_keluarga" class="form-label">NIK Kepala Keluarga</label>
                                <input type="text" class="form-control" id="no_nik_kepala_keluarga"
                                    name="no_nik_kepala_keluarga"
                                    value="{{ old('no_nik_kepala_keluarga', $resident->no_nik_kepala_keluarga) }}" required>
                            </div>

                            {{-- Nama Kepala Keluarga --}}
                            <div class="col-md-6 mb-3">
                                <label for="nama_kepala_keluarga" class="form-label">Nama Kepala Keluarga</label>
                                <input type="text" class="form-control" id="nama_kepala_keluarga"
                                    name="nama_kepala_keluarga"
                                    value="{{ old('nama_kepala_keluarga', $resident->nama_kepala_keluarga) }}" required>
                            </div>

                            {{-- Usaha --}}
                            <div class="col-md-6 mb-3">
                                <label for="usaha" class="form-label">Kepemilikan Usaha</label>
                                <input type="text" class="form-control" id="usaha" name="usaha"
                                    value="{{ old('usaha', $resident->usaha) }}">
                            </div>

                            {{-- Alamat --}}
                            <div class="col-12 mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat"
                                    rows="2">{{ old('alamat', $resident->alamat) }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="kelurahan" class="form-label">Kelurahan/Desa</label>
                                <input type="text" class="form-control" id="kelurahan" name="kelurahan"
                                    value="{{ old('kelurahan', $resident->kelurahan) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                                    value="{{ old('kecamatan', $resident->kecamatan) }}">
                            </div>

                            {{-- Status Kepemilikan Rumah --}}
                            <div class="col-md-6 mb-3">
                                <label for="status_kepemilikan_rumah" class="form-label">Status Kepemilikan Rumah</label>
                                <select class="form-control" name="status_kepemilikan_rumah">
                                    <option value="Milik Sendiri" {{ $resident->status_kepemilikan_rumah == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                    <option value="Kontrak/Sewa" {{ $resident->status_kepemilikan_rumah == 'Kontrak/Sewa' ? 'selected' : '' }}>Kontrak / Sewa</option>
                                    <option value="Menumpang" {{ $resident->status_kepemilikan_rumah == 'Menumpang' ? 'selected' : '' }}>Menumpang</option>
                                </select>
                            </div>

                            {{-- Jumlah Keluarga --}}
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_keluarga" class="form-label">Jumlah Keluarga</label>
                                <input type="number" class="form-control" id="jumlah_keluarga" name="jumlah_keluarga"
                                    value="{{ old('jumlah_keluarga', $resident->jumlah_keluarga) }}">
                            </div>

                            {{-- Pendapatan --}}
                            <div class="col-md-6 mb-3">
                                <label for="pendapatan" class="form-label">Pendapatan per-kapita/bulan</label>
                                <select class="form-control" name="pendapatan">
                                    <option value="<800.000" {{ $resident->pendapatan == '<800.000' ? 'selected' : '' }}>
                                        Kurang dari Rp.800.000 (Desil 1)</option>
                                    <option value="800.000 - 1,2jt" {{ $resident->pendapatan == '800.000 - 1,2jt' ? 'selected' : '' }}>Rp.800.000 - Rp.1,2jt (Desil 2)</option>
                                    <option value="1,2jt - 1,8jt" {{ $resident->pendapatan == '1,2jt - 1,8jt' ? 'selected' : '' }}>Rp.1,2jt - Rp.1,8jt (Desil 3)</option>
                                    <option value="1,8jt - 2,4jt" {{ $resident->pendapatan == '1,8jt - 2,4jt' ? 'selected' : '' }}>Rp.1,8jt - Rp.2,4jt (Desil 4)</option>
                                    <option value=">2,4jt" {{ $resident->pendapatan == '>2,4jt' ? 'selected' : '' }}>Lebih
                                        dari Rp.2,4jt (Desil 5)</option>
                                </select>
                            </div>

                            {{-- Foto Rumah --}}
                            <div class="col-md-6 mb-3">
                                <label for="foto_rumah" class="form-label">Foto Depan Rumah</label>
                                @if($resident->foto_rumah)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $resident->foto_rumah) }}" alt="Foto Rumah"
                                            class="img-fluid rounded" style="max-width:200px">
                                    </div>
                                @endif
                                <input type="file" class="form-control" id="foto_rumah" name="foto_rumah" accept="image/*">
                            </div>

                            {{-- Foto Dalam Rumah --}}
                            <div class="col-md-6 mb-3">
                                <label for="foto_tampak_dalam" class="form-label">Foto Dalam Rumah</label>
                                @if($resident->foto_tampak_dalam)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $resident->foto_tampak_dalam) }}" alt="Foto Dalam"
                                            class="img-fluid rounded" style="max-width:200px">
                                    </div>
                                @endif
                                <input type="file" class="form-control" id="foto_tampak_dalam" name="foto_tampak_dalam"
                                    accept="image/*">
                            </div>

                            {{-- Foto Kamar Mandi --}}
                            <div class="col-md-6 mb-3">
                                <label for="foto_kamar_mandi" class="form-label">Foto Kamar Mandi</label>
                                @if($resident->foto_kamar_mandi)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $resident->foto_kamar_mandi) }}" alt="Foto Kamar Mandi"
                                            class="img-fluid rounded" style="max-width:200px">
                                    </div>
                                @endif
                                <input type="file" class="form-control" id="foto_kamar_mandi" name="foto_kamar_mandi"
                                    accept="image/*">
                            </div>

                            {{-- Bantuan Sosial --}}
                            <div class="col-md-6 mb-3">
                                <label for="bansos" class="form-label">Bantuan Sosial yang diterima</label>
                                @php
                                    $daftarBansos = ['PKH', 'Sembako', 'PBI-JK', 'YAPI'];
                                    $isCustom = !in_array($resident->bansos, $daftarBansos);
                                @endphp
                                <select class="form-control" id="bansos" name="bansos">
                                    <option value="PKH" {{ $resident->bansos == 'PKH' ? 'selected' : '' }}>PKH</option>
                                    <option value="Sembako" {{ $resident->bansos == 'Sembako' ? 'selected' : '' }}>Sembako
                                    </option>
                                    <option value="PBI-JK" {{ $resident->bansos == 'PBI-JK' ? 'selected' : '' }}>PBI-JK
                                    </option>
                                    <option value="YAPI" {{ $resident->bansos == 'YAPI' ? 'selected' : '' }}>YAPI</option>
                                    <option value="Lain - Lain" {{ $isCustom ? 'selected' : '' }}>Lain - Lain</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3" id="bansos-field" style="{{ $isCustom ? '' : 'display:none;' }}">
                                <label for="bansos_lain" class="form-label">Bantuan Sosial (Lainnya)</label>
                                <input type="text" class="form-control" id="bansos_lain" name="bansos_lain"
                                    value="{{ old('bansos_lain', $isCustom ? $resident->bansos : '') }}">
                            </div>

                            {{-- Latitude & Longitude --}}
                            <div class="col-md-6 mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude"
                                    value="{{ old('latitude', $resident->latitude) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude"
                                    value="{{ old('longitude', $resident->longitude) }}">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end flex-wrap gap-2">
                        <a href="{{ route('residents.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary mx-2">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const bansosSelect = document.getElementById("bansos");
        const bansosField = document.getElementById("bansos-field");

        function toggleBansosField() {
            if (bansosSelect.value === "Lain - Lain") {
                bansosField.style.display = "block";
            } else {
                bansosField.style.display = "none";
                document.getElementById("bansos_lain").value = "";
            }
        }

        bansosSelect.addEventListener("change", toggleBansosField);
        toggleBansosField(); // inisialisasi saat halaman load
    });
</script>
@endpush