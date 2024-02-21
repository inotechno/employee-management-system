<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticated(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt(array($fieldType => $request->username, 'password' => $request->password))) {
            $request->session()->regenerate();
            $request->session()->flash('success', 'Login berhasil, Welcome to dashboard');

            // dd(auth()->user()->role);
            if (auth()->user()->hasRole('administrator')) {
                return redirect()->route('administrator.dashboard');
            } else if (auth()->user()->hasRole('employee')) {
                return redirect()->route('employee.dashboard');
            } else if (auth()->user()->hasRole('finance')) {
                return redirect()->route('finance.dashboard');
            } else if (auth()->user()->hasRole('hrd')) {
                return redirect()->route('hrd.dashboard');
            } else if (auth()->user()->hasRole('director')) {
                return redirect()->route('director.dashboard');
            }

            return redirect()->intended();
        }

        $request->session()->flash('error', 'Login gagal, silahkan coba kembali');
        return back();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
