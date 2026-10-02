<?php

namespace Kontur\Dashboard\App\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Kontur\Dashboard\App\Requests\UpdatePerPageRequest;

class UserController extends Controller
{
    public function perPage(UpdatePerPageRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::query()->findOrFail(auth()->user()->id);
        $user->update($request->validated());
        return response()->json(true);
    }
}
