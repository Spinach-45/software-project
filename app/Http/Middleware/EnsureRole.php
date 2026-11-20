<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * 角色檢查。用法：->middleware('role:admin') 或 ->middleware('role:admin,teacher')
 */
class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! in_array($user->role, $roles, true)) {
            abort(403, '你沒有權限使用這個功能');
        }

        return $next($request);
    }
}
