<?php
namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;
class HandleInertiaRequests extends Middleware {
    protected $rootView = 'app';
    public function version(Request $request): ?string { return parent::version($request); }
    public function share(Request $request): array {
        return array_merge(parent::share($request), [
            'auth' => fn () => $request->user() ? [
                'user' => $request->user()->only('id','name','email','role','tenant_id','locale_pref'),
                'tenant' => $request->user()->tenant ? $request->user()->tenant->only('id','name','plan_id','is_active','expires_at') : null,
            ] : null,
            'locale' => fn () => app()->getLocale(),
            'translations' => fn () => $this->getTranslations(),
            'flash' => fn () => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
            ],
            'ziggy' => fn () => array_merge((new Ziggy)->toArray(), ['location' => $request->url()]),
        ]);
    }
    private function getTranslations(): array {
        $locale = app()->getLocale();
        $path = lang_path($locale);
        $translations = [];
        if (is_dir($path)) {
            foreach (glob($path . '/*.php') as $file) {
                $key = basename($file, '.php');
                $translations[$key] = require $file;
            }
        }
        return $translations;
    }
}
