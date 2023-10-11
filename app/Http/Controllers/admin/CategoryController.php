<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index():View
    {
        $user = Auth::guard('admin')->user();
        $categories = Category::paginate(20);
        return \view('admin.dashboard.category.index', compact('user','categories'));
    }

    public function create():View
    {
        $user = Auth::guard('admin')->user();
        return \view('admin.dashboard.category.add_edit', compact('user', ));
    }

    public function store(Request $request){
       $validator = Validator::make($request->all(), [
           'name'=> 'required',
           'slug'=> 'required|unique:categories',
       ]);
       if ($validator->passes()){
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->save();
            $request->session()->flash('success', 'Catégorie créée avec succès.');
           return response()->json([
               'status'=> true,
               'errors'=>'Catégorie créée avec succès.'
           ]);
       }else{
           return response()->json([
               'status'=> false,
               'errors'=>$validator->errors()
           ]);
       }

    }

    public function edit(Category $category): View
    {

    }

    public function update(Request $request){

    }
    public function delete(Category $category){

    }

}
