<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">

<style>


body {
    font-size: 0.9rem;
    padding-top: 56px;
}

.sidebar {
    position: fixed;
    top: 56px;
    bottom: 0;
    left: 0;
    z-index: 100;
    padding: 0;
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, 0.1);
}

.sidebar .nav-link {
    color: #333;
    padding: 0.75rem 1rem;
    border-radius: 0;
    transition: all 0.3s ease;
}

.sidebar .nav-link:hover {
    color: #007bff;
    background-color: rgba(0, 123, 255, 0.1);
}

.sidebar .nav-link.active {
    color: #007bff;
    background-color: rgba(0, 123, 255, 0.1);
    border-right: 3px solid #007bff;
}

.sidebar .nav-link i {
    width: 16px;
    text-align: center;
}

/* Statistics Cards */
.card.border-left-primary {
    border-left: 0.25rem solid #007bff !important;
}

.card.border-left-success {
    border-left: 0.25rem solid #28a745 !important;
}

.card.border-left-info {
    border-left: 0.25rem solid #17a2b8 !important;
}

.card.border-left-warning {
    border-left: 0.25rem solid #ffc107 !important;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.text-gray-300 {
    color: #dddfeb !important;
}

/* Product images in table */
.product-img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
}

/* User avatars */
.user-avatar {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 50%;
}

/* Image placeholder for create product */
.image-placeholder {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 2rem;
    text-align: center;
    background-color: #f8f9fa;
}

/* Table hover effects */
.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}

/* Badge styles */
.badge {
    font-size: 0.75em;
    padding: 0.375em 0.75em;
}

/* Card shadows */
.card.shadow {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .sidebar {
        position: static;
        height: auto;
        box-shadow: none;
    }

    body {
        padding-top: 56px;
    }

    .col-md-9.ms-sm-auto {
        margin-left: 0 !important;
    }
}

/* Form styling */
.form-control:focus,
.form-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Button hover effects */
.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Custom scrollbar for sidebar */
.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.sidebar::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Animation for page load */
.card {
    animation: fadeInUp 0.5s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Status indicators */
.badge.bg-success {
    background-color: #28a745 !important;
}

.badge.bg-warning {
    background-color: #ffc107 !important;
    color: #212529 !important;
}

.badge.bg-danger {
    background-color: #dc3545 !important;
}

.badge.bg-info {
    background-color: #17a2b8 !important;
}

.badge.bg-secondary {
    background-color: #6c757d !important;
}

.badge.bg-primary {
    background-color: #007bff !important;
}

/* Table responsive improvements */
.table-responsive {
    border-radius: 8px;
}

.table th {
    border-top: none;
    font-weight: 600;
    background-color: #f8f9fa;
    color: #495057;
}

/* Loading states */
.btn.loading {
    pointer-events: none;
    opacity: 0.6;
}

/* Input group styling */
.input-group-text {
    background-color: #f8f9fa;
    border-color: #ced4da;
}

/* Dropdown improvements */
.dropdown-menu {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border-radius: 8px;
}

.dropdown-item:hover {
    background-color: rgba(0, 123, 255, 0.1);
    color: #007bff;
}

/* Page header styling */
.border-bottom {
    border-color: #e3e6f0 !important;
}

/* Custom alert styling */
.alert {
    border: none;
    border-radius: 8px;
}

/* Progress bar styling */
.progress {
    height: 8px;
    border-radius: 4px;
}

.progress-bar {
    border-radius: 4px;
}
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i>Admin
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif"
                            href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-home me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request()->routeIs('users.display')) active @endif"
                            href="{{ route('users.display') }}">
                                <i class="fas fa-users me-2"></i>Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request()->routeIs('products.display')) active @endif"
                            href="{{ route('products.display') }}">
                                <i class="fas fa-box me-2"></i>Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request()->routeIs('admin.orders.display')) active @endif"
                            href="{{ route('admin.orders.display') }}">
                                <i class="fas fa-shopping-cart me-2"></i>Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request()->routeIs('product.create')) active @endif"
                            href="{{ route('product.create') }}">
                                <i class="fas fa-plus me-2"></i>Add Product
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            @yield('content')

        </div>
    </div>
</body>
</html>
