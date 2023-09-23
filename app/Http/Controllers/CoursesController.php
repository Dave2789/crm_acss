<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\Courses;
use Illuminate\Http\Request;

class CoursesController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        
        public function viewCursos()
        {
            $coursesQuery    = DB::table("courses")
                                    ->where('status','=',1)
                                    ->get();
            
            
            return view('cursos.viewCourses', ["coursesQuery" => $coursesQuery]);
        }
        
         public function addCourse (Request $request) 
        {
            $name = $request->input("name");
            $code = $request->input("code");
            $link = $request->input("link");
            
            
            $insertCourses = new Courses;
            $insertCourses->code = $code;
            $insertCourses->name = htmlentities ($name);
            $insertCourses->link = $link;
            $insertCourses->status = 1;
            
            if($insertCourses->save()){
                return "true";
            }else{
                return "false";
            }
        }
        
         public function deleteCourse (Request $request) 
        {
            $pkCourse         = $request->input("pkCategory");
            
            $coursesUpdate   = DB::table("courses")
                                    ->where('pkCourses','=',$pkCourse)
                                    ->where('status','=',1)
                                    ->update(array("status" => 0));
            
            if($coursesUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
           public function viewUpdateCourse(Request $request){
            $pkCategory  = $request->input("idCategory");
            
            $course    = DB::table('courses')
                          ->select('pkCourses'
                                  ,'code'
                                  ,'name'
                                  ,'link')
                          ->where('status','=',1)
                          ->where('pkCourses','=',$pkCategory)
                          ->first();
            
               $view = view('cursos.editCourses', array(
                    "course" => $course,
                        ))->render();
        
            return \Response::json(array(
                                  "valid"       => "true",
                                  "view"        => $view
                                ));            
        }
        
        public function updateCourse (Request $request) 
        {
            $pkCourse           = $request->input("pkCourse");
            $name               = $request->input("name");
            $code               = $request->input("code");
            $link               = $request->input("link");
            
            $categoriesUpdate   = DB::table("courses")
                                    ->where('pkCourses','=',$pkCourse)
                                    ->where('status','=',1)
                                    ->update(array("name" => $name
                                                  ,"code" => $code
                                                  ,"link" => $link));
            
            if($categoriesUpdate >= 1){
                return "true";
            }else{
                return "false";
            }
        }
        
        
      
       

}
