@extends('layout.app')

@section('title', 'Mapa de Colombia')

@section('content')
    <div class="container mx-auto p-4 h-screen flex flex-col">
        <h1 class="text-3xl font-bold text-center mb-6">Mapa de {{ $department_info['name'] }}</h1>

        <div class="flex flex-1 gap-6">
            <!-- Mapa -->
            <div class="w-full md:w-2/3 h-full">
                <div id="map" class="h-96 bg-gray-200 rounded-lg"></div>
                <!-- Descripción -->
                <div class="mt-6 bg-white p-4 rounded-lg shadow-lg">
                    <p>{{ $department_info['description'] }}</p>
                </div>
            </div>

            <div class="w-full md:w-1/3 h-full p-4 bg-white shadow-lg rounded-lg">
                <h2 class="text-xl font-semibold">Información General de {{ $department_info['name'] }}</h2>
                <a href="/" class="text-blue-500 hover:text-blue-700 font-semibold">Inicio</a>
                <a href="{{ route('main') }}" class="text-yellow-500 hover:text-yellow-700 font-semibold">Colombia</a>
                <ul class="mt-4 space-y-2">
                    <li><strong>Superficie:</strong> {{ $department_info['surface'] }} km²</li>
                    <li><strong>Población:</strong> {{ number_format($department_info['population']) }}</li>
                </ul>
                <ul class="mt-4 space-y-2">
                    <li><strong>Capital:</strong> {{ $department_info['cityCapital']['name'] }}</li>
                    <li><strong>Código Postal:</strong> {{ $department_info['cityCapital']['postalCode'] }}</li>
                    <li><strong>Descripción:</strong> {{ $department_info['cityCapital']['description'] }}</li>
                </ul>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var departmentId = "{{ $department_info['id'] }}";
            var attractions = @json($touristAttraction_info);

            var map = L.map('map').setView([4.5709, -74.2973], 5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            fetch('/colombia-departments.geojson')
                .then(response => response.json())
                .then(data => {
                    L.geoJSON(data, {
                        style: function(feature) {
                            if (feature.properties.DPTO == departmentId) {
                                return {
                                    color: "#FF4500",
                                    weight: 4,
                                    fillOpacity: 0.7
                                };
                            }
                            return {
                                color: "#3182CE",
                                weight: 1,
                                fillOpacity: 0.5
                            };
                        },
                        onEachFeature: function(feature, layer) {
                            layer.on("click", function() {
                                let departamentoID = feature.properties.DPTO;
                                window.location.href =
                                    `/colombia/departamentos/${departamentoID}`;
                            });
                        }
                    }).addTo(map);
                })
                .catch(error => console.error("Error cargando el archivo GeoJSON:", error));

            // Agregar marcadores de atracciones turísticas
            attractions.forEach(attraction => {
                if (attraction.latitude && attraction.longitude) {
                    L.marker([attraction.latitude, attraction.longitude])
                        .addTo(map)
                        .bindPopup(`
                            <div style="text-align:center;">
                                <h3>${attraction.name}</h3>
                                <img src="${attraction.images[0]}" style="width: 100px; height: 70px; border-radius: 8px;" />
                                <p>${attraction.description.substring(0, 500)}...</p>
                            </div>
                        `);
                }
            });
        });
    </script>
@endsection
