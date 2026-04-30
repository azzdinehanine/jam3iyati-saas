<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Plan extends Model {
    protected $fillable = ['name_ar','name_fr','price_monthly','price_yearly','max_members','max_projects','features','is_active'];
    protected $casts = ['features' => 'array'];
    public function tenants() { return $this->hasMany(Tenant::class); }
}
