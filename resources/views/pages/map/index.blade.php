{{-- resources/views/pages/map/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div id="map" style="height: 900px;"></div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        var map = L.map('map').setView([-7.5102683, 112.4173366], 12);

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

        // Helper kategori warna (sesuai value <select>)
        function getColorByPendapatan(pendapatan) {
            switch (pendapatan) {
                case "<800.000": return "red";           // Desil 1
                case "800.000 - 1,2jt": return "orange"; // Desil 2
                case "1,2jt - 1,8jt": return "#FFD580";  // Desil 3 (orange muda)
                case "1,8jt - 2,4jt": return "yellow";   // Desil 4
                case ">2,4jt": return "blue";            // Desil 5
                default: return "gray";                  // fallback kalau kosong
            }
        }

        // Load markers dari database residents
        fetch("{{ route('map.residents') }}")
            .then(res => res.json())
            .then(data => {
                data.forEach(resident => {
                    if (resident.latitude && resident.longitude) {
                        let color = getColorByPendapatan(resident.pendapatan);

                        L.circleMarker([resident.latitude, resident.longitude], {
                            radius: 10,
                            fillColor: color,
                            color: "#000",
                            weight: 1,
                            opacity: 1,
                            fillOpacity: 0.8
                        })
                            .addTo(map)
                            .bindPopup(`
                                    <b>${resident.nama_kepala_keluarga}</b><br>
                                    Pendapatan: ${resident.pendapatan}<br>
                                    ${resident.alamat}<br>
                                    <a href="/residents/${resident.id}" class="btn text-white btn-sm btn-primary mt-2">Detail</a>
                                `);
                    }
                });
            });

        // Tambahkan legenda kategori desil
        var legend = L.control({ position: 'bottomright' });
        legend.onAdd = function () {
            var div = L.DomUtil.create('div', 'info legend');
            div.style.background = 'white';
            div.style.padding = '10px';
            div.style.border = '2px solid #ccc';
            div.style.borderRadius = '8px';
            div.style.fontSize = '14px';  // ukuran teks lebih besar
            div.style.lineHeight = '20px';

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
@endsection