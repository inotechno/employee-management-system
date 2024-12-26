<?php

use App\Http\Controllers\Admin\AbsentController;
use App\Http\Controllers\IClockController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;

//ADMIN
use App\Http\Controllers\Admin\MachineController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\PaidLeaveController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\DailyReportController;
use App\Http\Controllers\Admin\SallarySlipController;
use App\Http\Controllers\Admin\UserSettingController;
use App\Http\Controllers\Admin\ImportEmployeeController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\Admin\VisitController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SubmissionController;
use App\Http\Controllers\Admin\AnnouncementController;

//HRD
use App\Http\Controllers\Hrd\SiteController as HrdSiteController;
use App\Http\Controllers\Hrd\EmployeeController as HrdEmployeeController;
use App\Http\Controllers\Hrd\PositionController as HrdPositionController;
use App\Http\Controllers\Hrd\DashboardController as HrdDashboardController;
use App\Http\Controllers\Hrd\PaidLeaveController as HrdPaidLeaveController;
use App\Http\Controllers\Hrd\AbsentController as HrdAbsentController;
use App\Http\Controllers\Hrd\AttendanceController as HrdAttendanceController;
use App\Http\Controllers\Hrd\AttendanceTemporaryController as HrdAttendanceTemporaryController;
use App\Http\Controllers\Hrd\DailyReportController as HrdDailyReportController;
use App\Http\Controllers\Hrd\AnnouncementController as HrdAnnouncementController;

//FINANCE
use App\Http\Controllers\Finance\CommentController as HrdCommentController;
use App\Http\Controllers\Finance\DailyReportController as FinanceDailyReportController;
use App\Http\Controllers\Finance\DashboardController as FinanceDashboardController;
use App\Http\Controllers\Finance\AttendanceController as FinanceAttendanceController;
use App\Http\Controllers\Finance\SallarySlipController as FinanceSallarySlipController;
use App\Http\Controllers\Finance\SubmissionController as FinanceSubmissionController;

//EMPLOYEE
use App\Http\Controllers\Employee\DashboardController  as EmployeeDashboardController;
use App\Http\Controllers\Employee\PaidLeaveController  as EmployeePaidLeaveController;
use App\Http\Controllers\Employee\AbsentController  as EmployeeAbsentController;
use App\Http\Controllers\Employee\AttendanceController as EmployeeAttendanceController;
use App\Http\Controllers\Employee\DailyReportController as EmployeeDailyReportController;
use App\Http\Controllers\Employee\SallarySlipController as EmployeeSallarySlipController;
use App\Http\Controllers\Employee\CommentController as EmployeeCommentController;
use App\Http\Controllers\Employee\ProfileController  as EmployeeProfileController;
use App\Http\Controllers\Employee\SubmissionController as EmployeeSubmissionController;

//DIRECTOR
use App\Http\Controllers\Director\DashboardController as DirectorDashboardController;
use App\Http\Controllers\Director\AttendanceController as DirectorAttendanceController;
use App\Http\Controllers\Director\DailyReportController as DirectorDailyReportController;
use App\Http\Controllers\Director\EmployeeController as DirectorEmployeeController;
use App\Http\Controllers\Director\SiteController as DirectorSiteController;
use App\Http\Controllers\Director\PaidLeaveController as DirectorPaidLeaveController;
use App\Http\Controllers\Director\AbsentController as DirectorAbsentController;
use App\Http\Controllers\Director\SallarySlipController as DirectorSallarySlipController;
use App\Http\Controllers\Director\VisitController as DirectorVisitController;
use App\Http\Controllers\EmployeeController as ControllersEmployeeController;
use App\Http\Controllers\Director\SubmissionController as DirectorSubmissionController;
use App\Http\Controllers\Employee\VisitController as EmployeeVisitController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ReminderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/send-account', [ControllersEmployeeController::class, 'send_account']);
Route::get('/send-reminder', [ControllersEmployeeController::class, 'reminder']);
Route::get('/send', function () {
    $input['email'] = 'achmad.fatoni@mindotek.com';
    $input['name'] = 'Ahmad Fatoni';
    $input['username'] = '20221224';
    $input['password'] = '20221224';

    return view('email.send_account', $input);
});


Route::group(['middleware' => ['guest']], function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticated'])->name('login.process');

    //Forgot password
    Route::get('/forgot_password', [PasswordResetController::class, 'showForgetPasswordForm'])->name('forgot.password.get');
    Route::post('/forgot_password', [PasswordResetController::class, 'submitForgetPasswordForm'])->name('forgot.password.post');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('/reset-password', [PasswordResetController::class, 'submitResetPasswordForm'])->name('reset.password.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Report Route
Route::get('/report/attendance', [ReportController::class, 'attendance'])->name('report.attendance')->middleware('auth');
Route::get('/report/attendance/preview', [ReportController::class, 'preview_attendance'])->name('report.attendance.preview')->middleware('auth');
Route::post('/report/attendance', [ReportController::class, 'download_attendance'])->name('report.attendance.download')->middleware('auth');

// Report Route
Route::get('/report/daily_report', [ReportController::class, 'daily_report'])->name('report.daily_report')->middleware('auth');
Route::get('/report/daily_report/preview', [ReportController::class, 'preview_daily_report'])->name('report.daily_report.preview')->middleware('auth');
Route::post('/report/daily_report', [ReportController::class, 'download_daily_report'])->name('report.daily_report.download')->middleware('auth');

// Report Route
Route::get('/report/paid_leave', [ReportController::class, 'paid_leave'])->name('report.paid_leave')->middleware('auth');
Route::get('/report/paid_leave/preview', [ReportController::class, 'preview_paid_leave'])->name('report.paid_leave.preview')->middleware('auth');
Route::post('/report/paid_leave', [ReportController::class, 'download_paid_leave'])->name('report.paid_leave.download')->middleware('auth');

// Report Route
Route::get('/report/absent', [ReportController::class, 'absent'])->name('report.absent')->middleware('auth');
Route::get('/report/absent/preview', [ReportController::class, 'preview_absent'])->name('report.absent.preview')->middleware('auth');
Route::post('/report/absent', [ReportController::class, 'download_absent'])->name('report.absent.download')->middleware('auth');

// Report Route
Route::get('/report/submission', [ReportController::class, 'submission'])->name('report.submission')->middleware('auth');
Route::get('/report/submission/preview', [ReportController::class, 'preview_submission'])->name('report.submission.preview')->middleware('auth');
Route::post('/report/submission', [ReportController::class, 'download_submission'])->name('report.submission.download')->middleware('auth');

//importdata Route
Route::get('/importdata', [ImportEmployeeController::class, 'upload'])->name('import_data.employee');
Route::post('/importdata/preview-upload', [ImportEmployeeController::class, 'preview_upload'])->name('import_data.preview_process');
Route::get('/importdata/template', [ImportEmployeeController::class, 'download_template'])->name('import_data.template');
Route::get('/importdata/template/insert', [ImportEmployeeController::class, 'download_template_insert'])->name('import_data.template.insert');
Route::put('/importdata/upload', [ImportEmployeeController::class, 'process_upload'])->name('import_data.upload_process');

Route::get('/attendances/sync', [AttendanceController::class, 'sync'])->name('attendances.sync');
Route::get('/employees/sync', [EmployeeController::class, 'sync'])->name('employees.sync');

Route::get('/iclock/cdata', [IClockController::class, 'handshake']);
Route::post('/iclock/cdata', [IClockController::class, 'receiveRecords']);

Route::get('/iclock/test', [IClockController::class, 'test']);
Route::get('/iclock/getrequest', [IClockController::class, 'getrequest']);

// daily Report Route
Route::get('/daily-report', [DirectorDailyReportController::class, 'index'])->name('daily_reports.all');
Route::get('/daily-report/show/{id}', [DirectorDailyReportController::class, 'show'])->name('daily_reports.show.all');
Route::post('/daily-report/datatable', [DirectorDailyReportController::class, 'datatable'])->name('daily_reports.datatable.all');
Route::post('/daily-report-comment/{id}', [DirectorDailyReportController::class, 'store'])->name('daily_report_comment.all');

Route::get('/paid-leaves', [EmployeePaidLeaveController::class, 'paid_leaves_index'])->name('paid_leaves.all');
Route::get('/paid-leaves/show/{id}', [EmployeePaidLeaveController::class, 'paid_leaves_show'])->name('paid_leaves.show.all');
Route::get('/paid-leaves/datatable', [EmployeePaidLeaveController::class, 'paid_leaves_datatable'])->name('paid_leaves.datatable.all');
Route::put('/paid-leaves/validation/{id}', [EmployeePaidLeaveController::class, 'paid_leaves_validation'])->name('paid_leaves.validation.all');
Route::put('/paid-leaves/rejection/{id}', [EmployeePaidLeaveController::class, 'paid_leaves_rejection'])->name('paid_leaves.rejection.all');

Route::get('/submissions', [EmployeeSubmissionController::class, 'submissions_index'])->name('submissions.all');
Route::get('/submissions/show/{id}', [EmployeeSubmissionController::class, 'submissions_show'])->name('submissions.show.all');
Route::post('/submissions/datatable', [EmployeeSubmissionController::class, 'submissions_datatable'])->name('submissions.datatable.all');
Route::put('/submissions/validation/{id}', [EmployeeSubmissionController::class, 'submissions_validation'])->name('submissions.validation.all');
Route::put('/submissions/rejection/{id}', [EmployeeSubmissionController::class, 'submissions_rejection'])->name('submissions.rejection.all');

Route::get('/reminders', [ReminderController::class, 'index'])->name('reminders');
Route::post('/reminders/datatable', [ReminderController::class, 'datatable'])->name('reminders.datatable');

Route::post('/media/store', [MediaController::class, 'index'])->name('media.store');
// Route Admin
Route::group(['middleware' => ['role:administrator', 'auth'], 'prefix' => 'admin'], function () {

    // Dashboard Route
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('administrator.dashboard');

    // Machine Routes
    Route::get('/machines', [MachineController::class, 'index'])->name('machines');
    Route::post('/machines', [MachineController::class, 'store'])->name('machines.store');
    Route::get('/machines/create', [MachineController::class, 'create'])->name('machines.create');
    Route::get('/machines/edit/{id}', [MachineController::class, 'edit'])->name('machines.edit');
    Route::put('/machines/edit/{id}', [MachineController::class, 'update'])->name('machines.update');
    Route::put('/machines/active/{id}', [MachineController::class, 'active'])->name('machines.active');
    Route::delete('/machines/delete/{id}', [MachineController::class, 'destroy'])->name('machines.delete');
    Route::get('/machines/datatable', [MachineController::class, 'datatable'])->name('machines.datatable');


    // Position Routes
    Route::get('/positions', [PositionController::class, 'index'])->name('positions');
    Route::post('/positions', [PositionController::class, 'store'])->name('positions.store');
    Route::get('/positions/create', [PositionController::class, 'create'])->name('positions.create');
    Route::get('/positions/edit/{id}', [PositionController::class, 'edit'])->name('positions.edit');
    Route::put('/positions/edit/{id}', [PositionController::class, 'update'])->name('positions.update');
    Route::delete('/positions/delete/{id}', [PositionController::class, 'destroy'])->name('positions.delete');
    Route::post('/positions/datatable', [PositionController::class, 'datatable'])->name('positions.datatable');

    // Users Route
    Route::get('/pegawai', [UserSettingController::class, 'index'])->name('pegawai');
    Route::post('/pegawai', [UserSettingController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/create', [UserSettingController::class, 'create'])->name('pegawai.create');
    Route::get('/pegawai/edit/{id}', [UserSettingController::class, 'edit'])->name('pegawai.edit');
    Route::put('/pegawai/edit/{id}', [UserSettingController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/delete/{id}', [UserSettingController::class, 'destroy'])->name('pegawai.delete');
    Route::post('/pegawai/datatable', [UserSettingController::class, 'datatable'])->name('pegawai.datatable');

    // Employee Ruote
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::get('/employees/edit/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/edit/{id}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/delete/{id}', [EmployeeController::class, 'destroy'])->name('employees.delete');
    Route::post('/employees/datatable', [EmployeeController::class, 'datatable'])->name('employees.datatable');

    // Attendance Ruote
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances');
    Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
    Route::get('/attendances/create', [AttendanceController::class, 'create'])->name('attendances.create');
    Route::get('/attendances/edit/{id}', [AttendanceController::class, 'edit'])->name('attendances.edit');
    Route::put('/attendances/edit/{id}', [AttendanceController::class, 'update'])->name('attendances.update');
    Route::delete('/attendances/delete/{id}', [AttendanceController::class, 'destroy'])->name('attendances.delete');
    Route::post('/attendances/datatable', [AttendanceController::class, 'datatable'])->name('attendances.datatable');

    // Route::get('/attendances/datatable', [AttendanceController::class, 'datatable'])->name('attendances.datatable');

    // Daily Report Route
    Route::get('/daily-report', [DailyReportController::class, 'index'])->name('daily_reports');
    Route::post('/daily-report/datatable', [DailyReportController::class, 'datatable'])->name('daily_reports.datatable');
    Route::get('/daily-report/create', [DailyReportController::class, 'create'])->name('daily_reports.create');
    Route::post('/daily-report/store', [DailyReportController::class, 'store'])->name('daily_reports.store');
    Route::get('/daily-report/edit/{id}', [DailyReportController::class, 'edit'])->name('daily_reports.edit');
    Route::put('/daily-report/edit/{id}', [DailyReportController::class, 'update'])->name('daily_reports.update');
    Route::delete('/daily-report/delete/{id}', [DailyReportController::class, 'destroy'])->name('daily_reports.delete');
    Route::get('/daily-report/show/{id}', [DailyReportController::class, 'show'])->name('daily_reports.show');

    // Paid Leave Route
    Route::get('/paid-leave', [PaidLeaveController::class, 'index'])->name('paid_leaves');
    Route::get('/paid-leave/datatable', [PaidLeaveController::class, 'datatable'])->name('paid_leaves.datatable');
    Route::get('/paid-leave/create', [PaidLeaveController::class, 'create'])->name('paid_leaves.create');
    Route::post('/paid-leave/store', [PaidLeaveController::class, 'store'])->name('paid_leaves.store');
    Route::get('/paid-leave/edit/{id}', [PaidLeaveController::class, 'edit'])->name('paid_leaves.edit');
    Route::put('/paid-leave/edit/{id}', [PaidLeaveController::class, 'update'])->name('paid_leaves.update');
    Route::delete('/paid-leave/delete/{id}', [PaidLeaveController::class, 'destroy'])->name('paid_leaves.delete');
    Route::get('/paid-leave/show/{id}', [PaidLeaveController::class, 'show'])->name('paid_leaves.show');

    // Submission Route
    Route::get('/submission', [SubmissionController::class, 'index'])->name('submission');
    Route::post('/submission/datatable', [SubmissionController::class, 'datatable'])->name('submission.datatable');
    Route::delete('/submission/delete/{id}', [SubmissionController::class, 'destroy'])->name('submission.delete');
    Route::get('/submission/show/{id}', [SubmissionController::class, 'show'])->name('submission.show');

    // Site Route
    Route::get('/sites', [SiteController::class, 'index'])->name('sites');
    Route::get('/sites/create', [SiteController::class, 'create'])->name('sites.create');
    // Route::get('/sites/generate', [SiteController::class, 'generate'])->name('sites.generate');
    // Route::get('/sites/print', [SiteController::class, 'print'])->name('sites.print');
    Route::post('/sites/store', [SiteController::class, 'store'])->name('sites.store');
    Route::get('/sites/edit/{id}', [SiteController::class, 'edit'])->name('sites.edit');
    Route::put('/sites/edit/{id}', [SiteController::class, 'update'])->name('sites.update');
    Route::post('/sites/datatable', [SiteController::class, 'datatable'])->name('sites.datatable');
    Route::delete('/sites/delete/{id}', [SiteController::class, 'destroy'])->name('sites.delete');

    // Visit Route
    Route::get('/visits', [VisitController::class, 'index'])->name('visits');
    Route::get('/visits/detail', [VisitController::class, 'detail'])->name('visits.detail');
    Route::get('/visit/employee', [VisitController::class, 'employee'])->name('visit.employees');
    Route::get('/visit/site', [VisitController::class, 'site'])->name('visit.sites');
    Route::post('/visits/datatable', [VisitController::class, 'datatable'])->name('visits.datatable');
    Route::post('/visit/datatable/employees', [VisitController::class, 'datatable_employees'])->name('visit.datatable.employees');
    Route::post('/visit/datatable/sites', [VisitController::class, 'datatable_sites'])->name('visit.datatable.sites');

    // Slip Gaji Route
    Route::get('/sallary-slip/history', [SallarySlipController::class, 'history'])->name('sallary_slip.history');
    Route::post('/sallary-slip/datatable', [SallarySlipController::class, 'datatable'])->name('sallary_slip.datatable');

    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::get('/announcements/edit/{id}', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/edit/{id}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/delete/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.delete');
    Route::post('/announcements/datatable', [AnnouncementController::class, 'datatable'])->name('announcements.datatable');
    Route::get('/announcements/send/{id}', [AnnouncementController::class, 'send'])->name('announcements.send');

    // Absent Route
    Route::get('/absents', [AbsentController::class, 'index'])->name('absents');
    Route::get('/absents/create', [AbsentController::class, 'create'])->name('absents.create');
    Route::post('/absents/store', [AbsentController::class, 'store'])->name('absents.store');
    Route::get('/absents/edit/{id}', [AbsentController::class, 'edit'])->name('absents.edit');
    Route::put('/absents/edit/{id}', [AbsentController::class, 'update'])->name('absents.update');
    Route::delete('/absents/delete/{id}', [AbsentController::class, 'destroy'])->name('absents.delete');
    Route::post('/absents/datatable', [AbsentController::class, 'datatable'])->name('absents.datatable');
    Route::post('/absents/upload', [AbsentController::class, 'upload'])->name('absents.upload');
});

// Route Employee
Route::group(['middleware' => ['role:employee', 'auth'], 'prefix' => 'employee'], function () {

    // Dashboard Route
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');

    // Attendance Ruote
    Route::get('/attendances', [EmployeeAttendanceController::class, 'index'])->name('attendances.employee');
    Route::get('/attendances/location', [EmployeeAttendanceController::class, 'current_location'])->name('attendance.location');
    Route::post('/attendances/datatable', [EmployeeAttendanceController::class, 'datatable'])->name('attendances.datatable.employee');
    Route::post('/attendances/create', [EmployeeAttendanceController::class, 'store'])->name('attendance.employee.create');

    // Paid Leave Route
    Route::get('/paid-leave', [EmployeePaidLeaveController::class, 'index'])->name('paid_leaves.employee');
    Route::get('/paid-leave/create', [EmployeePaidLeaveController::class, 'create'])->name('paid_leaves.create.employee');
    Route::post('/paid-leave/store', [EmployeePaidLeaveController::class, 'store'])->name('paid_leaves.store.employee');
    Route::get('/paid-leave/edit/{id}', [EmployeePaidLeaveController::class, 'edit'])->name('paid_leaves.edit.employee');
    Route::put('/paid-leave/edit/{id}', [EmployeePaidLeaveController::class, 'update'])->name('paid_leaves.update.employee');
    Route::delete('/paid-leave/delete/{id}', [EmployeePaidLeaveController::class, 'destroy'])->name('paid_leaves.delete.employee');
    Route::post('/paid-leave/datatable', [EmployeePaidLeaveController::class, 'datatable'])->name('paid_leaves.datatable.employee');

    // Absent Route
    Route::get('/absents', [EmployeeAbsentController::class, 'index'])->name('absents.employee');
    Route::get('/absents/create', [EmployeeAbsentController::class, 'create'])->name('absents.create.employee');
    Route::post('/absents/store', [EmployeeAbsentController::class, 'store'])->name('absents.store.employee');
    Route::get('/absents/edit/{id}', [EmployeeAbsentController::class, 'edit'])->name('absents.edit.employee');
    Route::put('/absents/edit/{id}', [EmployeeAbsentController::class, 'update'])->name('absents.update.employee');
    Route::delete('/absents/delete/{id}', [EmployeeAbsentController::class, 'destroy'])->name('absents.delete.employee');
    Route::post('/absents/datatable', [EmployeeAbsentController::class, 'datatable'])->name('absents.datatable.employee');
    Route::post('/absents/upload', [EmployeeAbsentController::class, 'upload'])->name('absents.upload.employee');

    // Submissions Route
    Route::get('/submission', [EmployeeSubmissionController::class, 'index'])->name('submission.employee');
    Route::get('/submission/create', [EmployeeSubmissionController::class, 'create'])->name('submission.create.employee');
    Route::get('/submission/send_email/{id}', [EmployeeSubmissionController::class, 'email_submission'])->name('submission.send_email.employee');
    Route::post('/submission/send_submission/{id}', [EmployeeSubmissionController::class, 'send_submission_email'])->name('submission.send_submission.employee');
    Route::post('/submission/store', [EmployeeSubmissionController::class, 'store'])->name('submission.store.employee');
    Route::post('/submission/upload_receipt/{id}', [EmployeeSubmissionController::class, 'upload_receipt'])->name('submission.upload_receipt.employee');
    Route::get('/submission/edit/{id}', [EmployeeSubmissionController::class, 'edit'])->name('submission.edit.employee');
    Route::put('/submission/edit/{id}', [EmployeeSubmissionController::class, 'update'])->name('submission.update.employee');
    Route::delete('/submission/delete/{id}', [EmployeeSubmissionController::class, 'destroy'])->name('submission.delete.employee');
    Route::post('/submission/datatable', [EmployeeSubmissionController::class, 'datatable'])->name('submission.datatable.employee');

    // Paid Leave Route
    Route::get('/daily-report', [EmployeeDailyReportController::class, 'index'])->name('daily_reports.employee');
    Route::get('/daily-report/create', [EmployeeDailyReportController::class, 'create'])->name('daily_reports.create.employee');
    Route::get('/daily-report/send_email/{id}', [EmployeeDailyReportController::class, 'send_email'])->name('daily_reports.send_email.employee');
    Route::post('/daily-report/send_daily_report/{id}', [EmployeeDailyReportController::class, 'send_daily_email'])->name('daily_reports.send_daily.employee');
    Route::post('/daily-report/store', [EmployeeDailyReportController::class, 'store'])->name('daily_reports.store.employee');
    Route::get('/daily-report/show/{id}', [EmployeeDailyReportController::class, 'show'])->name('daily_reports.show.employee');
    Route::get('/daily-report/edit/{id}', [EmployeeDailyReportController::class, 'edit'])->name('daily_reports.edit.employee');
    Route::put('/daily-report/edit/{id}', [EmployeeDailyReportController::class, 'update'])->name('daily_reports.update.employee');
    Route::delete('/daily-report/delete/{id}', [EmployeeDailyReportController::class, 'destroy'])->name('daily_reports.delete.employee');
    Route::post('/daily-report/datatable', [EmployeeDailyReportController::class, 'datatable'])->name('daily_reports.datatable.employee');

    // Comment Route
    Route::post('/daily-report-comment/{id}', [EmployeeCommentController::class, 'store'])->name('daily_report_comment.employee');

    // Attendance Ruote
    Route::get('/sallary_slip', [EmployeeSallarySlipController::class, 'index'])->name('sallary_slip.employee');
    Route::get('/sallary_slip/export/{id}', [EmployeeSallarySlipController::class, 'export'])->name('sallary_slip.export.employee');
    Route::post('/sallary_slip/datatable', [EmployeeSallarySlipController::class, 'datatable'])->name('sallary_slip.datatable.employee');

    //profile route
    Route::get('/profile', [EmployeeProfileController::class, 'index'])->name('users.employee');
    Route::get('/profile/edit/{id}', [EmployeeProfileController::class, 'edit'])->name('users.edit.employee');
    Route::put('/profile/edit/{id}', [EmployeeProfileController::class, 'update'])->name('users.update.employee');
    Route::put('/profile/change_password/{id}', [EmployeeProfileController::class, 'update_password'])->name('users.update.password.employee');

    // Visit Route
    Route::get('/visits', [EmployeeVisitController::class, 'index'])->name('visits.employee');
    Route::post('/visits', [EmployeeVisitController::class, 'store'])->name('visits.store.employee');
    Route::post('/visits/datatable', [EmployeeVisitController::class, 'datatable'])->name('visits.datatable.employee');
    Route::post('/visits/upload', [EmployeeVisitController::class, 'upload'])->name('visits.upload.employee');

    // Site
    Route::get('/site', [EmployeeVisitController::class, 'getSite'])->name('visits.get_site.employee');
    Route::get('/distance', [EmployeeVisitController::class, 'getDistance'])->name('visits.get_distance.employee');
});

// Route HRD
Route::group(['middleware' => ['role:hrd', 'auth'], 'prefix' => 'hrd'], function () {

    // Dashboard route
    Route::get('/dashboard', [HrdDashboardController::class, 'index'])->name('hrd.dashboard');

    // Position Routes
    Route::get('/positions', [HrdPositionController::class, 'index'])->name('positions.hrd');
    Route::post('/positions', [HrdPositionController::class, 'store'])->name('positions.store.hrd');
    Route::get('/positions/create', [HrdPositionController::class, 'create'])->name('positions.create.hrd');
    Route::get('/positions/edit/{id}', [HrdPositionController::class, 'edit'])->name('positions.edit.hrd');
    Route::put('/positions/edit/{id}', [HrdPositionController::class, 'update'])->name('positions.update.hrd');
    Route::delete('/positions/delete/{id}', [HrdPositionController::class, 'destroy'])->name('positions.delete.hrd');
    Route::post('/positions/datatable', [HrdPositionController::class, 'datatable'])->name('positions.datatable.hrd');

    // Employee Ruote
    Route::get('/employees', [HrdEmployeeController::class, 'index'])->name('employees.hrd');
    Route::post('/employees', [HrdEmployeeController::class, 'store'])->name('employees.store.hrd');
    Route::get('/employees/sync', [HrdEmployeeController::class, 'sync'])->name('employees.sync.hrd');
    Route::get('/employees/create', [HrdEmployeeController::class, 'create'])->name('employees.create.hrd');
    Route::get('/employees/edit/{id}', [HrdEmployeeController::class, 'edit'])->name('employees.edit.hrd');
    Route::put('/employees/edit/{id}', [HrdEmployeeController::class, 'update'])->name('employees.update.hrd');
    Route::post('/employees/datatable', [HrdEmployeeController::class, 'datatable'])->name('employees.datatable.hrd');

    // Paid Leave Route
    Route::get('/paid-leave', [HrdPaidLeaveController::class, 'index'])->name('paid_leaves.hrd');
    Route::post('/paid-leave/datatable', [HrdPaidLeaveController::class, 'datatable'])->name('paid_leaves.datatable.hrd');
    Route::put('/paid-leave/validation/{id}', [HrdPaidLeaveController::class, 'validation'])->name('paid_leaves.validation.hrd');
    Route::put('/paid-leave/rejection/{id}', [HrdPaidLeaveController::class, 'rejection'])->name('paid_leaves.rejection.hrd');
    Route::delete('/paid-leave/delete/{id}', [HrdPaidLeaveController::class, 'destroy'])->name('paid_leaves.delete.hrd');
    Route::get('/paid-leave/show/{id}', [HrdPaidLeaveController::class, 'show'])->name('paid_leaves.show.hrd');

    // Absent Route
    Route::get('/absent', [HrdAbsentController::class, 'index'])->name('absents.hrd');
    Route::get('/absent/datatable', [HrdAbsentController::class, 'datatable'])->name('absents.datatable.hrd');
    Route::put('/absent/validation/{id}', [HrdAbsentController::class, 'validation'])->name('absents.validation.hrd');
    Route::put('/absent/rejection/{id}', [HrdAbsentController::class, 'rejection'])->name('absents.rejection.hrd');
    Route::delete('/absent/delete/{id}', [HrdAbsentController::class, 'destroy'])->name('absents.delete.hrd');

    // Attendance Ruote
    Route::get('/attendances', [HrdAttendanceController::class, 'index'])->name('attendances.hrd');
    Route::post('/attendances/datatable', [HrdAttendanceController::class, 'datatable'])->name('attendances.datatable.hrd');
    Route::get('/attendances/sync', [HrdAttendanceController::class, 'sync'])->name('attendances.sync.hrd');

    // Attendance Temporary Ruote
    Route::get('/attendances-temporary', [HrdAttendanceTemporaryController::class, 'index'])->name('attendances.temporary.hrd');
    Route::post('/attendances-temporary/datatable', [HrdAttendanceTemporaryController::class, 'datatable'])->name('attendances.temporary.datatable.hrd');
    Route::put('/attendances-temporary/validation/{id}', [HrdAttendanceTemporaryController::class, 'validation'])->name('attendances.temporary.validation.hrd');

    // Daily Report Route
    Route::get('/daily-report', [HrdDailyReportController::class, 'index'])->name('daily_reports.hrd');
    Route::get('/daily-report/show/{id}', [HrdDailyReportController::class, 'show'])->name('daily_reports.show.hrd');
    Route::post('/daily-report/datatable', [HrdDailyReportController::class, 'datatable'])->name('daily_reports.datatable.hrd');
    Route::post('/daily-report-comment/{id}', [HrdCommentController::class, 'store'])->name('daily_report_comment.hrd');

    // Announcement Route
    Route::get('/announcements', [HrdAnnouncementController::class, 'index'])->name('announcements.hrd');
    Route::post('/announcements', [HrdAnnouncementController::class, 'store'])->name('announcements.store.hrd');
    Route::get('/announcements/create', [HrdAnnouncementController::class, 'create'])->name('announcements.create.hrd');
    Route::get('/announcements/edit/{id}', [HrdAnnouncementController::class, 'edit'])->name('announcements.edit.hrd');
    Route::put('/announcements/edit/{id}', [HrdAnnouncementController::class, 'update'])->name('announcements.update.hrd');
    Route::delete('/announcements/delete/{id}', [HrdAnnouncementController::class, 'destroy'])->name('announcements.delete.hrd');
    Route::post('/announcements/datatable', [HrdAnnouncementController::class, 'datatable'])->name('announcements.datatable.hrd');

    // Site Route
    // Route::get('/sites', [HrdSiteController::class, 'index'])->name('sites.hrd');
    // Route::get('/sites/create', [HrdSiteController::class, 'create'])->name('sites.create.hrd');
    // Route::post('/sites/store', [HrdSiteController::class, 'store'])->name('sites.store.hrd');
    // Route::get('/sites/edit/{id}', [HrdSiteController::class, 'edit'])->name('sites.edit.hrd');
    // Route::put('/sites/edit/{id}', [HrdSiteController::class, 'update'])->name('sites.update.hrd');
    // Route::post('/sites/datatable', [HrdSiteController::class, 'datatable'])->name('sites.datatable.hrd');
    // Route::delete('/sites/delete/{id}', [HrdSiteController::class, 'destroy'])->name('sites.delete.hrd');
});

// Route Finance
Route::group(['middleware' => ['role:finance', 'auth'], 'prefix' => 'finance'], function () {

    // Dashboard route
    Route::get('/dashboard', [FinanceDashboardController::class, 'index'])->name('finance.dashboard');

    // Attendance Ruote
    Route::get('/attendances', [FinanceAttendanceController::class, 'index'])->name('attendances.finance');
    Route::post('/attendances/datatable', [FinanceAttendanceController::class, 'datatable'])->name('attendances.datatable.finance');

    // Daily Report Route
    Route::get('/daily-report', [FinanceDailyReportController::class, 'index'])->name('daily_reports.finance');
    Route::get('/daily-report/show/{id}', [FinanceDailyReportController::class, 'show'])->name('daily_reports.show.finance');
    Route::post('/daily-report/datatable', [FinanceDailyReportController::class, 'datatable'])->name('daily_reports.datatable.finance');

    // Sallary Slip Route
    Route::get('/sallary-slip/upload', [FinanceSallarySlipController::class, 'upload'])->name('sallary_slip.upload.finance');
    Route::get('/sallary-slip/history', [FinanceSallarySlipController::class, 'history'])->name('sallary_slip.history.finance');
    Route::get('/sallary-slip/template', [FinanceSallarySlipController::class, 'download_template'])->name('sallary_slip.template.finance');
    Route::delete('/sallary-slip/delete/{id}', [FinanceSallarySlipController::class, 'destroy'])->name('sallary_slip.history.delete');
    Route::post('/sallary-slip/preview-upload', [FinanceSallarySlipController::class, 'preview_upload'])->name('sallary_slip.preview_process.finance');
    Route::post('/sallary-slip/upload', [FinanceSallarySlipController::class, 'process_upload'])->name('sallary_slip.upload_process.finance');
    Route::post('/sallary-slip/datatable', [FinanceSallarySlipController::class, 'datatable'])->name('sallary_slip.datatable.finance');

    // Submissions Route
    Route::get('/submission', [FinanceSubmissionController::class, 'index'])->name('submission.finance');
    Route::put('/submission/validation/{id}', [FinanceSubmissionController::class, 'validation'])->name('submission.validation.finance');
    Route::put('/submission/rejection/{id}', [FinanceSubmissionController::class, 'rejection'])->name('submission.rejection.finance');
    Route::post('/submission/datatable', [FinanceSubmissionController::class, 'datatable'])->name('submission.datatable.finance');
    Route::get('/submission/show/{id}', [FinanceSubmissionController::class, 'show'])->name('submission.show.finance');

    // Comment Route
    // Route::post('/daily-report-comment/{id}', [FinanceCommentController::class, 'store'])->name('daily_report_comment.finance');
});

// Route Director
Route::group(['middleware' => ['role:director', 'auth'], 'prefix' => 'director'], function () {

    Route::get('/dashboard', [DirectorDashboardController::class, 'index'])->name('director.dashboard');

    // Attendance Ruote
    Route::get('/attendances', [DirectorAttendanceController::class, 'index'])->name('attendances.director');
    Route::post('/attendances/datatable', [DirectorAttendanceController::class, 'datatable'])->name('attendances.datatable.director');

    // Not Attendance
    Route::get('/not-present', [DirectorAttendanceController::class, 'not_present'])->name('not_present.director');
    Route::post('/not-present/datatable', [DirectorAttendanceController::class, 'not_present_datatable'])->name('not_present.datatable.director');

    // Employee Ruote
    Route::get('/employees', [DirectorEmployeeController::class, 'index'])->name('employees.director');
    Route::post('/employees/datatable', [DirectorEmployeeController::class, 'datatable'])->name('employees.datatable.director');

    // Site Route
    Route::get('/sites', [DirectorSiteController::class, 'index'])->name('sites.director');
    Route::post('/sites/datatable', [DirectorSiteController::class, 'datatable'])->name('sites.datatable.director');

    // Paid Leave Route
    Route::get('/paid-leave', [DirectorPaidLeaveController::class, 'index'])->name('paid_leaves.director');
    Route::get('/paid-leave/datatable', [DirectorPaidLeaveController::class, 'datatable'])->name('paid_leaves.datatable.director');
    Route::put('/paid-leave/validation/{id}', [DirectorPaidLeaveController::class, 'validation'])->name('paid_leaves.validation.director');
    Route::put('/paid-leave/rejection/{id}', [DirectorPaidLeaveController::class, 'rejection'])->name('paid_leaves.rejection.director');
    Route::delete('/paid-leave/delete/{id}', [DirectorPaidLeaveController::class, 'destroy'])->name('paid_leaves.delete.director');
    Route::get('/paid-leave/show/{id}', [DirectorPaidLeaveController::class, 'show'])->name('paid_leaves.show.director');

    // Absent Route
    Route::get('/absent', [DirectorAbsentController::class, 'index'])->name('absents.director');
    Route::get('/absent/datatable', [DirectorAbsentController::class, 'datatable'])->name('absents.datatable.director');
    Route::put('/absent/validation/{id}', [DirectorAbsentController::class, 'validation'])->name('absents.validation.director');
    Route::put('/absent/rejection/{id}', [DirectorAbsentController::class, 'rejection'])->name('absents.rejection.director');
    Route::delete('/absent/delete/{id}', [DirectorAbsentController::class, 'destroy'])->name('absents.delete.director');

    // Submissions Route
    Route::get('/submission', [DirectorSubmissionController::class, 'index'])->name('submission.director');
    Route::put('/submission/validation/{id}', [DirectorSubmissionController::class, 'validation'])->name('submission.validation.director');
    Route::put('/submission/pending/{id}', [DirectorSubmissionController::class, 'pending'])->name('submission.pending.director');
    Route::put('/submission/rejection/{id}', [DirectorSubmissionController::class, 'rejection'])->name('submission.rejection.director');
    Route::post('/submission/datatable', [DirectorSubmissionController::class, 'datatable'])->name('submission.datatable.director');
    Route::get('/submission/show/{id}', [DirectorSubmissionController::class, 'show'])->name('submission.show.director');

    // Slip Gaji Route
    Route::get('/sallary-slip/history', [DirectorSallarySlipController::class, 'history'])->name('sallary_slip.history.director');
    Route::post('/sallary-slip/datatable', [DirectorSallarySlipController::class, 'datatable'])->name('sallary_slip.datatable.director');

    // Visit Route
    Route::get('/visits', [DirectorVisitController::class, 'index'])->name('visits.director');
    Route::get('/visits/detail', [DirectorVisitController::class, 'detail'])->name('visits.director.detail');
    Route::get('/visit/employee', [DirectorVisitController::class, 'employee'])->name('visit.director.employees');
    Route::get('/visit/site', [DirectorVisitController::class, 'site'])->name('visit.director.sites');
    Route::post('/visits/datatable', [DirectorVisitController::class, 'datatable'])->name('visits.director.datatable');
    Route::post('/visit/datatable/employees', [DirectorVisitController::class, 'datatable_employees'])->name('visit.director.datatable.employees');
    Route::post('/visit/datatable/sites', [DirectorVisitController::class, 'datatable_sites'])->name('visit.director.datatable.sites');

    Route::post('/visits/datatable', [DirectorVisitController::class, 'datatable'])->name('visits.datatable.director');
});
