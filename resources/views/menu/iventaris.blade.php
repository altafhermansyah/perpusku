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
                                        <th class="border-bottom-0 col-3">
                                            <h6 class="fw-semibold mb-0">Buku</h6>
                                        </th>
                                        <th class="border-bottom-0 col-1">
                                            <h6 class="fw-semibold mb-0">Tanggal Pinjam</h6>
                                        </th>
                                        <th class="border-bottom-0 col-1">
                                            <h6 class="fw-semibold mb-0">Tanggal Kembali</h6>
                                        </th>
                                        <th class="border-bottom-0 col-1">
                                            <h6 class="fw-semibold mb-0">Status</h6>
                                        </th>
                                        <th class="border-bottom-0 col-1">
                                            <h6 class="fw-semibold mb-0">Rating</h6>
                                        </th>
                                        <th class="border-bottom-0 col-4">
                                            <h6 class="fw-semibold mb-0">Ulasan</h6>
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
                                                <img src="{{ asset('storage/' . $p->buku->gambar) }}" alt="{{ $p->buku->judul }}"
                                                class="rounded img-thumbnail w-75"
                                                style="aspect-ratio: 1 / 1; object-fit: cover; cursor: pointer;"
                                                data-bs-toggle="modal" data-bs-target="#imageModal{{ $p->bukuId }}">
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
                                            </td>
                                            <td class="border-bottom-0">
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
@endsection
