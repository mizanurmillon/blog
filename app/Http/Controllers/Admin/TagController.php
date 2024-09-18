<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TagController extends Controller
{
    //__tags method__//
    public function tags() {
        $tags = Tag::all();
        return view('admin.tags.index',compact('tags'));
    }

    //__tag store method__//
    public function tagStore(Request $request){
        $request->validate([
            'tag_name' => 'required|unique:tags|max:255',
        ]);

        Tag::insert([
            'tag_name' => $request->tag_name,
            'created_at' => Carbon::now(),
        ]);
        $notification = array('message' => 'Tag Added Successfully!','alert-type'=>'success' );
        return redirect()->route('tags')->with($notification);
    }

    public function tagDelete($tag_id){
        Tag::find($tag_id)->delete();
        return redirect()->back()->with('T_delete','Tag Permanently Deleted Successfully!');
    }
}
