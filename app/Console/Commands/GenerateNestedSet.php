<?php

namespace App\Console\Commands;

use App\Models\iblock;
use App\Service\Iblocks;
use Illuminate\Console\Command;

class GenerateNestedSet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nestedset:refresh';

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
        $counter = 1;
        $depth_counter = 0;
        $getChilds = function ($iblock) use (&$getChilds, &$counter, &$depth_counter) {
            $iblock->left = $counter++;
            $iblock->depth = $depth_counter++;
            $childs = iblock::where("parent_id", "=", $iblock->id)->get();
            foreach ($childs as $child) {
                $getChilds($child);
            }
            $depth_counter--;
            $iblock->right = $counter++;
            $iblock->save();
        };
        $iblock = iblock::find(1);
        $getChilds($iblock);
        return 0;
    }
}
