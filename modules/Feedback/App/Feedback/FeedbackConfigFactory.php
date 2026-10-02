<?php

namespace Modules\Feedback\App\Feedback;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Feedback\App\Models\Feedback;

class FeedbackConfigFactory
{
    private array $configs = [];
    private ?Collection $counts = null;

    public function __construct()
    {
        $this->prepareConfig();
    }

    private function prepareConfig(): void
    {
        foreach (new \DirectoryIterator(app_path('feedback')) as $config) {
            if ($config->isDot()) continue;
            $config = require $config->getRealPath();
            $this->configs[$config['name']] = $config;
        }
    }

    public function getConfig($name): ?array
    {
        if (isset($this->configs[$name])) {
            return $this->configs[$name];
        }
        return null;
    }

    public function getAllConfigs(): array
    {
        return $this->configs;
    }

    public function getCount(string $name): int
    {
        if (!$this->counts) {
            $this->counts = Feedback::query()->select('name', DB::raw('count(*) as count'))
                ->where('status', 0)
                ->groupBy('name')->get();
        }
        return $this->counts->where('name', $name)->first()->count ?? 0;
    }
}
