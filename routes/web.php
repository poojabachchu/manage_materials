<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MaterialsController;
use App\Http\Controllers\InwardOutwardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});


//Routes for category crud
Route::get('/add_category',[CategoryController::class,'index']);
Route::post('/add_category',[CategoryController::class,'addCategory']);
Route::get('/all_categories',[CategoryController::class,'listCategories']);
Route::get('/edit_category/{id}',[CategoryController::class,'editCategory']);
Route::post('/update_category',[CategoryController::class,'updateCategory']);
Route::get('/delete_category',[CategoryController::class,'deleteCategory']);

//Routes for materials crud
Route::get('/add_materials',[MaterialsController::class,'index']);
Route::post('/add_material',[MaterialsController::class,'addMaterials']);
Route::get('/show_materials',[MaterialsController::class,'listMaterials']);
Route::get('/delete_material',[MaterialsController::class,'deleteMaterial']);
Route::get('/edit_material/{id}',[MaterialsController::class,'editMaterial']);
Route::post('/update_material',[MaterialsController::class,'updateMaterial']);
Route::get('/list_materials',[MaterialsController::class,'listMaterials']);


Route::get('/add_inward_outward',[InwardOutwardController::class,'addInwardoutward']);
Route::post('/add_inwardoutward',[InwardOutwardController::class,'insert']);
Route::get('/getMaterials',[InwardOutwardController::class,'getMaterials']);
Route::get('/show_inwardoutward',[InwardOutwardController::class,'listInwardOutward']);
Route::get('/delete_inwardoutward',[InwardOutwardController::class,'deleteInwardOutward']);
Route::get('/edit_inwardoutward/{id}',[InwardOutwardController::class,'editInwardOutward']);
Route::post('/update_inwardoutward',[InwardOutwardController::class,'updateInwardOutward']);



