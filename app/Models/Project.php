<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;
class Project extends Model {
    use BelongsToTenant;
    protected $fillable = ['tenant_id','name','description','start_date','end_date','budget','spent','status'];
    protected $casts = ['start_date'=>'date','end_date'=>'date','budget'=>'decimal:2','spent'=>'decimal:2'];
    public function getProgressAttribute() { return $this->budget > 0 ? min(100, round(($this->spent / $this->budget) * 100)) : 0; }
}
