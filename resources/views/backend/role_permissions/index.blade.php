@extends('backend.layouts.master')
@section('title','Role Permissions Management')
@section('main-content')
<div class="container-fluid">
    @include('backend.layouts.notification')
    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Role Permissions Management</h1>
        <a href="{{ route('role-permissions.create-role') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add New Role
        </a>
    </div>

    <!-- Roles and Permissions Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Roles and Their Permissions</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="rolesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Role Name</th>
                            <th>Description</th>
                            <th>Users Count</th>
                            <th>Permissions Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>
                                <strong>{{ $role->display_name }}</strong>
                                <br>
                                <small class="text-muted">{{ $role->name }}</small>
                            </td>
                            <td>{{ $role->description ?? 'N/A' }}</td>
                            <td>
                                <span class="badge badge-info">{{ $role->users->count() }}</span>
                            </td>
                            <td>
                                <span class="badge badge-success">{{ $role->permissions->count() }}</span>
                            </td>
                            <td>
                                <a href="{{ route('role-permissions.show', $role->id) }}" class="btn btn-info btn-sm" title="View Permissions">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('role-permissions.edit', $role->id) }}" class="btn btn-warning btn-sm" title="Edit Permissions">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($role->name !== 'super_admin')
                                <form action="{{ route('role-permissions.destroy-role', $role->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this role?')" title="Delete Role">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Permissions Overview by Module -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Available Permissions by Module</h6>
        </div>
        <div class="card-body">
            @foreach($permissions as $module => $modulePermissions)
            <div class="mb-4">
                <h6 class="text-uppercase text-primary">{{ ucfirst(str_replace('_', ' ', $module)) }}</h6>
                <div class="row">
                    @foreach($modulePermissions as $permission)
                    <div class="col-md-3 col-sm-6 mb-2">
                        <span class="badge badge-secondary">{{ $permission->display_name }}</span>
                    </div>
                    @endforeach
                </div>
                @if(!$loop->last)
                <hr class="my-3">
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

@section('scripts')
<script>
$(document).ready(function() {
    $('#rolesTable').DataTable({
        "order": [[0, "asc"]],
        "pageLength": 25
    });
});
</script>
@endsection
@endsection
