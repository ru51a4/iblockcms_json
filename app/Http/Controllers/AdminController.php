<?php

namespace App\Http\Controllers;

use App\Models\iblock;
use App\Models\iblock_element;
use App\Models\iblock_prop_value;
use App\Models\iblock_property;
use App\Service\Iblocks;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index()
    {
        $iblocks = iblock::where("parent_id", "=", 0)->get();
        return view('admin/dashboard', compact("iblocks"));
    }

    public function addiblock(Request $request)
    {
        $iblock = new iblock();
        Iblocks::addSection(["name" => $request->name], $request->parent_id);
        return redirect("/admin");
    }

    public function addiblockform()
    {
        $iblocks = iblock::all();
        return view('admin/addiblock', compact("iblocks"));
    }

    public function elementlist(iblock $iblock)
    {
        $breadcrumb = Iblocks::getBreadcrumbIblock($iblock);
        $iblocks = iblock::where("parent_id", "=", $iblock->id)->get();
        $elements = iblock_element::where("iblock_id", "=", $iblock->id)->paginate(20);
        return view('admin/elementlist', compact("iblock", "elements", "iblocks", "breadcrumb"));
    }

    public function iblockeditform(iblock $iblock)
    {
        $breadcrumb = Iblocks::getBreadcrumbIblock($iblock);
        return view('admin/iblockedit', compact("iblock", "breadcrumb"));
    }

    public function iblockedit(Request $request, iblock $iblock)
    {
        $iblock->name = $request->name;
        $iblock->save();
        return redirect("/admin/" . $iblock->id . '/iblockedit');
    }

    public function deleteiblock(iblock $iblock)
    {
        $iblock->delete();
        return redirect("/admin/");
    }

    public function propertyadd(Request $request, iblock $iblock)
    {
        $property = new iblock_property();
        $property->is_number = ($request->is_number == "on") ? 1 : 0;
        $property->is_multy = ($request->is_multy == "on") ? 1 : 0;
        $property->name = $request->name;
        $iblock->properties()->save($property);
        return redirect("/admin/" . $iblock->id . '/iblockedit');

    }

    public function addelementform(iblock $iblock)
    {
        return view('admin/addelement', compact("iblock"));
    }

    public function addelement(Request $request, iblock $iblock)
    {
        $props = $iblock->getPropWithParrents(true);
        $cProps = [];
        foreach ($props as $prop) {
            $cProps[$prop->id] = $request->{$prop->id};
        }
        $obj = ["name" => $request->name, "prop" => $cProps];
        Iblocks::addElement($obj, $iblock->id);
        return redirect("/admin/" . $iblock->id . "/elementlist");
    }

    public function deleteelement($iblock_el)
    {
        $el = iblock_element::find($iblock_el);
        $el->delete();
        return redirect("/admin/");

    }

    public function editelementform(iblock_element $iblock_element)
    {

        $props = $iblock_element->iblock->getPropWithParents(true);

        $resProp = [];

        foreach ($props as $prop) {
            $t = $prop->toArray();
            $cProp = iblock_prop_value::where("el_id", "=", $iblock_element->id)->where("prop_id", "=", $prop->id)->get()->toArray();
            foreach ($cProp as $k) {
                if ($prop->is_number) {
                    $t["value"][$k["value_id"]] = (isset($k["value_number"])) ? $k["value_number"] : "";
                } else {
                    $t["value"][$k["value_id"]] = (isset($k["value"])) ? $k["value"] : "";
                }
            }
            $resProp[] = $t;
        }

        return view('admin/editelement', compact("iblock_element", "resProp"));
    }

    public function editelement(iblock_element $iblock_element, Request $request)
    {
        $iblock_element->name = $request->name;
        $props = $iblock_element->iblock->getPropWithParrents();
        $iblock_element->update();
        $c = [];
        foreach ($props as $p) {
            if (empty($request->{$p->id})) {
                continue;
            }
            $c[$p->name] = $request->{$p->id};
        }
        Iblocks::updateElement($c, $iblock_element->id);
        return redirect("/admin/" . $iblock_element->iblock_id . "/elementlist");
    }

    public function deleteproperty(iblock $iblock, Request $request)
    {
        iblock_property::where("id", "=", $request->id)->delete();
        return redirect("/admin/");
    }
}
