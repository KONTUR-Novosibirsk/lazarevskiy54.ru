<?php

    use Galtsevt\AppConf\app\Models\Setting;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\Cookie;
    use Laravel\Sanctum\PersonalAccessToken;
    use Modules\Accounts\App\Models\Account;

    function settings(string $key, $group = 'main', $default = null)
    {
        if (!$settings = Cache::get('admin_settings' . $group, null)) {
            $settings = Setting::getByGroup($group);
            Cache::put('admin_settings' . $group, $settings);
        }

        return $settings[$key] ?? $default;
    }

    function settingsImage(string $moduleClass, string $prefix)
    {
        $images = settingsImages(moduleClass: $moduleClass);

        return $images[$prefix] ?? null;
    }

    function settingsImages(string $moduleClass)
    {
        return Setting::image($moduleClass);
    }

    function current_account(): ?Account
    {
        $token = Session::get('auth') ?? Cookie::get('remember_token');
        if (!$token) {
            return null;
        }

        if (strpos($token, '|') === false) {
            return null;
        }

        [$id, $tokenString] = explode('|', $token, 2);

        $tokenInstance = PersonalAccessToken::where('id', $id)
            ->where('token', hash('sha256', $tokenString))
            ->first();
        if (!$tokenInstance) {
            return null;
        }

        return Account::find($tokenInstance->tokenable_id);
    }

    function templates(string $path): array
    {
        $templates = [];
        foreach (new DirectoryIterator(resource_path($path)) as $fileInfo) {
            if ($fileInfo->isDot()) continue;
            $filePath = explode('.', $fileInfo->getFilename());
            $name = array_shift($filePath);
            $templates[] = ['key' => $name, 'value' => $name];
        }
        return $templates;
    }
