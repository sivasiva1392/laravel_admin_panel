@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Amazon Sub-Categories</h6>
      <div class="float-right">
        <a href="{{route('amazon-sub-categories.create')}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Add Sub-Category">
            <i class="fas fa-plus"></i> Add Sub-Category
        </a>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($subCategories)>0)
        <table class="table table-bordered" id="amazon-sub-category-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.N.</th>
              <th>Image</th>
              <th>Category</th>
              <th>Sub-Category Name</th>
              <th>Description</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>S.N.</th>
              <th>Image</th>
              <th>Category</th>
              <th>Sub-Category Name</th>
              <th>Description</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
            @foreach($subCategories as $subCategory)
                <tr>
                    <td>{{$subCategory->id}}</td>
                    <td>
                        @if($subCategory->image)
                            <img src="{{asset('uploads/amazon/'.$subCategory->image)}}" class="img-fluid zoom" style="max-width:80px" alt="{{$subCategory->sub_category_name}}">
                        @else
                            <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid zoom" style="max-width:80px" alt="No image">
                        @endif
                    </td>
                    <td>{{$subCategory->category->category_name ?? 'N/A'}}</td>
                    <td>{{$subCategory->sub_category_name}}</td>
                    <td>
                        @if($subCategory->description)
                            <small>{{$subCategory->description}}</small>
                        @else
                            <span class="text-muted">No description</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn status-toggle-btn" data-id="{{$subCategory->id}}" data-route="{{route('amazon-sub-categories.toggle-status', $subCategory->id)}}" data-status="{{$subCategory->status}}">
                            @if($subCategory->status=='active')
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-warning">Inactive</span>
                            @endif
                        </button>
                    </td>
                    <td>
                        <a href="{{route('amazon-sub-categories.edit',$subCategory->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('amazon-sub-categories.destroy',[$subCategory->id])}}">
                      @csrf
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id={{$subCategory->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$subCategories->links()}}</span>
        @else
          <h6 class="text-center">No Sub-Categories found!!! Please create Sub-Category</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endpush

@push('scripts')
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script>
    $(document).ready(function() {
        $('#amazon-sub-category-dataTable').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            order: [[0, 'desc']]
        });
        
        // Status toggle functionality
        $('.status-toggle-btn').click(function() {
            var btn = $(this);
            var route = btn.data('route');
            var currentStatus = btn.data('status');
            
            $.ajax({
                url: route,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'POST'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        var newStatusBadge = response.new_status === 'active' 
                            ? '<span class="badge badge-success">Active</span>'
                            : '<span class="badge badge-warning">Inactive</span>';
                        btn.html(newStatusBadge);
                        btn.data('status', response.new_status);
                        
                        // Show success message
                        showNotification('Status updated successfully!', 'success');
                    }
                },
                error: function(xhr) {
                    showNotification('Error updating status!', 'error');
                }
            });
        });
    });
  </script>
@endpush
