<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        
        public function viewCategories()
        {
            $categoriesQuery    = DB::table("categories")
                                    ->where('categories.status','=',1)
                                    ->get();
            
            
            return view('catalogos.categorias', ["categoriesQuery" => $categoriesQuery]);
        }
        
        public function addCategory (Request $request) 
        {
            $name = $request->input("name");
            
            
            $insertCategory = new Categories;
            $insertCategory->name = htmlentities ($name);
            $insertCategory->status = 1;
            
            if($insertCategory->save()){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function viewupdateCategory(Request $request){
            $pkCategory  = $request->input("idCategory");
            
            $category    = DB::table('categories')
                          ->select('pkCategory'
                                  ,'name')
                          ->where('status','=',1)
                          ->where('pkCategory','=',$pkCategory)
                          ->first();
            
               $view = view('catalogos.updateCategory', array(
                    "category" => $category,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));            
        }
        
        public function updateCategory (Request $request) 
        {
            $pkCategory         = $request->input("idCategory");
            $name               = $request->input("name");
            
            $categoriesUpdate   = DB::table("categories")
                                    ->where('categories.pkCategory','=',$pkCategory)
                                    ->where('categories.status','=',1)
                                    ->update(array("name" => $name));
            
            if($categoriesUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
        public function deleteCategory (Request $request) 
        {
            $pkCategory         = $request->input("pkCategory");
            
            $categoriesUpdate   = DB::table("categories")
                                    ->where('categories.pkCategory','=',$pkCategory)
                                    ->where('categories.status','=',1)
                                    ->update(array("status" => 0));
            
            if($categoriesUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
	
}
