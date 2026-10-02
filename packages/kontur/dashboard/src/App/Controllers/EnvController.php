<?php

namespace Kontur\Dashboard\App\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class EnvController
{
    /**
     * Сохраняет новые настройки в файл .env, очищает кэш конфига
     *
     * @param Request $request - новые данные для .env
     * @return JsonResponse
     */
    public function saveEnv(Request $request): JsonResponse
    {
        $envPath = base_path('.env');

        if (!file_exists($envPath)) {
            return response()->json([
                'success' => false
            ]);
        }

        $envArray = [
            'APP_DEBUG' => $request->get('debug') == 1 ? 'true' : 'false',
            'MAIL_HOST' => $request->get('mailHost'),
            'MAIL_PORT' => $request->get('mailPort'),
            'MAIL_USERNAME' => $request->get('mailUserName'),
            'MAIL_PASSWORD' => $request->get('mailPassword'),
            'MAIL_ENCRYPTION' => $request->get('mailEncryption'),
            'MAIL_FROM_ADDRESS' => $request->get('mailUserName') != 'null' ? $request->get('mailUserName') : env('MAIL_FROM_ADDRESS'),
        ];
        $envArray['MAIL_FROM_ADDRESS'] = '"' . $envArray['MAIL_FROM_ADDRESS'] . '"';

        $content = file_get_contents($envPath);

        foreach ($envArray as $key => $value) {
            $pattern = "/^{$key}=.*$/m";

            $escaped = preg_quote($key, '/');

            if (preg_match("/^{$escaped}=.*/m", $content)) {
                $content = preg_replace($pattern, "{$key}={$value}", $content);
            } else {
                $content .= PHP_EOL . "{$key}={$value}";
            }
        }

        file_put_contents($envPath, $content);

        Artisan::call('config:clear');

        return response()->json([
            'success' => true
        ]);
    }
}
