<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Exception;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //get all student
    public function index(Request $request){
        try{
            $user_id = $request->header('id');
            $result = Student::where('user_id',$user_id)->get();
            if($result->isEmpty()){
                return response()->json(["message" => "No data found"], 404);
            }else{
                return response()->json([
                    'data' => $result,
                    'message' => 'Student fetched successfully'
                ],201);
            }
        }catch(Exception $e){
            return response()->json([
                "message" => "Something went wrong"
            ], 500);
        }
    }
    //add Student
    public function addStudent(Request $request){
        try{
            $user_id = $request->header('id');
            Student::create([
                'name'=> $request->input('name'),
                'email'=> $request->input('email'),
                'phone'=> $request->input('phone'),
                'user_id'=> $user_id,
                'batch_id'=> $request->input('batch_id'),
            ]);
            return response()->json(["message"=>"Student Added Successfully"],201);
        }catch(Exception $e){
            return response()->json([
                "message"=>'Something went wrong',
            ],500);
        }
    }
    //Student details get
    public function studentDetails(Request $request,$id){
        try{
            $user_id = $request->header('id');
            $result = Student::where('user_id',$user_id)->where('id',$id)->get();
            if($result->isEmpty()){
                return response()->json(["message" => "No data found"], 404);
            }else{
                return response()->json([
                    'data' => $result,
                    'message' => 'Student fetched successfully',
                    "success"=>true
                ],201);
            }
        }catch(Exception $e){
            return response()->json([
                "message"=>'Something went wrong',
                "success" => false,
            ],500);
        }
    }
    //Update Status
    public function updateStatusStudent(Request $request,$id){
        try{
            $user_id = $request->header('id');
            $result = Student::where('user_id',$user_id)->where('id',$id)->update([
                'status'=> $request->input('status')
            ]);
            if($result){
                return response()->json(["message"=>"Student Status Updated Successfully"],201);
            }else{
                return response()->json(["message"=>"Student Not Found"],404);
            }
        }catch(Exception $e){
            return response()->json([
                "message"=>'Something went wrong',
                "success" => false,
            ],500);
        }
    }
    //Update Students
    public function updateStudent(Request $request,$id){
        try{
            $user_id = $request->header('id');
            $result = Student::where('user_id',$user_id)->where('id',$id)->update([
                'name'=> $request->input('name'),
                'email'=> $request->input('email'),
                'phone'=> $request->input('phone'),
                'batch_id'=> $request->input('batch_id')
            ]);
            if($result){
                return response()->json([
                    'data' => $result,
                    'message' => 'Student fetched successfully',
                    "success"=>true
                ],201);
            }else{
                return response()->json([
                    "message" => "No data found",
                    "success" => false
                ], 404);
            }
        }catch(Exception $e){
            return response()->json([
                "message"=>'Something went wrong',
                "success" => false,
            ],500);
        }
    }
}
