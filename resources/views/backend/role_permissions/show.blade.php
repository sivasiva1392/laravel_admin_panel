@extends('backend.layouts.master')
@section('title','Role Permissions - {{ $role->display_name }}')
@section('main-content')
<div class="container-fluid">
    @include('backend.layouts.notification')
    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Role Permissions - {{ $role->display_name }}</h1>
        <a href="{{ route('role-permissions.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Roles
        </a>
    </div>

    <!-- Role Info Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Role Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <strong>Role Name:</strong> {{ $role->display_name }}
                </div>
                <div class="col-md-4">
                    <strong>System Name:</strong> {{ $role->name }}
                </div>
                <div class="col-md-4">
                    <strong>Users:</strong> {{ $role->users->count() }}
                </div>
            </div>
            @if($role->description)
            <div class="mt-2">
                <strong>Description:</strong> {{ $role->description }}
            </div>
            @endif
            <div class="mt-3">
                <strong>Total Permissions:</strong> 
                <span class="badge badge-success">{{ $role->permissions->count() }}</span>
            </div>
        </div>
    </div>

    <!-- Permissions by Module -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Assigned Permissions</h6>
        </div>
        <div class="card-body">
            @if($permissions->count() > 0)
                @foreach($permissions as $module => $modulePermissions)
                <div class="mb-4">
                    <h6 class="text-uppercase text-primary">
                        {{ ucfirst(str_replace('_', ' ', $module)) }}
                        <span class="badge badge-info ml-2">{{ $modulePermissions->count() }}</span>
                    </h6>
                    <div class="row">
                        @foreach($modulePermissions as $permission)
                        <div class="col-md-3 col-sm-6 mb-2">
                            <span class="badge badge-success p-2">
                                <i class="fas fa-check"></i> {{ $permission->display_name }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    @if(!$loop->last)
                    <hr class="my-3">
                    @endif
                </div>
                @endforeach
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> 
                    This role has no permissions assigned. 
                    <a href="{{ route('role-permissions.edit', $role->id) }}" class="btn btn-sm btn-primary ml-2">
                        Edit Permissions
                    </a>
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('role-permissions.edit', $role->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Permissions
                </a>
                <a href="{{ route('role-permissions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> All Roles
                </a>
            </div>
        </div>
    </div>

    <!-- Users with this Role -->
    @if($role->users->count() > 0)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Users with this Role ({{ $role->users->count() }})</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($role->users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge badge-{{ $user->status === 'active' ? 'success' : 'danger' }}">
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
