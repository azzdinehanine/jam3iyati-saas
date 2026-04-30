<?php
namespace App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Plan;
use App\Models\User;
use Inertia\Inertia;
class DashboardController extends Controller {
    public function index() {
        return Inertia::render('Super/Dashboard', [
            'stats' => [
                'tenants' => Tenant::count(),
                'active' => Tenant::where('is_active',true)->count(),
                'users' => User::count(),
                'plans' => Plan::count(),
            ],
            'tenants' => Tenant::with('plan')->latest()->take(10)->get(),
        ]);
    }
}
