@extends('admin.layouts.app')

@section('title', 'Edit Destinasi')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Data Destinasi</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('destinasi.update', $destinasi->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <div class="col-md-4 mb-3">
                                <input type="text" class="form-control form-control-user @error('destination_code') is-invalid @enderror" id="destination_code" name="destination_code" placeholder="Destinasi Code" value="{{ old('destination_code', $destinasi->destination_code) }}">
                                @error('destination_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror" id="name" name="name" placeholder="Name" value="{{ old('name', $destinasi->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="file" class="form-control form-control-user @error('img') is-invalid @enderror" id="img" name="img" accept="image/*">
                                @error('img')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 mb-3">
                                <textarea class="form-control form-control-user @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description" rows="4">{{ old('description', $destinasi->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card shadow p-3 mb-3">
                            <div id="map"></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user @error('lat') is-invalid @enderror" id="lat" name="lat" placeholder="Latitude" readonly value="{{ old('lat', $destinasi->lat) }}">
                                @error('lat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-user @error('lng') is-invalid @enderror" id="lng" name="lng" placeholder="Longitude" readonly value="{{ old('lng', $destinasi->lng) }}">
                                @error('lng')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">Update Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function initMap() {
        const defaultLocation = { lat: {{ $destinasi->lat }}, lng: {{ $destinasi->lng }} };

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 12,
            center: defaultLocation,
        });

        const marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true,
        });

        google.maps.event.addListener(marker, 'position_changed', function() {
            const position = marker.getPosition();
            document.getElementById('lat').value = position.lat();
            document.getElementById('lng').value = position.lng();
        });
    }
</script>
@endpush
