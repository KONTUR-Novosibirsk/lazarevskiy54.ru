<?php


namespace Kontur\Dashboard\App\Controllers\Auth;

use Illuminate\Http\Request;
use Kontur\Dashboard\App\Services\AuthService;

class AuthController extends \App\Http\Controllers\Controller
{

    public function __invoke(Request $request, AuthService $service): \Illuminate\Http\JsonResponse
    {
        if ($service->auth($request)) {
            return response()->json(true);
        }

        return response()->json(false);
    }
}
