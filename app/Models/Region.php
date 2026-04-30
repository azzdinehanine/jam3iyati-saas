<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Region extends Model {
    protected $fillable = ['name_ar','name_fr'];
    public function provinces() { return $this->hasMany(Province::class); }
    public function getNameAttribute() { return app()->getLocale()==='ar' ? $this->name_ar : $this->name_fr; }
}
