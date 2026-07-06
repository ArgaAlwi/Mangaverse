@extends('layouts.master')

@section('title', 'Daftar Akun Mangaverse')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 text-center pt-4 pb-0">
                    <h3 class="fw-bold" style="color: var(--mv-blue);">
                        <i class="fa-solid fa-user-plus"></i> DAFTAR
                    </h3>
                    <p class="text-muted">Mulai petualanganmu di Mangaverse</p>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                            <x-input-error :messages="$errors->get('name')" class="text-danger small mt-1" />
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                            <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control rounded-3 @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password">
                            <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password</label>
                            <input type="password" class="form-control rounded-3" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger small mt-1" />
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary rounded-pill py-2 fw-bold" style="background-color: var(--mv-blue); border: none;">Daftar Sekarang</button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <span class="text-muted small">Sudah punya akun? </span>
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: var(--mv-blue);">Masuk di sini</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection