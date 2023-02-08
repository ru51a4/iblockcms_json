<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class iblock_property extends Model
{
    use HasFactory;


    public function iblock()
    {
        return $this->belongsTo("App\Models\iblock");
    }

    public function propvalue()
    {
        return $this->hasMany(iblock_prop_value::class, "prop_id");
    }

    public function elements()
    {
        return $this->belongsToMany(iblock_element::class);
    }

}
