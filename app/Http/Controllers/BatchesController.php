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
    //get Single Batches
    public function getBatcheDetails(Request $request,$id){
        try{
            $user_id = $request->header('id');

            $result = Batches::where('user_id', $user_id)->where('id', $id)->get();
            if($result->isEmpty()){
                return response()->json([
                    'status' => false,
                    'message' => 'Batch not found',
                ],404);
            }else{
                return response()->json([
                    'data' => $result,
                    'message' => 'Batch Get Successfully !',
                ],201);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
            ],500);
        }
    }
    //delete Batch
    public function deleteBatch(Request $request,$id)
    {
        try{
            $user_id = $request->header('id');
            $result = Batches::where('user_id', $user_id)->where('id', $id)->delete();
            if($result){
                return response()->json([
                    'status' => true,
                    'message' => 'Batch deleted successfully!'
                ],201);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Batches Not found!'
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false
            ],500);
        }
    }
    //batches status
    public function statusBatch(Request $request,$id){
        try{
            $user_id = $request->header('id');
            $updateStatus = Batches::where('user_id', $user_id)->where('id', $id)->update([
                'status' => $request->input('status')
            ]);
            if($updateStatus){
                return response()->json([
                    'status' => true,
                    'message' => 'Batch status updated successfully!'
                ],201);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Batch Status Not found!'
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'success' => false
            ],500);
        }
    }
    //update Batches
    public function updateBatch(Request $request,$id){
        try{
            $user_id = $request->header('id');
            $result = Batches::where('user_id', $user_id)->where('id', $id)->update([
                'name' => $request->input('name'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'instructor_id' => $request->input('instructor_id')
            ]);
            if($result){
                return response()->json([
                    'status' => true,
                    'message' => 'Batch updated successfully!'
                ],201);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Batch Not found!'
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'message' => 'Something went wrong',
                'success' => false
            ],500);
        }
    }
}
