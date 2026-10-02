<?php

namespace Modules\Cookie\App\Services;

use Illuminate\Http\Request;
use Modules\Cookie\App\Models\CookieConsent;
use Illuminate\Support\Facades\Log;

class CookieService
{
    public function storeConsent(Request $request)
    {
        $user = current_account();

        $consentData = [
            'account_id' => $user?->id,
            'session_id' => session()->getId(),
            'ip_address' => $request->ip(),
            'accepted_all' => (bool) $request->input('accepted_all', true),
            'accepted_at' => now(),
            'created_at' => now(),
        ];

        try {
            session(['cookieConsent' => $consentData]);
            CookieConsent::create($consentData);

            return redirect()->back()
                ->with('success', 'Настройки cookies сохранены');
        } catch (\Exception $e) {
            Log::error('Ошибка сохранения cookie: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Произошла ошибка');
        }
    }
}
