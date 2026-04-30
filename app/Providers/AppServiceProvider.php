<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
class AppServiceProvider extends ServiceProvider {
    public function register(): void {}
    public function boot(): void {
        if (env('APP_URL')) {
            URL::forceRootUrl(env('APP_URL'));
            if (str_starts_with(env('APP_URL'), 'https')) {
                URL::forceScheme('https');
            }
        }
    }
}
