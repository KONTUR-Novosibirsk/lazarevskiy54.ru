<?php

namespace Modules\Shop\App\Services\Public;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Modules\Accounts\App\Models\Account;

class OrderService
{
    public function accountHistory(Account $account): LengthAwarePaginator
    {
        return $account->orders()
            ->with('products')
            ->orderBy('id', 'DESC')
            ->paginate(12)
            ->withQueryString();
    }
}
