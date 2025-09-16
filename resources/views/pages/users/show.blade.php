@extends('layouts.app')

@section('content')
<h3 class="mb-4">Detail Pengguna</h3>

<div class="card shadow-sm">
    <div class="card-body">
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
        <p><strong>Kecamatan:</strong> {{ $user->kecamatan ?? '-' }}</p>
    </div>
</div>

<a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection
