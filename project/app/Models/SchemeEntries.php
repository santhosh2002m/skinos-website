<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchemeEntries extends Model
{
    use HasFactory;

    protected $table = 'scheme_entries';
    protected $fillable = ['name', 'total_quantity', 'discount_percentage', 'number_of_boxes', 'name_of_the_box', 'quantity_of_items_per_box', 'max_buying_limit', 'scheme_id', 'status', 'is_deleted'];

    public function scheme() {
        return $this->belongsTo(Scheme::class, 'scheme_id');
    }
}