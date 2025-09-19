@extends('layouts.app')

@section('content')
<h3 class="mb-4">Edit Pengguna</h3>

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
    </div>
    <div class="mb-3">
        <label>Password (kosongkan jika tidak diganti)</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="mb-3">
        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>
    <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-control" id="role-select">
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="pendamping" {{ $user->role === 'pendamping' ? 'selected' : '' }}>Pendamping</option>
        </select>
    </div>
    <div class="mb-3" id="kecamatan-field" style="{{ $user->role === 'kecamatan' ? '' : 'display:none;' }}">
    <label>Kecamatan</label>
    <select name="kecamatan" id="kecamatan-select" class="form-control">
        <option value="">-- Pilih Kecamatan --</option>
    </select>
</div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
</form>

<script>
document.getElementById('role-select').addEventListener('change', function() {
    document.getElementById('kecamatan-field').style.display = this.value === 'kecamatan' ? 'block' : 'none';
});

function loadKecamatanList(selected = "") {
    fetch("{{ route('kecamatan.list') }}")
        .then(response => response.json())
        .then(data => {
            let select = document.getElementById('kecamatan-select');
            select.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
            data.forEach(kec => {
                let isSelected = (kec === selected) ? "selected" : "";
                select.innerHTML += `<option value="${kec}" ${isSelected}>${kec}</option>`;
            });
        });
}

document.addEventListener("DOMContentLoaded", function() {
    let role = document.getElementById('role-select').value;
    if (role === 'kecamatan') {
        loadKecamatanList("{{ $user->kecamatan }}");
    }

    document.getElementById('role-select').addEventListener('change', function() {
        let field = document.getElementById('kecamatan-field');
        if (this.value === 'kecamatan') {
            field.style.display = 'block';
            loadKecamatanList("{{ $user->kecamatan }}");
        } else {
            field.style.display = 'none';
        }
    });
});
</script>
@endsection
