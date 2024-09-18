<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    //__category method__//
    public function category()
    {
        $categories = Category::all();
        return view('admin.category.index',compact('categories'));
    }

    //__trash category method__//
    public function trashCategory()
    {
        $trashCategories = Category::onlyTrashed()->get();
        return view('admin.category.trash',compact('trashCategories'));
    }

    //__category store method__//
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories|max:255',
            'image'=>'required|mimes:png,jpg|max:2048',
        ]);

        $cat_image=$request->image;
        $extension = $cat_image->extension();
        $file_name = uniqid().'.'.$extension;
        $manager = new ImageManager(new Driver());
        $image = $manager->read($cat_image);
        $image->resize(200, 200);
        $image->save(public_path('uploads/category/'.$file_name));

        Category::insert([
            'category_name' => $request->category_name,
            'category_slug' => str::slug($request->category_name,'-'),
            'image' => $file_name,
            'status' =>1,
            'created_at' => Carbon::now(),
        ]);
        $notification = array('message' => 'Category Added Successfully!','alert-type'=>'success' );
        return redirect()->route('category')->with($notification);
    }

    //__category edit method__//
    public function categoryEdit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit',compact('category'));
    }

    //__category update method__//
    public function categoryUpdate(Request $request, $id)
    {
        $request->validate([
            'image'=>'mimes:png,jpg|max:2048',
        ]);
        $data=array();
        $data['category_name']=$request->category_name;
        $data['category_slug']=Str::slug($request->category_name,'-');
        //Icon
        $cat_image=$request->file('image');
        if($cat_image){
            $old_image=public_path('uploads/category/'.$request->old_image);
            if (File::exists($old_image)) {
                File::delete($old_image);
            }
            $cat_image=$request->image;
            $extension = $cat_image->extension();
            $file_name = uniqid().'.'.$extension;
            $manager = new ImageManager(new Driver());
            $image = $manager->read($cat_image);
            $image->resize(200, 200);
            $image->save(public_path('uploads/category/'.$file_name));
            $data['image'] = $file_name;
        }else{
            $data['image']=$request->old_image;
        }
        $data['updated_at']= Carbon::now();
        Category::where('id',$id)->update($data);
        $notification = array('message' => 'Category Updated Successfully!','alert-type'=>'success' );
        return redirect()->route('category')->with($notification);
    }

    //__category delete method__//
    public function categoryDelete($category_id)
    {
        Category::find($category_id)->delete();
        $notification = array('message' => 'Category Deleted Successfully!','alert-type'=>'error' );
        return redirect()->back()->with($notification);
    }

    //__category restore method__//
    public function categoryRestore($category_id)
    {
        Category::onlyTrashed()->find($category_id)->restore();
        $notification = array('message' => 'Category Restore Successfully!','alert-type'=>'success' );
        return redirect()->back()->with($notification);
    }

    //__category hard delete method__//
    public function categoryHardDelete($category_id)
    {
        $category = Category::onlyTrashed()->find($category_id);
        $delete_form = public_path('uploads/category/'.$category->image);
        unlink($delete_form);
        Category::onlyTrashed()->find($category_id)->forceDelete();
        return redirect()->back()->with('h_delete','Category Permanently Delete Successfully!');
    }
    //__category chack delete method__//
    public function categoryChackDelete(Request $request){
        foreach($request->category_id as $cat_id){
            Category::find($cat_id)->delete();
        }
        $notification = array('message' => 'Category All Deleted Successfully!','alert-type'=>'error' );
        return redirect()->back()->with($notification);
    }
    //__category chack restore && delete method__//
    public function categoryChackRestore(Request $request){
        if($request->action_btn ==1){
            foreach($request->category_id as $cat_id){
                Category::onlyTrashed()->find($cat_id)->restore();
            }
            $notification = array('message' => 'Category All Restore Successfully!','alert-type'=>'success' );
            return redirect()->back()->with($notification);
        }
        else{
            foreach($request->category_id as $cat_id){
                $category = Category::onlyTrashed()->find($cat_id);
                $delete_form = public_path('uploads/category/'.$category->image);
                unlink($delete_form);
                Category::onlyTrashed()->find($cat_id)->forceDelete();
            }
            $notification = array('message' => 'Category All Permanently Deleted Successfully!','alert-type'=>'error' );
            return redirect()->back()->with($notification);
        }

    }
    //__category active method__//
    public function categoryActive($category_id)
    {
        Category::where('id',$category_id)->update(['status' => 0]);
        $notification = array('message' => 'Category Inactive Successfully!','alert-type'=>'error' );
        return redirect()->back()->with($notification);
    }

    //__category inactive method__//
    public function categoryInactive($category_id)
    {
        Category::where('id',$category_id)->update(['status' => 1]);
        $notification = array('message' => 'Category Active Successfully!','alert-type'=>'success' );
        return redirect()->back()->with($notification);
    }
}
