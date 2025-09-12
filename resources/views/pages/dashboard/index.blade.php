@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-4 fw-bold">Dashboard SIMPELKESOS</h1>

        {{-- Row atas: Total Penduduk --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card bg-primary text-white shadow-lg text-center p-4">
                    <div class="card-body">
                        <h4>Total Penduduk Terdata</h4>
                        <h1 class="display-3 fw-bold">{{ $total }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <h4 class="mb-3">Distribusi Pendapatan (Desil)</h4>

        {{-- Row kedua: distribusi pendapatan (desil) --}}
        <div class="row mb-4">
            
            
            @foreach($desilCounts as $desil => $count)
                <div class="col-md-2 col-sm-6 mb-3">
                    <div class="card shadow text-center h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="fw-bold">{{ $desil }}</h5>
                            <p class="display-6 mb-0">{{ $count }}</p>
                            <small>keluarga</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- Row ketiga: status kepemilikan rumah + chart --}}
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Status Kepemilikan Rumah</h5>
                        <canvas id="chartRumah"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Distribusi Pendapatan (Grafik)</h5>
                        <canvas id="chartDesil"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chart Status Rumah
        const ctxRumah = document.getElementById('chartRumah');
        new Chart(ctxRumah, {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($statusRumah->toArray())) !!},
                datasets: [{
                    data: {!! json_encode(array_values($statusRumah->toArray())) !!},
                    backgroundColor: ['#007bff', '#ffc107', '#28a745', '#dc3545'],
                    borderWidth: 1
                }]
            }
        });

        // Chart Desil
        const ctxDesil = document.getElementById('chartDesil');
        new Chart(ctxDesil, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($desilCounts)) !!},
                datasets: [{
                    label: 'Jumlah Keluarga',
                    data: {!! json_encode(array_values($desilCounts)) !!},
                    backgroundColor: ['red', 'orange', '#FFD580', 'yellow', 'blue'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
@endsection