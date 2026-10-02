<?php

namespace Modules\Accounts\App\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$account = current_account()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
//            Смена редиректа если не вошел в аккаунт
//            return redirect()->route('account.register');
            return abort(404);
        }

        $request->merge(['account' => $account]);

        return $next($request);
    }
}
