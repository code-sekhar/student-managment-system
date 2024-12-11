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

}
