<?php

namespace App\Console\Commands;

use App\Models\iblock;
use App\Service\Iblocks;
use Illuminate\Console\Command;

class GenerateSiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:refresh';

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
        $file = "./public/sitemap.xml";
        if (file_exists($file)) {
            unlink($file);
        }
        $item = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        file_put_contents($file, $item);



        $sections = Iblocks::SectionGetList(1);
        $sections = Iblocks::treeToArray($sections);
        $sectionsSlug = [];
        foreach ($sections as $key => $sect) {
            if (is_numeric($key)) {
                $sectionsSlug[$key] = "/catalog/" . implode("/", $sect["slug"]);
            }
        }
        foreach ($sections as $id => $sect) {
            $item = '<url><loc>http://bitrix.su' . $sectionsSlug[$id] . '</loc></url>';
            file_put_contents($file, $item, FILE_APPEND);
        }
        $count = Iblocks::ElementsGetListByIblockId(1, 5, 1)["count"];
        for ($i = 1; $i <= ceil($count / 5); $i++) {
            $elements = Iblocks::ElementsGetListByIblockId(1, 5, $i)["res"];
            foreach ($elements as $el) {
                $item = '<url><loc>http://bitrix.su' . $sectionsSlug[$el["iblock_id"]] . $el["slug"] . '</loc></url>';
                file_put_contents($file, $item, FILE_APPEND);
            }
        }

        $item = '</urlset>';
        file_put_contents($file, $item, FILE_APPEND);
        return 0;
    }
}