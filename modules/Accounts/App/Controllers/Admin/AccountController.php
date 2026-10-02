<?php

namespace Modules\Accounts\App\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Inertia\Response;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\Accounts\App\Models\Account;
use Modules\Accounts\App\Resources\AccountResource;
use Modules\Accounts\App\Services\AccountService;

class AccountController extends Controller
{
    public function __construct(private AccountService $accountService)
    {
        Seo::breadcrumbs()->add(settings('name', 'accounts', 'Аккаунты'), route('admin.accounts.index'));
    }

    public function index(): Response
    {
        Seo::metaData()->setTitle(settings('name', 'accounts', 'Аккаунты'));

        $filters = Request::all('search');
        $accounts = $this->accountService->accounts($filters);

        return inertia('Modules/Accounts/Index', [
            'filters' => $filters,
            'accounts' => AccountResource::collection($accounts)
        ]);
    }

    public function toggleConfirmed(Account $account): JsonResponse
    {
        $response = AccountResource::make($account->toggleConfirmed())->toArray(request());

        if($account->is_confirmed){
            $message = $this->accountService->attemptSendMail($account);
            $response = array_merge($response, $message);
        }

        return response()->json($response);
    }

    public function destroy(Account $account): void
    {
        $account->delete();
    }
}


// привязка товаров к лк, цены, отправка почты
