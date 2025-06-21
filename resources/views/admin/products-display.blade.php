@extends('admin.layout')

@section('title', 'Products Management')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Products Management</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="{{ route('product.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add New Product
                        </a>
                    </div>
                </div>



                <!-- Products Table -->
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Products List</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        {{-- <th>Category</th> --}}
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $product->image) }}" height="60" width="60" style="border-radius:8px ">
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        {{-- <td>Electronics</td> --}}
                                        <td>${{ $product->price }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        @if ($product->quantity > 0)
                                            <td><span class="badge bg-success">In Stock</span></td>
                                        @else
                                            <td><span class="badge bg-danger">Out of Stock</span></td>
                                        @endif
                                        <td>
                                            <a href="edit-product.html" class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
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
            </main>
@endsection
