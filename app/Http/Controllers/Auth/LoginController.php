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
            if(url()->previous() == "http://127.0.0.1:8000/login"){
                $url = url(route('index'));
                return response()->json(['url' => $url]);
            }
            return response()->json(['url' => url()->previous()]);
        }
        return response()->json(['error_message' => 'Email hoặc mật khẩu không chính xác']);
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        return redirect()->route('index');
    }
}
