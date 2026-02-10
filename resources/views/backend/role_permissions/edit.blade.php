@extends('backend.layouts.master')
@section('title','Edit Role Permissions')
@section('main-content')
<div class="container-fluid">
    @include('backend.layouts.notification')
    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Permissions - {{ $role->display_name }}</h1>
        <a href="{{ route('role-permissions.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Roles
        </a>
    </div>

    <form action="{{ route('role-permissions.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        
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
            </div>
        </div>

        <!-- Permissions Selection -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Select Permissions</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-primary" onclick="selectAllPermissions()">
                            <i class="fas fa-check-square"></i> Select All
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="deselectAllPermissions()">
                            <i class="fas fa-square"></i> Deselect All
                        </button>
                        <button type="button" class="btn btn-sm btn-info" onclick="selectModulePermissions()">
                            <i class="fas fa-check"></i> Select by Module
                        </button>
                    </div>
                </div>

                @foreach($permissions as $module => $modulePermissions)
                <div class="mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <h6 class="text-uppercase text-primary mb-0 mr-3">{{ ucfirst(str_replace('_', ' ', $module)) }}</h6>
                        <button type="button" class="btn btn-xs btn-outline-primary" onclick="toggleModule('{{ $module }}')">
                            Toggle Module
                        </button>
                    </div>
                    
                    <div class="row">
                        @foreach($modulePermissions as $permission)
                        <div class="col-md-3 col-sm-6 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" 
                                       class="custom-control-input permission-checkbox" 
                                       id="permission_{{ $permission->id }}" 
                                       name="permissions[]" 
                                       value="{{ $permission->id }}"
                                       data-module="{{ $module }}"
                                       @if(in_array($permission->id, $rolePermissionIds)) checked @endif>
                                <label class="custom-control-label" for="permission_{{ $permission->id }}">
                                    {{ $permission->display_name }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if(!$loop->last)
                    <hr class="my-3">
                    @endif
                </div>
                @endforeach

                <div class="row mt-4">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update Permissions
                        </button>
                        <a href="{{ route('role-permissions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@section('scripts')
<script>
function selectAllPermissions() {
    $('.permission-checkbox').prop('checked', true);
}

function deselectAllPermissions() {
    $('.permission-checkbox').prop('checked', false);
}

function toggleModule(module) {
    $('input[data-module="' + module + '"]').prop('checked', function(i, val) {
        return !val;
    });
}

function selectModulePermissions() {
    var modules = [];
    $('input[data-module]').each(function() {
        var module = $(this).data('module');
        if (!modules.includes(module)) {
            modules.push(module);
        }
    });
    
    var moduleList = modules.join(', ');
    var selectedModule = prompt('Available modules:\n' + moduleList + '\n\nEnter module name to select:');
    
    if (selectedModule && modules.includes(selectedModule)) {
        $('input[data-module="' + selectedModule + '"]').prop('checked', true);
    } else if (selectedModule) {
        alert('Module not found: ' + selectedModule);
    }
}

// Add some visual feedback
$(document).ready(function() {
    $('.permission-checkbox').change(function() {
        if ($(this).is(':checked')) {
            $(this).closest('.custom-control').addClass('text-success');
        } else {
            $(this).closest('.custom-control').removeClass('text-success');
        }
    });
    
    // Initialize visual state
    $('.permission-checkbox:checked').closest('.custom-control').addClass('text-success');
});
</script>
@endsection
@endsection
