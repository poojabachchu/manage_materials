<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Material;
use App\Models\InwardOutward;
use Illuminate\Support\Facades\DB;

class InwardOutwardController extends Controller
{
    //View page for inward/outward form
    public function addInwardoutward(){
        $categories = Category::select('id','category_name')->get();
        $url = "/add_inwardoutward";
        $title = "Add Inward/Outward";
        $data = compact('url','title','categories');
        return view('inward_outward/add_inwardoutward')->with($data);
    }

    public function getMaterials(Request $request){
        $materials = Material::select('material_id','material_name')->where('category_id',$request['category_id'])->get();
        if(count($materials) > 0){
            echo json_encode(['materials'=>$materials,'msg'=>'Success']);
        }
        else{
            echo json_encode(['msg'=>'Failed']);
        }
    }

    public function insert(Request $request){
        // echo "<pre>";
        // print_r($request->all());
        // exit;

        //Validate the input
        $this->validate($request,[
            'category'=>'required',
            'material_id'=>'required',
            'date' => 'required',
            'quantity'=>'required|numeric|regex:/^[-+]?\d+(\.\d{1,2})?$/',
        ]);

        $inward_outward_exists = InwardOutward::where('material_id','=',$request['material_id'])->count();
        if($inward_outward_exists == 0){
            $inwardoutward = new InwardOutward;
            $inwardoutward->material_id = $request['material_id'];
            $inwardoutward->date = $request['date'];
            $inwardoutward->quantity = $request['quantity'];
            if($inwardoutward -> save()){
                return redirect('/show_inwardoutward')->with('msg','<div class="alert alert-success">Inward/Outward added succesfully</div>');
            }else{
                return redirect('/add_inward_outward')->with('msg','<div class="alert alert-danger">Inward/Outward not added</div>');
            }
        }
        else{
            return redirect()->back()->withInput()->with('msg','<div class="alert alert-danger">Details already exists!</div>');
        }
    }

    public function listInwardOutward(){
        $inwardoutwards = DB::table('inward_outward as io')->leftjoin('materials as mat','mat.material_id','=','io.material_id')->leftjoin('categories as cat','cat.id','=','mat.category_id')->whereNull('mat.deleted_at')->select('mat.material_id', 'mat.category_id', 'mat.material_name', 'mat.opening_balance', 'io.quantity','io.inward_id','io.date','cat.category_name')
        ->get();

        return view('inward_outward/show_inwardoutward')->with(compact('inwardoutwards'));
    }

    public function deleteInwardOutward(Request $request){
        $inward_outward = InwardOutward::where('inward_id','=',$request['id'])->first();
        if($inward_outward){
            if($inward_outward->delete()){
                echo json_encode(['msg'=>'Success']);
            }
            else{
                echo json_encode(['msg'=>'Failed']);
            }
        }
        else{
            echo json_encode(['msg'=>'Failed']);
        }
    }

    public function editInwardOutward($id){
        $inward_outward = DB::table('inward_outward as io')->leftjoin('materials as mat','mat.material_id','=','io.material_id')->leftjoin('categories as cat','cat.id','=','mat.category_id')->whereNull('mat.deleted_at')->where('io.inward_id','=',$id)->select('mat.material_id', 'mat.category_id', 'mat.material_name', 'mat.opening_balance', 'io.quantity','io.inward_id','io.date','cat.category_name')
        ->get();
        // echo "<pre>";
        // print_r($inward_outward);
        // exit;
        $url = "/update_inwardoutward";
        $title = "Update Inward/Outward";
        $categories = array();

        $data = compact('url','title','inward_outward','categories');
        return view('inward_outward/add_inwardoutward')->with($data);
    }

    public function updateInwardOutward(Request $request){
        $inward_outward = InwardOutward::where('inward_id','=',$request['inward_id'])->first();
        $inward_outward->date = $request['date'];
        $inward_outward->quantity = $request['quantity'];
        if($inward_outward->save()){
            return redirect('/show_inwardoutward')->with('msg','<div class="alert alert-success">Inward/Outward updated sucessfully</div>');
        }
        else{
            return redirect('/show_inwardoutward')->with('msg','<div class="alert alert-success">Inward/Outward not updated</div>');
        }
    }
}
