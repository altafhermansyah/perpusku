@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title fw-semibold mb-4">Daftar Peminjaman</h5>
                            <form method="GET">
                                <div class="input-group">
                                    <label class="input-group-text" for="statusSelect">Filter</label>
                                    <select class="form-select" id="statusSelect" name="status"
                                        onchange="this.form.submit()">
                                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>
                                            Sedang Dipinjam</option>
                                        <option value="kembali" {{ request('status') == 'kembali' ? 'selected' : '' }}>Sudah
                                            Dikembalikan</option>
                                        <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua
                                        </option>
                                    </select>
                                </div>
                            </form>
                        </div>


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

                                            <button type="button" class="btn btn-success m-1" data-bs-toggle="modal"
                                                data-bs-target="#ulasan{{ $b->id }}">
                                                <i class="ti ti-message me-2"></i>Ulasan
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Ulasan -->
                                <div class="modal fade" id="ulasan{{ $b->id }}" tabindex="-1"
                                    aria-labelledby="ulasanLabel{{ $b->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ulasanLabel{{ $b->id }}">
                                                    Ulasan untuk {{ $b->judul }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @if ($b->ulasan->isEmpty())
                                                    <p class="text-muted">Belum ada ulasan untuk buku ini.</p>
                                                @else
                                                    <div class="list-group">
                                                        @foreach ($b->ulasan as $ulasan)
                                                            <div class="list-group-item">
                                                                <h6 class="fw-bold">{{ $ulasan->user->name }}</h6>
                                                                <p>⭐ {{ $ulasan->rating }}/5</p>
                                                                <p>"{{ $ulasan->komentar }}"</p>
                                                                <small class="text-muted">Ditulis pada
                                                                    {{ \Carbon\Carbon::parse($ulasan->created_at)->format('d M Y') }}</small>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Preview Gambar -->
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

                        {{-- <!-- Modal untuk Ulasan -->
                        <div class="modal fade" id="ulasanModal{{ $p->buku->id }}" tabindex="-1"
                            aria-labelledby="ulasanModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Beri Ulasan untuk {{ $p->buku->judul }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('ulasan.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="buku_id" value="{{ $p->buku->id }}">
                                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                                            <div class="mb-3">
                                                <label class="form-label">Rating</label>
                                                <select name="rating" class="form-select" required>
                                                    <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                                                    <option value="4">⭐⭐⭐⭐ (4)</option>
                                                    <option value="3">⭐⭐⭐ (3)</option>
                                                    <option value="2">⭐⭐ (2)</option>
                                                    <option value="1">⭐ (1)</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Komentar</label>
                                                <textarea name="komentar" class="form-control" rows="3" required></textarea>
                                            </div>

                                            <button type="submit" class="btn btn-success">Kirim
                                                Ulasan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    @endsection
