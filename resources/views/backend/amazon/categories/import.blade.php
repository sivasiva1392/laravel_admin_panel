@extends('backend.layouts.master')

@section('main-content')
<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
           @include('backend.layouts.notification')
        </div>
    </div>
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Import Amazon Categories</h6>
        <a href="{{route('amazon-categories.index')}}" class="btn btn-secondary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Back to Categories">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <!-- Instructions -->
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle"></i> Instructions:</h6>
                    <ol>
                        <li>Prepare a CSV file with the following columns in order:</li>
                        <ul>
                            <li><strong>Category Name</strong> (required)</li>
                            <li><strong>Description</strong> (optional)</li>
                            <li><strong>Status</strong> (optional - "active" or "inactive", defaults to "active")</li>
                        </ul>
                        <li>The first row should contain headers.</li>
                        <li>Duplicate category names will be skipped.</li>
                        <li>Maximum file size: 10MB</li>
                    </ol>
                </div>

                <!-- Sample CSV Format -->
                <div class="alert alert-secondary">
                    <h6><i class="fas fa-file-csv"></i> Sample CSV Format:</h6>
                    <pre>category_name,description,status
Electronics,Electronic devices and accessories,active
Books,Books and literature,active
Clothing,Fashion and apparel,inactive</pre>
                </div>

                <!-- Download Sample -->
                <div class="text-center mb-4">
                    <a href="{{asset('templates/amazon_categories_sample.csv')}}" class="btn btn-info btn-sm" download>
                        <i class="fas fa-download"></i> Download Sample CSV Template
                    </a>
                </div>

                <!-- Upload Form -->
                <form method="POST" action="{{route('amazon-categories.import.store')}}" enctype="multipart/form-data">
                    @csrf
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
                            <i class="fas fa-upload"></i> Import Categories
                        </button>
                        <a href="{{route('amazon-categories.index')}}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
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
</script>
@endpush
