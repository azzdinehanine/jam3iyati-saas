<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Plan;
use App\Models\User;
use App\Models\Region;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;
class RegisterTenantController extends Controller {
    public function show() {
        return Inertia::render('Auth/Register', ['plans' => Plan::where('is_active', true)->get()]);
    }
    public function register(Request $request) {
        $data = $request->validate([
            'association_name' => 'required|string|max:200',
            'admin_first_name' => 'required|string|max:100',
            'admin_last_name' => 'required|string|max:100',
            'admin_email' => 'required|email|unique:users,email|unique:tenants,email',
            'admin_password' => 'required|string|min:8|confirmed',
            'admin_phone' => 'required|string|max:20',
            'plan_id' => 'required|exists:plans,id',
        ]);
        $plan = Plan::find($data['plan_id']);
        $defaultRegion = Region::first();
        $defaultProvince = Province::first();
        DB::beginTransaction();
        try {
            $tenant = new Tenant();
            $tenant->serial_code = strtoupper(Str::random(16));
            $tenant->name = $data['association_name'];
            $tenant->email = $data['admin_email'];
            $tenant->phone = $data['admin_phone'];
            $tenant->address = '-';
            $tenant->founded_at = now()->toDateString();
            $tenant->plan_id = $plan->id;
            $tenant->subscription_end = now()->addMonths($plan->duration_months ?? 1);
            $tenant->status = 'active';
            $tenant->locale = 'ar';
            if ($defaultRegion) $tenant->region_id = $defaultRegion->id;
            if ($defaultProvince) $tenant->province_id = $defaultProvince->id;
            $tenant->save();
            User::create([
                'tenant_id' => $tenant->id,
                'name' => $data['admin_first_name'],
                'lastname' => $data['admin_last_name'],
                'email' => $data['admin_email'],
                'password' => Hash::make($data['admin_password']),
                'phone' => $data['admin_phone'],
                'role' => 'admin',
                'is_active' => true,
            ]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['admin_email' => 'خطأ: ' . $e->getMessage()])->withInput();
        }
        return redirect()->route('login')->with('success', 'تم إنشاء حسابكم بنجاح. رمز السيريال: ' . $tenant->serial_code);
    }
}
