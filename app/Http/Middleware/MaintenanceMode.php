<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Settings;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $maintenance_mode = Settings::where('setting', 'maintenance_mode')->first();
		$maintenance_mode = $maintenance_mode->value;

        if ($maintenance_mode === "enabled") {
            if (Auth::check()) {
                if (auth()->user()->group === "admin") {
                    return $next($request);
                } else {
                    return redirect('maintenancemode');
                }
            } else {
                return redirect('maintenancemode');
            }
        } else {
            return $next($request);
        }
        
        
        
    }
}
