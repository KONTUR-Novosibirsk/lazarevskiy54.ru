<?php

namespace Modules\TelegramNotification\App\Controllers;

use App\Http\Controllers\Controller;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\TelegramNotification\App\Models\TelegramAccount;
use Modules\TelegramNotification\App\Requests\StoreRequest;
use Modules\TelegramNotification\App\Requests\UpdateRequest;
use Modules\TelegramNotification\App\Resources\TelegramAccountResource;
use Modules\TelegramNotification\App\Services\Telegram;

class TelegramController extends Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('Телеграм уведомления', route('admin.tg.index'));
    }

    public function index(): \Inertia\Response
    {
        Seo::metaData()->setTitle('Телеграм уведомления');

        return inertia('Modules/Telegram/Index', [
            'accounts' => TelegramAccountResource::collection(
                TelegramAccount::query()->paginate(auth()->user()->per_page),
            )
        ]);
    }

    public function sendTestMessage(TelegramAccount $account, Telegram $telegram): bool|\Illuminate\Http\Client\Response
    {
        return $telegram->sendMessage($account->chat_id, 'Test message from ' . settings('site_name') .' ' . hex2bin('F09F988E'));
    }

    public function changeStatus(TelegramAccount $account): TelegramAccountResource
    {
        $account->is_active = !$account->is_active;
        return new TelegramAccountResource($account);
    }

    public function store(StoreRequest $request): TelegramAccountResource
    {
        $account = new TelegramAccount($request->validated());
        $account->save();
        return new TelegramAccountResource($account);
    }

    public function update(UpdateRequest $request, TelegramAccount $account): TelegramAccountResource
    {
        $account->update($request->validated());
        return new TelegramAccountResource($account);
    }

    public function destroy(TelegramAccount $account): \Illuminate\Http\RedirectResponse
    {
        $account->delete();
        return redirect()->route('admin.tg.index');
    }
}
