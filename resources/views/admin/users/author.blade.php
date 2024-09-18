@extends('layouts.admin')
@push('css')
@endpush
@section('admin-content')
<div class="m-auto col-lg-10">
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="text-white">Authors List</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
              <table id="dataTableExample" class="table">
                <thead>
                  <tr>
                    <th>Sl</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Photo</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($authors as $index => $author)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $author->name }}</td>
                        <td>{{ $author->email }}</td>
                        <td>
                            @if($author->photo == null)
                                <img src="https://via.placeholder.com/30x30" alt="profile">
                            @else
                            <img src="" alt="">
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $author->status == 1 ? 'success' : 'danger' }}">{{ $author->status == 1 ? 'Active' : 'Deactive' }}</span>
                        </td>
                        <td>
                            <a href="{{ route('author.status', $author->id) }}" class="btn btn-{{ $author->status == 1 ? 'success' : 'primary' }}">Change Status</a>
                            <a href="{{ route('author.delete', $author->id) }}" class="btn btn-sm btn-danger" id="delete">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
@if (session('author_delete'))
<script>
    Swal.fire({
    title: "Good job!",
    text: "{{ session('author_delete') }}",
    icon: "success"
    });
</script>
@endif
@endpush
