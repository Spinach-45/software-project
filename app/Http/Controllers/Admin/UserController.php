<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * 共用功能：管理員審核帳號、調整角色
 */
class UserController extends Controller
{
    public function index()
    {
        $pending = User::where('status', 'pending')->orderBy('created_at')->get();
        $others = User::where('status', '!=', 'pending')->orderBy('name')->get();

        return view('admin.users.index', compact('pending', 'others'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(User::STATUSES))],
            'role' => ['required', Rule::in(array_keys(User::ROLES))],
        ]);

        if ($user->is($request->user()) && ($data['role'] !== 'admin' || $data['status'] !== 'approved')) {
            return back()->withErrors(['user' => '不能移除自己的管理員權限']);
        }

        $user->update($data);

        return back()->with('status', "已更新 {$user->name} 的帳號");
    }
}
