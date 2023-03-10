<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/students', [StudentController::class, 'index']);
Route::post('/students/create', [StudentController::class, 'store']);
Route::post('/students/edit', [StudentController::class, 'edit']);
Route::post('/students/delete', [StudentController::class, 'destroy']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::get('/students/courses/{id}', [StudentController::class, 'students_classes']);
Route::get('/students/courses/unassigned/{id}', [StudentController::class, 'students_classes_unassigned']);
Route::post('/students/courses/assign', [StudentController::class, 'assign']);
Route::post('/students/courses/unassign', [StudentController::class, 'unassign']);
Route::post('/students/grade', [StudentController::class, 'grade']);

Route::get('/courses', [CourseController::class, 'index']);
Route::post('/courses/create', [CourseController::class, 'store']);
Route::post('/courses/edit', [CourseController::class, 'edit']);
Route::post('/courses/delete', [CourseController::class, 'destroy']);
Route::get('/courses/{id}', [CourseController::class, 'show']);
Route::get('/courses/students/{id}', [CourseController::class, 'classes_students']);
Route::get('/courses/students/unassigned/{id}', [CourseController::class, 'classes_students_unassigned']);
Route::post('/courses/students/assign', [CourseController::class, 'assign']);
Route::post('/courses/students/unassign', [CourseController::class, 'unassign']);

Route::get('/grades', [GradeController::class, 'index']);
Route::post('/grades/create', [GradeController::class, 'store']);
Route::post('/grades/edit', [GradeController::class, 'edit']);
Route::post('/grades/delete', [GradeController::class, 'destroy']);
Route::get('/grades/{id}', [GradeController::class, 'show']);
