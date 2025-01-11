<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisteredUserController;
use Illuminate\Auth\Events\Authenticated;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\DashboardController;

Route::middleware(['auth:sanctum', 'role:admin'])->get('/admin-dashboard', [DashboardController::class, 'adminDashboard']);
Route::middleware(['auth:sanctum', 'role:teacher'])->get('/teacher-dashboard', [DashboardController::class, 'teacherDashboard']);
Route::middleware(['auth:sanctum', 'role:student'])->get('/student-dashboard', [DashboardController::class, 'studentDashboard']);

// Ruta para obtener el usuario autenticado
Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'getAuthenticatedUser']);


Route::resource('roles', RoleController::class);
Route::resource('courses', CourseController::class);
Route::resource('subjects', SubjectController::class);

//CRUD USERSS
Route::resource('users', UserController::class)->names([
    'index' => 'users.index',
    'create' => 'users.create',
    'store' => 'users.store',
    'show' => 'users.show',
    'edit' => 'users.edit',
    'update' => 'users.update',
    'destroy' => 'users.destroy'
]);


Route::resource('divisions', DivisionController::class);
Route::resource('forms', FormController::class);
Route::resource('questions', QuestionController::class);
Route::resource('answers', AnswerController::class);
Route::resource('groups', GroupController::class);
// ruta para pedir todas las preguntas y respuestas de un formulario
Route::get('forms/{formId}/questions', [FormController::class, 'getQuestionsAndAnswers']);




Route::post('/login', [AuthenticatedSessionController::class, 'login']);
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::middleware('auth:sanctum')->post('/logout', [AuthenticatedSessionController::class, 'logout']);
