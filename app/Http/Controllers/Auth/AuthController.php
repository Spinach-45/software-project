<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * 共用功能：註冊、登入、登出。三個模組共用同一套帳號。
 * 新註冊的帳號狀態為 pending，需管理員審核通過後才能登入。
 */
class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['teacher', 'user'])], // 不能自己註冊成管理員
        ]);

        User::create($data + ['status' => 'pending']);

        return redirect()->route('login')
            ->with('status', '註冊成功，請等待管理員審核通過後再登入。');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => '帳號或密碼錯誤'])->onlyInput('email');
        }

        if (! Auth::user()->isApproved()) {
            $message = Auth::user()->status === 'rejected' ? '你的帳號申請已被退回' : '你的帳號尚未通過審核';
            Auth::logout();

            return back()->withErrors(['email' => $message])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
