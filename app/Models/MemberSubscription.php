<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;
class MemberSubscription extends Model {
    use BelongsToTenant;
    protected $fillable = ['tenant_id','member_id','year','amount','paid_at','receipt_number','status','notes'];
    protected $casts = ['paid_at' => 'date', 'amount' => 'decimal:2'];
    public function member() { return $this->belongsTo(Member::class); }
}
