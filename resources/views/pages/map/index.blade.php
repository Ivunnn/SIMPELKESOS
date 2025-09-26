@extends('layouts.app')

{{-- Tambahkan CSS untuk styling control filter di dalam peta --}}
@section('styles')
    <style>
        /* Styling untuk container utama kontrol filter */
        .leaflet-control-filter {
            background-color: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.4);
            max-width: 280px;
            max-height: 90vh;
            /* Batasi tinggi agar bisa di-scroll di layar kecil */
            overflow-y: auto;
        }

        .leaflet-control-filter h5 {
            margin-top: 0;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 16px;
        }

        .leaflet-control-filter .form-control,
        .leaflet-control-filter .btn {
            margin-bottom: 10px;
        }

        .leaflet-control-filter .input-group {
            display: flex;
            gap: 5px;
        }

        .leaflet-control-filter label {
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
        }
    </style>
@endsection

@section('content')
    <div class="mb-3">
        <h3 class="mb-4 fw-bold">Peta Layanan Kesejahteraan Sosial</h3>

        {{-- KONTROL FILTER LAMA DIHAPUS DARI SINI --}}

        {{-- Action Buttons bisa tetap di sini atau dipindahkan juga --}}
        <div class="d-flex mb-3" style="gap:10px;">
            <a href="{{ route('map.export.excel') }}" id="btnExportExcel" class="btn btn-success btn-sm">📊 Export Excel</a>
            <a href="{{ route('map.export.pdf') }}" id="btnExportPdf" class="btn btn-danger btn-sm">📑 Export PDF</a>
            <button id="toggleHeatmap" class="btn btn-warning btn-sm">🌡️ Toggle Heatmap</button>
        </div>
    </div>

    {{-- Container Peta --}}
    <div id="map" style="height: 650px;"></div>

    {{-- Leaflet & Heatmap JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>

    <script>
        // Inisialisasi Peta
        var map = L.map('map').setView([-7.5102683, 112.4173366], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // --- Variabel Global & Helpers ---
        let markerLayer = L.layerGroup().addTo(map);
        let heatmapLayer = null;
        let currentPendapatan = "all";
        let currentKecamatan = "all";
        let currentKK = null;
        let kecamatanLayers = {};
        let isHeatmap = false;
        const USER_ROLE = '{{ Auth::user()->role }}'; // Ambil role user untuk logika di JS

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

        // Buat Custom Control untuk Filter
        L.Control.Filter = L.Control.extend({
            onAdd: function (map) {
                // Buat container utama untuk kontrol
                const container = L.DomUtil.create('div', 'leaflet-control-filter');

                // Mencegah event map (klik/drag) saat berinteraksi
                L.DomEvent.disableClickPropagation(container);
                L.DomEvent.disableScrollPropagation(container);

                // Definisikan HTML untuk filter dalam card
                let adminFilterHtml = '';
                if (USER_ROLE === 'admin') {
                    adminFilterHtml = `
                        <div class="mb-2">
                            <label for="filterKecamatan" class="form-label">Filter Kecamatan</label>
                            <select id="filterKecamatan" class="form-control">
                                <option value="all">Semua Kecamatan</option>
                            </select>
                        </div>
                    `;
                }

                container.innerHTML = `
                    <div class="card shadow-sm" style="border-radius:10px;">
                        <div class="card-header bg-primary text-white py-2 px-3">
                            <h6 class="m-0"><i class="fas fa-filter"></i> Filter Peta</h6>
                        </div>
                        <div class="card-body p-2">

                            <!-- Search by Nomor KK -->
                            <div class="mb-2">
                                <label for="searchKK" class="form-label">Cari Nomor KK</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="searchKK" class="form-control" placeholder="Cari...">
                                    <button id="btnSearchKK" class="btn btn-primary">Cari</button>
                                    <button id="btnResetKK" class="btn btn-secondary">X</button>
                                </div>
                            </div>

                            <!-- Filter Pendapatan -->
                            <div class="mb-2">
                                <label for="filterPendapatan" class="form-label">Filter Pendapatan (Desil)</label>
                                <select id="filterPendapatan" class="form-control form-control-sm">
                                    <option value="all">Semua</option>
                                    <option value="<800.000">Desil 1 (< Rp.800rb)</option>
                                    <option value="800.000 - 1,2jt">Desil 2 (Rp.800rb - 1,2jt)</option>
                                    <option value="1,2jt - 1,8jt">Desil 3 (Rp.1,2jt - 1,8jt)</option>
                                    <option value="1,8jt - 2,4jt">Desil 4 (Rp.1,8jt - 2,4jt)</option>
                                    <option value=">2,4jt">Desil 5 (> Rp.2,4jt)</option>
                                </select>
                            </div>

                            <!-- Filter Kecamatan (hanya admin) -->
                            ${adminFilterHtml}

                        </div>
                    </div>
                `;

                // Event Listeners
                container.querySelector("#filterPendapatan").addEventListener("change", function () {
                    currentPendapatan = this.value;
                    loadResidents();
                });

                if (USER_ROLE === 'admin') {
                    container.querySelector("#filterKecamatan").addEventListener("change", function () {
                        handleKecamatanFilterChange(this.value);
                    });
                }

                container.querySelector("#btnSearchKK").addEventListener("click", function () {
                    currentKK = container.querySelector("#searchKK").value;
                    loadResidents();
                });

                container.querySelector("#btnResetKK").addEventListener("click", function () {
                    container.querySelector("#searchKK").value = '';
                    currentKK = null;
                    loadResidents();
                });

                container.querySelector("#searchKK").addEventListener("keyup", function (e) {
                    if (e.key === "Enter") {
                        currentKK = this.value;
                        loadResidents();
                    }
                });

                return container;
            }
        });


        // 4. Tambahkan custom control baru ke peta
        L.control.filter = function (opts) {
            return new L.Control.Filter(opts);
        }
        L.control.filter({ position: 'topright' }).addTo(map);

        // --- Fungsi Utama (load data, render, dll) ---
        // Tidak ada perubahan signifikan di sini, hanya pemanggilan

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

        function renderMarkers(residents) {
            markerLayer.clearLayers();
            if (heatmapLayer) map.removeLayer(heatmapLayer);

            residents.forEach(resident => {
                if (resident.latitude && resident.longitude) {
                    let color = getColorByPendapatan(resident.pendapatan);
                    let marker = L.circleMarker([resident.latitude, resident.longitude], {
                        radius: 8, fillColor: color, color: "#000",
                        weight: 1, opacity: 1, fillOpacity: 0.8
                    }).bindPopup(`
                                <div style="min-width:220px">
                                    <h6 style="margin:0; font-weight:bold;">${resident.nama_kepala_keluarga || '-'}</h6>
                                    <medium><b>No. KK:</b> ${resident.no_kk || '-'}</medium><br>
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

        function renderHeatmap(residents) {
            markerLayer.clearLayers();
            if (heatmapLayer) map.removeLayer(heatmapLayer);

            let points = residents
                .filter(r => r.latitude && r.longitude) // Pastikan lat/lng valid
                .map(r => [
                    r.latitude,
                    r.longitude,
                    // Bobot untuk heatmap berdasarkan desil
                    r.pendapatan === "<800.000" ? 1.0 :
                        r.pendapatan === "800.000 - 1,2jt" ? 0.8 :
                            r.pendapatan === "1,2jt - 1,8jt" ? 0.6 :
                                r.pendapatan === "1,8jt - 2,4jt" ? 0.4 : 0.2
                ]);

            heatmapLayer = L.heatLayer(points, { radius: 25, max: 1.0 }).addTo(map);
        }

        function handleKecamatanFilterChange(kecamatanName) {
            currentKecamatan = kecamatanName;
            currentKK = null; // Reset pencarian KK jika ganti kecamatan
            loadResidents();

            // Reset style semua layer polygon
            Object.values(kecamatanLayers).forEach(layer => {
                layer.setStyle({ color: "black", weight: 1, fillColor: "violet", fillOpacity: 0.2 });
            });

            // Highlight & zoom ke kecamatan yang dipilih
            if (currentKecamatan !== "all") {
                let selectedLayer = kecamatanLayers[currentKecamatan];
                if (selectedLayer) {
                    selectedLayer.setStyle({ color: "red", weight: 3, fillColor: "purple", fillOpacity: 0.4 });
                    map.fitBounds(selectedLayer.getBounds());
                }
            }
        }

        // --- Event Listeners untuk Tombol di Luar Peta ---
        document.getElementById("toggleHeatmap").addEventListener("click", function () {
            isHeatmap = !isHeatmap;
            this.innerHTML = isHeatmap ? '📍 Toggle Markers' : '🌡️ Toggle Heatmap';
            loadResidents();
        });

        // --- Legenda ---
        var legend = L.control({ position: 'bottomright' });
        legend.onAdd = function () {
            var div = L.DomUtil.create('div', 'info legend');
            div.style.background = 'white';
            div.style.padding = '10px';
            div.style.border = '1px solid #ccc';
            div.style.borderRadius = '5px';
            var categories = [
                { label: "Desil 1", color: "red" },
                { label: "Desil 2", color: "orange" },
                { label: "Desil 3", color: "#FFD580" },
                { label: "Desil 4", color: "yellow" },
                { label: "Desil 5", color: "blue" }
            ];
            div.innerHTML = '<h6 style="margin:0 0 5px 0; font-weight:bold;">Legenda Pendapatan</h6>';
            categories.forEach(cat => {
                div.innerHTML +=
                    `<i style="background:${cat.color}; width:18px; height:18px; float:left; margin-right:8px; border:1px solid #000;"></i>
                             <span>${cat.label}</span><br>`;
            });
            return div;
        };
        legend.addTo(map);

        // --- Load GeoJSON Kecamatan ---
        fetch("{{ asset('geojson/kecamatan.geojson') }}")
            .then(res => res.json())
            .then(geojson => {
                // Populate dropdown kecamatan di dalam kontrol filter jika user adalah admin
                if (USER_ROLE === 'admin') {
                    const dropdown = document.querySelector("#filterKecamatan"); // Cari dropdown yang sudah dibuat oleh kontrol
                    if (dropdown) {
                        const kecamatanSet = new Set();
                        geojson.features.forEach(f => {
                            let namaKecamatan = f.properties.nm_kecamatan || f.properties.NAMOBJ;
                            if (namaKecamatan) kecamatanSet.add(namaKecamatan);
                        });

                        Array.from(kecamatanSet).sort().forEach(namaKecamatan => {
                            let opt = document.createElement("option");
                            opt.value = namaKecamatan;
                            opt.textContent = namaKecamatan;
                            dropdown.appendChild(opt);
                        });
                    }
                }

                // Render GeoJSON layer
                var geoLayer = L.geoJSON(geojson, {
                    style: { color: "black", weight: 1, fillColor: "violet", fillOpacity: 0.2 },
                    onEachFeature: function (feature, layer) {
                        let namaKecamatan = feature.properties.nm_kecamatan || feature.properties.NAMOBJ || 'Kecamatan';
                        layer.bindPopup(`<b>${namaKecamatan}</b>`);
                        kecamatanLayers[namaKecamatan] = layer;

                        // Tambahkan event klik pada polygon (hanya untuk admin)
                        if (USER_ROLE === 'admin') {
                            layer.on("click", function () {
                                document.querySelector("#filterKecamatan").value = namaKecamatan;
                                handleKecamatanFilterChange(namaKecamatan);
                            });
                        }
                    }
                }).addTo(map);

                map.fitBounds(geoLayer.getBounds());
                loadResidents(); // Load data awal setelah semua siap
            });

        // --- Logika Tombol Export (sudah benar, tidak perlu diubah) ---
        // (Kode untuk event listener btnExportExcel dan btnExportPdf tetap sama)
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