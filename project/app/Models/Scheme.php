<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    use HasFactory;
    protected $table = 'schemes';
    protected $fillable = ['name', 'status', 'is_deleted'];
    protected $with = 'scheme_entries';

    public function scheme_entries()
    {
        return $this->hasMany('App\Models\SchemeEntries');
    }
    public function brand()
    {
        return $this->hasMany('App\Models\Scheme');
    }

}
