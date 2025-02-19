@extends('layouts.guest')

@section('content')
<div class="card mb-0">
    <div class="card-body">
        <h1 class="text-nowrap text-center d-block fw-bolder py-3 w-100">Perpusku.</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input id="password" type="password"
                    class="form-control @error('password') is-invalid @enderror" name="password"
                    required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit"
                class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign
                In</button>
            <div class="d-flex align-items-center justify-content-center">
                <p class="fs-4 mb-0 fw-bold">Baru di Perpusku?</p>
                <a class="text-primary fw-bold ms-2" href="{{ route('register') }}">Buat Akun
                    Sekarang</a>
            </div>
        </form>
    </div>
</div>
@endsection
