<?php

namespace Galtsevt\AppConf\app\Http;

use App\Http\Controllers\Controller;
use Galtsevt\AppConf\app\Requests\AppearanceStoreRequest;
use Galtsevt\AppConf\app\Services\ConfigService;

class AppearanceController extends Controller
{
    public function __invoke(AppearanceStoreRequest $request, ConfigService $service): \Illuminate\Http\JsonResponse
    {
        return response()->json($service->storeAppearance($request->validated()));
    }
}
