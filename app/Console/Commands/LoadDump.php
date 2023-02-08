<?php

namespace App\Console\Commands;

use App\Models\iblock;
use App\Service\Iblocks;
use Illuminate\Console\Command;

class LoadDump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dump:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $data = json_decode(file_get_contents('https://catalogloader.com/downloads/e/json_catalogloader.json'), 1);
        /*
        $cc = [];
        foreach ($data["catalog"][0]["categories"] as $key => $value) {
        if (isset($value["parent_id"])) {
        $id = Iblocks::addSection(["name" => $value["name"]], $cc[$value["parent_id"]]);
        $cc[$value["id"]] = $id;
        } else {
        $id = Iblocks::addSection(["name" => $value["name"]], 1);
        $cc[$value["id"]] = $id;
        }
        }
        */

        for ($i = 0; $i < 600; $i++) {
            foreach ($data["catalog"][1]["products"] as $key => $value) {
                foreach ($data["catalog"][0]["categories"] as $key => $svalue) {
                    if ($svalue["id"] == $value["category_id"]) {
                        $iblockId = iblock::where("name", "=", $svalue["name"])->first()->id;
                        break;
                    }
                }
                $res = [];
                foreach ($value["features"] as $q) {
                    $res[$q["name"]] = $q["value"];
                }
                $res["price"] = random_int(100, 999);
                Iblocks::addElement(["name" => $value["name"], "prop" => $res], $iblockId);
            }
        }


        return 0;
    }
}