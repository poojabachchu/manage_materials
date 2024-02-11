<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
// use App\Http\Controllers\CustomDebug;

class CategoryController extends Controller
{
    //return the view page of add category
    public function index(){
        $url = "/add_category";
        $title = "Add Category";
        $data = compact('url','title');
        return view('category/add_category')->with($data);
    }

    //function to add category
    public function addCategory(Request $request){
        //validate if the category field is filled
        $this->validate($request,[
            'category' => 'required',
        ]);
        
        $category_name = strtolower($request['category']);
        //Check if a category exists with the provided name
        $category_exists = Category::where('category_name','=',$category_name)->count();
        if($category_exists == 0){
            //Create a new instance of Category model
            $category = new Category;
            $category->category_name = $request['category'];
            //Save the category
            if($category->save()){
                return redirect('/all_categories')->with('msg','<div class="alert alert-success">Category added succesfully</div>');
            }else{
                return redirect('/all_categories')->with('msg','<div class="alert alert-danger">Category not added</div>');
            }
        }else{
            //If category already exists return to add_category page with a error message
            return redirect()->back()->withInput()->with('msg','<div class="alert alert-danger">Category already exists!</div>');
        }
    }

    //Get the list of all categories
    public function listCategories(){
        $categories = Category::select('id','category_name')->get();
        return view('/category/show_categories')->with(compact('categories'));
    }

    //Return a edit page for updation of category
    public function editCategory($id){
        $url = "/update_category";
        $title = "Update Category";
        $category = Category::find($id);
        $data = compact('category','url','title');
        return view('category/add_category')->with($data);
    }

    //Update the category with given name
    public function updateCategory(Request $request){
        $category_name = strtolower($request['category']);
        // Check if a category if same name not exists 
        $category_exists = Category::where('category_name','=',$category_name)->where('id','!=',$request['category_id'])->count();
        if($category_exists == 0){
            $category = Category::find($request['category_id']);
            $category->category_name = $request['category'];
            if($category->save()){
                return redirect('/all_categories')->with('msg','<div class="alert alert-success">Category updated succesfully</div>');
            }else{
                return redirect('/all_categories')->with('msg','<div class="alert alert-danger">Category not updated</div>');
            }
        }else{
            //If category with same name already exists in database then provide a error msg
            return redirect()->back()->withInput()->with('msg','<div class="alert alert-danger">Category already exists!</div>');
        }
    }

    public function deleteCategory(Request $request){
        $category = Category::find($request['id']);
        if($category){
            if($category->delete()){
                echo json_encode(['msg'=>'Success']);
            }else{
                echo json_encode(['msg'=>'Failed']);
            }
        }else{
            echo json_encode(['msg'=>'Success']);
        }
    }
}
