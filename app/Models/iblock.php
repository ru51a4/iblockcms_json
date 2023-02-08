<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class iblock extends Model
{
    use HasFactory;

    private static $usedNestedSet = false;

    public function elements()
    {
        return $this->hasMany(iblock_element::class);
    }

    public function properties()
    {
        return $this->hasMany("App\Models\iblock_property");
    }

    public function getPropWithParents($is_admin = false)
    {
        return \App\Service\Iblocks::getPropsParents($this, $is_admin);
    }

    public function getParents()
    {
        $iblock = $this;
        if (self::$usedNestedSet) {
            $sectionTree = iblock::with("properties")->where("left", "<=", $iblock->left)->where("right", ">=", $iblock->right)->get();
        } else {
            $sectionTree = [$iblock];
            while ($iblock->parent_id != 0) {
                $iblock = iblock::with("properties")->where("id", "=", $iblock->parent_id)->first();
                $sectionTree[] = $iblock;
            }
        }
        return collect($sectionTree);
    }

    public function getChilds()
    {
        $iblock = $this;
        if (self::$usedNestedSet) {
            $sectionTree = iblock::where("left", ">=", $iblock->left)->where("right", "<=", $iblock->right)->get();
        } else {
            $sectionTree = [];
            $getChilds = function ($iblock) use (&$sectionTree, &$getChilds) {
                $sectionTree[] = $iblock;
                $childs = iblock::where("parent_id", "=", $iblock->id)->get();
                foreach ($childs as $child) {
                    $getChilds($child);
                }
            };
            $getChilds($iblock);
        }
        return collect($sectionTree);
    }


}
