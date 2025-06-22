@extends('layout.app')

@section('title', 'Products')



@section('content')

@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
    <section class="py-5">
        <div class="container">
            <div class="row">


                <!-- Products Grid -->
                <div class="col-lg-12">
                    <!-- Sort and View Options -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <span class="text-muted" id="productCount">Showing {{ $products->total() }} products</span>
                        </div>

                    </div>

                    <!-- Products Grid -->
                    <div class="row" id="productsGrid">
                        <!-- Product 1 -->

                        @foreach ($products as $product)
                            <div class="col-lg-3 col-md-6 mb-4 product-item" data-category="electronics" data-price="99.99" data-rating="5">
                            <div class="card product-card h-100 shadow-sm">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="Wireless Headphones">
                                    {{-- <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-success">Best Seller</span>
                                    </div> --}}
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    {{-- <p class="card-text text-muted">Premium quality wireless headphones with noise cancellation.</p> --}}
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="h5 text-primary mb-0">${{ $product->price }}</span>
                                            {{-- <div class="text-warning">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <small class="text-muted ms-1">(124)</small>
                                            </div> --}}
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


                    <nav aria-label="Page navigation" class="mt-5">
                        <ul class="pagination justify-content-center">
                            {{-- Previous Page Link --}}
                            @if ($products->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">Previous</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                <li class="page-item {{ $products->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($products->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Next</span>
                                </li>
                            @endif
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </section>
@endsection
