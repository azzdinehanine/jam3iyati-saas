<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Province extends Model {
    protected $fillable = ['region_id','name_ar','name_fr'];
    public function region() { return $this->belongsTo(Region::class); }
    public function communes() { return $this->hasMany(Commune::class); }
    public function getNameAttribute() { return app()->getLocale()==='ar' ? $this->name_ar : $this->name_fr; }
}
