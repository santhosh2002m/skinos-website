<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountSlab extends Model
{
    protected $fillable = ['min_value','max_value','discount_percentage','status'];
    protected $table =  "discount_slabs";
    use HasFactory;
}
