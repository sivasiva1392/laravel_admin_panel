@extends('backend.layouts.master')

@section('main-content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Add Amazon Product</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{route('amazon-products.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="amazon_category_id">Category <span class="text-danger">*</span></label>
                        <select name="amazon_category_id" id="amazon_category_id" class="form-control @error('amazon_category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $id => $name)
                                <option value="{{$id}}" {{old('amazon_category_id') == $id ? 'selected' : ''}}>{{$name}}</option>
                            @endforeach
                        </select>
                        @error('amazon_category_id')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <input type="hidden" name="status" value="active">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="product_name">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="product_name" id="product_name" class="form-control @error('product_name') is-invalid @enderror" value="{{old('product_name')}}" placeholder="Enter product name" required>
                        @error('product_name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter product description">{{old('description')}}</textarea>
                        @error('description')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="short_description">Short Description</label>
                        <textarea name="short_description" id="short_description" class="form-control @error('short_description') is-invalid @enderror" rows="2" placeholder="Enter short description for previews" maxlength="500">{{old('short_description')}}</textarea>
                        <small class="form-text text-muted">Brief description for product listings (max 500 characters)</small>
                        @error('short_description')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image">Upload Image</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg,image/jpg,image/png,image/gif">
                        <small class="form-text text-muted">Allowed formats: JPEG, JPG, PNG, GIF (Max size: 2MB)</small>
                        @error('image')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image_url">External Image URL</label>
                        <input type="url" name="image_url" id="image_url" class="form-control @error('image_url') is-invalid @enderror" value="{{old('image_url')}}" placeholder="Enter external image URL" maxlength="500">
                        <small class="form-text text-muted">Optional: External image URL instead of upload</small>
                        @error('image_url')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="link">External Link</label>
                        <input type="url" name="link" id="link" class="form-control @error('link') is-invalid @enderror" value="{{old('link')}}" placeholder="Enter external link (e.g., Amazon product URL)" maxlength="500">
                        <small class="form-text text-muted">Optional: Link to external product page</small>
                        @error('link')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="affiliate_url">Affiliate URL</label>
                        <input type="url" name="affiliate_url" id="affiliate_url" class="form-control @error('affiliate_url') is-invalid @enderror" value="{{old('affiliate_url')}}" placeholder="Enter affiliate link URL" maxlength="500">
                        <small class="form-text text-muted">Optional: Affiliate marketing link</small>
                        @error('affiliate_url')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control @error('meta_title') is-invalid @enderror" value="{{old('meta_title')}}" placeholder="Enter SEO meta title" maxlength="255">
                        <small class="form-text text-muted">SEO: Meta title for search engines</small>
                        @error('meta_title')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" class="form-control @error('meta_description') is-invalid @enderror" rows="3" placeholder="Enter SEO meta description" maxlength="500">{{old('meta_description')}}</textarea>
                        <small class="form-text text-muted">SEO: Meta description for search engines</small>
                        @error('meta_description')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="meta_keywords">Meta Keywords</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror" value="{{old('meta_keywords')}}" placeholder="Enter SEO keywords (comma separated)" maxlength="255">
                        <small class="form-text text-muted">SEO: Meta keywords for search engines</small>
                        @error('meta_keywords')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Product
                        </button>
                        <a href="{{route('amazon-products.index')}}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
$(document).ready(function() {
    $('#description').summernote({
        height: 200,
        placeholder: 'Enter product description...',
        toolbar: [
            ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['para', ['ul', 'ol', 'paragraph', 'height']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
});
</script>
@endpush
