<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;
class Document extends Model {
    use BelongsToTenant;
    protected $fillable = ['tenant_id','name','type','file_path','uploaded_by'];
    public function uploader() { return $this->belongsTo(User::class, 'uploaded_by'); }
}
