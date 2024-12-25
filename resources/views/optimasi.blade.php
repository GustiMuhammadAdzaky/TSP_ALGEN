@extends('admin.layouts.app')

@section('title', 'Rute Optimal')

@section('content')

@if(!is_null($data["distance_km"]))
<div class="container">
    @php
        $resultData = $data
    @endphp

    <div class="alert alert-success">
        <h4>Hasil Optimasi:</h4>
        <p>Rute: 
            @php
                $idToNameMap = $destinasi->pluck('name', 'id')->toArray();
                $routeNames = array_map(function($id) use ($idToNameMap) {
                    return $idToNameMap[$id] ?? $id;
                }, $resultData['chromosome']);
            @endphp
            {{ implode(' -> ', $routeNames) }}
        </p>
        <p>Total Jarak: {{ $resultData['distance_km'] }} km</p>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Visualisasi Rute</h6>
                </div>
                <div class="card-body">
                    <div id="map" style="height: 600px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Petunjuk Arah</h6>
                </div>
                <div class="card-body">
                    <div id="directions-panel" style="height: 600px; overflow-y: auto;"></div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('optimasi.store') }}" method="POST">
        @csrf
        <input name="solusi" type="hidden" value="{{ json_encode($resultData['chromosome']) }}">
        <input name="jarak" type="hidden" value="{{ $resultData['distance_km'] }}">
        <button type="submit" class="btn btn-primary btn-block mb-5">Simpan Data</button>
    </form>

</div>
@endif

<div class="container">
    <div class="text-center" style="display:flex; flex-direction:column;">
        <img src="{{ asset('storage/images/404.svg') }}" alt="404 Image">
        <h3 style="color: #375ECE;">Belum Ada Jalur yang di Optimasi</h3>
    </div>
</div>


<!-- Pindahkan script Google Maps ke sini dan tambahkan libraries yang diperlukan -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places,geometry&callback=initMap" async defer></script>

<style>
    .custom-map-control {
        background-color: #fff;
        border: 2px solid #fff;
        border-radius: 3px;
        box-shadow: 0 2px 6px rgba(0,0,0,.3);
        cursor: pointer;
        margin: 10px;
        padding: 8px 16px;
        text-align: center;
        color: rgb(25,25,25);
        font-family: 'Roboto',Arial,sans-serif;
        font-size: 14px;
    }
    
    .custom-map-control:hover {
        background-color: #f1f1f1;
    }
    
    .adp-directions {
        width: 100%;
    }
    
    .adp-placemark {
        background-color: #f8f9fc;
        border: 1px solid #e3e6f0;
    }
    
    .adp-summary {
        padding: 5px;
        background-color: #f8f9fc;
    }
    
    .adp-legal {
        font-size: 0.8em;
    }
    
    #directions-panel {
        font-family: 'Arial', sans-serif;
        font-size: 0.9em;
    }
    </style>


<script>
    let map;
let markers = [];
let polyline;
let directionsService;
let directionsRenderer;
let infoWindows = [];
let isPolylineVisible = true;
let isDirectionsVisible = true;
let currentDirectionsResult = null;

function initMap() {
    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer({
        suppressMarkers: true,
        suppressPolylines: false,
        preserveViewport: true,
        panel: document.getElementById('directions-panel')
    });

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: { lat: -6.200000, lng: 106.816666 },
        mapTypeControl: true,
        fullscreenControl: true,
        streetViewControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
        }
    });

    directionsRenderer.setMap(map);

    // Tombol toggle polyline
    const togglePolylineButton = document.createElement("button");
    togglePolylineButton.textContent = "Toggle Polyline";
    togglePolylineButton.classList.add("custom-map-control");
    togglePolylineButton.addEventListener("click", togglePolyline);

    // Tombol toggle directions
    const toggleDirectionsButton = document.createElement("button");
    toggleDirectionsButton.textContent = "Toggle Directions";
    toggleDirectionsButton.classList.add("custom-map-control");
    toggleDirectionsButton.addEventListener("click", toggleDirections);

    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(togglePolylineButton);
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(toggleDirectionsButton);

    const destinations = @json($destinasi);
    const route = @json($data['chromosome']);
    
    const coordinates = route.map(id => {
        const destination = destinations.find(d => d.id == id);
        return {
            lat: parseFloat(destination.lat),
            lng: parseFloat(destination.lng),
            name: destination.name,
            description: destination.description
        };
    });

    createMarkers(coordinates);
    createPolyline(coordinates);
    calculateAndDisplayRoute(coordinates);

    const bounds = new google.maps.LatLngBounds();
    coordinates.forEach(coord => bounds.extend({ lat: coord.lat, lng: coord.lng }));
    map.fitBounds(bounds);
}

function createMarkers(coordinates) {
    coordinates.forEach((coord, index) => {
        const marker = new google.maps.Marker({
            position: { lat: coord.lat, lng: coord.lng },
            map: map,
            label: {
                text: String.fromCharCode(65 + index),
                color: 'white',
                fontWeight: 'bold'
            },
            animation: google.maps.Animation.DROP,
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                scale: 15,
                fillColor: index === 0 ? '#4CAF50' : 
                          (index === coordinates.length - 1 ? '#F44336' : '#2196F3'),
                fillOpacity: 1,
                strokeWeight: 2,
                strokeColor: 'white',
            }
        });

        const infoWindow = new google.maps.InfoWindow({
            content: `
                <div style="max-width: 200px;">
                    <h6 style="margin: 0 0 5px 0;">${coord.name}</h6>
                    <p style="margin: 0 0 5px 0; font-size: 0.9em;">${coord.description || 'Tidak ada deskripsi'}</p>
                    <p style="margin: 0; font-size: 0.8em;">
                        Titik ${String.fromCharCode(65 + index)} 
                        (${index === 0 ? 'Awal' : (index === coordinates.length - 1 ? 'Akhir' : 'Persinggahan')})
                    </p>
                </div>
            `
        });

        marker.addListener('click', () => {
            infoWindows.forEach(iw => iw.close());
            infoWindow.open(map, marker);
        });

        markers.push(marker);
        infoWindows.push(infoWindow);
    });
}

function createPolyline(coordinates) {
    if (polyline) {
        polyline.setMap(null);
    }
    
    const path = coordinates.map(coord => ({ lat: coord.lat, lng: coord.lng }));
    
    polyline = new google.maps.Polyline({
        path: path,
        geodesic: true,
        strokeColor: '#FF0000',
        strokeOpacity: 1.0,
        strokeWeight: 3,
        map: isPolylineVisible ? map : null
    });
}

function togglePolyline() {
    isPolylineVisible = !isPolylineVisible;
    if (polyline) {
        polyline.setMap(isPolylineVisible ? map : null);
    }
}

function toggleDirections() {
    isDirectionsVisible = !isDirectionsVisible;
    if (currentDirectionsResult) {
        if (isDirectionsVisible) {
            directionsRenderer.setDirections(currentDirectionsResult);
            directionsRenderer.setMap(map);
        } else {
            directionsRenderer.setMap(null);
        }
    }
}

async function calculateAndDisplayRoute(coordinates) {
    if (coordinates.length < 2) return;

    try {
        const waypoints = coordinates.slice(1, -1).map(coord => ({
            location: new google.maps.LatLng(coord.lat, coord.lng),
            stopover: true
        }));

        const request = {
            origin: new google.maps.LatLng(coordinates[0].lat, coordinates[0].lng),
            destination: new google.maps.LatLng(coordinates[coordinates.length - 1].lat, coordinates[coordinates.length - 1].lng),
            waypoints: waypoints,
            optimizeWaypoints: false,
            travelMode: google.maps.TravelMode.DRIVING
        };

        const result = await new Promise((resolve, reject) => {
            directionsService.route(request, (result, status) => {
                if (status === 'OK') {
                    resolve(result);
                } else {
                    reject(status);
                }
            });
        });

        currentDirectionsResult = result;
        if (isDirectionsVisible) {
            directionsRenderer.setDirections(result);
        }

    } catch (error) {
        console.error('Error calculating directions:', error);
        alert('Gagal menghitung rute. Silakan coba lagi.');
    }
}
</script>

@endsection