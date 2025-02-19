@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4">Daftar Peminjaman</h5>
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle text-center table-bordered table-fixed">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0 col-1">
                                            <h6 class="fw-semibold mb-0">No</h6>
                                        </th>
                                        <th class="border-bottom-0 col-2">
                                            <h6 class="fw-semibold mb-0">Peminjam</h6>
                                        </th>
                                        <th class="border-bottom-0 col-2">
                                            <h6 class="fw-semibold mb-0">Buku</h6>
                                        </th>
                                        <th class="border-bottom-0 col-2">
                                            <h6 class="fw-semibold mb-0">Tanggal Pinjam</h6>
                                        </th>
                                        <th class="border-bottom-0 col-2">
                                            <h6 class="fw-semibold mb-0">Tanggal Kembali</h6>
                                        </th>
                                        <th class="border-bottom-0 col-2">
                                            <h6 class="fw-semibold mb-0">Status</h6>
                                        </th>
                                        <th class="border-bottom-0 col-2">
                                            <h6 class="fw-semibold mb-0">Aksi</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($peminjaman as $item => $p)
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">{{ $item + 1 }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mt-1">{{ $p->user->name }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mt-1">{{ $p->buku->judul }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mt-1">{{ $p->tanggalPeminjaman }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mt-1">{{ $p->tanggalPengembalian }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mt-1">{{ $p->statusPeminjaman }}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <div class="d-flex">
                                                    @if (!$p->tanggalPeminjaman)
                                                        <button type="button" class="btn btn-success m-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#pinjamkan{{ $p->id }}"><i
                                                                class="ti ti-gavel me-2"></i>Pinjamkan</button>
                                                        <button type="button" class="btn btn-info m-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#kembali{{ $p->id }}" disabled><i
                                                                class="ti ti-circle-check me-2"></i>Kembali</button>
                                                    @elseif ($p->tanggalPeminjaman && !$p->tanggalPengembalian)
                                                        <button type="button" class="btn btn-success m-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#pinjamkan{{ $p->id }}" disabled><i
                                                                class="ti ti-gavel me-2"></i>Pinjamkan</button>
                                                        <button type="button" class="btn btn-info m-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#kembali{{ $p->id }}"><i
                                                                class="ti ti-circle-check me-2"></i>Kembali</button>
                                                    @elseif ($p->tanggalPengembalian && $p->tanggalPeminjaman)
                                                        <button type="button" class="btn btn-success m-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#pinjamkan{{ $p->id }}" disabled><i
                                                                class="ti ti-gavel me-2"></i>Pinjamkan</button>
                                                        <button type="button" class="btn btn-info m-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#kembali{{ $p->id }}" disabled><i
                                                                class="ti ti-circle-check me-2"></i>Kembali</button>
                                                    @endif
                                                </div>
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

    @foreach ($peminjaman as $p)
        {{-- Modal Pinjamkan --}}
        <div class="modal fade" id="pinjamkan{{ $p->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Peminjaman Buku</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Kamu akan menyetujui <b>{{ $p->user->name }}</b> meminjam buku <b>{{ $p->buku->judul }}</b>?
                        </p>
                        <form action="{{ route('peminjaman.update', $p->id) }}" method="POST">
                            @method('PUT')
                            <input type="hidden" name="status" id="" value="dipinjam">
                            <input type="hidden" name="tanggalPinjam" id="" value="{{ date(now()) }}">
                            @csrf
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Ya, Pinjamkan</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Modal Kembali --}}
        <div class="modal fade" id="kembali{{ $p->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Peminjaman Buku</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Kamu akan menyetujui bahwa <b>{{ $p->user->name }}</b> telah mengembalikan buku <b>{{ $p->buku->judul }}</b>
                        </p>
                        <form action="{{ route('peminjaman.update', $p->id) }}" method="POST">
                            @method('PUT')
                            <input type="hidden" name="status" id="" value="kembali">
                            <input type="hidden" name="tanggalPinjam" id="" value="{{ $p->tanggalPeminjaman }}">
                            <input type="hidden" name="tanggalKembali" id="" value="{{ date(now()) }}">
                            @csrf
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Ya, Benar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
