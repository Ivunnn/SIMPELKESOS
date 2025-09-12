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

        <label for="filterPendapatan" class="form-label">Filter Pendapatan per-kapita/bulan</label>
        <select id="filterPendapatan" class="form-control" style="max-width:400px;">
            <option value="all">Semua</option>
            <option value="<800.000">Kurang dari Rp.800.000 (Desil 1)</option>
            <option value="800.000 - 1,2jt">Rp.800.000 - Rp.1,2jt (Desil 2)</option>
            <option value="1,2jt - 1,8jt">Rp.1,2jt - Rp.1,8jt (Desil 3)</option>
            <option value="1,8jt - 2,4jt">Rp.1,8jt - Rp.2,4jt (Desil 4)</option>
            <option value=">2,4jt">Lebih dari Rp.2,4jt (Desil 5)</option>
        </select>
    </div>

    <div id="map" style="height: 650px;"></div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        var map = L.map('map').setView([-7.5102683, 112.4173366], 13);

        // Basemap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Load GeoJSON wilayah
        fetch("{{ asset('geojson/data.geojson') }}")
            .then(res => res.json())
            .then(geojson => {
                var geoLayer = L.geoJSON(geojson, {
                    style: {
                        color: "black",
                        weight: 1,
                        fillColor: "violet",
                        fillOpacity: 0.2
                    },
                    onEachFeature: function (feature, layer) {
                        if (feature.properties) {
                            layer.bindPopup(`<b>${feature.properties.NAMOBJ || 'Wilayah'}</b>`);
                        }
                    }
                }).addTo(map);

                map.fitBounds(geoLayer.getBounds());
            });

        // Helper kategori warna
        function getColorByPendapatan(pendapatan) {
            switch (pendapatan) {
                case "<800.000": return "red";           // Desil 1
                case "800.000 - 1,2jt": return "orange"; // Desil 2
                case "1,2jt - 1,8jt": return "#FFD580";  // Desil 3
                case "1,8jt - 2,4jt": return "yellow";   // Desil 4
                case ">2,4jt": return "blue";            // Desil 5
                default: return "gray";                  // fallback
            }
        }

        let allResidents = [];
        let markerLayer = L.layerGroup().addTo(map);

        // Fungsi load data dari server
        function loadResidents(noKK = '') {
            let url = "{{ route('map.residents') }}";
            if (noKK) {
                url += `?no_kk=${encodeURIComponent(noKK)}`;
            }

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    allResidents = data;
                    renderMarkers("all"); // default render semua (nanti tetap bisa filter pendapatan)
                });
        }

        // Render awal
        loadResidents();

        // Fungsi render marker sesuai filter pendapatan
        function renderMarkers(filterValue) {
            markerLayer.clearLayers();

            allResidents.forEach(resident => {
                if (resident.latitude && resident.longitude) {
                    if (filterValue === "all" || resident.pendapatan === filterValue) {
                        let color = getColorByPendapatan(resident.pendapatan);

                        let marker = L.circleMarker([resident.latitude, resident.longitude], {
                            radius: 10,
                            fillColor: color,
                            color: "#000",
                            weight: 1,
                            opacity: 1,
                            fillOpacity: 0.8
                        }).bindPopup(`
                            <div style="min-width:220px">
                                <h6 style="margin:0; font-weight:bold;">${resident.nama_kepala_keluarga}</h6>
                                <medium><b>No. KK:</b> ${resident.no_kk || '-'}</medium><br>
                                <medium><b>Alamat:</b> ${resident.alamat}</medium><br>
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
                }
            });
        }

        // Event filter pendapatan
        document.getElementById("filterPendapatan").addEventListener("change", function () {
            renderMarkers(this.value);
        });

        // Event search by Nomor KK
        document.getElementById("btnSearchKK").addEventListener("click", function () {
            let kk = document.getElementById("searchKK").value;
            loadResidents(kk);
        });

        // Event reset search
        document.getElementById("btnResetKK").addEventListener("click", function () {
            document.getElementById("searchKK").value = '';
            loadResidents();
        });

        // Event tekan Enter di input search
        document.getElementById("searchKK").addEventListener("keyup", function (e) {
            if (e.key === "Enter") {
                loadResidents(this.value);
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
    </script>
    >
@endsection