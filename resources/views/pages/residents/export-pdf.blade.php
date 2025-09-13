<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Penduduk</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Laporan Data Penduduk</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. KK</th>
                <th>Nama Kepala Keluarga</th>
                <th>Kecamatan</th>
                <th>Pendapatan</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $row)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $row->no_kk }}</td>
                    <td>{{ $row->nama_kepala_keluarga }}</td>
                    <td>{{ $row->kecamatan }}</td>
                    <td>{{ $row->pendapatan }}</td>
                    <td>{{ $row->alamat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
