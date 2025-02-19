@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="ti ti-plus me-2"></i>Tambah Kategori
            </button>
        </div>
        <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4">Daftar Kategori</h5>
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle text-center table-bordered table-fixed">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0 col-1">
                                            <h6 class="fw-semibold mb-0">No</h6>
                                        </th>
                                        <th class="border-bottom-0 col-6">
                                            <h6 class="fw-semibold mb-0">Kategori</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Aksi</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kategori as $item => $k)
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">{{ $item + 1 }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mt-1">{{ $k->nama }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <button type="button" class="btn btn-warning m-1" data-bs-toggle="modal"
                                                    data-bs-target="#showData{{ $k->id }}"><i
                                                        class="ti ti-eye me-2"></i>Lihat Buku</button>
                                                <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal"
                                                    data-bs-target="#editData{{ $k->id }}"><i
                                                        class="ti ti-edit me-2"></i>Edit</button>
                                                <button type="button" class="btn btn-danger m-1" data-bs-toggle="modal"
                                                    data-bs-target="#deleteData{{ $k->id }}"><i
                                                        class="ti ti-trash me-2"></i>Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kategori</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('kategori.store') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Kategori</span>
                            <input type="text" class="form-control" name="kategori" placeholder="Masukkan Nama Kategori"
                                aria-label="kategori" aria-describedby="basic-addon1" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($kategori as $k)
        {{-- Modal Edit --}}
        <div class="modal fade" id="editData{{ $k->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Kategori</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('kategori.update', $k->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Kategori</span>
                                <input type="text" class="form-control" name="kategori"
                                    placeholder="Masukkan Nama Kategori" aria-label="Kategori"
                                    aria-describedby="basic-addon1" value="{{ $k->nama }}" required>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Modal Delete --}}
        <div class="modal fade" id="deleteData{{ $k->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Kategori</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apa Anda Yakin Akan Menghapus Kategori {{ $k->nama }}?</p>
                        <form action="{{ route('kategori.destroy', $k->id) }}" method="POST" enctype="multipart/form-data">
                            @method('DELETE')
                            @csrf
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
