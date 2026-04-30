<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
class LoginController extends Controller {
    public function showLogin() { return Inertia::render('Auth/Login'); }
    public function login(Request $request) {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'serial_code' => 'nullable|string',
        ]);
        $user = User::where('email', $data['email'])->first();
        if (!$user || !\Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages(['email' => __('auth.failed')]);
        }
        if ($user->role !== 'super_admin') {
            $tenant = Tenant::where('serial_code', $data['serial_code'] ?? '')->first();
            if (!$tenant || $tenant->id !== $user->tenant_id) {
                throw ValidationException::withMessages(['serial_code' => __('auth.invalid_serial')]);
            }
            if (!$tenant->is_active) {
                throw ValidationException::withMessages(['email' => __('auth.tenant_suspended')]);
            }
        }
        Auth::login($user, true);
        $request->session()->regenerate();
        if ($user->locale_pref) session(['locale' => $user->locale_pref]);
        return redirect()->intended($user->role === 'super_admin' ? '/super/dashboard' : '/dashboard');
    }
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
