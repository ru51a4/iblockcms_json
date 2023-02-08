<?php

namespace App\Service;

use App\Models\iblock;
use App\Models\iblock_element;
use App\Models\iblock_prop_value;


class functions
{
    public static function getOpItem($iblockId)
    {
        $res = Iblocks::ElementsGetListByIblockId($iblockId, 5, false, [["prop" => "is_op", "type" => "=", "value" => "1"]])["res"];
        if (isset($res[$iblockId]["elements"][0])) {
            return $res[$iblockId]["elements"][0];
        }
        return [];
    }
    public static function slugParse($slug)
    {
        $type = "catalog";
        $page = [];
        $filter = [];
        $resParams = ["param" => [], "range" => []];
        if ($slug) {
            $slug = explode("/", $slug);
            $page = 1;
            if (end($slug) == "apply") {
                $s = array_pop($slug);
                while ($s !== 'filter') {
                    $s = array_pop($slug);
                    $filter[] = $s;
                }
                array_pop($filter);
                foreach ($filter as $filterItem) {
                    if (str_contains($filterItem, "range")) {
                        $c = explode("_", $filterItem);
                        $cval = explode(";", $c[2]);
                        $resParams["range"][$c[1]]["from"] = $cval[0];
                        $resParams["range"][$c[1]]["to"] = $cval[1];
                    } else {
                        $filterItem = iblock_prop_value::where("slug", "=", $filterItem)->first();
                        $resParams["param"][$filterItem->prop->id][] = $filterItem->id;
                    }
                }
            }
            if (is_numeric(end($slug))) {
                $page = array_pop($slug);
            }
            $id = array_pop($slug);
            if (!empty($id)) {
                $detailId = iblock_element::where("slug", "=", $id)->first();
                if (!empty($detailId)) {
                    $type = "detail";
                    $id = $detailId->id;
                } else {
                    $id = iblock::where("slug", "=", $id)->first()->id;
                }
            } else {
                $id = 1;
            }
        } else {
            $page = 1;
            $id = 1;
        }

        return ["id" => $id, "page" => $page, "resParams" => $resParams, "filter" => $filter, "type" => $type];
    }

}