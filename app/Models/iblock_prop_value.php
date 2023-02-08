<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class iblock_prop_value extends Model
{
    use HasFactory;

    public function el()
    {
        return $this->belongsTo(iblock_element::class);
    }
    public function prop()
    {
        return $this->belongsTo(iblock_property::class);
    }
}
