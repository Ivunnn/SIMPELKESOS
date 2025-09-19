@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Penduduk</h1>
            <a href="{{ route('residents.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data Penduduk
            </a>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Filter & Aksi Data</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('residents.index') }}" method="GET" class="mb-4">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    <label for="search" class="form-label">Cari No. KK</label>
                                    <input type="text" name="search" id="search" class="form-control"
                                        placeholder="Masukkan No. KK..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    @auth
                                        @if(auth()->user()->role === 'admin')
                                            <label for="kecamatan" class="form-label">Kecamatan</label>
                                            <select name="kecamatan" id="kecamatan" class="form-select">
                                                <option value="all">Semua Kecamatan</option>
                                                @foreach($kecamatanList as $kecamatan)
                                                    <option value="{{ $kecamatan }}" {{ request('kecamatan') == $kecamatan ? 'selected' : '' }}>
                                                        {{ $kecamatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    @endauth
                                </div>
                                <div class="col-md-3">
                                    <label for="pendapatan" class="form-label">Rentang Pendapatan (Desil)</label>
                                    <select name="pendapatan" id="pendapatan" class="form-select">
                                        <option value="all">Semua Desil</option>
                                        <option value="<800.000" {{ request('pendapatan') == '<800.000' ? 'selected' : '' }}>
                                            &lt; Rp 800.000 (Desil 1)</option>
                                        <option value="800.000 - 1,2jt" {{ request('pendapatan') == '800.000 - 1,2jt' ? 'selected' : '' }}>Rp 800.000 - Rp 1,2jt (Desil 2)</option>
                                        <option value="1,2jt - 1,8jt" {{ request('pendapatan') == '1,2jt - 1,8jt' ? 'selected' : '' }}>Rp 1,2jt - Rp 1,8jt (Desil 3)</option>
                                        <option value="1,8jt - 2,4jt" {{ request('pendapatan') == '1,8jt - 2,4jt' ? 'selected' : '' }}>Rp 1,8jt - Rp 2,4jt (Desil 4)</option>
                                        <option value=">2,4jt" {{ request('pendapatan') == '>2,4jt' ? 'selected' : '' }}> &gt;
                                            Rp 2,4jt (Desil 5)</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex mx-2">
                                        <button type="submit" class="btn btn-primary w-50 btn-sm mr-1">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>
                                        <a href="{{ route('residents.index') }}" class="btn btn-secondary w-50 btn-sm ml-1">
                                            <i class="fas fa-times"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="row border-top pt-3 mt-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-bold">Import Data dari Excel</label>
                                <form action="{{ route('residents.import') }}" method="POST" enctype="multipart/form-data"
                                    class="d-flex gap-2">
                                    @csrf
                                    <input type="file" name="file" required class="form-control">
                                    <button type="submit" class="btn btn-success flex-shrink-0 ml-2">
                                        <i class="fas fa-file-import"></i> Import
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Export Data</label>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('residents.export.excel', request()->all()) }}"
                                        class="btn btn-outline-success w-100">
                                        <i class="fas fa-file-excel"></i> Export Excel
                                    </a>
                                    <a href="{{ route('residents.export.pdf', request()->all()) }}"
                                        class="btn btn-outline-danger w-100">
                                        <i class="fas fa-file-pdf"></i> Export PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Data Penduduk</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="bg-primary text-light table-light text-center ">
                            <tr>
                                <th>No</th>
                                <th>No. KK</th>
                                <th>Nama Kepala Keluarga</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($residents as $resident)
                                <tr>
                                    <td class="text-center">
                                        {{ ($residents->currentPage() - 1) * $residents->perPage() + $loop->iteration }}</td>
                                    <td>{{ $resident->no_kk }}</td>
                                    <td>{{ $resident->nama_kepala_keluarga }}</td>
                                    <td>{{ $resident->alamat }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center flex-wrap gap-2">
                                            <a href="{{ route('residents.show', $resident->id) }}" class="btn btn-info btn-sm"
                                                title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('residents.edit', $resident->id) }}"
                                                class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm btn-delete" data-toggle="modal"
                                                data-target="#confirmationDelete" data-id="{{ $resident->id }}"
                                                data-no-kk="{{ $resident->no_kk }}" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-danger py-4">
                                        Data tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($residents->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $residents->appends(request()->all())->links('vendor.pagination.custom') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Confirmation Delete Modal -->
    <div class="modal fade" id="confirmationDelete" tabindex="-1" role="dialog" aria-labelledby="confirmationDeleteLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationDeleteLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data dengan No. KK <strong class="delete-target">-</strong> ?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(function () {
            var $modal = $('#confirmationDelete');
            var $form = $('#deleteForm');
            var template = "{{ route('residents.destroy', ':id') }}";

            $modal.on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var noKk = button.data('no-kk');

                $form.attr('action', template.replace(':id', id));
                $modal.find('.delete-target').text(noKk);
            });
        });
    </script>
@endpush