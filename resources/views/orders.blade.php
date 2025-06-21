@extends('layout.app')

@section('title', 'Orders')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h2 class="fw-bold mb-4"><i class="fas fa-clipboard-list text-primary me-2"></i>My Orders</h2>
            </div>
        </div>

        <!-- Order Filters -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="btn-group" role="group">
                    <a href="{{ route('orders.display') }}" class="btn btn-{{ !request('status') ? 'primary' : 'outline-primary' }}">All Orders</a>
                    @foreach(['pending', 'shipped', 'delivered', 'cancelled'] as $status)
                        <a href="{{ route('orders.display', ['status' => $status]) }}"
                           class="btn btn-{{ request('status') == $status ? 'primary' : 'outline-primary' }}">
                           {{ ucfirst($status) }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <form action="{{ route('orders.display') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                               placeholder="Search orders..." value="{{ request('search') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($orders->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-5" id="emptyState">
                <i class="fas fa-shopping-bag text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3 text-muted">No orders found</h4>
                <p class="text-muted">Start shopping to see your orders here</p>
                <a href="{{ route('products') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-cart me-2"></i>Start Shopping
                </a>
            </div>
        @else
            @foreach($orders as $order)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <strong>Order #{{ $order->id }}</strong>
                            <br>
                            <small class="text-muted">Placed on {{ $order->created_at->format('M d, Y') }}</small>
                        </div>
                        <div class="col-md-2">
                            <strong>${{ number_format($order->total, 2) }}</strong>
                        </div>
                        <div class="col-md-3">
                            <span class="badge bg-{{
                                $order->status == 'delivered' ? 'success' :
                                ($order->status == 'pending' ? 'warning' :
                                ($order->status == 'shipped' ? 'info' :
                                ($order->status == 'cancelled' ? 'danger' : 'warning')))
                                }}">
                                <i class="fas
                                    {{ $order->status == 'delivered' ? 'fa-check-circle' :
                                    ($order->status == 'pending' ? 'fa-clock' :
                                    ($order->status == 'shipped' ? 'fa-shipping-fast' :
                                    ($order->status == 'cancelled' ? 'fa-times-circle' : 'fa-clock'))) }}
                                    me-1"></i>
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="col-md-4 text-end">
                            @if($order->status == 'pending')
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary me-2">View Details</a>
                                <button type="button" class="btn btn-danger" data-cancel-order data-order-id="{{ $order->id }}">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </button>

                                <!-- Cancel Form -->
                                <form id="cancel-order-form" action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('PATCH')
                                </form>

                            @elseif($order->status == 'shipped')
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary me-2">View Details</a>
                                <button class="btn btn-sm btn-outline-success">Track Order</button>

                            @elseif($order->status == 'delivered')
                                <button class="btn btn-sm btn-outline-primary me-2">Review Product</button>
                                <button class="btn btn-sm btn-outline-secondary">Buy Again</button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($order->items as $item)
                    <div class="row mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                        <div class="col-md-2">
                            <img src="{{ asset('storage/' . $item->product->image) }}" class="img-fluid rounded" alt="{{ $item->product->name }}">
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">{{ $item->product->name }}</h6>
                            <p class="text-muted mb-1">{{ $item->product->description ?? 'No description available' }}</p>
                            <small class="text-muted">Quantity: {{ $item->quantity }}</small>
                        </div>
                        <div class="col-md-4">
                            @if($order->status == 'processing')
                                <div class="progress mb-2">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%"></div>
                                </div>
                                <small class="text-muted">Expected delivery: {{ $order->created_at->addDays(7)->format('M d, Y') }}</small>

                            @elseif($order->status == 'shipped')
                                <div class="progress mb-2">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 75%"></div>
                                </div>
                                <small class="text-muted">Expected delivery: {{ $order->created_at->addDays(5)->format('M d, Y') }}</small>

                            @elseif($order->status == 'delivered')
                                <div class="progress mb-2">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                                </div>
                                <small class="text-success">Delivered on {{ $order->updated_at->format('M d, Y') }}</small>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

<script>
    // Cancel Button Event Listener
document.addEventListener('DOMContentLoaded', function() {
    const cancelButton = document.querySelector('[data-cancel-order]');
    const cancelForm = document.getElementById('cancel-order-form');

    cancelButton.addEventListener('click', function() {
        cancelForm.submit();
    });
});
</script>
@endsection


