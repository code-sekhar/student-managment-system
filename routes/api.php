<?php

use App\Http\Controllers\BatchesController;
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
