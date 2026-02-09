@extends('backend.layouts.master')

@section('main-content')
<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
           @include('backend.layouts.notification')
        </div>
    </div>
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Import Amazon Products</h6>
        <a href="{{route('amazon-products.index')}}" class="btn btn-secondary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Back to Products">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <!-- Upload Form -->
                <form method="POST" action="{{route('amazon-products.import.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="amazon_category_id">Select Category <span class="text-danger">*</span></label>
                        <select name="amazon_category_id" id="amazon_category_id" class="form-control @error('amazon_category_id') is-invalid @enderror" required>
                            <option value="">-- Choose Category --</option>
                            @foreach($categories as $id => $name)
                                <option value="{{ $id }}" {{ old('amazon_category_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('amazon_category_id')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="csv_file">Select CSV File <span class="text-danger">*</span></label>
                        <input type="file" name="csv_file" id="csv_file" class="form-control @error('csv_file') is-invalid @enderror" accept=".csv,.txt" required>
                        <small class="form-text text-muted">Allowed formats: CSV, TXT (Max size: 10MB)</small>
                        @error('csv_file')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Import Products
                        </button>
                        <a href="{{route('amazon-products.index')}}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>

                        <!-- Download Sample -->
                        <a href="{{asset('templates/amazon_products_sample.csv')}}" class="btn btn-info btn-sm" download>
                            <i class="fas fa-download"></i> Download Sample CSV Template
                        </a>
                    </div>
                </form>

                <!-- Instructions -->
                <div>
                    <h6><i class="fas fa-info-circle"></i> Instructions:</h6>
                    <ol>
                        <li>First select a category from the dropdown above.</li>
                        <li>Prepare a CSV file with the following columns in order:</li>
                        <ul>
                            <li><strong>Product Name</strong> (required)</li>
                            <li><strong>Description</strong> (optional)</li>
                            <li><strong>Link</strong> (optional - Amazon product link)</li>
                            <li><strong>Meta Title</strong> (optional)</li>
                            <li><strong>Meta Description</strong> (optional)</li>
                            <li><strong>Meta Keywords</strong> (optional)</li>
                            <li><strong>Status</strong> (optional - "active" or "inactive", defaults to "active")</li>
                        </ul>
                        <li>The first row should contain headers.</li>
                        <li>All products will be imported into the selected category.</li>
                        <li>Duplicate product names in the same category will be skipped.</li>
                        <li>Maximum file size: 10MB</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// File validation
document.getElementById('csv_file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const maxSize = 10 * 1024 * 1024; // 10MB in bytes
    
    if (file) {
        if (file.size > maxSize) {
            alert('File size exceeds 10MB limit. Please choose a smaller file.');
            e.target.value = '';
            return;
        }
        
        const allowedTypes = ['text/csv', 'text/plain', 'application/csv'];
        if (!allowedTypes.includes(file.type) && !file.name.match(/\.(csv|txt)$/i)) {
            alert('Please select a valid CSV or TXT file.');
            e.target.value = '';
            return;
        }
    }
});

// Category selection validation
document.querySelector('form').addEventListener('submit', function(e) {
    const category = document.getElementById('amazon_category_id').value;
    const file = document.getElementById('csv_file').files[0];
    
    if (!category) {
        e.preventDefault();
        alert('Please select a category.');
        return;
    }
    
    if (!file) {
        e.preventDefault();
        alert('Please select a CSV file.');
        return;
    }
});
</script>
@endpush
