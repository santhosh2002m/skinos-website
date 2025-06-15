<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'slug', 'image', 'status'];
    public $timestamps = false; // Add this line to disable timestamps
}
