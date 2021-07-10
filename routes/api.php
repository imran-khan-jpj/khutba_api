<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\KhateebController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QuestionaireController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




Route::post("/login", [LoginController::class, 'login']);
Route::post("/student/login", [LoginController::class, 'login']);
Route::post("/register", [RegisterController::class, 'register']);

//Admin Routes
Route::get("/admin/all-khateeb", [KhateebController::class, 'index']);
Route::post("/admin/create-khateeb", [KhateebController::class, 'store']);
Route::post("/admin/change-password", [ResetPasswordController::class, 'resetPassword']);
Route::delete('/admin/delete/{user}/khateeb', [KhateebController::class, 'destroy']);

////////////////////////DONE////////////////////////////////////////////////

//Khateeb Routes
Route::get('/courses', [CourseController::class, 'index']);
Route::post('/khateeb/create-course', [CourseController::class, 'store']);
Route::patch('/khateeb/course/{course}/update', [CourseController::class, 'update']);
Route::delete('/khateeb/course/{course}/destroy', [CourseController::class, 'destroy']);
Route::post('/khateeb/course/{course}/add-lesson', [CourseController::class, 'addLesson']);
Route::get('/khateeb/course/{course}/lessons', [CourseController::class, 'getLessons']);
Route::get('/khateeb/questionaires', [QuestionaireController::class, 'index']);
Route::post('/khateeb/{course}/create-questionaire', [QuestionaireController::class, 'store']);
Route::post('/khateeb/course/{course}/questionaire/{questionaire}/add-questions', [QuestionaireController::class, 'addQuestions']);
Route::get('/khateeb/{course}/{questionaire}/getQuestions', [QuestionaireController::class, 'getQuestions']);
Route::delete('/khateeb/delete/{question}', [QuestionaireController::class, 'deleteQuestion']);
Route::post('/khateeb/question/{question}/answer', [QuestionsController::class, 'answer']);
Route::post("/khateeb/change-password", [ResetPasswordController::class, 'resetPassword']);
//Student Routes
Route::post('/student/create-question', [QuestionsController::class, 'store']);
Route::post('/student/register/{course}', [CourseController::class, 'registerCourse']);
Route::get('/student/your-questions', [QuestionsController::class, 'studentQuestions']);
Route::get('/student/all-questions', [QuestionsController::class, 'index']);
Route::get('/student/questionaire/{questionaire}/questionaireQuestions', [QuestionaireController::class, 'questionaireQuestions']);
Route::post('/student/submit-answers', [QuestionaireController::class, 'submit_answers']);
Route::get('/student/questionaire/{questionaire}/getResult', [QuestionaireController::class, 'showResult']);
Route::post('/student/question/{question}/further', [QuestionsController::class, 'further']);
Route::post('/question/further/answer/{further}', [QuestionsController::class, 'furtherAnswer']);
Route::post('/student/explanation/reply/{explanation}', [CourseController::class, 'addReply']);
Route::post('/khateeb/explanation/reply/{reply}', [CourseController::class, 'answerReply']);

// Route who are about this line are Done Routes


// Route::patch('/khateeb/{questionaire}/update', [QuestionaireController::class, 'update']);
// Route::delete('/khateeb/{questionaire}/delete', [QuestionaireController::class, 'destroy']);

