<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthorController extends Controller
{
    //__author register method__//
    public function author_register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:authors',
            'password' => ['required', 'confirmed',Password::min(8) ->letters()->mixedCase()->numbers()->symbols()],
            'password_confirmation' =>'required'
        ],[
            'name.required' => 'Please Enter Your Name!',
            'email.required' => 'Please Enter Your Email!',
            'email.email' => 'Please Enter Valid Email Address!',
            'email.unique' => 'This Email Already Exist!',
            'password.required' => 'Please Enter Your Password!',
            'password.confirmed' => 'Password Not Matched!',
            'password_confirmation.required' => 'Please Enter Your Password Again!'
        ]);
        Author::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
        ]);
        return back()->with('author_register', 'Registration Success!Your Account Is Pending For Approval. You will get an email when your account is approved. Thank You.');
    }

    //__author login method__//
    public function author_login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ],[
            'email.required' => 'Please Enter Your Email!',
            'password.required' => 'Please Enter Your Password!',
        ]);

        if(Author::where('email', $request->email)->exists()){
            if(Auth::guard('author')->attempt(['email' => $request->email, 'password' => $request->password]))
            {
                if(Auth::guard('author')->user()->status != 1){
                    Auth::guard('author')->logout();
                    return back()->with('pending', 'Your Account Is Pending For Approval. You will get an email when your account is approved. Thank You.');
                }else{
                    return redirect()->route('index');
                }


            }
            else{
                return back()->with('password_error', 'Wrong Password!');
            }
        }
        else{
            return back()->with('email_error', 'This Email Is Not Found!');
        }

    }

    //__author dashboard method__//
    public function author_dashboard()
    {
        return view('frontend.author.dashboard');
    }

    //__author logout method__//
    public function author_logout()
    {
        Auth::guard('author')->logout();
        return redirect()->route('index');
    }

}
