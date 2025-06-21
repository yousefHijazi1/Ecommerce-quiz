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
                <!-- Sidebar Filters -->
                <div class="col-lg-3 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filters</h5>
                        </div>
                        <div class="card-body">
                            <!-- Categories -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Categories</h6>
                                <div class="form-check">
                                    <input class="form-check-input category-filter" type="checkbox" value="electronics" id="electronics">
                                    <label class="form-check-label" for="electronics">
                                        Electronics <span class="badge bg-light text-dark ms-1">8</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input category-filter" type="checkbox" value="accessories" id="accessories">
                                    <label class="form-check-label" for="accessories">
                                        Accessories <span class="badge bg-light text-dark ms-1">4</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input category-filter" type="checkbox" value="wearables" id="wearables">
                                    <label class="form-check-label" for="wearables">
                                        Wearables <span class="badge bg-light text-dark ms-1">3</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input category-filter" type="checkbox" value="home" id="home">
                                    <label class="form-check-label" for="home">
                                        Home & Garden <span class="badge bg-light text-dark ms-1">2</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Price Range -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Price Range</h6>
                                <div class="form-check">
                                    <input class="form-check-input price-filter" type="checkbox" value="0-100" id="price1">
                                    <label class="form-check-label" for="price1">
                                        Under $100
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input price-filter" type="checkbox" value="100-500" id="price2">
                                    <label class="form-check-label" for="price2">
                                        $100 - $500
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input price-filter" type="checkbox" value="500-1000" id="price3">
                                    <label class="form-check-label" for="price3">
                                        $500 - $1000
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input price-filter" type="checkbox" value="1000+" id="price4">
                                    <label class="form-check-label" for="price4">
                                        Over $1000
                                    </label>
                                </div>
                            </div>

                            <!-- Rating -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Rating</h6>
                                <div class="form-check">
                                    <input class="form-check-input rating-filter" type="checkbox" value="5" id="rating5">
                                    <label class="form-check-label" for="rating5">
                                        <div class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input rating-filter" type="checkbox" value="4" id="rating4">
                                    <label class="form-check-label" for="rating4">
                                        <div class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            & Up
                                        </div>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input rating-filter" type="checkbox" value="3" id="rating3">
                                    <label class="form-check-label" for="rating3">
                                        <div class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            & Up
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Clear Filters -->
                            <button class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                                <i class="fas fa-times me-2"></i>Clear All Filters
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-lg-9">
                    <!-- Sort and View Options -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <span class="text-muted" id="productCount">Showing {{ $products->total() }} products</span>
                        </div>
                        {{-- <div class="d-flex align-items-center">
                            <label class="me-2">Sort by:</label>
                            <select class="form-select form-select-sm" style="width: auto;" id="sortSelect">
                                <option value="featured">Featured</option>
                                <option value="price-low">Price: Low to High</option>
                                <option value="price-high">Price: High to Low</option>
                                <option value="rating">Customer Rating</option>
                                <option value="newest">Newest First</option>
                            </select>
                        </div> --}}
                    </div>

                    <!-- Products Grid -->
                    <div class="row" id="productsGrid">
                        <!-- Product 1 -->

                        @foreach ($products as $product)
                            <div class="col-lg-4 col-md-6 mb-4 product-item" data-category="electronics" data-price="99.99" data-rating="5">
                            <div class="card product-card h-100 shadow-sm">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="Wireless Headphones">
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-success">Best Seller</span>
                                    </div>
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
                    <!-- Load More Button -->
                    {{-- <div class="text-center mt-4">
                        <button class="btn btn-outline-primary btn-lg" onclick="loadMoreProducts()">
                            <i class="fas fa-plus me-2"></i>Load More Products
                        </button>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
@endsection
