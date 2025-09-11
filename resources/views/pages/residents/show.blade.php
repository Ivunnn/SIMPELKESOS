@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4 flex-wrap">
    <h1 class="h3 mb-2 text-gray-800">Detail Asset {{ $resident->nama_kepala_keluarga }}</h1>
    <div class="mt-2 mt-md-0">
        <a href="{{ route('residents.index') }}" class="btn btn-sm btn-secondary shadow-sm mb-1">Kembali</a>
        <a href="{{ route('residents.pdf', $resident->id) }}" class="btn btn-sm btn-danger shadow-sm mb-1">Download PDF</a>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card shadow-sm">
            <div class="card-body">
                {{-- Detail Data --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
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
                            <th>Kepemilikan Usaha</th>
                            <td>{{ $resident->usaha }}</td>
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
                            <th>Foto Rumah (Depan/Atas)</th>
                            <td>
                                @if($resident->foto_rumah)
                                    <img src="{{ asset('storage/' . $resident->foto_rumah) }}" alt="Foto Rumah"
                                         class="img-fluid rounded shadow-sm" style="max-width:250px;">
                                @else
                                    <span class="text-muted">Tidak ada foto</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Foto Dalam Rumah</th>
                            <td>
                                @if($resident->foto_tampak_dalam)
                                    <img src="{{ asset('storage/' . $resident->foto_tampak_dalam) }}" alt="Foto Dalam"
                                         class="img-fluid rounded shadow-sm" style="max-width:250px;">
                                @else
                                    <span class="text-muted">Tidak ada foto</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Foto Kamar Mandi</th>
                            <td>
                                @if($resident->foto_kamar_mandi)
                                    <img src="{{ asset('storage/' . $resident->foto_kamar_mandi) }}" alt="Foto Kamar Mandi"
                                         class="img-fluid rounded shadow-sm" style="max-width:250px;">
                                @else
                                    <span class="text-muted">Tidak ada foto</span>
                                @endif
                            </td>
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

                {{-- Form Tambah Anggota --}}
                <h5 class="mt-4">Tambah Anggota Keluarga</h5>
                <div class="card mb-3">
                    <div class="card-body">
                        <form action="{{ route('family-members.store', $resident->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-12 mb-3">
                                    <label for="nik">NIK</label>
                                    <input type="text" name="nik" class="form-control" placeholder="Masukkan NIK">
                                </div>
                                <div class="col-md-4 col-12 mb-3">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama">
                                </div>
                                <div class="col-md-4 col-12 mb-3">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-12 mb-3">
                                    <label for="hubungan_keluarga">Hubungan Keluarga</label>
                                    <select name="hubungan_keluarga" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option value="Kepala">Kepala Keluarga</option>
                                        <option value="Istri">Istri</option>
                                        <option value="Anak">Anak</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-12 mb-3">
                                    <label for="pendidikan">Pendidikan</label>
                                    <select name="pendidikan" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA">SMA</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-12 mb-3">
                                    <label for="pekerjaan">Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control" placeholder="Masukkan Pekerjaan">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Tambah Anggota</button>
                        </form>
                    </div>
                </div>

                {{-- List Anggota --}}
                <h4 class="mt-4">Anggota Keluarga</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="bg-light">
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Hubungan</th>
                                <th>Pendidikan</th>
                                <th>Pekerjaan</th>
                                <th>Aksi</th>
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
                                    <td>
                                        <form action="{{ route('family-members.destroy', [$resident->id, $member->id]) }}"
                                              method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada anggota keluarga</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
