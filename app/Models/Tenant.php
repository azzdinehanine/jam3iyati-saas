<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Tenant extends Model {
    protected $fillable = ['serial_code','name','email','phone','address','facebook','founded_at','goals','region_id','province_id','commune_id','logo_path','deposit_receipt_path','plan_id','subscription_end','status','locale'];
    protected $casts = ['founded_at' => 'date', 'subscription_end' => 'date'];
    public static function generateSerial(): string {
        do { $code = 'JM3-' . strtoupper(bin2hex(random_bytes(3))); } while (self::where('serial_code', $code)->exists());
        return $code;
    }
    public function users() { return $this->hasMany(User::class); }
    public function members() { return $this->hasMany(Member::class); }
    public function plan() { return $this->belongsTo(Plan::class); }
    public function region() { return $this->belongsTo(Region::class); }
    public function province() { return $this->belongsTo(Province::class); }
    public function commune() { return $this->belongsTo(Commune::class); }
}
