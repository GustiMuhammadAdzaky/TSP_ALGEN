@extends('admin.layouts.app')

@section('title', 'Home Page')

@section('content')

@php
@endphp

<div class="container">
    {{-- coba --}}
    <div class="c-card" style="display: flex">
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Jumlah Destinasi</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <h3>{{ $data["destinasi"] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Jumlah Data Optimasi Tersimpan</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <h3>{{ $data["optimasi"] }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    {{-- coba --}}
   


    <div class="card shadow mb-4 p-5">
        <div class="dashboard-intro">
            <h1>Selamat Datang di Sistem Generator TSP Menggunakan Algoritma Genetika</h1>
            <p>
              Aplikasi ini dirancang untuk membantu Anda dalam menyelesaikan permasalahan 
              <strong>Traveling Salesman Problem (TSP)</strong> secara efisien dengan menggunakan pendekatan 
              <strong>Algoritma Genetika (ALGEN)</strong>.
            </p>
            <h2>Tujuan Aplikasi:</h2>
            <ul>
              <li>
                <strong>Optimasi Rute Perjalanan</strong><br>
                Menghasilkan rute perjalanan terbaik dengan jarak terpendek untuk mengurangi waktu dan biaya.
              </li>
              <li>
                <strong>Kemudahan Penggunaan</strong><br>
                Aplikasi ini memberikan antarmuka yang user-friendly untuk memudahkan pengguna memahami hasil optimasi.
              </li>
              <li>
                <strong>Integrasi dengan Google Maps API</strong><br>
                Visualisasi rute optimal secara interaktif melalui peta digital.
              </li>
              <li>
                <strong>Solusi yang Fleksibel dan Dinamis</strong><br>
                Mampu menangani berbagai jumlah destinasi, baik untuk kebutuhan bisnis maupun penelitian.
              </li>
            </ul>
          </div>
          
    </div>
</div>

@endsection
