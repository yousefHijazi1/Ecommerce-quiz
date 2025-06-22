@extends('admin.layout')

@section('title', 'Users Management')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Users Management</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="{{ route('user.create') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>Add New User
                        </a>
                    </div>
                </div>


                <!-- Users Table -->
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Users List</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>

                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Joined</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        @if ($user->role != 'admin')
                                            <tr>
                                                <td>
                                                    <div>
                                                        <strong>{{ $user->name }}</strong>
                                                        <br><small class="text-muted">ID: #{{ $user->id }}</small>
                                                    </div>
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td><span class="badge bg-primary">{{ $user->role }}</span></td>
                                                <td>{{ date_format($user->created_at,"M d, Y") }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary me-1">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-info me-1">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <nav aria-label="Page navigation" class="mt-5">
                            <ul class="pagination justify-content-center">
                                {{-- Previous Page Link --}}
                                @if ($users->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">Previous</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                    <li class="page-item {{ $users->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($users->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">Next</a>
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
