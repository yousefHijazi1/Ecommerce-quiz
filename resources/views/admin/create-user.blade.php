@extends('admin.layout')

@section('title', 'Create User')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Create New User</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>

                <!-- Create User Form -->
                <div class="row">
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    <div class="col-lg-12">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">User Information</h6>
                            </div>

                            <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                                @csrf
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="UserName" class="form-label">User Name *</label>
                                                <input type="text" name="name" class="form-control" id="UserName" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="email" name="email" class="form-control" id="email" step="1" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="phone_number" class="form-label">Phone Number *</label>
                                                <input type="number" name="phone_number" class="form-control" id="phone_number" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password *</label>
                                                <input type="password" name="password" class="form-control" id="password" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Confirm Password *</label>
                                                <input type="password" name="password_confirmation" class="form-control" id="password" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-3">
                                        <button type="submit" class="btn btn-primary w-100 mb-2">
                                            <i class="fas fa-save me-2"></i>Create User
                                        </button>
                                    </div>

                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </main>
@endsection
