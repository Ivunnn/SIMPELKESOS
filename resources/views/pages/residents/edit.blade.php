@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Data Penduduk</h1>
    </div>

    <div class="row">
        <div class="col">
            <form action="{{ route('residents.update', $resident->id) }}" method="POST" enctype="multipart/form-data">
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
                            <label for="no_nik_kepala_keluarga">NIK Kepala Keluarga</label>
                            <input type="text" class="form-control" id="no_nik_kepala_keluarga"
                                name="no_nik_kepala_keluarga"
                                value="{{ old('no_nik_kepala_keluarga', $resident->no_nik_kepala_keluarga) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama_kepala_keluarga">Nama Kepala Keluarga</label>
                            <input type="text" class="form-control" id="nama_kepala_keluarga" name="nama_kepala_keluarga"
                                value="{{ old('nama_kepala_keluarga', $resident->nama_kepala_keluarga) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="usaha">Kepemilikan Usaha</label>
                            <input type="text" class="form-control" id="usaha" name="usaha"
                                value="{{ old('usaha', $resident->usaha) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat">{{ old('alamat', $resident->alamat) }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="status_kepemilikan_rumah">Status Kepemilikan Rumah</label>
                            <select class="form-control" name="status_kepemilikan_rumah">
                                <option value="Milik Sendiri" {{ $resident->status_kepemilikan_rumah == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                <option value="Kontrak/Sewa" {{ $resident->status_kepemilikan_rumah == 'Kontrak/Sewa' ? 'selected' : '' }}>Kontrak / Sewa</option>
                                <option value="Menumpang" {{ $resident->status_kepemilikan_rumah == 'Menumpang' ? 'selected' : '' }}>Menumpang</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="jumlah_keluarga">Jumlah Keluarga</label>
                            <input type="number" class="form-control" id="jumlah_keluarga" name="jumlah_keluarga"
                                value="{{ old('jumlah_keluarga', $resident->jumlah_keluarga) }}">
                        </div>

                        {{-- === field lain sama, tinggal tambahkan selected & value dari $resident === --}}
                        
                        <div class="form-group mb-3">
                            <label for="pendapatan">Pendapatan per-kapita/bulan</label>
                            <select class="form-control" name="pendapatan">
                                <option value="<800.000" {{ $resident->pendapatan == '<800.000' ? 'selected' : '' }}>Kurang dari Rp.800.000 (Desil 1)</option>
                                <option value="800.000 - 1,2jt" {{ $resident->pendapatan == '800.000 - 1,2jt' ? 'selected' : '' }}>Rp.800.000 - Rp.1,2jt (Desil 2)</option>
                                <option value="1,2jt - 1,8jt" {{ $resident->pendapatan == '1,2jt - 1,8jt' ? 'selected' : '' }}>Rp.1,2jt - Rp.1,8jt (Desil 3)</option>
                                <option value="1,8jt - 2,4jt" {{ $resident->pendapatan == '1,8jt - 2,4jt' ? 'selected' : '' }}>Rp.1,8jt - Rp.2,4jt (Desil 4)</option>
                                <option value=">2,4jt" {{ $resident->pendapatan == '>2,4jt' ? 'selected' : '' }}>Lebih dari Rp.2,4jt (Desil 5)</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="foto_rumah">Foto Rumah</label>
                            @if($resident->foto_rumah)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$resident->foto_rumah) }}" alt="Foto Rumah" width="200">
                                </div>
                            @endif
                            <input type="file" class="form-control" id="foto_rumah" name="foto_rumah" accept="image/*">
                        </div>

                        <div class="form-group mb-3">
                            <label for="foto_tampak_dalam">Foto Dalam Rumah</label>
                            @if($resident->foto_tampak_dalam)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$resident->foto_tampak_dalam) }}" alt="Foto Dalam" width="200">
                                </div>
                            @endif
                            <input type="file" class="form-control" id="foto_tampak_dalam" name="foto_tampak_dalam" accept="image/*">
                        </div>

                        <div class="form-group mb-3">
                            <label for="foto_kamar_mandi">Foto Kamar Mandi</label>
                            @if($resident->foto_kamar_mandi)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$resident->foto_kamar_mandi) }}" alt="Foto Kamar Mandi" width="200">
                                </div>
                            @endif
                            <input type="file" class="form-control" id="foto_kamar_mandi" name="foto_kamar_mandi" accept="image/*">
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
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
