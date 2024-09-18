@extends('layouts.admin')

@section('admin-content')
@push('css')
@endpush
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">Category List</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <form action="{{ route('category.chack.delete') }}" method="post">
                    @csrf
                  <table id="dataTableExample" class="table">
                    <thead>
                      <tr>
                        <th width='40'>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" id="chkSelectAll">
                                   Chack All
                                <i class="input-frame"></i></label>
                            </div>
                        </th>
                        <th>Sl</th>
                        <th>Category</th>
                        <th>Slug</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $key => $category)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="category_id[]" value="{{ $category->id }}" class="form-check-input chkDel">
                                        <i class="input-frame"></i></label>
                                    </div>
                                </td>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $category->category_name }}</td>
                                <td>{{ $category->category_slug }}</td>
                                <td>
                                    <img src="{{ asset('uploads/category/'.$category->image) }}" alt="{{ $category->category_name }}">
                                </td>
                                <td>
                                    @if ($category->status == 1)
                                        <a href="{{ route('category.active', $category->id) }}"><span class="badge badge-success">Active</span></a>
                                    @else
                                        <a href="{{ route('category.inactive', $category->id) }}"><span class="badge badge-danger">Inactive</span></a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('edit', $category->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="{{ route('delete', $category->id) }}" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                    <div class="my-2">
                        <button type="submit" class="btn btn-danger del_chack btn-sm d-none">Delete Chacked</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">Add New Category</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="category">Category Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('category_name') is-invalid @enderror" name="category_name" id="category" autocomplete="off" placeholder="Category Name">
                        @error('category_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Category Image<span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <div class="my-2">
                            <img src="" id="blah" style="width: 200px">
                        </div>
                    </div>
                    <button type="submit" class="mr-2 btn btn-primary">Add Category</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $("#chkSelectAll").on('click', function(){
        this.checked ? $(".chkDel").prop("checked",true) : $(".chkDel").prop("checked",false);
        $('.del_chack').toggleClass('d-none')
    })
    $(".chkDel").on('click', function(){
        $('.del_chack').removeClass('d-none')
    })

</script>
@endpush
