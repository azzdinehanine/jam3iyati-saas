<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable {
    use Notifiable;
    protected $fillable = ['tenant_id','name','lastname','email','phone','password','role','is_active'];
    protected $hidden = ['password','remember_token'];
    protected $casts = ['email_verified_at'=>'datetime','password'=>'hashed'];
    public function tenant() { return $this->belongsTo(Tenant::class); }
    public function isSuperAdmin(): bool { return $this->role === 'super_admin'; }
    public function isAdmin(): bool { return $this->role === 'admin'; }
}
