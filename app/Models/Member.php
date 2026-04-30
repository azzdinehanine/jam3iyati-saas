<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;
class Member extends Model {
    use BelongsToTenant;
    protected $fillable = ['tenant_id','cin','name','lastname','email','phone','address','birthdate','gender','join_date','role_in_assoc','status','photo'];
    protected $casts = ['birthdate' => 'date', 'join_date' => 'date'];
    public function subscriptions() { return $this->hasMany(MemberSubscription::class); }
    public function getFullNameAttribute() { return $this->name . ' ' . $this->lastname; }
}
