<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Commune extends Model {
    protected $fillable = ['province_id','name_ar','name_fr'];
    public function province() { return $this->belongsTo(Province::class); }
    public function getNameAttribute() { return app()->getLocale()==='ar' ? $this->name_ar : $this->name_fr; }
}
