<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Виставляє нечутливу (без токенів/секретів) cookie-мітку залогіненим
 * користувачам. Cloudflare сам не знає, хто "зареєстрований користувач" —
 * ця cookie і є той сигнал, за який чіпляється Configuration Rule на боці
 * Cloudflare, щоб не показувати Under Attack challenge залогіненим людям,
 * коли ProtectionStateService вмикає ATTACK через load15-поріг
 * (config('cloudflare_protection.thresholds.load_attack_threshold')).
 *
 * Значення cookie навмисно НЕ шифрується (додано у $except в EncryptCookies) —
 * Cloudflare-правило порівнює сире значення "1", а не спроможне розшифрувати
 * Laravel APP_KEY.
 */
class MarkAuthenticatedCookie
{
    public const COOKIE_NAME = 'logged_in';

    // Laravel 8 не має іменованих констант (FIVE_YEARS з'явився пізніше) — 5 років у хвилинах.
    private const FIVE_YEARS_MINUTES = 5 * 365 * 24 * 60;

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check()) {
            $response->headers->setCookie(cookie(
                self::COOKIE_NAME,
                '1',
                self::FIVE_YEARS_MINUTES,
                '/',
                null,
                (bool) config('session.secure'),
                true, // httpOnly — читає лише Cloudflare-правило на рівні HTTP, JS не потрібен
                false,
                config('session.same_site', 'lax')
            ));
        } elseif ($request->cookie(self::COOKIE_NAME)) {
            $response->headers->clearCookie(self::COOKIE_NAME);
        }

        return $response;
    }
}
