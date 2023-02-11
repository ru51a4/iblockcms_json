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
        $props = $iblock->getPropWithParents(true);
        $cProps = [];
        foreach ($props as $prop) {
            $cProps[$prop->name] = $request->{$prop->id};
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

        $_props = $iblock_element->iblock->getPropWithParents();
        $props = [];
        foreach ($_props as $prop) {
            $props[\Str::slug($prop->name)] = $prop;
        }
        $resProp = Iblocks::ElementsGetList([$iblock_element->id])[0]["prop"];
        $cProps = [];
        foreach ($resProp as $name => $prop) {
            $cProps[\Str::slug($name)] = $prop;
        }
        $resProp = $cProps;
        return view('admin/editelement', compact("iblock_element", "props", "resProp"));
    }

    public function editelement(iblock_element $iblock_element, Request $request)
    {
        $iblock_element->name = $request->name;
        $props = $iblock_element->iblock->getPropWithParents();
        $iblock_element->update();
        $c = [];
        foreach ($props as $p) {
            if (empty($request->{\Str::slug($p->name)})) {
                continue;
            }
            if (count($request->{\Str::slug($p->name)}) == 1) {
                $c[$p->name] = $request->{\Str::slug($p->name)}[0];
            } else {
                $c[$p->name] = $request->{\Str::slug($p->name)};
            }
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