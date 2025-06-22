@extends('admin.layout')

@section('title', 'Orders Management')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Orders Management</h1>
                    {{-- <div class="btn-toolbar mb-2 mb-md-0">
                        <button class="btn btn-outline-primary me-2">
                            <i class="fas fa-download me-2"></i>Export Orders
                        </button>
                    </div> --}}
                </div>

                <!-- Orders Statistics -->
                <div class="row mb-4">
                    <div class="col-md-2 p-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>{{ $orders->count() }}</h4>
                                        <p class="mb-0">Total Orders</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-shopping-cart fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 p-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4> {{ $orders->where('status', 'pending')->count() }}</h4>
                                        <p class="mb-0">Pending</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 p-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4> {{ $orders->where('status', 'shipped')->count() }}</h4>
                                        <p class="mb-0">Shipped</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-cog fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 p-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4> {{ $orders->where('status', 'cancelled')->count() }}</h4>
                                        <p class="mb-0">Cancelled</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-cancel fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 p-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4> {{ $orders->where('status', 'delivered')->count() }}</h4>
                                        <p class="mb-0">Delivered</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-check fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <!-- Orders Table -->
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Orders List</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td><strong># {{ $order->id }}</strong></td>
                                            <td>
                                                <div>
                                                    <strong>{{ $order->user->name }}</strong>
                                                    <br><small class="text-muted">{{ $order->user->email }}</small>
                                                </div>
                                            </td>
                                            <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                                            <td>
                                                <span class="badge bg-{{
                                                    $order->status == 'delivered' ? 'success' :
                                                    ($order->status == 'pending' ? 'warning' :
                                                    ($order->status == 'shipped' ? 'info' :
                                                    ($order->status == 'cancelled' ? 'danger' : 'warning')))
                                                }}">{{ ucfirst($order->status) }}</span>
                                            </td>
                                            <td>
                                                <small>{{ $order->created_at->format('M d, Y') }}<br>{{ $order->created_at->format('h:i A') }}</small>
                                            </td>
                                            <td>
                                                @if(!in_array($order->status, ['cancelled', 'delivered']))
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                                            id="statusDropdown{{ $order->id }}" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                        Change Status
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="statusDropdown{{ $order->id }}">
                                                        <li>
                                                            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" name="status" value="processing" class="dropdown-item">
                                                                    <i class="fas fa-clock me-2"></i>Pending
                                                                </button>
                                                                <button type="submit" name="status" value="processing" class="dropdown-item">
                                                                    <i class="fas fa-cog me-2"></i>Processing
                                                                </button>
                                                                <button type="submit" name="status" value="shipped" class="dropdown-item">
                                                                    <i class="fas fa-truck me-2"></i>Shipped
                                                                </button>
                                                                <button type="submit" name="status" value="delivered" class="dropdown-item">
                                                                    <i class="fas fa-check-circle me-2"></i>Delivered
                                                                </button>
                                                                <div class="dropdown-divider"></div>
                                                                <button type="submit" name="status" value="cancelled" class="dropdown-item text-danger">
                                                                    <i class="fas fa-times-circle me-2"></i>Cancel Order
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                                @else
                                                <span class="text-muted">No actions</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <nav aria-label="Page navigation" class="mt-5">
                            <ul class="pagination justify-content-center">
                                {{-- Previous Page Link --}}
                                @if ($orders->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $orders->previousPageUrl() }}" rel="prev">Previous</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                    <li class="page-item {{ $orders->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($orders->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $orders->nextPageUrl() }}" rel="next">Next</a>
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
