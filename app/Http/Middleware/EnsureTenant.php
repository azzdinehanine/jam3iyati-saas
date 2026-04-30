<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class EnsureTenant {
    public function handle(Request $request, Closure $next) {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');
        if ($user->role === 'super_admin') return $next($request);
        if (!$user->tenant_id) abort(403, 'No tenant');
        if ($user->tenant && !$user->tenant->is_active) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Tenant suspended']);
        }
        app()->instance('currentTenant', $user->tenant);
        return $next($request);
    }
}
