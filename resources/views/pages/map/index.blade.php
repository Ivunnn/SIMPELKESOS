{{-- resources/views/pages/map/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="mb-3">
        <h1 class="mb-4 fw-bold">Peta Layanan Kesejahteraan Sosial</h1>

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

        {{-- Filter wilayah kecamatan --}}
        <label for="filterKecamatan" class="form-label">Filter Kecamatan</label>
        <select id="filterKecamatan" class="form-control">
            <option value="all">Semua Kecamatan</option>
        </select>
    </div>

    <div id="map" style="height: 590px;"></div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        var map = L.map('map').setView([-7.5102683, 112.4173366], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        function getColorByPendapatan(pendapatan) {
            switch (pendapatan) {
                case "<800.000":
                    return "red";
                case "800.000 - 1,2jt":
                    return "orange";
                case "1,2jt - 1,8jt":
                    return "#FFD580";
                case "1,8jt - 2,4jt":
                    return "yellow";
                case ">2,4jt":
                    return "blue";
                default:
                    return "gray";
            }
        }

        let markerLayer = L.layerGroup().addTo(map);
        let currentPendapatan = "all";
        let currentKecamatan = "all";
        let kecamatanLayers = {};

        function loadResidents() {
            let url = "{{ route('map.residents') }}";
            let params = {};
            
            // Tambahkan filter kecamatan ke URL
            if (currentKecamatan !== "all") {
                params.kecamatan = currentKecamatan;
            }

            // Tambahkan filter pendapatan ke URL
            if (currentPendapatan !== "all") {
                // Catatan: Anda perlu memfilter pendapatan di sisi server juga jika ingin efisien,
                // tapi kode ini hanya menunjukkan cara meneruskan parameter.
                // Saat ini, filter pendapatan masih dilakukan di sisi klien.
            }

            // Gabungkan parameter menjadi query string
            let queryString = new URLSearchParams(params).toString();
            if (queryString) {
                url += `?${queryString}`;
            }

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    renderMarkers(data);
                });
        }

        function renderMarkers(residents) {
            markerLayer.clearLayers();

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
                            <h6 style="margin:0; font-weight:bold;">${resident.nama_kepala_keluarga}</h6>
                            <medium><b>No. KK:</b> ${resident.no_kk || '-'}</medium><br>
                            <medium><b>Alamat:</b> ${resident.alamat}</medium><br>
                            <medium><b>Kecamatan:</b> ${resident.kecamatan}</medium><br>
                            <medium><b>Pendapatan:</b> ${resident.pendapatan}</medium><br>
                            <a href="/residents/${resident.id}"
                               class="btn btn-primary btn-sm mt-2 text-white"
                               style="padding:4px 8px; font-size:12px;">
                                Detail
                            </a>
                        </div>
                    `);
                    markerLayer.addLayer(marker);
                }
            });
        }

        document.getElementById("filterPendapatan").addEventListener("change", function() {
            currentPendapatan = this.value;
            loadResidents(); // Panggil ulang untuk memuat data dengan filter baru
        });

        document.getElementById("filterKecamatan").addEventListener("change", function() {
            currentKecamatan = this.value;
            loadResidents(); // Panggil ulang untuk memuat data dengan filter baru

            // Reset dan highlight polygon
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
        
        // Event search by Nomor KK
        document.getElementById("btnSearchKK").addEventListener("click", function () {
            let kk = document.getElementById("searchKK").value;
            let url = "{{ route('map.residents') }}";
            if (kk) {
                url += `?no_kk=${encodeURIComponent(kk)}`;
            }

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    renderMarkers(data);
                });
        });

        // Event reset search
        document.getElementById("btnResetKK").addEventListener("click", function () {
            document.getElementById("searchKK").value = '';
            loadResidents();
        });

        // Event tekan Enter di input search
        document.getElementById("searchKK").addEventListener("keyup", function (e) {
            if (e.key === "Enter") {
                let kk = this.value;
                let url = "{{ route('map.residents') }}";
                if (kk) {
                    url += `?no_kk=${encodeURIComponent(kk)}`;
                }
                
                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        renderMarkers(data);
                    });
            }
        });

        // Tambahkan legenda kategori desil
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
                    `<i style="background:${cat.color}; width:20px; height:20px; display:inline-block; margin-right:8px; border:1px solid #000;"></i>
                         <span style="font-weight:500;">${cat.label}</span><br>`;
            });
            return div;
        };
        legend.addTo(map);

        // Load GeoJSON kecamatan + isi dropdown
        fetch("{{ asset('geojson/kecamatan.geojson') }}")
            .then(res => res.json())
            .then(geojson => {
                let dropdown = document.getElementById("filterKecamatan");
                let kecamatanSet = new Set();
                
                geojson.features.forEach(f => {
                    let namaKecamatan = f.properties.nm_kecamatan || f.properties.NAMOBJ || 'Kecamatan';
                    kecamatanSet.add(namaKecamatan);
                });

                Array.from(kecamatanSet).sort().forEach(namaKecamatan => {
                    let opt = document.createElement("option");
                    opt.value = namaKecamatan;
                    opt.textContent = namaKecamatan;
                    dropdown.appendChild(opt);
                });

                var geoLayer = L.geoJSON(geojson, {
                    style: {
                        color: "black",
                        weight: 1,
                        fillColor: "violet",
                        fillOpacity: 0.2
                    },
                    onEachFeature: function(feature, layer) {
                        if (feature.properties) {
                            let namaKecamatan = feature.properties.nm_kecamatan || feature.properties.NAMOBJ || 'Kecamatan';
                            layer.bindPopup(`<b>${namaKecamatan}</b>`);
                            kecamatanLayers[namaKecamatan] = layer;

                            layer.on("click", function() {
                                document.getElementById("filterKecamatan").value = namaKecamatan;
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
                }).addTo(map);

                map.fitBounds(geoLayer.getBounds());
                loadResidents(); // Panggil awal setelah GeoJSON dimuat
            });
    </script>
@endsection