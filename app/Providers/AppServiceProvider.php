<?php

namespace App\Providers;

use App\Models\Absent;
use App\Models\Comment;
use App\Models\DailyReport;
use App\Models\Employee;
use App\Models\PaidLeave;
use App\Models\Submission;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        view()->composer(
            '*',
            function ($view) {
                $_employees = Employee::where('status', 1)->get()->sortBy(function ($query) {
                    return $query->user->name;
                });
                $paid_leaves = PaidLeave::where('seen_at', null)->whereNotIn('status',  [2, 3])->get();
                $submissions = Submission::where('seen_at', null)->whereNotIn('status',  [2, 3])->get();
                $absents = Absent::where('validation_at', NULL)->get();
                $daily_reports = DailyReport::where('seen_at', null)->get();

                // $daily_reports_users = Collection::empty();

                $comment_daily_reports = Collection::empty();
                $daily_reports_users = Collection::empty();
                $paid_leaves_users = Collection::empty();
                $submissions_users = Collection::empty();
                $notif_submissions_users = Collection::empty();
                $notif_paid_leaves_users = Collection::empty();

                if (Auth::check()) {
                    if (auth()->user()->hasRole('employee')) {
                        $comment_daily_reports = Comment::where('seen_at', NULL)->where('user_id', '!=', auth()->user()->id)->whereHas('daily_report.employee', function ($q) {
                            return $q->where('employee_id', Auth::user()->employee->id);
                        })->with('daily_report.employee.user')->get();
                    } else {
                        $comment_daily_reports = Comment::with('daily_report.employee', 'daily_report.employee.user')->where('user_id', '!=', auth()->user()->id)->get();
                    }

                    $daily_reports_users = DailyReport::whereHas('users', function ($query) {
                        return $query->where('user_id', Auth::user()->id);
                    })->get();

                    $paid_leaves_users = PaidLeave::whereHas('supervisor', function ($query) {
                        return $query->where('user_id', Auth::user()->id);
                    })->whereNotIn('status', [2, 3])->get();

                    $submissions_users = Submission::whereHas('supervisor', function ($query) {
                        return $query->where('user_id', Auth::user()->id);
                    })->whereNotIn('status', [2, 3])->get();

                    $notif_submissions_users = Submission::whereHas('supervisor', function ($query) {
                        return $query->where('user_id', Auth::user()->id);
                    })->where('seen_at', NULL)->whereNotIn('status',  [2, 3])->get();

                    $notif_paid_leaves_users = PaidLeave::whereHas('supervisor', function ($query) {
                        return $query->where('user_id', Auth::user()->id);
                    })->whereNotIn('status', [2, 3])->where('seen_at', NULL)->get();
                }

                // dd($comment_daily_reports);
                $view->with([
                    '_employees' => $_employees,
                    '_paidleaves' => $paid_leaves,
                    '_submissions' => $submissions,
                    '_daily_reports' => $daily_reports,
                    '_daily_reports_users' => $daily_reports_users,
                    '_paid_leaves_users' => $paid_leaves_users,
                    '_notif_paid_leaves_users' => $notif_paid_leaves_users,
                    '_submissions_users' => $submissions_users,
                    '_notif_submissions_users' => $notif_submissions_users,
                    '_comment_daily_reports' => $comment_daily_reports,
                    '_absents' => $absents
                ]);
            }
        );
    }
}
