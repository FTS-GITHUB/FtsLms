<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BuzzerController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ClassAllocateController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\CourseAssignToTeacherController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\IslamicShortStoryController;
use App\Http\Controllers\Api\MarkController;
use App\Http\Controllers\Api\MosqueController;
use App\Http\Controllers\Api\PrayerController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\QuranicController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\RoundController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WelfareController;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'middleware' => 'auth:sanctum',
], function () {
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/roles', RoleController::class);
    Route::apiResource('/blogs', BlogController::class);
    Route::apiResource('/books', BookController::class);

    Route::apiResource('/class_allocates', ClassAllocateController::class);
    Route::apiResource('/departments', DepartmentController::class);
    Route::apiResource('/categories', CategoryController::class);
    Route::apiResource('/teachers', TeacherController::class);

    Route::apiResource('/mosques', MosqueController::class);
    Route::apiResource('/prayers', PrayerController::class);
    Route::apiResource('/courses', CourseController::class);

    Route::apiResource('/students', StudentController::class);
    Route::apiResource('/welfares', WelfareController::class);
    Route::apiResource('/quranics', QuranicController::class);

    Route::apiResource('/questions', QuestionController::class);
    Route::apiResource('/buzzers', BuzzerController::class);
    Route::post('/buzzers-results', [BuzzerController::class, 'buzzers_results']);

    Route::post('/quize-game', [QuestionController::class, 'games']);

    Route::post('/result', [QuestionController::class, 'result']);

    Route::apiResource('/events', EventController::class);
    Route::apiResource('/rounds', RoundController::class);
    Route::apiResource('/teams', TeamController::class);

    Route::apiResource('/marks', MarkController::class);

    Route::apiResource('/course_assign_to_teachers', CourseAssignToTeacherController::class);
    Route::get('/free_courses', [CourseController::class, 'freeCourse']);

    Route::get('/pro_courses', [CourseController::class, 'proCourse']);
    Route::apiResource('/islamic_short_stories', IslamicShortStoryController::class);
    Route::post('/replies', [CommentController::class, 'replies']);
    Route::apiResource('/comments', CommentController::class)->only([
        'index', 'store',
    ]);
    Route::post('/approved/{id}', [BlogController::class, 'approved']);
});
