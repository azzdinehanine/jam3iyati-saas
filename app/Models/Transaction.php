<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;
class Transaction extends Model {
    use BelongsToTenant;
    protected $fillable = ['tenant_id','type','category','amount','description','transaction_date','receipt_file','created_by'];
    protected $casts = ['transaction_date' => 'date', 'amount' => 'decimal:2'];
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function scopeIncomes($q) { return $q->where('type','income'); }
    public function scopeExpenses($q) { return $q->where('type','expense'); }
}
