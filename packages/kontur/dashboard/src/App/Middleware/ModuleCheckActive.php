<?php

namespace Kontur\Dashboard\App\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kontur\Dashboard\App\Facades\Modules;
use Symfony\Component\HttpFoundation\Response;

class ModuleCheckActive
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @param string $name
     * @return Response
     */
    public function handle(Request $request, Closure $next, string $name): Response
    {
        if (Modules::get($name)?->isActive()) {
            return $next($request);
        }
        abort(404);
    }
}
