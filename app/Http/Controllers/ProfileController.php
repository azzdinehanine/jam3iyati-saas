<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
class ProfileController extends Controller {
    public function edit() { return Inertia::render('Profile/Edit', ['user' => auth()->user()]); }
    public function update(Request $request) {
        $user = auth()->user();
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);
        $user->update($data);
        return back()->with('success', 'تم التحديث');
    }
    public function password(Request $request) {
        $request->validate(['current_password' => 'required|current_password', 'password' => 'required|string|min:8|confirmed']);
        auth()->user()->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'تم تغيير كلمة المرور');
    }
}
