@extends('layouts.admin')

@section('admin-content')
@push('css')
@endpush
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">Tags List</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                  <table id="dataTableExample" class="table">
                    <thead>
                      <tr>
                        <th>Sl</th>
                        <th>Tag Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($tags as $index => $tag)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $tag->tag_name }}</td>
                                <td>
                                    <a href="{{ route('tag.delete',$tag->id) }}" class="btn btn-danger btn-sm" id="delete">Delete</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">Add New Tags</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('tag.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="tag">Tags Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('tag_name') is-invalid @enderror" name="tag_name" id="tag" autocomplete="off" placeholder="Tag Name">
                        @error('tag_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="mr-2 btn btn-primary">Add Tags</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
//message
@if (session('T_delete'))
    <script>
        Swal.fire({
        title: "Good job!",
        text: "{{ session('T_delete') }}",
        icon: "success"
        });
    </script>
@endif
@endpush
