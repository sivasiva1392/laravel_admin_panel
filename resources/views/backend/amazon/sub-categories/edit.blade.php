@extends('backend.layouts.master')

@section('main-content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Amazon Sub-Category</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{route('amazon-sub-categories.update', $subCategory->id)}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="amazon_category_id">Category <span class="text-danger">*</span></label>
                        <select name="amazon_category_id" id="amazon_category_id" class="form-control @error('amazon_category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $id => $name)
                                <option value="{{$id}}" {{old('amazon_category_id', $subCategory->amazon_category_id) == $id ? 'selected' : ''}}>{{$name}}</option>
                            @endforeach
                        </select>
                        @error('amazon_category_id')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sub_category_name">Sub-Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="sub_category_name" id="sub_category_name" class="form-control @error('sub_category_name') is-invalid @enderror" value="{{old('sub_category_name', $subCategory->sub_category_name)}}" placeholder="Enter sub-category name" required>
                        @error('sub_category_name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Enter sub-category description">{{old('description', $subCategory->description)}}</textarea>
                        @error('description')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg,image/jpg,image/png,image/gif">
                        <small class="form-text text-muted">Allowed formats: JPEG, JPG, PNG, GIF (Max size: 2MB). Leave empty to keep current image.</small>
                        @if($subCategory->image)
                            <small class="form-text text-info">Current image: <img src="{{asset('uploads/amazon/'.$subCategory->image)}}" class="img-fluid" style="max-width:100px" alt="{{$subCategory->sub_category_name}}"></small>
                        @endif
                        @error('image')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <input type="hidden" name="status" value="active">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Sub-Category
                        </button>
                        <a href="{{route('amazon-sub-categories.index')}}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
