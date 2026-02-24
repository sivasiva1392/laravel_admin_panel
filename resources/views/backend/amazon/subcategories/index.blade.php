@extends('backend.layouts.master')

@section('main-content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Amazon Sub-Categories</h6>
        <a href="{{route('amazon-subcategories.create')}}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Sub-Category
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session('success')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{session('error')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Category</th>
                        <th>Sub-Category Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subCategories as $index => $subCategory)
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td>{{$subCategory->category->category_name}}</td>
                        <td>{{$subCategory->sub_category_name}}</td>
                        <td>{{Str::limit($subCategory->description, 50)}}</td>
                        <td>
                            @if($subCategory->image)
                                <img src="{{asset('uploads/amazon/'.$subCategory->image)}}" alt="{{$subCategory->sub_category_name}}" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{$subCategory->status == 'active' ? 'success' : 'danger'}}">
                                {{$subCategory->status}}
                            </span>
                        </td>
                        <td>{{date('d-M-Y', strtotime($subCategory->created_at))}}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{route('amazon-subcategories.edit', $subCategory->id)}}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{route('amazon-subcategories.destroy', $subCategory->id)}}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this sub-category?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-sm btn-{{$subCategory->status == 'active' ? 'warning' : 'success'}} toggle-status" data-id="{{$subCategory->id}}" data-status="{{$subCategory->status}}">
                                    <i class="fas fa-{{$subCategory->status == 'active' ? 'pause' : 'play'}}"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center">
            {{ $subCategories->links() }}
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.toggle-status').on('click', function() {
        var btn = $(this);
        var id = btn.data('id');
        var currentStatus = btn.data('status');
        
        $.ajax({
            url: '{{route("amazon-subcategories.toggle-status", ":id")}}'.replace(':id', id),
            type: 'POST',
            data: {
                _token: '{{csrf_token()}}',
                _method: 'POST'
            },
            success: function(response) {
                if(response.success) {
                    // Update button appearance
                    btn.removeClass('btn-warning btn-success').addClass('btn-' + (response.status == 'active' ? 'warning' : 'success'));
                    btn.find('i').removeClass('fa-pause fa-play').addClass('fa-' + (response.status == 'active' ? 'pause' : 'play'));
                    btn.data('status', response.status);
                    
                    // Update badge in table
                    var badge = btn.closest('tr').find('.badge');
                    badge.removeClass('badge-success badge-danger').addClass('badge-' + (response.status == 'active' ? 'success' : 'danger'));
                    badge.text(response.status);
                    
                    // Show success message
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    });
});
</script>
@endsection
