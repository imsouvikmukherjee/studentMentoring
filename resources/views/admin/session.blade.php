@extends('admin.layout.main')

@section('main-container')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Sessions</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('admin_dashboard')}}" style="color: #00a8ff;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Sessions</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.sessions.add') }}" class="btn btn-primary">Add Session</a>
            </div>
        </div>
        <!--end breadcrumb-->

        @if (session('success'))
        <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
            <div class="text-white">{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
            <div class="text-white">{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Session Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($sessions->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center">No sessions found</td>
                                </tr>
                            @else
                                @foreach($sessions as $session)
                                <tr>
                                    <td>{{ $session->id }}</td>
                                    <td>{{ $session->name }}</td>
                                    <td>
                                        @if($session->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editSessionModal{{ $session->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('admin.sessions.destroy', $session->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this session?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                
                                <!-- Edit Modal for Session -->
                                <div class="modal fade" id="editSessionModal{{ $session->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Session</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.sessions.update', $session->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="edit_session_name{{ $session->id }}" class="form-label">Session Name</label>
                                                        <input type="text" class="form-control" id="edit_session_name{{ $session->id }}" name="name" value="{{ $session->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_description{{ $session->id }}" class="form-label">Description</label>
                                                        <textarea class="form-control" id="edit_description{{ $session->id }}" name="description" rows="3">{{ $session->description }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="edit_is_active{{ $session->id }}" name="is_active" value="1" {{ $session->is_active ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="edit_is_active{{ $session->id }}">
                                                                Active
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="academicSession" value="{{ $session->id }}">
                                                    <button type="submit" class="btn btn-primary">Update Session</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 