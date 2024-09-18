@extends('layouts.admin')

@section('admin-content')
@push('css')
@endpush
<div class="row">
    <div class="m-auto col-lg-10">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">Trash Category List</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <form action="{{ route('category.chack.restore') }}" method="post">
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
                        @foreach ($trashCategories as $key => $category)
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
                                    <a href="{{ route('category.restore', $category->id) }}" class="btn btn-primary btn-sm">Restore</a>
                                    <a href="{{ route('category.hard.delete', $category->id) }}" class="btn btn-danger btn-sm" id="delete">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                    <div class="my-2">
                        <button type="submit" name="action_btn" value="1" class="btn btn-primary del_chack btn-sm d-none">Restore</button>
                        <button type="submit" name="action_btn" value="2" class="btn btn-danger del_chack btn-sm d-none">Delete Chacked</button>
                    </div>
                </form>
                </div>
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
    //message
    @if (session('h_delete'))
        <script>
            Swal.fire({
            title: "Good job!",
            text: "{{ session('h_delete') }}",
            icon: "success"
            });
        </script>
    @endif
@endpush
