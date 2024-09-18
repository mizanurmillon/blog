@extends('layouts.admin')
@section('admin-content')
    <div class="row">
        <div class="m-auto col-lg-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="text-white">Edit Category</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('category.update', $category->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="category">Category Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="category_name" id="category" autocomplete="off" value="{{ $category->category_name }}">
                        </div>
                        <div class="form-group">
                            <label for="image">Category Image<span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                            <input type="hidden" name="old_image" value="{{ $category->image }}">
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <div class="my-2">
                                <img src="{{ asset('uploads/category') }}/{{ $category->image }}" id="blah" style="width: 200px">
                            </div>
                        </div>
                        <button type="submit" class="mr-2 btn btn-primary">Update Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')

@endpush
