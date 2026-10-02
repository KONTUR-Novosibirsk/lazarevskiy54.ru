<?php

namespace Modules\Accounts\App\Controllers\Public;

use App\Http\Controllers\Controller;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Http\{JsonResponse, Response};
use Modules\Accounts\App\Models\Account;
use Modules\Accounts\App\Requests\{LoginRequest, RegisterRequest};
use Modules\Accounts\App\Resources\AccountResource;
use Modules\Accounts\App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function register(): Response
    {
        Seo::breadcrumbs()->add('Регистрация', route('account.register'));
        return response()->view('accounts::register');
    }

    public function login(): Response
    {
        Seo::breadcrumbs()->add('Авторизация', route('account.login'));
        return response()->view('accounts::login');
    }

    public function store(RegisterRequest $request): JsonResponse
    {
        /** @var Account $account */
        $account = Account::query()->create($request->validated());
        $account->login();
        return response()->json(new AccountResource($account), 201);
    }

    public function authenticate(LoginRequest $request): JsonResponse
    {
        if (!$account = $this->authService->attemptLogin($request->validated())) {
            return response()->json([
                'message' => 'Неверные учетные данные',
                'errors' => [
                    'general' => ['Неверные учетные данные'],
                ],
            ], 401);
        }
        return response()->json(new AccountResource($account));
    }
}
