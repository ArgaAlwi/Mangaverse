@extends('layouts.master')

@section('title', 'Masuk ke Mangaverse')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 text-center pt-4 pb-0">
                    <h3 class="fw-bold" style="color: var(--mv-blue);">
                        <i class="fa-solid fa-book-open"></i> MANGAVERSE
                    </h3>
                    <p class="text-muted">Selamat datang kembali, Nakama!</p>
                </div>
                <div class="card-body p-4">
                    <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                                <input type="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                                <input type="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="current-password">
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                <label class="form-check-label text-muted small" for="remember_me">Ingat Saya</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none small fw-bold" href="{{ route('password.request') }}" style="color: var(--mv-blue);">Lupa password?</a>
                            @endif
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary rounded-pill py-2 fw-bold" style="background-color: var(--mv-blue); border: none;">Masuk</button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <span class="text-muted small">Belum punya akun? </span>
                            <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: var(--mv-blue);">Daftar di sini</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection