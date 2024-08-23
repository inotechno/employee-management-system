<?php

use App\Http\Controllers\Api\AbsentController;
use App\Http\Controllers\Api\AccessControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SiteController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\VisitController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\PaidLeaveController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\SubmissionController;
use App\Http\Controllers\Api\DailyReportController;
use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\EventAttendanceController;
use App\Http\Controllers\Api\VisitCategoryController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // dd($request);
    return $request->user()->load('roles')->load('employee');
});

Route::post('/http-listening', [AccessControl::class, 'HttpListening']);

// Route If Not Logged In
Route::get('unauthorized', function () {
    return response()->json(['error' => 'Unauthorized.'], 401);
})->name('unauthorized');

Route::controller(LoginController::class)->group(function () {
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/visit/employee/{id}', [VisitController::class, 'employee']);
    Route::get('/attendance/employee/{id}', [AttendanceController::class, 'employee']);
    Route::get('/attendance/check/{id}', [AttendanceController::class, 'check_absen']);
    Route::get('/paid-leave/employee/{id}', [PaidLeaveController::class, 'employee']);
    Route::get('/absent/employee/{id}', [AbsentController::class, 'employee']);
    Route::get('/daily-report/employee/{id}', [DailyReportController::class, 'employee']);
    Route::get('/daily-report/last/{id}', [DailyReportController::class, 'last']);
    Route::get('/daily-report/users', [DailyReportController::class, 'daily_report_employees']);
    Route::post('/daily-report-comment/{id}', [CommentController::class, 'store']);
    Route::post('/profile/update/{id}', [ProfileController::class, 'update']);
    Route::post('/profile/change_password/{id}', [ProfileController::class, 'update_password']);
    Route::get('/submission/employee/{id}', [SubmissionController::class, 'employee']);
    Route::post('/submission/upload_receipt/{id}', [SubmissionController::class, 'upload_receipt']);

    Route::apiResource('employee', EmployeeController::class, array("as" => "api"));
    Route::apiResource('attendance', AttendanceController::class, array("as" => "api"));
    Route::apiResource('absent', AbsentController::class, array("as" => "api"));
    Route::apiResource('paid-leave', PaidLeaveController::class, array("as" => "api"));
    Route::apiResource('submission', SubmissionController::class, array("as" => "api"));
    Route::apiResource('daily-report', DailyReportController::class, array("as" => "api"));
    Route::apiResource('announcements', AnnouncementController::class, array("as" => "api"));
    Route::apiResource('visit', VisitController::class, array("as" => "api"));
    Route::apiResource('site', SiteController::class, array("as" => "api"));
    Route::apiResource('event', EventAttendanceController::class, array("as" => "api"));
    Route::apiResource('visit-category', VisitCategoryController::class, array("as" => "api"));

    Route::any('{segment}', function () {
        return response()->json([
            'success' => false,
            'message' => 'Bad request url.',
        ], 400);
    })->where('segment', '.*');
});
