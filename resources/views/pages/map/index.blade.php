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
                        color: "red",
                        weight: 1,
                        fillColor: "yellow",
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

        // Load markers dari database residents
        fetch("{{ route('map.residents') }}") // pastikan route ini ada
            .then(res => res.json())
            .then(data => {
                data.forEach(resident => {
                    if (resident.latitude && resident.longitude) {
                        L.marker([resident.latitude, resident.longitude])
                            .addTo(map)
                            .bindPopup(`
                                <b>${resident.nama_kepala_keluarga}</b><br>
                                ${resident.alamat}<br>
                                <a href="/residents/${resident.id}" class="btn text-white btn-sm btn-primary mt-2">Detail</a>
                            `);
                    }
                });
            });
    </script>

@endsection