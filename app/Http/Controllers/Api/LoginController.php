<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends BaseController
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Bad Parameter.', ['error' => $validator->errors()]);
        }

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt(array($fieldType => $request->username, 'password' => $request->password))) {
            $user = Auth::user()->load('employee');

            $success['token'] =  $user->createToken('EmpSystem')->plainTextToken;

            $success['id']  = $user->id;
            $success['name']  = $user->name;
            $success['username']  = $user->username;
            $success['email']  = $user->email;
            $success['created_at']  = $user->created_at;
            $success['updated_at']  = $user->updated_at;
            $success['employee']    = $user->employee;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('User not found.', ['error' => 'Username dan password salah']);
        }
    }
}
