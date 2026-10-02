<?php

namespace Kontur\Dashboard\App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function auth(Request $request): bool
    {
        $data = $this->validate($request);
        $response = $this->authorizationOnTheServer($data);

        if (!$response->error) {
            $user = $this->userGetOrCreate([
                'username' => $data['username'],
                'role' => $response->role == 'admin' ? '5' : '4',
            ]);
            Auth::login($user, isset($data['remember']));
            return true;
        }

        return false;
    }

    private function userGetOrCreate($data): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return User::query()->updateOrCreate(['username' => $data['username']], $data);
    }

    private function validate(Request $request): array
    {
        return $request->validate([
            'username' => 'required|string|min:2',
            'password' => 'required|string|min:5',
            'remember' => 'required|boolean',
        ]);
    }

    public function logout(): void
    {
        Auth::logout();
    }

    private function authorizationOnTheServer($data)
    {
        $data['domain'] = request()->getHttpHost();
        $curl = curl_init(config('dashboard.authServer'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_REFERER, 'http://'. $data['domain']);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

}
