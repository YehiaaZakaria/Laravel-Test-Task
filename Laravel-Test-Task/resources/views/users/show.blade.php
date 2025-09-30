@extends('layouts.app')

@section('title', 'User Details - ' . $user->full_name)

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body text-center">
                <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                     alt="Profile Picture" 
                     class="profile-img-large mb-3">
                
                <h4>{{ $user->full_name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                
                @if($user->phone)
                    <p class="mb-2">
                        <i class="bi bi-telephone me-2"></i>
                        <a href="tel:{{ $user->phone }}" class="text-decoration-none">
                            {{ $user->phone }}
                        </a>
                    </p>
                @endif
                
                <p class="text-muted small">
                    <i class="bi bi-calendar me-2"></i>
                    Registered: {{ $user->created_at->format('F d, Y') }}
                </p>
                
                @if($user->updated_at != $user->created_at)
                    <p class="text-muted small">
                        <i class="bi bi-clock me-2"></i>
                        Last updated: {{ $user->updated_at->format('F d, Y g:i A') }}
                    </p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>User Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <strong>Full Name:</strong>
                    </div>
                    <div class="col-sm-8">
                        {{ $user->full_name }}
                    </div>
                </div>
                <hr>
                
                <div class="row">
                    <div class="col-sm-4">
                        <strong>Email Address:</strong>
                    </div>
                    <div class="col-sm-8">
                        <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                            {{ $user->email }}
                        </a>
                    </div>
                </div>
                <hr>
                
                <div class="row">
                    <div class="col-sm-4">
                        <strong>Phone Number:</strong>
                    </div>
                    <div class="col-sm-8">
                        @if($user->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->phone) }}" 
                               class="text-decoration-none text-success" 
                               target="_blank"
                               title="Open WhatsApp chat">
                                <i class="bi bi-whatsapp me-1"></i>{{ $user->phone }}
                            </a>
                        @else
                            <span class="text-muted">Not provided</span>
                        @endif
                    </div>
                </div>
                <hr>
                
                <div class="row">
                    <div class="col-sm-4">
                        <strong>Profile Picture:</strong>
                    </div>
                    <div class="col-sm-8">
                        <span class="text-success">
                            <i class="bi bi-check-circle me-1"></i>Uploaded
                        </span>
                    </div>
                </div>
                <hr>
                
                <div class="row">
                    <div class="col-sm-4">
                        <strong>Registration Date:</strong>
                    </div>
                    <div class="col-sm-8">
                        {{ $user->created_at->format('F d, Y g:i A') }}
                        <small class="text-muted">({{ $user->created_at->diffForHumans() }})</small>
                    </div>
                </div>
                
                @if($user->updated_at != $user->created_at)
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Last Updated:</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ $user->updated_at->format('F d, Y g:i A') }}
                            <small class="text-muted">({{ $user->updated_at->diffForHumans() }})</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back to Users
            </a>
            <div>
                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning me-2">
                    <i class="bi bi-pencil me-1"></i>Edit User
                </a>
                <button type="button" 
                        class="btn btn-danger" 
                        onclick="confirmDelete({{ $user->id }}, '{{ $user->full_name }}')">
                    <i class="bi bi-trash me-1"></i>Delete User
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="userName"></strong>?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Delete User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDelete(userId, userName) {
        document.getElementById('userName').textContent = userName;
        document.getElementById('deleteForm').action = `/users/${userId}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
</script>
@endsection