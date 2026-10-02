<?php

namespace Modules\Accounts\App\Controllers\Public;

use App\Http\Controllers\Controller;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Http\{JsonResponse, Response};
use Modules\Accounts\App\Requests\{PasswordResetRequest, PasswordUpdateRequest};
use Modules\Accounts\App\Services\PasswordResetService;
class PasswordResetController extends Controller
{
    public function __construct(private PasswordResetService $passwordResetService) {}

    public function reset(): Response
    {
        Seo::breadcrumbs()->add('Сброс пароля', route('account.password.reset'));
        return response()->view('accounts::password-reset');
    }

    public function edit(): Response
    {
        Seo::breadcrumbs()->add('Изменение пароля', route('account.password.edit'));
        return response()->view('accounts::password-edit');
    }

    public function sendResetLink(PasswordResetRequest $request): JsonResponse
    {
        $message = $this->passwordResetService->sendResetLink($request->email);
        return response()->json($message);
    }

    public function update(PasswordUpdateRequest $request): JsonResponse
    {
        $this->passwordResetService->update($request->validated());
        return response()->json('Пароль изменен');
    }
}
