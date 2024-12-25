@extends('admin.layouts.app')

@section('title', 'Destinasi Page')

@section('content')
<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Destinasi</h6>
            <a href="{{ route('destinasi.create') }}" class="btn btn-primary">Tambah data</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Destination Code</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($destinasi as $destination)
                        <tr>
                            <td>{{ $destination->destination_code }}</td>
                            <td>{{ $destination->name }}</td>
                            <td>
                                @if($destination->img)
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#imageModal" data-img="{{ asset('storage/images/destinations/' . $destination->img) }}">
                                    <i class="fas fa-eye"></i> Lihat Gambar
                                </button>
                                @else
                                    <span>No image</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('destinasi.edit', $destination->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('destinasi.destroy', $destination->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"><i class="fas fa-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Image" style="width: 100%; height: auto;">
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $('#imageModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var imgSrc = button.data('img'); // Extract info from data-* attributes
        var modal = $(this);
        modal.find('#modalImage').attr('src', imgSrc);
    });

    @if(session('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif
</script>
@endpush
