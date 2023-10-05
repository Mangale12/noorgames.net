<?php

namespace App\Http\Controllers;
use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::get();
        // $parents = Category::where('sub_category',null)->get();
        return view('newLayout.category.index',compact('categories'));
    }
    public function create(){
        $categories = Category::where('sub_category',null)->get();
        return view('newlayout.category.create',compact('category'));
    }
    public function store(Request $request){
        $request->validate([
            'name'=>'required|unique:categories,name',
            'category'=>'required',
            'icon'=>'required',
        ]);
        Category::create([
            'name'=>$request->name,
            'sub_category'=>$request->sub_category,
            'category_link'=>$request->category_link,
            'icon'=>$request->icon,
            'role'=>$request->role,
        ]);
        return redirect()->route('category.index');
    }
    public function edit(Request $request){
        $category = Category::where('id',$request->category_id)->first();
        return response()->json(['category'=>$category]);
    }
    public function update(Request $request){
        $request->validate([
            'name'=>'required|unique:categories,name,'.$request->category_id,
            'category_link'=>'required',
            'icon'=>'required',
        ]);

        Category::where('id',$request->category_id)->update([
            'name'=>$request->name,
            'sub_category'=>$request->sub_category,
            'link'=>$request->category_link,
            'icon'=>$request->icon,
            'role'=>$request->role,
        ]);
        return redirect()->route('category.index');
    }
    public function destroy(Category $category){
        $categories = Category::where('sub_category',$category->id)->get();
        foreach($categories as $categoryid){
            Category::where('id',$cateogryid->id)->delete();
        }
        $category->delete();
        return back();
    }
}
