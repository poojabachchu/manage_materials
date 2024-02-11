<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Material;
use App\Models\InwardOutward;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialsController extends Controller
{
    ///View the add_materials view
    public function index(){
        $categories = Category::select('id','category_name')->get();
        $url = "/add_material";
        $title = "Add Material";
        $material = [
            ['category_id' => '']
        ];
        $data = compact('url','title','categories','material');
        return view('materials/add_materials')->with($data);
    }

    //Add the materials
    public function addMaterials(Request $request){
        //Validate the input fields
        $this->validate($request,[
            'category'=>'required',
            'material_name'=>'required',
            'opening_balance'=>'required|numeric|regex:/^[-+]?\d+(\.\d{1,2})?$/',
        ]);

        //Check if material with same name exists under the same category
        $material_exists = Material::where('material_name','=',strtolower($request['material_name']))->where('category_id','=',$request['category'])->count();
        if($material_exists == 0){
            $material = new Material;
            $material->category_id = $request['category'];
            $material->material_name = $request['material_name'];
            $material->opening_balance = $request['opening_balance'];
            if($material->save()){
                return redirect('/show_materials')->with('msg','<div class="alert alert-success">Material added succesfully</div>');
            }else{
                return redirect('/show_materials')->with('msg','<div class="alert alert-success">Material not added</div>');
            }
        }else{
            //If material with same name exists unde a category then display a error message
            return redirect()->back()->withInput()->with('msg','<div class="alert alert-danger">This material already exists under this category!</div>');
        }
    }

    //Get the list of all the materials
    public function listMaterials(Request $request){
        $materials = DB::table('materials as mat')
        ->leftJoin('inward_outward as io', 'io.material_id', '=', 'mat.material_id')->whereNull('mat.deleted_at')
        ->select('mat.material_id', 'mat.category_id', 'mat.material_name', 'mat.opening_balance', 'io.quantity')
        ->get();
        if($request['value'] != ''){
            $basic_details = 'on';
        }else{
            $basic_details = 'off';
        }
        $data = compact('materials','basic_details');
        return view('materials/show_materials')->with($data);
    }

    //Soft delete the materials
    public function deleteMaterial(Request $request){
        //Check if a material with spefic id is found in the records
        $query = Material::where('material_id', $request['id']);
        $material = $query->first();

        //If found then delete the record
        if($material){
            if($material->delete()){
                echo json_encode(['msg'=>'Success']);
            }
            else{
                echo json_encode(['msg'=>'Failed']);
            }
        }else{
            //If not found then show a error message
            echo json_encode(['msg'=>'Failed']);
        }
    }

    //Display a edit form for editing materials
    public function editMaterial($id){
        $material = Material::select('material_id','category_id','material_name','opening_balance')->where('material_id','=',$id)->get();
        $categories = Category::select('id','category_name')->get();
        $url = "/update_material";
        $title = "Update Material";
        $data = compact('material','url','title','categories');
        return view('materials/add_materials')->with($data);
    }

    //Update the material
    public function updateMaterial(Request $request){

        $material_exists = Material::where('material_name', '=', strtolower($request['material_name']))
        ->where('category_id', '=', $request['category'])
        ->where('material_id', '!=', $request['material_id'])
        ->first();

     
        // If the count of material_exists is 0 then save the material 
        if(!$material_exists){
            $material = Material::where('material_id','=',$request['material_id'])->first();

            $material->material_name = $request['material_name'];
            $material->category_id = $request['category'];
            $material->opening_balance = $request['opening_balance'];
        
            //Get the url parameter so that based on which update page called it, the redirection will be done to that respective listings
            if(isset($request["current_balance"])){
                $redirection_url = "/list_materials/basic_details";
            }else{
                $redirection_url = "/show_materials";
            }

            if($material->save()){
                return redirect($redirection_url)->with('msg','<div class="alert alert-success">Material updated succesfully</div>');
            }else{
                return redirect($redirection_url)->with('msg','<div class="alert alert-success">Material not updated</div>');
            }
        }
        else{
            //If material under the same category exists then throw a error message
            return redirect()->back()->withInput()->with('msg','<div class="alert alert-danger">This material already exists under this category!</div>');
        }

    }
}
