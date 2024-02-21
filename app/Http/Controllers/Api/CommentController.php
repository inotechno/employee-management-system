<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DailyReportResource;
use App\Models\DailyReport;

class CommentController extends BaseController
{
    public function store(Request $request, $id)
    {
        // dd($id);
        $daily_reports = Comment::where('daily_report_id', $id)->update([
            'seen_at' => date('Y-m-d H:i:s')
        ]);

        Comment::create([
            'daily_report_id'     => $id,
            'user_id'             => $request->user_id,
            'comment'             => $request->comment,
        ]);

        return $this->sendResponse(new DailyReportResource(DailyReport::find($id)), 'Daily report retrieved successfully');
    }
}
