@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="ti ti-plus me-2"></i>Tambah Buku
            </button>
        </div>
        <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4">Daftar Buku</h5>
                        <div class="row">
                            @foreach ($buku as $b)
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="d-flex justify-content-center mt-3">
                                            <img src="{{ asset('storage/' . $b->gambar) }}" alt="{{ $b->judul }}"
                                                class="rounded img-thumbnail w-75"
                                                style="aspect-ratio: 1 / 1; object-fit: cover; cursor: pointer;"
                                                data-bs-toggle="modal" data-bs-target="#imageModal{{ $b->id }}">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $b->judul }} ({{ $b->tahunTerbit }})</h5>
                                            @foreach ($b->kategoribuku as $kb)
                                                <span class="badge bg-primary rounded-3 m-1">{{ $kb->kategori->nama }}</span>
                                            @endforeach
                                            <p class="card-text mt-2">Penulis: <b>{{ $b->penulis }}</b></p>
                                            <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal"
                                                data-bs-target="#editData{{ $b->id }}"><i
                                                    class="ti ti-edit me-2"></i>Edit</button>
                                            <button type="button" class="btn btn-danger m-1" data-bs-toggle="modal"
                                                data-bs-target="#deleteData{{ $b->id }}"><i
                                                    class="ti ti-trash me-2"></i>Delete</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="imageModal{{ $b->id }}" tabindex="-1"
                                    aria-labelledby="imageModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imageModalLabel">Preview Gambar</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('storage/' . $b->gambar) }}" id="modalImage"
                                                    alt="Gambar Buku" class="img-fluid rounded w-50">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{ $buku->links() }}
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Buku</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Judul</span>
                            <input type="text" class="form-control" name="judul" placeholder="Masukkan Judul Buku"
                                aria-label="Username" aria-describedby="basic-addon1" required>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Penulis</span>
                            <input type="text" class="form-control" name="penulis" placeholder="Masukkan Penulis Buku"
                                aria-label="Username" aria-describedby="basic-addon1" required>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Penerbit</span>
                            <input type="text" class="form-control" name="penerbit" placeholder="Masukkan Penerbit Buku"
                                aria-label="Username" aria-describedby="basic-addon1" required>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Tahun Terbit</span>
                            <select class="form-control" name="tahun" id="tahunTerbit" required>
                                <option value="" disabled selected>Pilih Tahun</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pilih Kategori</label><br>
                            @foreach ($kategori as $k)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="kategori[]"
                                        value="{{ $k->id }}" id="kategori{{ $k->id }}">
                                    <label class="form-check-label"
                                        for="kategori{{ $k->id }}">{{ $k->nama }}</label>
                                </div>
                            @endforeach
                        </div>


                        <div class="mb-3">
                            <label for="formFile" class="form-label">Input Gambar</label>
                            <input class="form-control" name="gambar" type="file" id="formFile" required>
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

    @foreach ($buku as $b)
        {{-- Modal Edit --}}
        <div class="modal fade" id="editData{{ $b->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Buku</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('buku.update', $b->id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Judul</span>
                                <input type="text" class="form-control" name="judul"
                                    placeholder="Masukkan Judul Buku" aria-label="Username"
                                    aria-describedby="basic-addon1" value="{{ $b->judul }}" required>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Penulis</span>
                                <input type="text" class="form-control" name="penulis"
                                    placeholder="Masukkan Penulis Buku" aria-label="Username"
                                    aria-describedby="basic-addon1" value="{{ $b->penulis }}" required>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Penerbit</span>
                                <input type="text" class="form-control" name="penerbit"
                                    placeholder="Masukkan Penerbit Buku" aria-label="Username"
                                    aria-describedby="basic-addon1" value="{{ $b->penerbit }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <div class="d-flex flex-wrap">
                                    @foreach ($kategori as $k)
                                        @php
                                            $checked = false;
                                            foreach ($b->kategoriBuku as $bk) {
                                                if ($bk->kategoriId == $k->id) {
                                                    $checked = 'checked';
                                                    break;
                                                }
                                            }
                                        @endphp
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" name="kategori[]"
                                                value="{{ $k->id }}" id="kategori{{ $k->id }}"
                                                {{ $checked }}>
                                            <label class="form-check-label" for="kategori{{ $k->id }}">
                                                {{ $k->nama }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Tahun Terbit</span>
                                <input type="number" class="form-control" name="tahun"
                                    placeholder="Masukkan Tahun Terbit" aria-label="Tahun Terbit"
                                    aria-describedby="basic-addon1" value="{{ $b->tahunTerbit }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="formFile" class="form-label">Input Gambar</label>
                                <input class="form-control" name="gambar" type="file" id="formFile">
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
        <div class="modal fade" id="deleteData{{ $b->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Buku</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apa Anda Yakin Akan Menghapus Buku {{ $b->judul }}?</p>
                        <form action="{{ route('buku.destroy', $b->id) }}" method="POST" enctype="multipart/form-data">
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let selectTahun = document.getElementById("tahunTerbit");
            let tahunSekarang = new Date().getFullYear();
            for (let i = tahunSekarang; i >= 1945; i--) {
                let option = document.createElement("option");
                option.value = i;
                option.textContent = i;
                selectTahun.appendChild(option);
            }
        });
    </script>
@endsection
