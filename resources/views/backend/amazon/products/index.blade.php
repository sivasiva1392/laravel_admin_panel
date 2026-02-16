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
      <h6 class="m-0 font-weight-bold text-primary float-left">Amazon Products</h6>
      <div class="float-right">
        <a href="{{route('amazon-products.import')}}" class="btn btn-success btn-sm mr-2" data-toggle="tooltip" data-placement="bottom" title="Import Products">
            <i class="fas fa-file-import"></i> Import
        </a>
        <a href="{{route('amazon-products.create')}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Add Product"><i class="fas fa-plus"></i> Add Product</a>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($products)>0)
        <table class="table table-bordered" id="amazon-product-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.N.</th>
              <th>Product Name</th>
              <th>Slug</th>
              <th>Category</th>
              <th>Short Description</th>
              <th>Image</th>
              <th>Links</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>S.N.</th>
              <th>Product Name</th>
              <th>Slug</th>
              <th>Category</th>
              <th>Short Description</th>
              <th>Image</th>
              <th>Links</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>
                        <strong>{{$product->product_name}}</strong>
                        @if($product->slug)
                            <br><small class="text-muted">Slug: {{$product->slug}}</small>
                        @endif
                    </td>
                    <td>{{$product->slug ?? 'N/A'}}</td>
                    <td>{{$product->category->category_name ?? 'N/A'}}</td>
                    <td>
                        @if($product->short_description)
                            <small>{{$product->short_description}}</small>
                        @else
                            <span class="text-muted">No short description</span>
                        @endif
                    </td>
                    <td>
                        @if($product->image)
                            <img src="{{asset('uploads/amazon/'.$product->image)}}" class="img-fluid zoom" style="max-width:80px" alt="{{$product->product_name}}">
                        @elseif($product->image_url)
                            <img src="{{$product->image_url}}" class="img-fluid zoom" style="max-width:80px" alt="{{$product->product_name}}" onerror="this.src='{{asset('backend/img/thumbnail-default.jpg')}}'">
                        @else
                            <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid zoom" style="max-width:80px" alt="No image">
                        @endif
                    </td>
                    <td>
                        <div class="btn-group-vertical" role="group">
                            @if($product->link)
                                <a href="{{$product->link}}" target="_blank" class="btn btn-sm btn-info mb-1" title="External Link">
                                    <i class="fas fa-external-link-alt"></i> Link
                                </a>
                            @endif
                            @if($product->affiliate_url)
                                <a href="{{$product->affiliate_url}}" target="_blank" class="btn btn-sm btn-success mb-1" title="Affiliate Link">
                                    <i class="fas fa-dollar-sign"></i> Affiliate
                                </a>
                            @endif
                            @if(!$product->link && !$product->affiliate_url)
                                <span class="text-muted">No Links</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <button class="btn status-toggle-btn" data-id="{{$product->id}}" data-route="{{route('amazon-products.toggle-status', $product->id)}}" data-status="{{$product->status}}">
                            @if($product->status=='active')
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-warning">Inactive</span>
                            @endif
                        </button>
                    </td>
                    <td>
                        <a href="{{route('amazon-products.edit',$product->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('amazon-products.destroy',[$product->id])}}">
                      @csrf
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id={{$product->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$products->links()}}</span>
        @else
          <h6 class="text-center">No Products found!!! Please create Product</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
  </style>
@endpush

@push('scripts')
  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>
      $('#amazon-product-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[3,4,5]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){

        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Status toggle functionality
        $('.status-toggle-btn').click(function(e){
            e.preventDefault();
            var btn = $(this);
            var route = btn.data('route');
            var currentStatus = btn.data('status');
            
            $.ajax({
                url: route,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Update the status badge
                        var newBadge = response.status === 'active' 
                            ? '<span class="badge badge-success">Active</span>'
                            : '<span class="badge badge-warning">Inactive</span>';
                        btn.html(newBadge);
                        btn.data('status', response.status);
                        
                        // Show success message
                        swal("Success!", response.message, "success");
                    }
                },
                error: function(xhr) {
                    swal("Error!", "Something went wrong. Please try again.", "error");
                }
            });
        });
        
        // Sweet alert for delete
        $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush
