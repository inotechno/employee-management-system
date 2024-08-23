<?php

namespace App\Http\Controllers\Hrd;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        // dd($id);
        Comment::create([
            'daily_report_id' => $id,
            'user_id'         => auth()->id(),
            'comment'         => $request->comment,
        ]);

        return redirect()->back();
    }
}
