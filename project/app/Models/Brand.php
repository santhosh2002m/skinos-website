<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','photo','image','is_featured','status', 'scheme_id'];
    public $timestamps = false;

    public function scheme() {
        return $this->belongsTo(Scheme::class,'scheme_id');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
