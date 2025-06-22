@extends('layout.app')

@section('title', 'Order Details')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center mb-4">
                    <h2 class="fw-bold mb-0 me-3">
                        <i class="fas fa-receipt text-primary me-2"></i>Order #{{ $order->id }}
                    </h2>
                    <span class="badge bg-{{
                        $order->status == 'delivered' ? 'success' :
                        ($order->status == 'pending' ? 'warning' :
                        ($order->status == 'shipped' ? 'info' :
                        ($order->status == 'cancelled' ? 'danger' : 'warning')))
                        }} fs-6">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="d-flex justify-content-between mb-4">
                    <div>
                        <small class="text-muted">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</small>
                    </div>
                    @if($order->status == 'pending')
                    <div>
                        <button type="button" class="btn btn-danger" data-cancel-order data-order-id="{{ $order->id }}">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>

                        <!-- Cancel Form -->
                        <form id="cancel-order-form" action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('PATCH')
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Order Items -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Order Items ({{ $order->items->count() }})</h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($order->items as $item)
                        <div class="p-4 border-bottom">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                        class="img-fluid rounded"
                                        alt="{{ $item->product->name }}">
                                </div>
                                <div class="col-md-5">
                                    <h5 class="fw-bold mb-1">{{ $item->product->name }}</h5>
                                    <p class="text-muted mb-2">{{ $item->product->description }}</p>
                                    <small class="text-muted">Quantity: {{ $item->quantity }}</small>
                                </div>
                                <div class="col-md-3">
                                    <p class="fw-bold text-primary mb-0">
                                        ${{ number_format($item->price, 2) }}
                                    </p>
                                </div>
                                <div class="col-md-2 text-end">
                                    <p class="fw-bold text-primary">
                                        ${{ number_format($item->price * $item->quantity, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Shipping Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <h6 class="fw-bold">Shipping Address</h6>
                                <p class="mb-1">{{ $order->shipping_address }}</p>
                            </div>
                            <div class="col-md-3">
                                <h6 class="fw-bold">Client Name</h6>
                                <p class="mb-1">{{ $order->user->name}}</p>
                            </div>
                            <div class="col-md-3">
                                <h6 class="fw-bold">Email</h6>
                                <p class="mb-1">{{ $order->user->email}}</p>
                            </div>
                            <div class="col-md-3">
                                <h6 class="fw-bold">Phone Number</h6>
                                <p class="mb-1">{{ $order->user->phone_number}}</p>
                            </div>

                        </div>
                        @if($order->status == 'shipped')
                        <div class="mt-3">
                            <h6 class="fw-bold">Tracking Information</h6>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 75%"></div>
                            </div>
                            <small class="text-muted">Expected delivery: {{ $order->created_at->addDays(5)->format('M d, Y') }}</small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal ({{ $order->items->count() }} items)</span>
                            <span>${{ number_format($order->subtotal, 2) }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <span>${{ number_format($order->shipping, 2) }}</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total</strong>
                            <strong class="text-primary">${{ number_format($order->total, 2) }}</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Payment Method</span>
                            <span class="text-capitalize">Cash on Delivery</span>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span>Payment Status</span>
                            <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Customer Support -->
                <div class="card shadow-sm mt-3">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Need Help?</h6>
                        <p class="small text-muted mb-2">
                            <i class="fas fa-phone-alt me-2"></i> +1 (555) 123-4567
                        </p>
                        <p class="small text-muted mb-2">
                            <i class="fas fa-envelope me-2"></i> support@example.com
                        </p>
                        <button class="btn btn-outline-primary btn-sm mt-2">
                            <i class="fas fa-comment-dots me-1"></i> Live Chat
                        </button>
                    </div>
                </div>
            </div>
        </div>
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






