<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya catat request GET (bukan POST/PUT/DELETE) dan abaikan AJAX/Asset
        if ($request->isMethod('get') && !$request->expectsJson()) {
            $ip = $request->ip();
            $today = now()->toDateString();
            $userAgent = substr($request->userAgent() ?? '', 0, 255);

            try {
                // Simpan atau abaikan jika IP sudah tercatat hari ini
                DB::table('visitors')->insertOrIgnore([
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                    'visit_date' => $today,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (\Exception $e) {
                // Abaikan error log agar tidak mengganggu response pengguna
            }
        }
        return $next($request);
    }
}
