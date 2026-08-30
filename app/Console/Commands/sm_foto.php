<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class sm_foto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sm_foto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sm_foto';

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

        $Allm = DB::table('Allcities')->select('id','domen')
            ->get();

        foreach ($Allm as $All) {
            $idf=$All->id; $domen=$All->domen;
            $Foto[$idf]=$domen;
        }

        $Allc = DB::table('Foto')
            ->select('id')
            ->groupBy('id')
            ->where('id', '>', 0)->get();
        foreach ($Allc as $All) {
            $id = $All->id;
            $domen = $Foto[$id];


            $ua.="  <url>
    <loc>https://1ua.com.ua/$domen/foto</loc>
  </url>
";
            $ru.="  <url>
    <loc>https://1ua.com.ua/$domen/foto/ru</loc>
  </url>
";
            $en.="  <url>
    <loc>https://1ua.com.ua/$domen/foto/en</loc>
  </url>
";
        }

        $ua.="
</urlset>";
        $ru.="
</urlset>";
        $en.="
</urlset>";


        Storage::disk('public')->put('sm/fcua.xml', $ua);
        Storage::disk('public')->put('sm/fcru.xml', $ru);
        Storage::disk('public')->put('sm/fcen.xml', $en);

        $memory_contents = Storage::disk('public')->get('sitemap.xml');

        $Md_tod = date('Y-m-d');


        $position = strpos($memory_contents, "/fcua.xml"); $content = substr($memory_contents, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/fcua.xml</loc>
             <lastmod>$Md_tod", $memory_contents);

        $position = strpos($memory_contents_new, "/fcru.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/fcru.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);

        $position = strpos($memory_contents_new, "/fcen.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/fcen.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);

        Storage::disk('public')->put('sitemap.xml', $memory_contents_new);

        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Ffcua.xml').'<br/>';
        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Ffcru.xml').'<br/>';
        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Ffcen.xml').'<br/>';
        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsitemap.xml').'<br/>';


        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/fcua.xml').'<br/>';
        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/fcru.xml').'<br/>';
        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/fcen.xml').'<br/>';
        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sitemap.xml').'<br/>';


    }


}
