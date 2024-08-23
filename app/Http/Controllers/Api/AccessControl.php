<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccessControl extends Controller
{
    public function HttpListening(Request $request)
    {
        \Log::info($request->all());
        return response()->json($request->all());
    }
}
