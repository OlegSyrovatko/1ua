<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class sm_blogallcities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sm_blogallcities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sm_blogallcities';

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


        $ua1="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";
        $ru1="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";
        $ua2="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";
        $ru2="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";



        $Allc = DB::table('Allcities')->select('domen')->
        where('id', '>', 0)->get();
        foreach ($Allc as $All) {
            $domen = $All->domen;
            $ua1.="  <url>
    <loc>https://1ua.com.ua/$domen/blog/ua/1</loc>
  </url>
";
            $ru1.="  <url>
    <loc>https://1ua.com.ua/$domen/blog/ru/1</loc>
  </url>
";
            $ua2.="  <url>
    <loc>https://1ua.com.ua/$domen/blog/ua/2</loc>
  </url>
";
            $ru2.="  <url>
    <loc>https://1ua.com.ua/$domen/blog/ru/2</loc>
  </url>
";
        }

        $ua1.="
</urlset>";
        $ru1.="
</urlset>";
        $ua2.="
</urlset>";
        $ru2.="
</urlset>";


        Storage::disk('public')->put('sm/blogua1.xml', $ua1);
        Storage::disk('public')->put('sm/blogru1.xml', $ru1);
        Storage::disk('public')->put('sm/blogua2.xml', $ua2);
        Storage::disk('public')->put('sm/blogru2.xml', $ru2);


        $memory_contents = Storage::disk('public')->get('sitemap.xml');

        $Md_tod = date('Y-m-d');


        $position = strpos($memory_contents, "/blogua1.xml"); $content = substr($memory_contents, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/blogua1.xml</loc>
             <lastmod>$Md_tod", $memory_contents);

        $position = strpos($memory_contents_new, "/blogru1.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/blogru1.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);

        Storage::disk('public')->put('sitemap.xml', $memory_contents_new);
        $memory_contents = Storage::disk('public')->get('sitemap.xml');

        $position = strpos($memory_contents, "/blogua2.xml"); $content = substr($memory_contents, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/blogua2.xml</loc>
             <lastmod>$Md_tod", $memory_contents);

        $position = strpos($memory_contents_new, "/blogru2.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/blogru2.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);


        Storage::disk('public')->put('sitemap.xml', $memory_contents_new);

        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Fblogua1.xml').'<br/>';
        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Fblogru1.xml').'<br/>';
        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Fblogua2.xml').'<br/>';
        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Fblogru2.xml').'<br/>';
        print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsitemap.xml').'<br/>';


        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/blogua1.xml').'<br/>';
        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/blogru1.xml').'<br/>';
        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/blogua2.xml').'<br/>';
        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/blogru2.xml').'<br/>';
        print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sitemap.xml').'<br/>';


    }


}
