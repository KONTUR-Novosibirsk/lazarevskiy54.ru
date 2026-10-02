<?php


namespace Kontur\Dashboard\App\Controllers\Auth;

use Illuminate\Http\Request;
use Kontur\Dashboard\App\Services\AuthService;

class LogoutController extends \App\Http\Controllers\Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, AuthService $service): \Illuminate\Http\RedirectResponse
    {
        $service->logout();
        return redirect()->route('admin.login');
    }
}
