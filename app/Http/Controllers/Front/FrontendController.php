<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $categories = Category::where('status',1)->get();
        return view('frontend.index',[
            'categories' => $categories
        ]);
    }

    //__author login page__//
    public function author_login_page(){
        return view('frontend.author.login');
    }

    //__author register page__//
    public function author_register_page(){
        return view('frontend.author.register');
    }
}
