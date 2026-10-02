<?php

namespace Kontur\Dashboard\App\Controllers;

use App\Http\Controllers\Controller;
use Kontur\Dashboard\App\Requests\CommandRequest;
use Kontur\Dashboard\App\Services\CommandService;

class CommandController extends Controller
{
    public function __invoke(CommandRequest $commandRequest, CommandService $commandService): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            $commandService->call(current($commandRequest->validated()))
        );
    }
}
