<?php

namespace App\Http\Controllers;

use App\Models\iblock;
use App\Models\iblock_element;
use App\Models\iblock_prop_value;
use App\Models\iblock_property;
use App\Service\functions;
use Illuminate\Http\Request;

use App\Service\Iblocks;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function catalog(Request $request, $slug = "")
    {
        $slug = functions::slugParse($slug);
        $id = $slug["id"];
        $resParams = $slug["resParams"];
        $page = $slug["page"];
        $filter = $slug["filter"];
        $type = $slug["type"];
        if ($type == "detail") {
            return $this->detail($id);
        }
        $tree = Iblocks::treeToArray(Iblocks::SectionGetList(1));
        $els = Iblocks::ElementsGetListByIblockId($id, 5, $page, false, $resParams);
        $count = $els["count"];
        $els = $els["res"];
        $sectionsDetail = [];
        foreach ($tree as $cId => $c) {
            $sectionsDetail[$cId] = functions::getOpItem($cId);
        }
        $countSection = array_filter($tree[$id], function ($item) {
            return isset($item["key"]);
        });
        $sectionIsset = count($countSection);

        $allProps = Iblocks::getAllProps($id, true);
        $allPropValue = $allProps["values"];
        $allProps = $allProps["res"];

        foreach ($allProps as $prop) {
            if ($prop->is_number) {
                $max = 0;
                $min = 0;
                foreach ($prop->propvalue as $p) {
                    if ($p->value_number < $min) {
                        $min = $p->value_number;
                    }
                    if ($p->value_number > $max) {
                        $max = $p->value_number;
                    }
                }
                $prop->propvalue = ["min" => $min, "max" => $max];
            }
        }
        //zhsmenu
        $zhsmenu = ["childrens" => []];
        $deep = function (&$c) use (&$deep) {
            $q["title"] = $c["key"];
            $q["url"] = "/catalog/" . implode("/", $c["slug"]);
            if (!isset($q["childrens"])) {
                $q["childrens"] = [];
            }
            foreach ($c as $key => $value) {
                if (is_numeric($key)) {
                    $q["childrens"][] = $deep($c[$key]);
                }
            }
            return $q;
        };

        $zhsmenu["childrens"][] = $deep($tree[1]);
        $zhsmenu["childrens"] = $zhsmenu["childrens"][0]["childrens"];
        $zhsmenu = json_encode($zhsmenu);
        //
        return view('home', compact("tree", "count", "els", "id", "sectionIsset", "sectionsDetail", "allProps", "resParams", "allPropValue", "page", "zhsmenu", "filter"));
    }

    public function detail($id)
    {
        $el = (Iblocks::ElementsGetList([$id])[0]);
        $id = $el["iblock_id"];
        $tree = Iblocks::SectionGetList(1);
        $tree = Iblocks::treeToArray($tree);

        //zhsmenu
        $zhsmenu = ["childrens" => []];
        $deep = function (&$c) use (&$deep) {
            $q["title"] = $c["key"];
            $q["url"] = "/catalog/" . implode("/", $c["slug"]);
            if (!isset($q["childrens"])) {
                $q["childrens"] = [];
            }
            foreach ($c as $key => $value) {
                if (is_numeric($key)) {
                    $q["childrens"][] = $deep($c[$key]);
                }
            }
            return $q;
        };

        $zhsmenu["childrens"][] = $deep($tree[1]);
        $zhsmenu["childrens"] = $zhsmenu["childrens"][0]["childrens"];
        $zhsmenu = json_encode($zhsmenu);
        return view('detail', compact("id", "tree", "el", "zhsmenu"));
    }


}