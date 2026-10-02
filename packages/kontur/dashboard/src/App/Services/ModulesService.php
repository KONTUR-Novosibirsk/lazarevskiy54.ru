<?php

namespace Kontur\Dashboard\App\Services;

use Illuminate\Support\Facades\Cache;
use Kontur\Dashboard\App\Requests\UpdateModules;

class ModulesService
{
    public function __construct(
        private readonly ConfigManager $configManager = new ConfigManager(),
    )
    {

    }

    public function saveSettings(UpdateModules $request): bool
    {
        $data = $request->validated();
        $modules = [];
        foreach ($data['modules'] as $module) {
            $modules[$module['id']] = $module['config'];
        }
        if ($this->configManager->store('modules', $modules)) {
            return true;
        }
        return false;
    }
}
