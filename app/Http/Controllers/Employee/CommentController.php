<?php

namespace App\Http\Controllers\Employee;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        // dd($id);
        $daily_reports = Comment::where('daily_report_id', $id)->update([
            'seen_at' => date('Y-m-d H:i:s')
        ]);

        Comment::create([
            'daily_report_id'     => $id,
            'user_id'             => auth()->user()->id,
            'comment'             => $request->comment,
        ]);

        return redirect()->back();
    }
}
