<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class sm_mview extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sm_mview';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sm_mview';

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


        $ua="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";
        $ru="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";
        $en="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";


        $Allc = DB::table('Foto')
            ->select('id')
            ->groupBy('id')
            ->where('id', '>', 0)
            ->where('x', '>', 0)
            ->get();
        foreach ($Allc as $All) {
            $id = $All->id;



            $ua.="  <url>
    <loc>https://1ua.com.ua/mc$id</loc>
  </url>
";
            $ru.="  <url>
    <loc>https://1ua.com.ua/rmc$id</loc>
  </url>
";
            $en.="  <url>
    <loc>https://1ua.com.ua/emc$id</loc>
  </url>
";
        }

        $ua.="
</urlset>";
        $ru.="
</urlset>";
        $en.="
</urlset>";


        Storage::disk('public')->put('sm/mcua.xml', $ua);
        Storage::disk('public')->put('sm/mcru.xml', $ru);
        Storage::disk('public')->put('sm/mcen.xml', $en);

        $memory_contents = Storage::disk('public')->get('sitemap.xml');

        $Md_tod = date('Y-m-d');


        $position = strpos($memory_contents, "/mcua.xml"); $content = substr($memory_contents, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/mcua.xml</loc>
             <lastmod>$Md_tod", $memory_contents);

        $position = strpos($memory_contents_new, "/mcru.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/mcru.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);

        $position = strpos($memory_contents_new, "/mcen.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/mcen.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);

        Storage::disk('public')->put('sitemap.xml', $memory_contents_new);

        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Fmcua.xml').'<br/>';
        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Fmcru.xml').'<br/>';
        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Fmcen.xml').'<br/>';
        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsitemap.xml').'<br/>';


        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/mcua.xml').'<br/>';
        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/mcru.xml').'<br/>';
        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/mcen.xml').'<br/>';
        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sitemap.xml').'<br/>';


    }


}
