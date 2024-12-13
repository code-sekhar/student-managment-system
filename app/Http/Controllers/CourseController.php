<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\result;
use Exception;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //Get All Course
    public function index(Request $request){
        try{
            $user_id = $request->header('id');
            $result = Courses::where('user_id',$user_id)->get();
            if(count($result)>0){
                return response()->json($result,201);
            }else{
                return response()->json(null,404);
            }
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!'
            ],500);
        }
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
    //Course Details get
    public function getCourseDetails(Request $request,$id){
        try{
            $user_id = $request->header('id');
            $result = Courses::where('user_id',$user_id)->where('id',$id)->first();
            if($result){
                return response()->json($result,201);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Course Not Found'
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => 'Sorry something went wrong',
                'success' => false
            ],500);
        }
    }
    //Course status Update
    public function CourseStatusUpdate(Request $request,$id){
        try{
            $user_id = $request->header('id');
            $result = Courses::where('user_id',$user_id)->where('id',$id)->update([
                'status' => $request->input('status')
            ]);
            if($result){
                return response()->json([
                    'message' => 'Course Status Updated Successfully',
                    'data' => $result,
                ],201);
            }else{
                return response()->json([
                    'message' => 'Course Not Found',
                    'success' => false
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => 'Sorry something went wrong',
                'success' => false
            ],500);
        }
    }
    //course Update
    public function CourseUpdate(Request $request,$id){
        try{
            $user_id = $request->header('id');
            $result = Courses::where('user_id',$user_id)->where('id',$id)->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'duration' => $request->input('duration')
            ]);
            if($result){
                return response()->json([
                    'message' => 'Course Status Updated Successfully',
                    'data' => $result,
                    'success' => true
                ],201);
            }else{
                return response()->json([
                    'message' => 'Course Not Found',
                    'success' => false
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => 'Sorry something went wrong',
                'success' => false
            ],500);
        }
    }
    public function CourseDelete(Request $request,$id){
        try{
            $user_id = $request->header('id');
            $result = Courses::where('user_id',$user_id)->where('id',$id)->delete();
            if($result){
                return response()->json([
                    'message' => 'Course Deleted Successfully',
                    'success' => true
                ],201);
            }else{
                return response()->json([
                    'message' => 'Course Not Found',
                    'success' => false
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => 'Sorry something went wrong',
                'success' => false
            ],500);
        }
    }
}
