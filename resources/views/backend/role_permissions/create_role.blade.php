@extends('backend.layouts.master')
@section('title','Create New Role')
@section('main-content')
<div class="container-fluid">
    @include('backend.layouts.notification')
    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create New Role</h1>
        <a href="{{ route('role-permissions.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Roles
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Role Details</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('role-permissions.store-role') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="name">Role Name (System)</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="e.g., content_manager"
                                   required>
                            <small class="form-text text-muted">Use lowercase and underscores only (e.g., content_manager)</small>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="display_name">Display Name</label>
                            <input type="text" 
                                   class="form-control @error('display_name') is-invalid @enderror" 
                                   id="display_name" 
                                   name="display_name" 
                                   value="{{ old('display_name') }}" 
                                   placeholder="e.g., Content Manager"
                                   required>
                            <small class="form-text text-muted">This is the name that will be displayed in the interface</small>
                            @error('display_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3" 
                                      placeholder="Describe the role and its responsibilities">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="copyPermissions" onchange="toggleRoleSelection()">
                                <label class="custom-control-label" for="copyPermissions">
                                    Copy permissions from existing role
                                </label>
                            </div>
                        </div>

                        <div class="form-group" id="roleSelection" style="display: none;">
                            <label for="copyFromRole">Copy permissions from:</label>
                            <select class="form-control" id="copyFromRole" name="copy_from_role">
                                <option value="">-- Select Role --</option>
                                @foreach(\App\Models\Role::all() as $existingRole)
                                <option value="{{ $existingRole->id }}">{{ $existingRole->display_name }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">If selected, the new role will inherit all permissions from the chosen role</small>
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Role
                            </button>
                            <a href="{{ route('role-permissions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
function toggleRoleSelection() {
    const checkbox = document.getElementById('copyPermissions');
    const roleSelection = document.getElementById('roleSelection');
    
    if (checkbox.checked) {
        roleSelection.style.display = 'block';
    } else {
        roleSelection.style.display = 'none';
        document.getElementById('copyFromRole').value = '';
    }
}

// Auto-format role name to lowercase and underscores
document.getElementById('name').addEventListener('input', function(e) {
    e.target.value = e.target.value.toLowerCase().replace(/[^a-z0-9_]/g, '_');
});
</script>
@endsection
@endsection
