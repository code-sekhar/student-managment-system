<?php

use App\Http\Controllers\BatchesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
Route::post('/SendOtpCode',[UserController::class,'SendOtpCode']);
Route::post('/verifyOTP',[UserController::class,'verifyOTP']);
Route::post('/resetPassword',[UserController::class,'resetPassword'])->middleware(TokenVerificationMiddleware::class);
Route::post('/logOut',[UserController::class,'logOut'])->middleware(TokenVerificationMiddleware::class);

//Teacher section
Route::post('/teacher',[TeacherController::class,'create'])->middleware(TokenVerificationMiddleware::class);
Route::get('/teacher',[TeacherController::class,'index'])->middleware(TokenVerificationMiddleware::class);
Route::delete('/teacher/{id}',[TeacherController::class,'delete'])->middleware(TokenVerificationMiddleware::class);
Route::put('/teacher/{id}',[TeacherController::class,'update'])->middleware(TokenVerificationMiddleware::class);
Route::get('/teacher/{id}',[TeacherController::class,'getTeacherDetails'])->middleware(TokenVerificationMiddleware::class);
Route::put('/teacher/{id}/status',[TeacherController::class,'teacherStatus'])->middleware(TokenVerificationMiddleware::class);

//Batches Routes Section
Route::get('/batches',[BatchesController::class,'index'])->middleware(TokenVerificationMiddleware::class);
Route::post('/batches',[BatchesController::class,'create'])->middleware(TokenVerificationMiddleware::class);
Route::get('/batches/{id}',[BatchesController::class,'getBatcheDetails'])->middleware(TokenVerificationMiddleware::class);
Route::delete('/batches/{id}',[BatchesController::class,'deleteBatch'])->middleware(TokenVerificationMiddleware::class);
Route::put('/batches/{id}/status',[BatchesController::class,'statusBatch'])->middleware(TokenVerificationMiddleware::class);
Route::put('/batches/{id}',[BatchesController::class,'updateBatch'])->middleware(TokenVerificationMiddleware::class);

//Students Route Section
Route::post('/student',[StudentController::class,'addStudent'])->middleware(TokenVerificationMiddleware::class);
Route::get('/student',[StudentController::class,'index'])->middleware(TokenVerificationMiddleware::class);
Route::get('/student/{id}',[StudentController::class,'studentDetails'])->middleware(TokenVerificationMiddleware::class);
Route::put('/student/{id}/status',[StudentController::class,'updateStatusStudent'])->middleware(TokenVerificationMiddleware::class);
Route::put('/student/{id}',[StudentController::class,'updateStudent'])->middleware(TokenVerificationMiddleware::class);
Route::delete('/student/{id}',[StudentController::class,'deleteStudent'])->middleware(TokenVerificationMiddleware::class);
