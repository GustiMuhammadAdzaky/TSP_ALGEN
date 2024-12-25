@extends('admin.layouts.app')

@section('title', 'Generate Page')

@section('content')





<div class="container">
    <div class="card shadow mb-4"> 
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Optimasi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal Disimpan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ruteOptimal as $rO)
                        <tr>
                            <td>{{ $rO->date_time }}</td>
                            <td class="text-center">
                                <form style="display: inline" action="{{ route('optimasi.show') }}" method="get">
                                    <button type="submit" class="btn btn-warning show-btn">
                                        <input type="hidden" name="id" value="{{ $rO->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </form>
                                <form action="{{ route('optimasi.destroy') }}" method="POST" style="display: inline" id="delete-form-{{ $rO->id }}">
                                    @csrf
                                    <input name="id" type="hidden" value="{{ $rO->id }}">
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $rO->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    <a href="{{ route('optimasi.generate') }}" class="btn btn-primary btn-block"><i class="fas fa-route"></i>Generate</a> 
                </div>
            </div>
        </div>
    </div>
</div>



@endsection




@push('scripts')




    <script>

    
        
        @if(session('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
        @endif


        function confirmDelete(id) {
            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah anda yakin menghapus rute ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endpush('scripts')