@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading and Actions -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 flex-wrap">
        <h1 class="h3 mb-2 text-gray-800">Detail Data {{ $resident->nama_kepala_keluarga }}</h1>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('residents.index') }}" class="btn btn-sm btn-secondary shadow-sm mb-1">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
            <a href="{{ route('residents.pdf', $resident->id) }}" class="btn btn-sm btn-danger shadow-sm mb-1">
                <i class="fas fa-file-pdf fa-sm text-white-50"></i> Download PDF
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Kolom Kiri: Detail Data Penduduk -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Utama</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" style="font-size: 0.9rem;">
                            <tr>
                                <th width="35%">Nomor Kartu Keluarga</th>
                                <td>{{ $resident->no_kk }}</td>
                            </tr>
                            <tr>
                                <th>NIK Kepala Keluarga</th>
                                <td>{{ $resident->no_nik_kepala_keluarga }}</td>
                            </tr>
                            <tr>
                                <th>Nama Kepala Keluarga</th>
                                <td>{{ $resident->nama_kepala_keluarga }}</td>
                            </tr>
                            <tr>
                                <th>Bantuan Sosial</th>
                                <td>{{ $resident->bansos ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Lokasi Peta</th>
                                <td>
                                    {{-- INI BAGIAN YANG DIPERBARUI --}}
                                    @if($resident->latitude && $resident->longitude)
                                        <a href="https://www.google.com/maps?q={{ $resident->latitude }},{{ $resident->longitude }}" target="_blank" class="btn btn-sm btn-info">
                                            <i class="fas fa-map-marker-alt me-1"></i> Buka di Google Maps
                                        </a>
                                        <span class="ms-2 text-muted small">({{ $resident->latitude }}, {{ $resident->longitude }})</span>
                                    @else
                                        <span class="text-muted">Koordinat tidak tersedia</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Alamat Lengkap</th>
                                <td>{{ $resident->alamat }}, {{ $resident->kelurahan }}, {{ $resident->kecamatan }}</td>
                            </tr>
                            <tr>
                                <th>Kepemilikan Usaha</th>
                                <td>{{ $resident->usaha ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pendapatan / Bulan</th>
                                <td>{{ $resident->pendapatan }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Anggota Keluarga</th>
                                <td>{{ $resident->jumlah_keluarga }}</td>
                            </tr>
                        </table>
                    </div>

                    <h6 class="mt-4 font-weight-bold text-primary">Detail Aset & Kondisi Rumah</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" style="font-size: 0.9rem;">
                            <tr><th width="35%">Status Kepemilikan Rumah</th><td>{{ $resident->status_kepemilikan_rumah }}</td></tr>
                            <tr><th>Jenis Lantai</th><td>{{ $resident->jenis_lantai }}</td></tr>
                            <tr><th>Jenis Dinding</th><td>{{ $resident->jenis_dinding }}</td></tr>
                            <tr><th>Jenis Atap</th><td>{{ $resident->jenis_atap }}</td></tr>
                            <tr><th>Sumber Air Minum</th><td>{{ $resident->sumber_air_minum }}</td></tr>
                            <tr><th>Daya Listrik</th><td>{{ $resident->daya_listrik }}</td></tr>
                            <tr><th>Bahan Bakar Memasak</th><td>{{ $resident->bahan_bakar_memasak }}</td></tr>
                            <tr><th>Fasilitas BAB</th><td>{{ $resident->fasilitas_bab }}</td></tr>
                            <tr><th>Asset Bergerak</th><td>{{ $resident->asset_bergerak ?? '-' }}</td></tr>
                            <tr><th>Asset Tidak Bergerak</th><td>{{ $resident->asset_tidak_bergerak ?? '-' }}</td></tr>
                            <tr><th>Hewan Ternak</th><td>{{ $resident->ternak ?? '-' }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Foto & Anggota Keluarga -->
        <div class="col-lg-5 mb-4">
            <!-- Foto-foto -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dokumentasi Foto</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <h6 class="small fw-bold">Foto Depan Rumah</h6>
                            @if($resident->foto_rumah)
                                <img src="{{ asset('storage/' . $resident->foto_rumah) }}" alt="Foto Rumah" class="img-fluid rounded shadow-sm">
                            @else
                                <span class="text-muted small">Tidak ada</span>
                            @endif
                        </div>
                        <div class="col-4">
                            <h6 class="small fw-bold">Dalam Rumah</h6>
                            @if($resident->foto_tampak_dalam)
                                <img src="{{ asset('storage/' . $resident->foto_tampak_dalam) }}" alt="Foto Dalam" class="img-fluid rounded shadow-sm">
                            @else
                                <span class="text-muted small">Tidak ada</span>
                            @endif
                        </div>
                        <div class="col-4">
                            <h6 class="small fw-bold">Kamar Mandi</h6>
                            @if($resident->foto_kamar_mandi)
                                <img src="{{ asset('storage/' . $resident->foto_kamar_mandi) }}" alt="Foto Kamar Mandi" class="img-fluid rounded shadow-sm">
                            @else
                                <span class="text-muted small">Tidak ada</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Anggota Keluarga -->
            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Anggota Keluarga</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" style="font-size: 0.85rem;">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>Hubungan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($resident->familyMembers as $member)
                                    <tr>
                                        <td>{{ $member->nama }}</td>
                                        <td>{{ $member->hubungan_keluarga }}</td>
                                        <td>
                                            <form action="{{ route('family-members.destroy', [$resident->id, $member->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm py-0 px-1"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada anggota keluarga</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Form Tambah Anggota (disembunyikan dalam accordion) -->
                    <div class="accordion mt-3" id="accordionTambahAnggota">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    Tambah Anggota Baru
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionTambahAnggota">
                                <div class="accordion-body">
                                    <form action="{{ route('family-members.store', $resident->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-2"><input type="text" name="nik" class="form-control form-control-sm" placeholder="NIK" required></div>
                                        <div class="mb-2"><input type="text" name="nama" class="form-control form-control-sm" placeholder="Nama Lengkap" required></div>
                                        <div class="mb-2"><select name="jenis_kelamin" class="form-select form-select-sm" required><option value="">-- Jenis Kelamin --</option><option value="L">Laki-laki</option><option value="P">Perempuan</option></select></div>
                                        <div class="mb-2"><select name="hubungan_keluarga" class="form-select form-select-sm" required><option value="">-- Hubungan --</option><option value="Kepala Keluarga">Kepala Keluarga</option><option value="Istri">Istri</option><option value="Anak">Anak</option></select></div>
                                        <div class="mb-2"><select name="pendidikan" class="form-select form-select-sm" required><option value="">-- Pendidikan --</option><option value="Tidak Sekolah">Tidak Sekolah</option><option value="SD">SD</option><option value="SMP">SMP</option><option value="SMA">SMA</option><option value="D1/D2/D3">D1/D2/D3</option><option value="S1/S2/S3">S1/S2/S3</option></select></div>
                                        <div class="mb-3"><input type="text" name="pekerjaan" class="form-control form-control-sm" placeholder="Pekerjaan"></div>
                                        <button type="submit" class="btn btn-success btn-sm w-100">Simpan Anggota</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Menambahkan script Bootstrap 5 JS agar accordion berfungsi --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush
