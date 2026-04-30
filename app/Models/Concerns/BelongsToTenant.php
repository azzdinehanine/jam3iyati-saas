<?php
namespace App\Models\Concerns;
use App\Scopes\TenantScope;
trait BelongsToTenant {
    protected static function bootBelongsToTenant() {
        static::addGlobalScope(new TenantScope);
        static::creating(function ($model) {
            if (auth()->check() && auth()->user()->tenant_id && !$model->tenant_id) {
                $model->tenant_id = auth()->user()->tenant_id;
            }
        });
    }
    public function tenant() { return $this->belongsTo(\App\Models\Tenant::class); }
}
