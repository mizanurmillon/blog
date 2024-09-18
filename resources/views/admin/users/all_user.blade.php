@extends('layouts.admin')

@section('admin-content')
@push('css')
@endpush
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">Users List</h3>
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
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->photo == '')
                                    <img src="https://via.placeholder.com/30x30" alt="profile">
                                    @else
                                    <img src="{{ asset('uploads/users/'.$user->photo) }}" width="70" height="70" alt="">
                                    @endif
                                </td>
                                <td><a href="{{ route('admin.user.delete', $user->id) }}" class="btn btn-danger btn-sm" id="delete"><i data-feather="trash"></i></a></td>
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
                <h3 class="text-white">Add New User</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('user.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername1">Username</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="exampleInputUsername1" autocomplete="off" placeholder="Username">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="exampleInputEmail1" placeholder="Email">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="exampleInputPassword1" placeholder="Password">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="mr-2 btn btn-primary">Add User</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')

@endpush
