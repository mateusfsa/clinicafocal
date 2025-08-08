<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CountSiteVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $today = Carbon::today()->toDateString();
       // dd($ip, $today);

        // Só registra se ainda não visitou hoje
        if (!Visit::where('ip', $ip)->where('date', $today)->exists()) {
            Visit::insert([
                'ip' => $ip,
                'date' => $today,
            ]);
        }

        return $next($request);
    }
}
