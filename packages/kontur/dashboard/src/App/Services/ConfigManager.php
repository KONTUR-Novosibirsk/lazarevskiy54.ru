<?php

namespace Kontur\Dashboard\App\Services;

use Illuminate\Support\Facades\Cache;

class ConfigManager
{
    public function find(string $name)
    {
        return Cache::rememberForever($name . '.config', function () use ($name) {
            if (is_file(config_path($name . '.php'))) {
                return require config_path($name . '.php');
            }
            return null;
        });
    }

    public function store(string $name, array $data): bool
    {
        $array = str_replace(['\'0\'', '\'1\''], ['false', 'true'], var_export([$name => $data], true));
        $config = "<?php\n\n" . 'return ' . $array . ";\n";
        if (file_put_contents(config_path($name . '.php'), $config)) {
            Cache::forget($name . '.config');
            return true;
        }
        return false;
    }
}
