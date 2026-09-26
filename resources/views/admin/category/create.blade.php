@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col">
                    <div class="card radius-10 mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">Add new category</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm radius-30">Categories</a>
                                </div>
                            </div>
                            <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data" id="categoryForm">
                                @csrf
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Category name">
                                    <span style="color: red"> {{ $errors->has('name') ? $errors->first('name') : ' ' }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" name="image" class="form-control" required />
                                    <span style="color: red"> {{ $errors->has('image') ? $errors->first('image') : ' ' }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Banner Image</label>
                                    <input type="file" name="banner" class="form-control" required />
                                    <span style="color: red"> {{ $errors->has('banner') ? $errors->first('banner') : ' ' }}</span>
                                </div>
                                <button type="submit" class="btn btn-success mt-2 float-right" id="submitBtn">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Form validation before submission
        $('#categoryForm').on('submit', function(e) {
            let isValid = true;
            let errorMessage = '';

            // Validate Name
            if (!$('input[name="name"]').val().trim()) {
                isValid = false;
                errorMessage += 'Category Name is required\n';
                $('input[name="name"]').css('border', '2px solid red');
            } else {
                $('input[name="name"]').css('border', '');
            }

            // If validation fails, prevent submission
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields:\n' + errorMessage);
                return false;
            }

            // Disable submit button to prevent double submission
            $('#submitBtn').prop('disabled', true).text('Submitting...');
        });

        // Remove red border on input focus
        $('input, select, textarea').on('focus', function() {
            $(this).css('border', '');
        });
    </script>
@endpush
