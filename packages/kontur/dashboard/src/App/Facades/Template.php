<?php

namespace Kontur\Dashboard\App\Facades;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Facade;
use Inertia\LazyProp;
use Inertia\Response;
use Kontur\Dashboard\App\Utils\RenderFactory;

/**
 * @method static void setRootView(string $name)
 * @method static void share($key, $value = null)
 * @method static array getShared(string $key = null, $default = null)
 * @method static array flushShared()
 * @method static void version($version)
 * @method static int|string getVersion()
 * @method static LazyProp lazy(callable $callback)
 * @method static Response render($component, array|Arrayable $props = [])
 * @method static \Symfony\Component\HttpFoundation\Response location(string $url)
 *
 * @see \Kontur\Dashboard\App\Utils\RenderFactory
 */

class Template extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RenderFactory::class;
    }
}
