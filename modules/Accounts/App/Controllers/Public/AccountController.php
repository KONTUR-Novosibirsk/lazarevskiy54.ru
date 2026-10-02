<?php

namespace Modules\Accounts\App\Controllers\Public;

use App\Http\Controllers\Controller;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request, Response};
use Modules\Accounts\App\Requests\UpdateRequest;
use Modules\Accounts\App\Resources\AccountResource;
use Modules\Shop\App\Resources\Order\ShopOrderResource;
use Modules\Shop\App\Services\Public\OrderService;
class AccountController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function profile(): Response
    {
        Seo::breadcrumbs()->add('Личный кабинет', route('account.me'));
        return response()->view('accounts::profile');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->account->logout();
        session()->forget('cookieConsent');
        return redirect()->route('index');
    }

    public function account(Request $request): JsonResponse
    {
        return response()->json(AccountResource::make($request->account));
    }

    public function history(Request $request): JsonResponse
    {
        $orders = $this->orderService->accountHistory($request->account);
        return response()->json(ShopOrderResource::collection($orders));
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        $request->account->update($request->validated());
        return response()->json(AccountResource::make($request->account));
    }
}
