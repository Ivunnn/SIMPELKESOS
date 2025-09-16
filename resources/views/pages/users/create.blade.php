@extends('layouts.app')

@section('content')
<h3 class="mb-4">Tambah Pengguna</h3>

<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-control" required id="role-select">
            <option value="admin">Admin</option>
            <option value="kecamatan">Kecamatan</option>
        </select>
    </div>
    <div class="mb-3" id="kecamatan-field" style="display:none;">
    <label>Kecamatan</label>
    <select name="kecamatan" id="kecamatan-select" class="form-control">
        <option value="">-- Pilih Kecamatan --</option>
    </select>
</div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
</form>

<script>
document.getElementById('role-select').addEventListener('change', function() {
    document.getElementById('kecamatan-field').style.display = this.value === 'kecamatan' ? 'block' : 'none';
});

document.getElementById('role-select').addEventListener('change', function() {
    let field = document.getElementById('kecamatan-field');
    if (this.value === 'kecamatan') {
        field.style.display = 'block';

        // Fetch daftar kecamatan dari backend
        fetch("{{ route('kecamatan.list') }}")
            .then(response => response.json())
            .then(data => {
                let select = document.getElementById('kecamatan-select');
                select.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                data.forEach(kec => {
                    select.innerHTML += `<option value="${kec}">${kec}</option>`;
                });
            });
    } else {
        field.style.display = 'none';
    }
});
</script>
@endsection
