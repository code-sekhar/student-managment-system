<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use Exception;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //Get All Course
    public function index(Request $request){

    }
    //Add Course
    public function create(Request $request){
        try{
            $user_id = $request->header('id');
            $result = Courses::create([
                'user_id' => $user_id,
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'duration' => $request->input('duration')
            ]);
            return response()->json([
                'message' => 'Course Created Successfully',
                'data' => $result,
                'success' => true
            ],201);
        }catch(Exception $e){
            return response()->json([
                'message' => 'Sorry something went wrong',
                'success' => false
            ],500);
        }
    }
}
