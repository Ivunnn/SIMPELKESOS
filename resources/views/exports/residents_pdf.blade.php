<h2>Data Residents</h2>
<table border="1" cellspacing="0" cellpadding="5">
    <tr>
        <th>No KK</th>
        <th>Nama Kepala Keluarga</th>
        <th>Pendapatan</th>
        <th>Alamat</th>
        <th>Kecamatan</th>
        <th>Kelurahan</th>
    </tr>
    @foreach($residents as $r)
    <tr>
        <td>{{ $r->no_kk }}</td>
        <td>{{ $r->nama_kepala_keluarga }}</td>
        <td>{{ $r->pendapatan }}</td>
        <td>{{ $r->alamat }}</td>
        <td>{{ $r->kecamatan }}</td>
        <td>{{ $r->kelurahan }}</td>
    </tr>
    @endforeach
</table>
