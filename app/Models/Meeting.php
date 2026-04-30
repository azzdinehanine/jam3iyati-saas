<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;
class Meeting extends Model {
    use BelongsToTenant;
    protected $fillable = ['tenant_id','title','type','meeting_date','location','agenda','minutes','status'];
    protected $casts = ['meeting_date' => 'datetime'];
    public function attendances() { return $this->hasMany(MeetingAttendance::class); }
    public function attendees() { return $this->belongsToMany(Member::class, 'meeting_attendances')->withPivot('attended'); }
}
