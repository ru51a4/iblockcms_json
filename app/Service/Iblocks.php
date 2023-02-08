<?php

namespace App\Service;

use App\Models\iblock;
use App\Models\iblock_element;
use App\Models\iblock_property;
use App\Models\iblock_prop_value;
use Illuminate\Support\Facades\Cache;


class Iblocks
{
    public static function getBreadcrumbIblock($iblock)
    {
        $sectionTree = $iblock->getParents();
        $res = [["name" => $iblock->name, "id" => $iblock->id]];
        while ($iblock->parent_id != 0) {
            $iblock = $sectionTree->where("id", "=", $iblock->parent_id)->first();
            $res[] = ["name" => $iblock->name, "id" => $iblock->id];
        }
        return array_reverse($res);
    }

    public static function getPropsParents($iblock, $is_admin = false)
    {
        $sectionTree = $iblock->getParents();
        $res = [];
        foreach ($iblock->properties as $prop) {
            if ($iblock->id == 1 && !$is_admin) {
                continue;
            }
            $res[] = $prop;
        }
        while ($iblock->parent_id != 0) {
            $iblock = $sectionTree->where("id", "=", $iblock->parent_id)->first();
            foreach ($iblock->properties as $prop) {
                if ($iblock->id == 1 && !$is_admin) {
                    continue;
                }
                $res[] = $prop;
            }
        }
        return $res;
    }

    public static function getAllProps($iblock, $values = false)
    {
        $res = [];
        $iblock = iblock::find($iblock);
        $ids = $iblock->getParents()->map(function ($item) {
            return $item->id;
        });
        foreach (self::getPropsParents($iblock) as $c) {
            $res[] = $c;
        }
        if ($values) {
            $allProps = $res;
            $allPropValue = [];
            if (!empty($allProps)) {
                foreach ($allProps as $prop) {
                    $els = iblock_element::whereIn("iblock_id",$ids)->whereJsonLength("properties->" . \Str::slug($prop->name) . "->value", ">", 0)->groupBy("properties->" . \Str::slug($prop->name) . "->value")->get();
                    foreach ($els as $el) {
                        $allPropValue[$prop->id][] = $el->properties[\Str::slug($prop->name)];
                    }
                }
            }
            return ["res" => $res, "values" => $allPropValue];
        }
        //todo
        return $res;
        $deep = function ($childs) use (&$res, &$deep) {
            foreach ($childs as $child) {
                foreach ($child->properties as $prop) {
                    $res[] = $prop;
                }
            }
            foreach ($childs as $child) {
                $c = iblock::where("parent_id", "=", $child->id)->get();
                if (count($c)) {
                    $deep($c);
                }
            }
        };
        $c = iblock::where("parent_id", "=", $iblock)->get();
        if (count($c)) {
            $deep($c);
        }
        return $res;
    }

    /*
    $where["prop"];
    $where["type"];
    $where["value"];
    $params["range"]["id"]["to"]
    $params["range"]["id"]["from"]
    $params["param"][$c[1]] = $param;
    */
    public static function ElementsGetListByIblockId($iblockID = 1, $itemPerPage = 5, $page = false, $where = null, $params = null)
    {
        $res = [];
        $ids = iblock::find($iblockID)->getChilds()->map(function ($iblock) {
            return $iblock->id;
        });
        $els = iblock_element::whereIn("iblock_id", $ids);
        if ($page) {
            $els = $els->where("name", "!=", "op");
        }
        if ($where) {
            foreach ($where as $cond) {
                $els->where('properties->key', '=', $cond["prop"])
                    ->where("properties->value", $cond["type"], $cond["value"]);
            }
        }

        if (isset($params["param"])) {
            foreach ($params["param"] as $id => $param) {
                $els->where(function ($query) use ($param, $id) {
                    $query->WhereJsonContains("properties->" . $id . "->slug", $param[0]);
                    for ($i = 1; $i <= count($param) - 1; $i++) {
                        $query->orWhereJsonContains("properties->" . $id . "->slug", $param[$i]);
                    }
                });
            }
        }

        $count = $els->count();
        if ($page) {
            $els = $els->offset($itemPerPage * ($page - 1))->take($itemPerPage);
        }
        $els = $els->get();
        foreach ($els as $el) {
            $t = $el->toArray();
            $t["prop"] = [];
            foreach (($el["properties"]) as $key => $item) {
                if (count($item["value"]) > 1) {
                    $key = $item["prop_name"];
                    $item = $item["value"];
                } else {
                    $key = $item["prop_name"];
                    $item = $item["value"][0];
                }
                $t["prop"][$key] = $item;
            }
            unset($t["properties"]);
            $res[] = $t;
        }
        return ["count" => $count, "res" => $res];
    }

    public static function SectionGetList($iblockID)
    {
        $res = [];
        $iblock = iblock::find($iblockID);
        $stack = [$iblock];
        //nested set
        $sectionTree = $iblock->getChilds();
        $getChilds = function ($iblock, &$c) use (&$getChilds, &$stack, &$sectionTree) {
            $c[$iblock->id]["key"] = $iblock->name;
            $c[$iblock->id]["path"] = array_map(
                function ($item) {
                    return $item->id;
                }
                ,
                $stack
            );
            $c[$iblock->id]["slug"] = array_map(
                function ($item) {
                    return $item->slug;
                }
                ,
                array_slice($stack, 1)
            );
            //
            $childs = $sectionTree->where("parent_id", "=", $iblock->id)->all();
            foreach ($childs as $child) {
                $stack[] = $child;
                $getChilds($child, $c[$iblock->id]);
                array_pop($stack);
            }
        };
        $getChilds($iblock, $res);

        return $res;
    }

    public static function ElementsGetList($ids)
    {
        $els = iblock_element::whereIn('id', $ids)->get();
        $res = [];
        foreach ($els as $el) {
            $t = $el->toArray();
            $t["prop"] = [];
            foreach (($el["properties"]) as $key => $item) {
                if (count($item["value"]) > 1) {
                    $key = $item["prop_name"];
                    $item = $item["value"];
                } else {
                    $key = $item["prop_name"];
                    $item = $item["value"][0];
                }
                $t["prop"][$key] = $item;
            }
            unset($t["properties"]);
            $res[] = $t;
        }
        return $res;
    }

    /**
     * $obj = ["name"=>"air core2dd", "prop"=>["prop1"=>"aaa"]];
     * Iblocks::addElement($obj, 1);
     */
    public static function addElement($obj, $iblockId)
    {
        //$el = iblock_element::where("name", "=", $obj["name"])->first();
        //if (empty($el)) {
        $el = new iblock_element();
        //}
        $el->name = $obj["name"];
        $el->slug = \Str::slug($obj["name"]);
        $el->iblock_id = $iblockId;
        $el->properties = [];
        foreach ($obj["prop"] as $id => $prop) {
            if (empty($prop)) {
                continue;
            }
            $propsIds = self::getAllProps($iblockId, false);
            $propsIds = array_map(function ($prop) {
                return $prop->id;
            }, $propsIds);
            if (is_int($id)) {
                $prop = iblock_property::where("id", "=", $id)->whereIn("id", $propsIds)->first();
            } else {
                $prop = iblock_property::where("name", "=", $id)->whereIn("id", $propsIds)->first();
            }
            if (empty($prop)) {
                $prop = new iblock_property();
                $prop->name = $id;
                $prop->iblock_id = $iblockId;
                if (is_array($obj["prop"][$id])) {
                    $isMulty = true;
                    $isNumber = is_int($obj["prop"][$id][0]);
                } else {
                    $isMulty = false;
                    $isNumber = is_int($obj["prop"][$id]);
                }
                $prop->is_multy = $isMulty;
                $prop->is_number = $isNumber;
                $prop->save();
            }
            //multy shit
            if (is_array($obj["prop"][$id])) {
                $properties = [];
                foreach ($obj["prop"][$id] as $item) {
                    $pp[] = $item;
                    $pslug[] = \Str::slug($prop->name) . "_" . \Str::slug($item);
                }
                $properties[\Str::slug($prop->name)] = ["prop_name" => $prop->name, "prop" => $prop->id, "value" => $pp, "slug" => $pslug];

                $pp = ($el->properties);
                foreach ($pp as $key => $item) {
                    $properties[$key] = $item;
                }
                $el->properties = ($properties);
            } else {
                $properties[\Str::slug($prop->name)] = ["prop_name" => $prop->name, "prop" => $prop->id, "value" => [$obj["prop"][$id]], "slug" => [\Str::slug($prop->name) . "_" . \Str::slug($obj["prop"][$id])]];
                $pp = ($el->properties);
                foreach ($pp as $key => $item) {
                    $properties[$key] = $item;
                }
                $el->properties = ($properties);
            }
        }

        $el->save();
    }

    public static function addSection($obj, $parentId)
    {
        $el = new iblock();
        $el->name = $obj["name"];
        $el->slug = \Str::slug($obj["name"]);
        $el->parent_id = (is_numeric($parentId)) ? $parentId : 0;
        $el->save();
        return $el->id;
    }

    /**
     * $prop = ["prop1"=>"bbb"];
     * Iblocks::updateElement($prop, 16);
     */
    public static function updateElement($props, $elId)
    {
        foreach ($props as $key => $p) {
            $p = iblock_property::where("name", "=", $key)->first();
            if (isset($props[$p->name])) {
                iblock_prop_value::where("el_id", "=", $elId)->where("prop_id", "=", $p->id)->delete();
                if (is_array($props[$p->name])) {
                    $count = 0;
                    foreach ($props[$p->name] as $item) {
                        if (empty($item)) {
                            continue;
                        }
                        $c = new iblock_prop_value();
                        $c->el_id = $elId;
                        $c->prop_id = $p->id;
                        $c->slug = \Str::slug($p->name . "-" . $item);
                        $c->value_id = ++$count;
                        if ($p->is_number) {
                            $c->value_number = (integer) $item;
                        } else {
                            $c->value = $item;
                        }
                        $c->save();
                    }
                } else {
                    $count = 0;
                    $c = new iblock_prop_value();
                    $c->el_id = $elId;
                    $c->prop_id = $p->id;
                    $c->slug = \Str::slug($p->name . "-" . $item);
                    $c->value_id = ++$count;
                    if ($p->is_number) {
                        $c->value_number = (integer) $props[$p->name];
                    } else {
                        $c->value = $props[$p->name];
                    }
                    $c->save();
                }
            }
        }
    }

    public static function treeToArray($tree)
    {
        $resTree = [];
        $getTree = function ($tree) use (&$getTree, &$treeKeys, &$resTree) {
            foreach ($tree as $key => $el) {
                //key - iblock_id
                if (isset($el["key"])) { //if curr iblock
                    $resTree[$key] = $el;
                    $getTree($el);
                }
            }
        };
        $getTree($tree);
        return $resTree;
    }
}