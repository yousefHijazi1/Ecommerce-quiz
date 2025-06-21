@extends('admin.layout')

@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Users</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">1,245</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Products</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">856</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-box fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Orders</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">2,341</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Revenue</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">$125,430</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Tables -->
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Recent Users</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>John Doe</td>
                                                <td>john@example.com</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                            </tr>
                                            <tr>
                                                <td>Jane Smith</td>
                                                <td>jane@example.com</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                            </tr>
                                            <tr>
                                                <td>Mike Johnson</td>
                                                <td>mike@example.com</td>
                                                <td><span class="badge bg-warning">Pending</span></td>
                                            </tr>
                                            <tr>
                                                <td>Sarah Wilson</td>
                                                <td>sarah@example.com</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center">
                                    <a href="users.html" class="btn btn-primary btn-sm">View All Users</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Recent Orders</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>#1001</td>
                                                <td>John Doe</td>
                                                <td>$120.00</td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                            </tr>
                                            <tr>
                                                <td>#1002</td>
                                                <td>Jane Smith</td>
                                                <td>$85.50</td>
                                                <td><span class="badge bg-warning">Processing</span></td>
                                            </tr>
                                            <tr>
                                                <td>#1003</td>
                                                <td>Mike Johnson</td>
                                                <td>$200.00</td>
                                                <td><span class="badge bg-info">Shipped</span></td>
                                            </tr>
                                            <tr>
                                                <td>#1004</td>
                                                <td>Sarah Wilson</td>
                                                <td>$75.25</td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center">
                                    <a href="orders.html" class="btn btn-primary btn-sm">View All Orders</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
@endsection
