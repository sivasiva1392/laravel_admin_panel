@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add User</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Name</label>
        <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{old('name')}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
            <label for="inputEmail" class="col-form-label">Email</label>
          <input id="inputEmail" type="email" name="email" placeholder="Enter email"  value="{{old('email')}}" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="inputPassword" class="col-form-label">Password</label>
          <input id="inputPassword" type="password" name="password" placeholder="Enter password"  value="{{old('password')}}" class="form-control">
          @error('password')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="inputPasswordConfirmation" class="col-form-label">Confirm Password</label>
          <input id="inputPasswordConfirmation" type="password" name="password_confirmation" placeholder="Confirm password"  value="{{old('password_confirmation')}}" class="form-control">
          @error('password_confirmation')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Photo</label>
        <input type="file" class="form-control-file" accept="image/*" name="photo">
        <small class="text-muted">Upload user avatar (JPEG, PNG, JPG, GIF - Max 2MB)</small>
        <div id="uploadPreview" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
            <label for="role_id" class="col-form-label">Role</label>
            <select name="role_id" class="form-control">
                <option value="">-----Select Role-----</option>
                @foreach($roles as $role)
                    <option value="{{$role->id}}">{{$role->display_name}}</option>
                @endforeach
            </select>
          @error('role_id')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div>
          <div class="form-group">
            <label for="status" class="col-form-label">Status</label>
            <select name="status" class="form-control">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div>
          <!-- Permissions Section -->
          <div class="form-group">
            <label class="col-form-label">Permissions</label>
            <div class="card shadow-sm">
              <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                  <h6 class="mb-0">
                    <input type="checkbox" id="selectAll" class="mr-2">
                    <label for="selectAll" class="mb-0 font-weight-bold text-white">Select All Permissions</label>
                  </h6>
                  <div class="d-flex align-items-center">
                    <div class="input-group input-group-sm mr-2" style="width: 200px;">
                      <input type="text" id="permissionSearch" class="form-control" placeholder="Search permissions...">
                      <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                      </div>
                    </div>
                    <div class="btn-group btn-group-sm" role="group">
                      <button type="button" class="btn btn-light btn-sm" id="expandAll">Expand All</button>
                      <button type="button" class="btn btn-light btn-sm" id="collapseAll">Collapse All</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body p-3" style="max-height: 450px; overflow-y: auto; border: 1px solid #dee2e6;">
                <div id="permissionSearchResults" class="mb-2 d-none">
                  <small class="text-info"><i class="fas fa-info-circle"></i> <span id="searchResultText"></span></small>
                </div>
                @if(isset($permissions) && $permissions->count() > 0)
                  @php
                    $groupedPermissions = $permissions->groupBy('module');
                  @endphp
                  <div id="permissionsContainer">
                    @foreach($groupedPermissions as $module => $modulePermissions)
                      <div class="mb-3 border rounded-lg shadow-sm module-section" data-module="{{ $module }}" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 border-bottom">
                          <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-link p-0 mr-2 toggle-module text-primary" data-toggle="collapse" data-target="#moduleCollapse_{{ $module }}" aria-expanded="true">
                              <i class="fas fa-chevron-down" id="icon_{{ $module }}"></i>
                            </button>
                            <h6 class="text-primary font-weight-bold mb-0">{{ ucfirst($module) }}</h6>
                            <span class="badge badge-primary ml-2">{{ $modulePermissions->count() }}</span>
                            <span class="badge badge-success ml-1 module-selected-count" data-module="{{ $module }}">0 selected</span>
                          </div>
                          <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input module-select-all" id="module_{{ $module }}" data-module="{{ $module }}">
                            <label class="custom-control-label small font-weight-bold" for="module_{{ $module }}">Select All</label>
                          </div>
                        </div>
                        <div class="collapse show module-collapse" id="moduleCollapse_{{ $module }}">
                          <div class="p-2">
                            <div class="row">
                              @foreach($modulePermissions as $permission)
                                <div class="col-md-6 col-lg-4 mb-2 permission-item" data-permission-name="{{ strtolower($permission->display_name) }}">
                                  <div class="custom-control custom-checkbox permission-checkbox-wrapper">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                           class="custom-control-input permission-checkbox module-{{ $module }}" id="permission_{{ $permission->id }}">
                                    <label class="custom-control-label small" for="permission_{{ $permission->id }}">
                                      <i class="fas fa-shield-alt text-muted mr-1"></i>
                                      {{ $permission->display_name }}
                                    </label>
                                  </div>
                                </div>
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
                      @if(!$loop->last)<div class="my-3"></div>@endif
                    @endforeach
                  </div>
                @else
                  <div class="text-center py-5">
                    <i class="fas fa-exclamation-triangle text-muted fa-3x mb-3"></i>
                    <p class="text-muted mb-0 font-weight-bold">No permissions available</p>
                    <small class="text-muted">Please contact administrator to set up permissions</small>
                  </div>
                @endif
              </div>
              <div class="card-footer bg-light py-3">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center">
                    <small class="text-muted mr-3">
                      <i class="fas fa-info-circle text-primary"></i> 
                      Select permissions for this user. Super Admin automatically gets all permissions.
                    </small>
                    <button type="button" class="btn btn-sm btn-outline-danger" id="clearAll">Clear All</button>
                  </div>
                  <div class="d-flex align-items-center">
                    <div class="selected-count mr-2">
                      <small class="badge badge-info p-2">Selected: <span id="selectedCount">0</span></small>
                    </div>
                    <div class="total-count">
                      <small class="badge badge-secondary p-2">Total: <span id="totalCount">{{ isset($permissions) ? $permissions->count() : 0 }}</span></small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{asset('backend/vendor/jquery/jquery.min.js')}}"></script>
<script>
    $(document).ready(function() {
        // File preview functionality
        $('input[name="photo"]').on('change', function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#uploadPreview').html('<img src="' + e.target.result + '" style="max-width: 200px; max-height: 100px; border: 1px solid #ddd; border-radius: 4px;"/>');
                };
                reader.readAsDataURL(file);
            } else {
                $('#uploadPreview').html('');
            }
        });
        
        // Select all permissions functionality
        $('#selectAll').on('change', function() {
            var isChecked = $(this).prop('checked');
            $('.permission-checkbox:not(:disabled)').prop('checked', isChecked);
        });
        
        // Uncheck select all if any individual checkbox is unchecked
        $('.permission-checkbox').on('change', function() {
            var enabledCheckboxes = $('.permission-checkbox:not(:disabled)');
            var checkedEnabledCheckboxes = $('.permission-checkbox:not(:disabled):checked');
            
            if (!$(this).prop('checked')) {
                $('#selectAll').prop('checked', false);
            } else {
                // Check if all enabled checkboxes are checked
                var allChecked = enabledCheckboxes.length === checkedEnabledCheckboxes.length;
                $('#selectAll').prop('checked', allChecked);
            }
            
            // Update module select all states
            updateModuleSelectAllStates();
        });
        
        // Handle role change - show/hide permissions based on role
        $('select[name="role_id"]').on('change', function() {
            var selectedRole = $(this).val();
            if (selectedRole == '1') { // Super Admin
                $('.permission-checkbox').prop('checked', true).prop('disabled', true);
                $('#selectAll').prop('checked', true).prop('disabled', true);
                $('.module-select-all').prop('checked', true).prop('disabled', true);
                $('.form-text.text-muted').text('Super Admin automatically gets all permissions.');
            } else {
                $('.permission-checkbox').prop('disabled', false);
                $('.module-select-all').prop('disabled', false);
                // Reset select all state when role changes to non-super admin
                var totalEnabled = $('.permission-checkbox:not(:disabled)').length;
                var totalChecked = $('.permission-checkbox:not(:disabled):checked').length;
                $('#selectAll').prop('checked', totalEnabled === totalChecked && totalEnabled > 0);
                $('#selectAll').prop('disabled', false);
                $('.form-text.text-muted').text('Select permissions for this user. Super Admin automatically gets all permissions.');
                
                // Update module select all states
                updateModuleSelectAllStates();
            }
        });
        
        // Module-specific select all functionality
        $('.module-select-all').on('change', function() {
            var moduleName = $(this).data('module');
            var isChecked = $(this).prop('checked');
            $('.module-' + moduleName + ':not(:disabled)').prop('checked', isChecked);
            
            // Update main select all state
            updateMainSelectAllState();
        });
        
        // Update module select all when individual permissions change
        $('.permission-checkbox').on('change', function() {
            var enabledCheckboxes = $('.permission-checkbox:not(:disabled)');
            var checkedEnabledCheckboxes = $('.permission-checkbox:not(:disabled):checked');
            
            if (!$(this).prop('checked')) {
                $('#selectAll').prop('checked', false);
            } else {
                // Check if all enabled checkboxes are checked
                var allChecked = enabledCheckboxes.length === checkedEnabledCheckboxes.length;
                $('#selectAll').prop('checked', allChecked);
            }
            
            // Update module select all states
            updateModuleSelectAllStates();
        });
        
        // Function to update module select all states
        function updateModuleSelectAllStates() {
            $('.module-select-all').each(function() {
                var moduleName = $(this).data('module');
                var moduleCheckboxes = $('.module-' + moduleName + ':not(:disabled)');
                var checkedModuleCheckboxes = $('.module-' + moduleName + ':not(:disabled):checked');
                
                var allChecked = moduleCheckboxes.length === checkedModuleCheckboxes.length && moduleCheckboxes.length > 0;
                $(this).prop('checked', allChecked);
            });
        }
        
        // Function to update main select all state
        function updateMainSelectAllState() {
            var enabledCheckboxes = $('.permission-checkbox:not(:disabled)');
            var checkedEnabledCheckboxes = $('.permission-checkbox:not(:disabled):checked');
            var allChecked = enabledCheckboxes.length === checkedEnabledCheckboxes.length && enabledCheckboxes.length > 0;
            $('#selectAll').prop('checked', allChecked);
        }
        
        // Update selected count display
        function updateSelectedCount() {
            var checkedCount = $('.permission-checkbox:checked').length;
            $('#selectedCount').text(checkedCount);
        }
        
        // Expand/Collapse all modules
        $('#expandAll').on('click', function() {
            $('.module-collapse').collapse('show');
            $('.toggle-module i').removeClass('fa-chevron-right').addClass('fa-chevron-down');
        });
        
        $('#collapseAll').on('click', function() {
            $('.module-collapse').collapse('hide');
            $('.toggle-module i').removeClass('fa-chevron-down').addClass('fa-chevron-right');
        });
        
        // Toggle individual module
        $('.toggle-module').on('click', function() {
            var target = $(this).data('target');
            var icon = $(this).find('i');
            
            $(target).on('shown.bs.collapse', function () {
                icon.removeClass('fa-chevron-right').addClass('fa-chevron-down');
            });
            
            $(target).on('hidden.bs.collapse', function () {
                icon.removeClass('fa-chevron-down').addClass('fa-chevron-right');
            });
        });
        
        // Update selected count when checkboxes change
        $('.permission-checkbox').on('change', function() {
            updateSelectedCount();
            updateModuleSelectedCounts();
        });
        
        // Search functionality
        $('#permissionSearch').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            var $modules = $('.module-section');
            var visibleModules = 0;
            var totalPermissions = 0;
            var visiblePermissions = 0;
            
            if (searchTerm === '') {
                // Show all modules and permissions
                $modules.show();
                $('.permission-item').show();
                $('#permissionSearchResults').addClass('d-none');
            } else {
                $('#permissionSearchResults').removeClass('d-none');
                $modules.each(function() {
                    var $module = $(this);
                    var $permissions = $module.find('.permission-item');
                    var moduleHasVisiblePermissions = false;
                    var moduleVisiblePermissions = 0;
                    
                    $permissions.each(function() {
                        var $permissionItem = $(this);
                        var permissionName = $permissionItem.data('permission-name');
                        
                        if (permissionName.includes(searchTerm)) {
                            $permissionItem.show();
                            moduleHasVisiblePermissions = true;
                            moduleVisiblePermissions++;
                            visiblePermissions++;
                        } else {
                            $permissionItem.hide();
                        }
                    });
                    
                    totalPermissions += $permissions.length;
                    
                    if (moduleHasVisiblePermissions) {
                        $module.show();
                        visibleModules++;
                        // Expand the module if it has matching permissions
                        $module.find('.module-collapse').collapse('show');
                        $module.find('.toggle-module i').removeClass('fa-chevron-right').addClass('fa-chevron-down');
                    } else {
                        $module.hide();
                    }
                    
                    // Update module count badge to show visible permissions
                    var $countBadge = $module.find('.badge-primary');
                    var originalCount = $countBadge.data('original-count') || $countBadge.text();
                    $countBadge.data('original-count', originalCount);
                    
                    if (searchTerm !== '') {
                        $countBadge.text(moduleVisiblePermissions + '/' + originalCount);
                    } else {
                        $countBadge.text(originalCount);
                    }
                });
                
                // Update search result text
                var resultText = 'Found ' + visiblePermissions + ' permissions in ' + visibleModules + ' modules';
                $('#searchResultText').text(resultText);
            }
            
            updateSelectedCount();
            updateModuleSelectedCounts();
        });
        
        // Clear all functionality
        $('#clearAll').on('click', function() {
            $('.permission-checkbox:not(:disabled)').prop('checked', false);
            $('#selectAll').prop('checked', false);
            $('.module-select-all').prop('checked', false);
            updateSelectedCount();
            updateModuleSelectedCounts();
            updateModuleSelectAllStates();
        });
        
        // Update module selected counts
        function updateModuleSelectedCounts() {
            $('.module-selected-count').each(function() {
                var moduleName = $(this).data('module');
                var moduleCheckboxes = $('.module-' + moduleName + ':not(:disabled)');
                var checkedModuleCheckboxes = $('.module-' + moduleName + ':not(:disabled):checked');
                
                $(this).text(checkedModuleCheckboxes.length + ' selected');
            });
        }
        
        // Initialize selected count on page load
        updateSelectedCount();
        updateModuleSelectedCounts();
    });
</script>
@endpush