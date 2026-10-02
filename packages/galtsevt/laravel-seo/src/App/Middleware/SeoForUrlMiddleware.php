<?php

namespace Galtsevt\LaravelSeo\App\Middleware;

use Closure;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Galtsevt\LaravelSeo\App\Models\SeoForUrl;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeoForUrlMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!$request->ajax() && SeoForUrl::query()->where('url', $request->getRequestUri())->count() > 0) {
            $urlSeo = SeoForUrl::query()->where('url', $request->getRequestUri())->first();
            Seo::metaData()->prepare($urlSeo);
        }
        return $next($request);
    }
}
