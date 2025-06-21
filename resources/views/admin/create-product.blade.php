@extends('admin.layout')

@section('title', 'Create Product')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Create New Product</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>

                <!-- Create Product Form -->
                <div class="row">
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    <div class="col-lg-8">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Product Information</h6>
                            </div>

                            <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                                @csrf
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="productName" class="form-label">Product Name *</label>
                                                <input type="text" name="name" class="form-control" id="productName" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="productPrice" class="form-label">Price *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" name="price" class="form-control" id="productPrice" step="1" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="productStock" class="form-label">Stock Quantity *</label>
                                                <input type="number" name="quantity" class="form-control" id="productStock" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 mb-2">
                                            <i class="fas fa-save me-2"></i>Create Product
                                        </button>
                                    </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Product Images</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="productImage" class="form-label">Upload Images</label>
                                        <input type="file" name="image" class="form-control" id="productImage" multiple accept="image/*">
                                        <div class="form-text">You can select multiple images</div>
                                    </div>
                                    <div class="image-preview-container">
                                        <div class="image-placeholder">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                            <p class="text-muted mt-2">No images uploaded</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
@endsection
