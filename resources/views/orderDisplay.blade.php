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
                        <button class="btn btn-sm btn-outline-danger"
                                onclick="showCancelModal('{{ $order->id }}')">
                            <i class="fas fa-times-circle me-1"></i> Cancel Order
                        </button>
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
                                        ${{ number_format($item->price, 2) }} each
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
                            <div class="col-md-6">
                                <h6 class="fw-bold">Shipping Address</h6>
                                <p class="mb-1">{{ $order->shipping_address }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold">Billing Address</h6>
                                <p class="mb-1">{{ $order->billing_address }}</p>
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
                            <span class="text-capitalize">{{ $order->payment_method ?? 'Not specified' }}</span>
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

    <!-- Cancel Order Modal -->
    <div class="modal fade" id="cancelOrderModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="cancelOrderForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title">Cancel Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to cancel this order?</p>
                        <p class="text-muted">Order #<span id="cancelOrderId"></span></p>
                        <div class="mb-3">
                            <label for="cancelReason" class="form-label">Reason for cancellation</label>
                            <select class="form-select" id="cancelReason" name="reason" required>
                                <option value="">Select a reason</option>
                                <option value="changed-mind">Changed my mind</option>
                                <option value="found-better-price">Found better price</option>
                                <option value="no-longer-needed">No longer needed</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keep Order</button>
                        <button type="submit" class="btn btn-danger">Cancel Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function showCancelModal(orderId) {
        document.getElementById('cancelOrderId').textContent = orderId;
        document.getElementById('cancelOrderForm').action = `/orders/${orderId}/cancel`;
        new bootstrap.Modal(document.getElementById('cancelOrderModal')).show();
    }
</script>
@endsection
