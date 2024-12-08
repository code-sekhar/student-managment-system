<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Exception;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(Request $request){
        try{
            $user_id = $request->header('id');
            $count = Teacher::where('user_id',$user_id)->count();
            if($count > 0){
                $data = Teacher::where('user_id',$user_id)->get();
                return response()->json([
                    'data' => $data,
                    'message' => 'success'
                ],200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'not found'
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'something went wrong',
            ],500);
        }

    }
    //add Teacher
    public function create(Request $request){
        try{
            $user_id = $request->header('id');
            $result = Teacher::create([
                'user_id' => $user_id,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'expertise' => $request->input('expertise'),
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Teacher created successfully',
                'data' => $result,
            ],201);
        }catch (Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ],500);
        }
    }
    //delete Teacher
    public function delete(Request $request,$id){
        try{
            $user_id = $request->header('id');
            $findTeacher = Teacher::where('user_id',$user_id)->where('id',$id)->count();
            if($findTeacher > 0){
                Teacher::where('user_id',$user_id)->where('id',$id)->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Teacher deleted successfully',
                ],201);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Teacher not found',
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ]);
        }
    }
    //update Teacher
    public function update(Request $request,$id){
        try{
            $user_id = $request->header('id');
            $findTeacher = Teacher::where('user_id',$user_id)->where('id',$id)->count();
            if($findTeacher > 0){
                $result = Teacher::where('user_id',$user_id)->where('id',$id)->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'expertise' => $request->input('expertise'),
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Teacher updated successfully',
                    'data' => $result,
                ],201);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Teacher not found',
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ],500);
        }
    }
    //Single Teacher get
    public function getTeacherDetails(Request $request,$id){
        try{
            $user_id = $request->header('id');
            $findTeacher = Teacher::where('user_id',$user_id)->where('id',$id)->count();
            if($findTeacher > 0){
                $all = Teacher::where('user_id',$user_id)->where('id',$id)->get();
                return response()->json([
                    'data' => $all,
                    'message' => 'success'
                ],201);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Teacher not found'
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ],500);
        }
    }
    //Teacher Status control
    public function teacherStatus(Request $request,$id){
        try{
            $user_id = $request->header('id');
            $findTeacher = Teacher::where('user_id',$user_id)->where('id',$id)->count();
            if($findTeacher > 0){
                $updateStatus = Teacher::where('user_id',$user_id)->where('id',$id)->update([
                    'status' => $request->input('status')
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Teacher status updated successfully',
                ],201);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Teacher not found'
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ],500);
        }
    }
}
