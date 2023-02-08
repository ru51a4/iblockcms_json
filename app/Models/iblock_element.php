<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Service\Iblocks;

class iblock_element extends Model
{
    use HasFactory;

    public function iblock()
    {
        return $this->belongsTo(iblock::class);
    }

    public function propvalue()
    {
        return $this->hasMany(iblock_prop_value::class, "el_id");
    }

    public function properties()
    {
        return $this->belongsToMany(iblock_property::class);
    }

    public function getPropWithParents($iblock)
    {
        return \App\Service\Iblocks::getPropsParents($iblock);
    }


}


