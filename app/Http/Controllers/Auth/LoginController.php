<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
class LoginController extends Controller {
    public function showLogin() { return Inertia::render('Auth/Login'); }
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $serial = $request->input('serial_code');
        if (Auth::attempt($credentials, true)) {
            $user = Auth::user();
            // SuperAdmin can login with serial_code
            if ($user->role === 'super_admin') {
                $request->session()->regenerate();
                return redirect()->intended('/super/dashboard');
            }
            // Tenant user must have active tenant
            if ($user->tenant && $user->tenant->status === 'rejected') {
                Auth::logout();
                return back()->withErrors(['email' => 'الجمعية محظورة']);
            }
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
        return back()->withErrors(['email' => 'بيانات غير صحيحة'])->onlyInput('email');
    }
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
