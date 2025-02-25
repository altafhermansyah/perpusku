@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4">Daftar Buku</h5>
                        <div class="row">
                            @foreach ($buku as $b)
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="position-relative">
                                            <a href="javascript:void(0)"><img src="{{ asset('storage/' . $b->gambar) }}"
                                                    class="card-img-top rounded-0 rounded img-thumbnail" alt="..."
                                                    style="aspect-ratio: 1 / 1; object-fit: cover; cursor: pointer;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#imageModal{{ $b->id }}"></a>
                                            {{-- <a href="javascript:void(0)"
                                                class="btn btn-light rounded-circle p-3 text-dark d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3 toggle-koleksi"
                                                data-buku-id="{{ $b->id }}" data-in-koleksi="{{ $isInKoleksi }}">
                                                <i class="ti ti-star fs-6 {{ $isInKoleksi ? 'text-warning' : '' }}"></i>
                                            </a> --}}
                                            <form id="koleksi-form-{{ $b->id }}"
                                                action="{{ route('koleksi.store') }}" method="POST" style="display: none;">
                                                @csrf
                                                <input type="hidden" name="buku_id" value="{{ $b->id }}">
                                            </form>
                                            @php
                                                $isInKoleksi = Auth::user()->koleksi->contains('buku_id', $b->id);
                                            @endphp
                                            <a href="javascript:void(0)"
                                                class="btn btn-light rounded-circle p-3 text-dark d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3 toggle-koleksi"
                                                data-buku-id="{{ $b->id }}"
                                                onclick="submitKoleksiForm({{ $b->id }})">
                                                <i class="ti ti-star fs-6 {{ $isInKoleksi ? 'text-warning' : '' }}"></i>
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $b->judul }} ({{ $b->tahunTerbit }})</h5>
                                            @foreach ($b->kategoribuku as $kb)
                                                <span
                                                    class="badge bg-primary rounded-3 m-1">{{ $kb->kategori->nama }}</span>
                                            @endforeach
                                            <p class="card-text mt-2">Penulis: <b>{{ $b->penulis }}</b></p>
                                            @if ($b->peminjaman->contains('user_id', Auth::id()))
                                                <button type="button" class="btn btn-success m-1" data-bs-toggle="modal"
                                                    data-bs-target="#pinjam{{ $b->id }}" disabled><i
                                                        class="ti ti-vocabulary me-2"></i>Pinjam</button>
                                            @else
                                                <button type="button" class="btn btn-success m-1" data-bs-toggle="modal"
                                                    data-bs-target="#pinjam{{ $b->id }}"><i
                                                        class="ti ti-vocabulary me-2"></i>Pinjam</button>
                                            @endif
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
    @foreach ($buku as $b)
        {{-- Modal Delete --}}
        <div class="modal fade" id="pinjam{{ $b->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Peminjaman Buku</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apa kamu benar-benar akan meminjam buku <b>{{ $b->judul }}</b> ini?</p>
                        <form action="{{ route('list.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="buku" value="{{ $b->id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Ya, Pinjam</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <script>
        function submitKoleksiForm(bukuId) {
            let form = document.getElementById(`koleksi-form-${bukuId}`);
            let formData = new FormData(form);
            let button = document.querySelector(`.toggle-koleksi[data-buku-id="${bukuId}"]`);
            let icon = button.querySelector('i');

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'added') {
                    icon.classList.add('text-warning');
                } else if (data.status === 'removed') {
                    icon.classList.remove('text-warning');
                }
            });
        }
    </script>

@endsection
