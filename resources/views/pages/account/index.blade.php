@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4 fw-bold text-lg-start">Akun Saya</h2>

        {{-- Flash message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4"> {{-- gunakan gutter untuk spasi antar kolom --}}
            {{-- Update Profil --}}
            <div class="col-12 col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">
                        Informasi Akun
                    </div>
                    <div class="card-body">
                        <form action="{{ route('account.updateProfile') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                            </div>
                            <div class="">
                                <button type="submit" class="btn btn-primary w-100 ">Update Profil</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection