<?php

namespace App\Http\Controllers;

use App\Models\Batches;
use App\Models\Teacher;
use Exception;
use Illuminate\Http\Request;

class BatchesController extends Controller
{
    //Get all Batches
    public function index(Request $request){
        try{
            $user_id = $request->header('id');
            $result = Batches::where('user_id', $user_id)->get();
            if($result->isEmpty()){
                return response()->json([
                    'status' => false,
                    'message' => 'No Batches found !',
                ],404);
            }else{
                return response()->json([
                    'message' => 'success',
                    'success' => true,
                    'data' => $result
                ],201);
            }

        }catch(Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'success' => false,
            ],500);
        }
    }
    //add Batches
    public function create(Request $request){
        try{
            $user_id = $request->header('id');
            $teacher = Teacher::where('user_id', $user_id)
                ->where('id', $request->input('instructor_id'))
                ->first();
            if($teacher == null){
                return response()->json([
                    'status' => false,
                    'message' => 'Teacher not found',
                ],404);
            }else{
                $result = Batches::create([
                    'user_id' => $user_id,
                    'name' => $request->input('name'),
                    'start_date' => $request->input('start_date'),
                    'end_date' => $request->input('end_date'),
                    'instructor_id' => $request->input('instructor_id'),
                ]);
                return response()->json([
                    'data' => $result,
                    'message' => 'Batch created!',
                    'success' => true
                ],201);
            }

        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
            ],500);
        }
    }
}
