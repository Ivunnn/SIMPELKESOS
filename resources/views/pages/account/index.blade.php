@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4 fw-bold">Akun Saya</h2>

        {{-- Flash message --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            {{-- Update Profil --}}
            <div class="col-lg-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">
                        Informasi Akun
                    </div>
                    <div class="card-body">
                        <form action="{{ route('account.updateProfile') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label>Nama</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                            </div>
                            <div class="form-group mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Update Profil</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Update Password --}}
            <div class="col-lg-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-warning text-dark fw-bold">
                        Ubah Password
                    </div>
                    <div class="card-body">
                        <form action="{{ route('account.updatePassword') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label>Password Lama</label>
                                <input type="password" name="current_password" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label>Password Baru</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label>Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-warning w-100">Ubah Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection