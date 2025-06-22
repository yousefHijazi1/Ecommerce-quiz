@extends('layout.app')

@section('title', 'Home')

@section('content')

@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
     <!-- Hero Section -->
    <section class="hero-section bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-3">Welcome to ShopEase</h1>
                    <p class="lead mb-4">Discover amazing products at unbeatable prices. Shop with confidence and enjoy fast, secure delivery.</p>
                    <a href="{{ route('products') }}" class="btn btn-light btn-lg">Shop Now</a>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.pexels.com/photos/298863/pexels-photo-298863.jpeg?auto=compress&cs=tinysrgb&w=800"
                        class="img-fluid rounded" alt="Shopping">
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    <h2 class="fw-bold">Featured Products</h2>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="{{ route('products') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-right me-2"></i>View All Products
                    </a>
                </div>
            </div>
            <div class="row" id="productsContainer">
                <!-- Product 1 -->
                @foreach ($products as $product)
                    <!-- Product Card -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card product-card h-100 shadow-sm">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="Product Image">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted">{{ $product->description }}</p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="h5 text-primary mb-0">${{ $product->price }}</span>
                                    </div>
                                    @if ($product->quantity < 1)
                                        <strong class="text-danger">Out of Stock</strong>
                                    @endif
                                    <form action="{{ route('cart.add') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button
                                            type="submit"
                                            class="btn btn-primary w-100"
                                            {{ $product->quantity < 1 ? 'disabled' : '' }} >
                                            <i class="fas fa-cart-plus me-2"></i>
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

@endsection
