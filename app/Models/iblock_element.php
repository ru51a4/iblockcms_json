<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Service\Iblocks;

class iblock_element extends Model
{
    use HasFactory;


    protected $casts = [
        'properties' => 'array'
    ];

    public function iblock()
    {
        return $this->belongsTo(iblock::class);
    }


    public function property()
    {
        return $this->belongsToMany(iblock_property::class);
    }

    public function getPropWithParents($iblock)
    {
        return \App\Service\Iblocks::getPropsParents($iblock);
    }


}