@extends('backend.layouts.master')

@section('main-content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Add Amazon Product with Dynamic Categories</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="#" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="amazon_category_id">Category <span class="text-danger">*</span></label>
                        <select name="amazon_category_id" id="amazon_category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="amazon_sub_category_id">Sub-Category</label>
                        <select name="amazon_sub_category_id" id="amazon_sub_category_id" class="form-control" disabled>
                            <option value="">Select Sub-Category</option>
                        </select>
                        <small class="form-text text-muted">Please select a category first to load subcategories</small>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="product_name">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Enter product name" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter product description"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Product
                        </button>
                        <a href="#" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#amazon_category_id').on('change', function() {
        var categoryId = $(this).val();
        var subCategorySelect = $('#amazon_sub_category_id');
        
        // Reset subcategory dropdown
        subCategorySelect.prop('disabled', true);
        subCategorySelect.html('<option value="">Select Sub-Category</option>');
        
        if(categoryId) {
            $.ajax({
                url: '{{route("amazon-categories.subcategories.api", ":categoryId")}}'.replace(':categoryId', categoryId),
                type: 'GET',
                success: function(response) {
                    // Populate subcategory dropdown
                    subCategorySelect.prop('disabled', false);
                    $.each(response, function(key, value) {
                        subCategorySelect.append('<option value="' + value.id + '">' + value.sub_category_name + '</option>');
                    });
                },
                error: function(xhr) {
                    console.error('Error loading subcategories:', xhr);
                    alert('Error loading subcategories. Please try again.');
                }
            });
        }
    });
});
</script>
@endsection
