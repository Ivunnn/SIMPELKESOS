@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <h1 class="h3 mb-0 text-gray-800">Data Penduduk</h1>

        {{-- Import --}}
        <form action="{{ route('residents.import') }}" method="POST" enctype="multipart/form-data"
            class="d-flex align-items-center gap-2">
            @csrf
            <input type="file" name="file" required class="form-control form-control-sm w-auto">
            <button type="submit" class="btn btn-success btn-sm shadow-sm">
                <i class="fas fa-file-import"></i> Import Data
            </button>
        </form>
    </div>

    <div class="mb-4">
        <a href="{{ route('residents.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Input Penduduk
        </a>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover table-striped mt-3">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th>No</th>
                                <th>No. KK</th>
                                <th>Nama Kepala Keluarga</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        @if ($residents->count() < 1)
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-center text-danger pt-3">
                                        Tidak ada data
                                    </td>
                                </tr>
                            </tbody>
                        @else
                            <tbody>
                                @foreach ($residents as $resident)
                                    <tr>
                                        {{-- Nomor tetap urut sesuai halaman --}}
                                        <td>{{ ($residents->currentPage() - 1) * $residents->perPage() + $loop->iteration }}</td>
                                        <td>{{ $resident->no_kk }}</td>
                                        <td>{{ $resident->nama_kepala_keluarga }}</td>
                                        <td>{{ $resident->alamat }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center" style="gap: 1.25rem;">
                                                <a href="{{ route('residents.show', $resident->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                                <a href="{{ route('residents.edit', $resident->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-pen"></i> Edit
                                                </a>
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#confirmationDelete-{{ $resident->id }}"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @include('pages.residents.confirmation-delete', ['resident' => $resident])
                                @endforeach
                            </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $residents->appends(['per_page' => request('per_page', 10)])->links('vendor.pagination.custom') }}
    </div>

@endsection