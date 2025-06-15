<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MixMatchProduct extends Model
{
    use HasFactory;
    protected $table = 'mix_match';
    protected $fillable = [
        'user_id',
        'scheme_entry_id',
        'brand_id',
        'no_of_boxes',
        'max_number_of_boxes',
        'mix_match_cart'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function schemeEntry()
    {
        return $this->belongsTo(SchemeEntries::class);
    }
}
