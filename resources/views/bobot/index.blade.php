@extends('admin.layouts.app')

@section('title', 'Matriks Jarak Page')

@section('content')
<div class="container">
    <div class="container card shadow p-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Destination</th>
                    @foreach ($destinations as $destination)
                        <th>{{ $destination->destination_code }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($destinations as $origin)
                    <tr>
                        <th>{{ $origin->destination_code }}</th>
                        @foreach ($destinations as $destination)
                            @php
                                // Cari jarak antara dua destinasi
                            $distance = $distanceMatrix->where('origin_id', $origin->id)
                                                        ->where('destination_id', $destination->id)
                                                        ->first();
                            @endphp
                            <td>{{ $distance ? $distance->distance . ' km' : '0' }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
