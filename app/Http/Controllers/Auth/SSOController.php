<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

final class SSOController extends Controller
{
    public function redirect(?string $type = null): RedirectResponse
    {
        $url = config('auth.sso.url').'/login?redirect='.config('app.url').'/auth/callback&app=empleo';

        if ($type === 'register') {
            $url = config('auth.sso.url').'/register?redirect='.config('app.url').'/auth/callback&app=empleo';
        }

        return redirect()->away($url);
    }

    public function callback(Request $request): RedirectResponse
    {
        $token = $request->input('token');

        $request = Http::withToken($token)->get(config('auth.sso.url').'/api/user');
        $userData = $request->json();

        $user = User::query()->updateOrCreate(['email' => $userData['email']], [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => $userData['email'],
        ]);

        auth()->login($user);

        return redirect()->route('dashboard');
    }
}
