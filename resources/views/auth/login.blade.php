@extends('auth.layout')

@section('title', 'Login')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-user-circle text-primary fs-1 mb-3"></i>
                            <h2 class="fw-bold">Welcome Back</h2>
                            <p class="text-muted">Sign in to your account</p>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form id="loginForm" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope text-muted"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control" id="email" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control" id="password" required>
                                </div>
                            </div>

                            {{-- <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div> --}}

                            <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </button>
                        </form>

                        {{-- <div class="text-center">
                            <a href="#" class="text-decoration-none">Forgot your password?</a>
                        </div> --}}

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="mb-0">Don't have an account?</p>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary w-100 mt-2">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
