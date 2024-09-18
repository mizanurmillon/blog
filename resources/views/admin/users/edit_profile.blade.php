@extends('layouts.admin')

@section('admin-content')
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">Edit Profile</h3>
            </div>
            <div class="card-body">
                @if(@session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form class="forms-sample" action="{{ route('update.profile') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername1">Username</label>
                        <input type="text" class="form-control" name="name" id="exampleInputUsername1" autocomplete="off" placeholder="Username" value="{{ Auth::user()->name }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Email" value="{{ Auth::user()->email }}">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">Change Password</h3>
            </div>
            <div class="card-body">
                @if(@session('pass_success'))
                    <div class="alert alert-success">{{ session('pass_success') }}</div>
                @endif
                <form action="{{ route('update.password') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="c_password">Current Password</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" id="c_password" autocomplete="off" placeholder="Current Password">
                        @error('current_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        @if(session('error'))
                            <small class="text-danger">{{ session('error') }}</small>
                        @endsession
                    </div>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="New Password">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="con_password">Confirm Password</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="con_password" placeholder="Confirm Password">
                        @error('password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Update Password</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">Photo Update</h3>
            </div>
            <div class="card-body">
                @if(@session('photo_success'))
                    <div class="alert alert-success">{{ session('photo_success') }}</div>
                @endif
                <form action="{{ route('photo.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" id="photo" autocomplete="off" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        @error('photo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <div class="my-2">
                            <img id="blah" src="{{ asset('uploads/users') }}/{{ Auth::user()->photo }}" width="100" />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
