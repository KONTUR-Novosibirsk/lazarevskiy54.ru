<?php

namespace Modules\Cookie\App\Controllers\Public;

use Modules\Cookie\App\Requests\CookieRequests;
use Modules\Cookie\App\Services\CookieService;

class CookieController extends \App\Http\Controllers\Controller
{
    public cookieService $cookieService;

    public function __construct(CookieService $cookieService)
    {
        $this->cookieService = $cookieService;
    }

    public function accept(CookieRequests $request)
    {
        return $this->cookieService->storeConsent($request);
    }
}
