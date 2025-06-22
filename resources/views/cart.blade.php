@extends('layout.app')

@section('title', 'Cart')

@php
use App\Models\Cart;
@endphp

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center mb-4">
                    <h2 class="fw-bold mb-0 me-3"><i class="fas fa-shopping-cart text-primary me-2"></i>Shopping Cart</h2>
                    <span class="badge bg-primary fs-6" id="cartItemCount">{{ Cart::where('user_id', Auth::id())->count() }} items</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Cart Items -->
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <!-- Cart Item 1 -->
                        @foreach($cartItems as $item)
                            <div class="cart-item p-4 border-bottom">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="img-fluid rounded" alt="Product Image">
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="fw-bold mb-1">{{ $item->product->name }}</h5>
                                        <p class="text-muted mb-0">{{ $item->product->description }}</p>
                                        @if ($item->product->quantity < 1)
                                            <strong class="text-danger">Out of Stock</strong>
                                        @endif
                                        @if ($item->product->quantity > 1)
                                            <strong class="text-success">In Stock</strong>
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        <div class="quantity-controls">
                                            <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity({{ $item->id }}, -1)">-</button>
                                                <span class="mx-2 fw-bold">{{ $item->quantity }}</span>
                                            <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity({{ $item->id }}, 1)">+</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="fw-bold  mb-0 {{ $item->product->quantity < 1 ? 'text-decoration-line-through text-secondary' : 'text-primary' }}" >${{ $item->product->price }}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="fw-bold mb-0 item-subtotal {{ $item->product->quantity < 1 ? 'text-decoration-line-through text-secondary' : 'text-primary' }}">${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger remove-item">
                                                <i class="fas fa-trash"></i> Remove
                                            </button>
                                        </form>
                                    </div>
                                    <div id="error-message-{{ $item->id }}"></div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Continue Shopping -->
                        <div class="p-4">
                            <a href="{{ route('products')}}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Shipping Address -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Shipping Address *</h6>
                        <div class="input-group">
                            <input name="shipping_address" type="text" class="form-control" placeholder="Enter your shipping address" id="shippingAddress" required>
                        </div>
                    </div>
                </div>
                <!-- Order Summary -->
                <div class="card shadow-sm mt-3">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Order Summary</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $validCartItems = $cartItems->filter(function ($item) {
                                return $item->product->quantity >= 1;
                            });
                            $subtotal = $validCartItems->sum(function ($item) {
                                return $item->product->price * $item->quantity;
                            });
                        @endphp

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal ({{ $validCartItems->count() }} items)</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <span>$10.00</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total</strong>
                            <strong class="text-primary">${{ number_format($subtotal + 10, 2) }}</strong>
                        </div>

                        <button
                            class="btn btn-primary w-100 btn-lg mb-3"
                            id="checkoutButton"
                            {{ $validCartItems->isEmpty() ? 'disabled' : '' }}
                        >
                            <i class="fas fa-credit-card me-2"></i>
                            Proceed to Checkout
                        </button>

                        <div class="text-center">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Secure checkout with SSL encryption
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Promo Code -->

            </div>
        </div>
    </div>

<script>
document.getElementById('checkoutButton').addEventListener('click', function() {
    // Get shipping address from input
    const shippingAddress = document.getElementById('shippingAddress').value;

    // Validate shipping address
    if (!shippingAddress) {
        alert('Please enter your shipping address');
        this.innerHTML = '<i class="fas fa-credit-card me-2"></i> Proceed to Checkout';
        this.disabled = false;
        return;
    }

    // Show loading state
    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing...';
    this.disabled = true;

    // Create the order via AJAX
    fetch('{{ route("orders.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            shipping_address: shippingAddress
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.redirect) {
            window.location.href = data.redirect;
        } else if (data.error) {
            alert(data.error);
            this.innerHTML = '<i class="fas fa-credit-card me-2"></i> Proceed to Checkout';
            this.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred during checkout. Please try again.');
        this.innerHTML = '<i class="fas fa-credit-card me-2"></i> Proceed to Checkout';
        this.disabled = false;
    });
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function updateQuantity(id, quantity) {
        $.ajax({
            type: 'POST',
            url: '{{ route('cart.update') }}',
            data: {
                id: id,
                quantity: quantity,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                if(data.error){
                    $('#error-message-' + id).html('<span class="text-danger">' + data.error + '</span>');
                }else{
                    window.location.reload();
                }
            }
        });
    }


</script>

@endsection

