@extends('layout.app')

@section('title', 'Mapa de Colombia')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-center mb-6">Mapa de Colombia</h1>
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Mapa -->
            <div class="w-full md:w-2/3">
                <div id="map" class="h-96 bg-gray-200 rounded-lg"></div>
                <div  class="mt-6 bg-white p-4 rounded-lg shadow-lg">{{ $colombia_info['description'] }}</div>
            </div>
            
            <!-- Información -->
            <div class="w-full md:w-1/3 p-4 bg-white shadow-lg rounded-lg">
                <h2 class="text-xl font-semibold">Información General</h2>
                <a href="/" class="text-blue-500 hover:text-blue-700 font-semibold">Inicio</a>
                <ul class="mt-4 space-y-2">
                    <li><strong>Capital:</strong> {{ $colombia_info['stateCapital'] }}</li>
                    <li><strong>Superficie:</strong> {{ $colombia_info['surface'] }} km²</li>
                    <li><strong>Población:</strong> {{ number_format($colombia_info['population']) }}</li>
                    <li><strong>Zona Horaria:</strong> {{ $colombia_info['timeZone'] }}</li>
                    <li><strong>Moneda:</strong> {{ $colombia_info['currency'] }} ({{ $colombia_info['currencySymbol'] }})</li>
                    <li><strong>Código ISO:</strong> {{ $colombia_info['isoCode'] }}</li>
                    <li><strong>Dominio de Internet:</strong> {{ $colombia_info['internetDomain'] }}</li>
                    <li><strong>Prefijo Telefónico:</strong> {{ $colombia_info['phonePrefix'] }}</li>
                </ul>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var map = L.map('map').setView([4.5709, -74.2973], 5); // Mapa centrado en Colombia
    
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
    
            // Cargar el GeoJSON de los departamentos
            fetch('/colombia-departments.geojson')
                .then(response => response.json())
                .then(data => {
                    L.geoJSON(data, {
                        style: {
                            color: "#3182CE",
                            weight: 1,
                            fillOpacity: 0.5
                        },
                        onEachFeature: function (feature, layer) {
                            layer.on("click", function () {
                                let departamentoID = feature.properties.DPTO;
                                window.location.href = `/colombia/departamentos/${departamentoID}`;
                            });
                        }
                    }).addTo(map);
                })
                .catch(error => console.error("Error cargando el GeoJSON:", error));
        });
    </script>
@endsection
