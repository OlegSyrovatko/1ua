<?php

namespace App\Http\Middleware;

use Closure;
use GeoIp2\Database\Reader;

class BlockChina
{
    public function handle($request, Closure $next)
    {
        $ip = $request->ip();

        try {
            $reader = new Reader(storage_path('app/geoip/GeoLite2-Country.mmdb'));
            $record = $reader->country($ip);

            if ($record->country->isoCode === 'CN') {
                abort(403, 'Access Denied');
            }
        } catch (\Exception $e) {
            // Якщо IP не знайдено в базі – пропускаємо
        }

        return $next($request);
    }
}
