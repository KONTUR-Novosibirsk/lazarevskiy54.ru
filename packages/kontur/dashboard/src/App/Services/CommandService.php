<?php

namespace Kontur\Dashboard\App\Services;

use Illuminate\Support\Facades\Artisan;

class CommandService
{
    protected array $allowedCommands = [
        'cache:clear',
        'route:clear',
        'config:clear',
        'view:clear',
        'optimize',
        'optimize:clear',
        'storage:link'
    ];

    public function call(string $command): bool|int
    {
        return in_array($command, $this->allowedCommands) ? Artisan::call($command) : false;
    }
}
