<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Iblocks;
use App\Service\functions;
use Illuminate\Support\Facades\Cache;


class IndexController extends Controller
{
    public function __construct()
    {

    }


    /**
     * @OA\Get(
     * path="/api/index/{id}/{page}",
     *
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="number"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="page",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="number"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="catalog+els",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     */
    public function index($id = 1, $page = 1)
    {
        $tree = (Iblocks::SectionGetList($id));
        $els = Iblocks::ElementsGetListByIblockId($id, 5, $page, false, []);
        $count = $els["count"];
        $cEls = $els["res"];

        $props = Iblocks::getAllProps($id, true);
        $cTree = $tree;
        $deep = function (&$c, $id) use (&$cEls, &$deep) {
            foreach ($c as $key => $value) {
                if (is_numeric($key)) {
                    $deep($c[$key], $key);
                }
            }
            $c["sectionDetail"] = functions::getOpItem($id);
        };
        $deep($cTree[$id], $id);
        $kek[$id] = $cTree[$id];
        return ["count" => $count, "tree" => $kek, "props" => $props, "els" => $cEls];
    }

    /**
     * @OA\Get(
     * path="/api/detail/{id}",
     *
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="number"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="el info",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     */
    public function detail($id)
    {
        return (Iblocks::ElementsGetList([$id])[0]);
    }
}
