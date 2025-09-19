@extends('layouts.app')

@section('content')
    <div class="mb-3">
        <h3 class="mb-4 fw-bold">Peta Layanan Kesejahteraan Sosial</h3>

        {{-- Search by Nomor KK --}}
        <div class="d-flex mb-3" style="gap:10px; max-width:500px;">
            <input type="text" id="searchKK" class="form-control" placeholder="Cari Nomor KK...">
            <button id="btnSearchKK" class="btn btn-primary">Cari</button>
            <button id="btnResetKK" class="btn btn-secondary">Reset</button>
        </div>

        {{-- Filter pendapatan --}}
        <label for="filterPendapatan" class="form-label">Filter Pendapatan per-kapita/bulan</label>
        <select id="filterPendapatan" class="form-control mb-3" style="max-width:400px;">
            <option value="all">Semua</option>
            <option value="<800.000">Kurang dari Rp.800.000 (Desil 1)</option>
            <option value="800.000 - 1,2jt">Rp.800.000 - Rp.1,2jt (Desil 2)</option>
            <option value="1,2jt - 1,8jt">Rp.1,2jt - Rp.1,8jt (Desil 3)</option>
            <option value="1,8jt - 2,4jt">Rp.1,8jt - Rp.2,4jt (Desil 4)</option>
            <option value=">2,4jt">Lebih dari Rp.2,4jt (Desil 5)</option>
        </select>

        {{-- Filter wilayah kecamatan (hanya admin) --}}
        @if(Auth::user()->role === 'admin')
            <label for="filterKecamatan" class="form-label">Filter Kecamatan</label>
            <select id="filterKecamatan" class="form-control mb-3" style="max-width:400px;">
                <option value="all">Semua Kecamatan</option>
            </select>
        @endif

        {{-- Action Buttons --}}
        <div class="d-flex mb-3" style="gap:10px;">
            <a href="{{ route('map.export.excel') }}" id="btnExportExcel" class="btn btn-success btn-sm">📊 Export Excel</a>
            <a href="{{ route('map.export.pdf') }}" id="btnExportPdf" class="btn btn-danger btn-sm">📑 Export PDF</a>
            <button id="toggleHeatmap" class="btn btn-warning btn-sm">🌡️ Toggle Heatmap</button>
        </div>
    </div>

    <div id="map" style="height: 560px;"></div>

    {{-- Leaflet & Heatmap --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>

    <script>
        var map = L.map('map').setView([-7.5102683, 112.4173366], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // --- Helpers ---
        function getColorByPendapatan(pendapatan) {
            switch (pendapatan) {
                case "<800.000": return "red";
                case "800.000 - 1,2jt": return "orange";
                case "1,2jt - 1,8jt": return "#FFD580";
                case "1,8jt - 2,4jt": return "yellow";
                case ">2,4jt": return "blue";
                default: return "gray";
            }
        }

        let markerLayer = L.layerGroup().addTo(map);
        let heatmapLayer = null;
        let currentPendapatan = "all";
        let currentKecamatan = "all";
        let currentKK = null;
        let kecamatanLayers = {};
        let isHeatmap = false;

        // --- Load Residents ---
        function loadResidents() {
            let url = "{{ route('map.residents') }}";
            let params = {};

            if (currentKK) params.no_kk = currentKK;
            if (currentKecamatan !== "all") params.kecamatan = currentKecamatan;
            if (currentPendapatan !== "all") params.pendapatan = currentPendapatan;

            let queryString = new URLSearchParams(params).toString();
            if (queryString) url += `?${queryString}`;

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if (isHeatmap) {
                        renderHeatmap(data);
                    } else {
                        renderMarkers(data);
                    }
                });
        }

        // --- Render Markers ---
        function renderMarkers(residents) {
            markerLayer.clearLayers();
            if (heatmapLayer) map.removeLayer(heatmapLayer);

            residents.forEach(resident => {
                if (resident.latitude && resident.longitude) {
                    let color = getColorByPendapatan(resident.pendapatan);

                    let marker = L.circleMarker([resident.latitude, resident.longitude], {
                        radius: 10,
                        fillColor: color,
                        color: "#000",
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.5
                    }).bindPopup(`
                            <div style="min-width:220px">
                                <h6 style="margin:0; font-weight:bold;">
                                    ${resident.nama_kepala_keluarga || '-'}
                                </h6>
                                <medium><b>No. KK:</b> ${resident.no_kk || '-'} </medium><br>
                                <medium><b>Alamat:</b> ${resident.alamat || '-'}</medium><br>
                                <medium><b>Kecamatan:</b> ${resident.kecamatan || '-'}</medium><br>
                                <medium><b>Pendapatan:</b> ${resident.pendapatan || '-'}</medium><br>
                                <a href="/residents/${resident.id}" class="btn btn-sm btn-primary mt-2 text-light">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </div>
                        `);

                    markerLayer.addLayer(marker);
                }
            });
        }

        // --- Render Heatmap ---
        function renderHeatmap(residents) {
            markerLayer.clearLayers();
            if (heatmapLayer) map.removeLayer(heatmapLayer);

            let points = residents.map(r => [
                r.latitude,
                r.longitude,
                r.pendapatan === "<800.000" ? 1 :
                    r.pendapatan === "800.000 - 1,2jt" ? 2 :
                        r.pendapatan === "1,2jt - 1,8jt" ? 3 :
                            r.pendapatan === "1,8jt - 2,4jt" ? 4 : 5
            ]);

            heatmapLayer = L.heatLayer(points, { radius: 25 }).addTo(map);
        }

        // --- Event Listeners ---
        document.getElementById("filterPendapatan").addEventListener("change", function () {
            currentPendapatan = this.value;
            loadResidents();
        });

        // Hanya aktifkan filter kecamatan jika ada (role admin)
        if (document.getElementById("filterKecamatan")) {
            document.getElementById("filterKecamatan").addEventListener("change", function () {
                currentKecamatan = this.value;
                currentKK = null;
                loadResidents();

                Object.values(kecamatanLayers).forEach(layer => {
                    layer.setStyle({
                        color: "black",
                        weight: 1,
                        fillColor: "violet",
                        fillOpacity: 0.2
                    });
                });

                if (currentKecamatan !== "all") {
                    let selectedLayer = kecamatanLayers[currentKecamatan];
                    if (selectedLayer) {
                        selectedLayer.setStyle({
                            color: "red",
                            weight: 3,
                            fillColor: "purple",
                            fillOpacity: 0.4
                        });
                        map.fitBounds(selectedLayer.getBounds());
                    }
                }
            });
        }

        // Search KK
        document.getElementById("btnSearchKK").addEventListener("click", function () {
            currentKK = document.getElementById("searchKK").value;
            loadResidents();
        });

        // Reset KK
        document.getElementById("btnResetKK").addEventListener("click", function () {
            document.getElementById("searchKK").value = '';
            currentKK = null;
            loadResidents();
        });

        document.getElementById("searchKK").addEventListener("keyup", function (e) {
            if (e.key === "Enter") {
                currentKK = this.value;
                loadResidents();
            }
        });

        // Toggle Heatmap
        document.getElementById("toggleHeatmap").addEventListener("click", function () {
            isHeatmap = !isHeatmap;
            loadResidents();
        });

        // --- Legend ---
        var legend = L.control({ position: 'bottomright' });
        legend.onAdd = function () {
            var div = L.DomUtil.create('div', 'info legend');
            div.style.background = 'white';
            div.style.padding = '10px';
            div.style.border = '2px solid #ccc';
            div.style.borderRadius = '8px';
            div.style.fontSize = '14px';
            div.style.lineHeight = '22px';

            var categories = [
                { label: "Kurang dari Rp.800.000 (Desil 1)", color: "red" },
                { label: "Rp.800.000 - Rp.1,2jt (Desil 2)", color: "orange" },
                { label: "Rp.1,2jt - Rp.1,8jt (Desil 3)", color: "#FFD580" },
                { label: "Rp.1,8jt - Rp.2,4jt (Desil 4)", color: "yellow" },
                { label: "Lebih dari Rp.2,4jt (Desil 5)", color: "blue" }
            ];

            categories.forEach(cat => {
                div.innerHTML +=
                    `<i style="background:${cat.color}; width:10px; height:10px; display:inline-block; margin-right:8px; border:1px solid #000;"></i>
                         <span style="font-weight:500;">${cat.label}</span><br>`;
            });
            return div;
        };
        legend.addTo(map);

        // --- Load GeoJSON Kecamatan ---
        fetch("{{ asset('geojson/kecamatan.geojson') }}")
            .then(res => res.json())
            .then(geojson => {
                // Isi dropdown kecamatan hanya kalau admin
                let dropdown = document.getElementById("filterKecamatan");
                let kecamatanSet = new Set();

                geojson.features.forEach(f => {
                    let namaKecamatan = f.properties.nm_kecamatan || f.properties.NAMOBJ || 'Kecamatan';
                    kecamatanSet.add(namaKecamatan);
                });

                if (dropdown) {
                    Array.from(kecamatanSet).sort().forEach(namaKecamatan => {
                        let opt = document.createElement("option");
                        opt.value = namaKecamatan;
                        opt.textContent = namaKecamatan;
                        dropdown.appendChild(opt);
                    });
                }

                var geoLayer = L.geoJSON(geojson, {
                    style: {
                        color: "black",
                        weight: 1,
                        fillColor: "violet",
                        fillOpacity: 0.2
                    },
                    onEachFeature: function (feature, layer) {
                        if (feature.properties) {
                            let namaKecamatan = feature.properties.nm_kecamatan || feature.properties.NAMOBJ || 'Kecamatan';
                            layer.bindPopup(`<b>${namaKecamatan}</b>`);
                            kecamatanLayers[namaKecamatan] = layer;

                            // Klik kecamatan hanya kalau admin
                            if (dropdown) {
                                layer.on("click", function () {
                                    dropdown.value = namaKecamatan;
                                    currentKecamatan = namaKecamatan;
                                    loadResidents();

                                    Object.values(kecamatanLayers).forEach(l => {
                                        l.setStyle({
                                            color: "black",
                                            weight: 1,
                                            fillColor: "violet",
                                            fillOpacity: 0.2
                                        });
                                    });

                                    layer.setStyle({
                                        color: "red",
                                        weight: 3,
                                        fillColor: "purple",
                                        fillOpacity: 0.4
                                    });
                                    map.fitBounds(layer.getBounds());
                                });
                            }
                        }
                    }
                }).addTo(map);

                map.fitBounds(geoLayer.getBounds());
                loadResidents(); // load pertama kali
            });

        // --- Export Buttons ---
        document.getElementById("btnExportExcel").addEventListener("click", function (e) {
            e.preventDefault();
            let url = "{{ route('map.export.excel') }}";
            let params = {};

            if (currentKecamatan !== "all") params.kecamatan = currentKecamatan;
            if (currentPendapatan !== "all") params.pendapatan = currentPendapatan;
            if (currentKK) params.no_kk = currentKK;

            let queryString = new URLSearchParams(params).toString();
            if (queryString) url += `?${queryString}`;

            window.location.href = url;
        });

        document.getElementById("btnExportPdf").addEventListener("click", function (e) {
            e.preventDefault();
            let url = "{{ route('map.export.pdf') }}";
            let params = {};

            if (currentKecamatan !== "all") params.kecamatan = currentKecamatan;
            if (currentPendapatan !== "all") params.pendapatan = currentPendapatan;
            if (currentKK) params.no_kk = currentKK;

            let queryString = new URLSearchParams(params).toString();
            if (queryString) url += `?${queryString}`;

            window.location.href = url;
        });
    </script>
@endsection