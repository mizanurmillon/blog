<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Models\Author;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Validation\Rules\Password;


class AdminController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }
    //__user store method__//
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => ['required',Password::min(8)],
        ]);
        User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $notification = array('message' => 'User added Successfully!','alert-type'=>'success' );
        return redirect()->route('users')->with($notification);
    }
    //__all users list method__//
    public function users()
    {
        $users = User::all();
        return view('admin.users.all_user',compact('users'));
    }

    //__all authors list method__//
    public function author()
    {
        $authors = Author::all();
        return view('admin.users.author',compact('authors'));
    }

    //__author status change method__//
    public function author_status_change($author_id)
    {
        $author = Author::find($author_id);
        if($author->status == 0){
            Author::find($author_id)->update([
                'status' => 1
            ]);
            $notification = array('message' => 'Author Status Actived!','alert-type'=>'success' );
            return redirect()->back()->with($notification);
        }
        else{
            Author::find($author_id)->update([
                'status' => 0
            ]);
            $notification = array('message' => 'Author Status Deactived!','alert-type'=>'error' );
            return redirect()->back()->with($notification);
        }
    }

    //__author delete method__//
    public function author_delete($author_id)
    {
        Author::find($author_id)->delete();
        return redirect()->back()->with('author_delete','Author Permanently Delete Successfully!');
    }

    //__edit profile method__//
    public function editProfile()
    {
        return view('admin.users.edit_profile');
    }

    //__update profile method__//
    public function updateProfile(Request $request)
    {
        User::find(Auth::id())->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        return back()->with('success', 'Profile Updated Successfully');
    }

    //__change password method__//
    public function updatePassword(PasswordRequest $request)
    {
        if(Hash::check($request->current_password, Auth::user()->password)){
            User::find(Auth::id())->update([
                'password' => Hash::make($request->password)
            ]);
            return back()->with('pass_success', 'Password Updated Successfully');
        }else{
            return back()->with('error','Current password Does Not Match!');
        }
    }

    //__photo update method__//
    public function photoUpdate(Request $request){
        $request->validate([
            'photo' => 'required|mimes:png,jpg|max:2048'
        ]);
        if(Auth::user()->photo != null){
            $delete_photo = public_path('uploads/users/'.Auth::user()->photo);
            unlink($delete_photo);
        }
        $photo=$request->photo;
        $extension = $photo->extension();
        $file_name = uniqid().'.'.$extension;
        $manager = new ImageManager(new Driver());
        $image = $manager->read($photo);
        $image->resize(300, 250);
        $image->save(public_path('uploads/users/'.$file_name));
        User::find(Auth::id())->update([
            'photo' => $file_name
        ]);
        return back()->with('photo_success', 'Profile Photo Updated Successfully');
    }

    //__delete user method__//
    public function adminUserDelete($user_id)
    {
        $user = User::find($user_id);
        if($user->photo != null){
            $delete_photo = public_path('uploads/users/'.$user->photo);
            unlink($delete_photo);
        }
        User::find($user_id)->delete();
        $notification = array('message' => 'User Deleted!','alert-type'=>'error' );
        return redirect()->route('users')->with($notification);
    }
}
