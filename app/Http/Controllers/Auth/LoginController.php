<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $questions = Question::with('user')->latest()->paginate(10);
            return redirect()->route('index');
        }
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        return redirect()->route('index');
    }
}
