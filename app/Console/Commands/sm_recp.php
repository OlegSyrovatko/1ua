<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class sm_recp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sm_recp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sm_recp';

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




        $Allc = DB::table('Memoryp')
            ->select('idrec')
            ->orderBy('Md', 'desc')
            ->where(DB::raw('LENGTH(Aboutep)'), '>', 500)
            ->get();


        foreach ($Allc as $All) {
            $idrec = $All->idrec;

                $ua .= "  <url>
    <loc>https://1ua.com.ua/recp$idrec</loc>
  </url>
";
                $ru .= "  <url>
    <loc>https://1ua.com.ua/rrecp$idrec</loc>
  </url>
";
                $en .= "  <url>
    <loc>https://1ua.com.ua/erecp$idrec</loc>
  </url>
";

        }

        $ua.="
</urlset>";
        $ru.="
</urlset>";
        $en.="
</urlset>";



        Storage::disk('public')->put('sm/recpua.xml', $ua);
        Storage::disk('public')->put('sm/recpru.xml', $ru);
        Storage::disk('public')->put('sm/recpen.xml', $en);

        $memory_contents = Storage::disk('public')->get('sitemap.xml');

        $Md_tod = date('Y-m-d');


        $position = strpos($memory_contents, "/recpua.xml"); $content = substr($memory_contents, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/recpua.xml</loc>
             <lastmod>$Md_tod", $memory_contents);

        $position = strpos($memory_contents_new, "/recpru.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/recpru.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);

        $position = strpos($memory_contents_new, "/recpen.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/recpen.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);

        Storage::disk('public')->put('sitemap.xml', $memory_contents_new);



        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Fnfua1.xml').'<br/>';
        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Fnfru1.xml').'<br/>';
        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Fnfen1.xml').'<br/>';
        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Fnfua2.xml').'<br/>';
        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Fnfru2.xml').'<br/>';
        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Fnfen2.xml').'<br/>';

        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsitemap.xml').'<br/>';


        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/nfua1.xml').'<br/>';
        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/nfru1.xml').'<br/>';
        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/nfen1.xml').'<br/>';
        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/nfua2.xml').'<br/>';
        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/nfru2.xml').'<br/>';
        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/nfen2.xml').'<br/>';

        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sitemap.xml').'<br/>';


    }


}
