@extends('layouts.app')

@push('styles')
{{-- Cukup muat Bootstrap untuk memastikan kelas-kelas dasar ada --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid p-4">

    <div class="row mb-4">
        <div class="col">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Dashboard SIMPELKESOS</h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-primary text-white shadow h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <h6 class="text-uppercase mb-1">Total Penduduk</h6>
                    <div class="h1 fw-bold">{{ $total }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-md-6 mb-3">
            <div class="card shadow h-100">
                <div class="card-body">
                    <h6 class="text-primary fw-bold mb-3 text-center">Distribusi Pendapatan (Desil)</h6>
                    <div class="row g-2">
                        @foreach($desilCounts as $desil => $count)
                            <div class="col">
                                <div class="card bg-light text-center">
                                    <div class="card-body p-2">
                                        <div class="fw-bold small">{{ $desil }}</div>
                                        <div class="h5 mb-0">{{ $count }}</div>
                                        <div class="small text-muted">Keluarga</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status Kepemilikan Rumah</h6>
                </div>
                <div class="card-body">
                    <div id="chartRumah"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Distribusi Pendapatan (Grafik)</h6>
                </div>
                <div class="card-body">
                    <div id="chartDesil"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Grafik Status Kepemilikan Rumah (Pie Chart)
    const statusRumahOptions = {
        series: {!! json_encode(array_values($statusRumah->toArray()), JSON_NUMERIC_CHECK) !!},
        labels: {!! json_encode(array_keys($statusRumah->toArray())) !!},
        chart: { type: 'pie', height: 400 },
        legend: { position: 'top' }
    };
    const chartRumah = new ApexCharts(document.querySelector("#chartRumah"), statusRumahOptions);
    chartRumah.render();

    // Grafik Distribusi Pendapatan (Bar Chart)
    const desilOptions = {
        series: [{
            name: 'Jumlah Keluarga',
            data: {!! json_encode(array_values($desilCounts), JSON_NUMERIC_CHECK) !!}
        }],
        chart: { type: 'bar', height: 400 },
        xaxis: { categories: {!! json_encode(array_keys($desilCounts)) !!} }
    };
    const chartDesil = new ApexCharts(document.querySelector("#chartDesil"), desilOptions);
    chartDesil.render();
});
</script>
@endpush