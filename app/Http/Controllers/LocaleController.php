<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
class LocaleController extends Controller {
    public function switch(Request $request, string $locale) {
        if (!in_array($locale, ['ar', 'fr'])) abort(400);
        Session::put('locale', $locale);
        if (Auth::check()) { $u = Auth::user(); $u->locale_pref = $locale; $u->save(); }
        return back();
    }
}
