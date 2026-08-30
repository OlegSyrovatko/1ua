<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class sm_users extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sm_users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sm_users';

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
        $en1="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";

        $ua2="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";
        $ru2="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";
        $en2="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";

        $ua3="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";
        $ru3="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";
        $en3="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";

        $ua4="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";
        $ru4="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";
        $en4="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
";

        $Allus = DB::table('users')
            ->crossJoin('Private')
            ->select('users.domen')
            ->where('Private.Num','=',DB::raw('users.Num'))
            ->where('Private.Page','!=',5)
            ->where('Private.Page','!=',4)
            ->where('Private.Page','!=',3)
            ->get();
        $Allnn = $Allus->count();
        echo"nr with Private $Allnn";
        foreach ($Allus as $Allu) {
            $domen = $Allu->domen;
            $ua1.="  <url>
    <loc>https://1ua.com.ua/$domen</loc>
  </url>
";
            $ru1.="  <url>
    <loc>https://1ua.com.ua/$domen/ru</loc>
  </url>
";
            $en1.="  <url>
    <loc>https://1ua.com.ua/$domen/en</loc>
  </url>
";

        }



        $ua1.="
</urlset>";
        $ru1.="
</urlset>";
        $en1.="
</urlset>";


        Storage::disk('public')->put('sm/iua1.xml', $ua1);
        Storage::disk('public')->put('sm/iru1.xml', $ru1);
        Storage::disk('public')->put('sm/ien1.xml', $en1);




        $Allus = DB::table('users')
            ->leftjoin('Private', 'users.Num', '=', 'Private.Num')
            ->select('users.domen')
            ->whereNull('Private.Num')
            ->get();

        $Allnn = $Allus->count();

        echo"nr without Private $Allnn<br />";
        $np=1;
        foreach ($Allus as $Allu) {
            $domen = $Allu->domen;
            if($np<49000){
                $ua2.="  <url>
    <loc>https://1ua.com.ua/$domen</loc>
  </url>
";
                $ru2.="  <url>
    <loc>https://1ua.com.ua/$domen/ru</loc>
  </url>
";
                $en2.="  <url>
    <loc>https://1ua.com.ua/$domen/en</loc>
  </url>
";
            }
            if($np>=49000 && $np<98000){
                $ua3.="  <url>
    <loc>https://1ua.com.ua/$domen</loc>
  </url>
";
                $ru3.="  <url>
    <loc>https://1ua.com.ua/$domen/ru</loc>
  </url>
";
                $en3.="  <url>
    <loc>https://1ua.com.ua/$domen/en</loc>
  </url>
";
            }
            if($np>=98000){
                $ua4.="  <url>
    <loc>https://1ua.com.ua/$domen</loc>
  </url>
";
                $ru4.="  <url>
    <loc>https://1ua.com.ua/$domen/ru</loc>
  </url>
";
                $en4.="  <url>
    <loc>https://1ua.com.ua/$domen/en</loc>
  </url>
";
            }

            $np++;
        }


        $ua2.="
</urlset>";
        $ru2.="
</urlset>";
        $en2.="
</urlset>";
        $ua3.="
</urlset>";
        $ru3.="
</urlset>";
        $en3.="
</urlset>";
        $ua4.="
</urlset>";
        $ru4.="
</urlset>";
        $en4.="
</urlset>";


        Storage::disk('public')->put('sm/iua2.xml', $ua2);
        Storage::disk('public')->put('sm/iru2.xml', $ru2);
        Storage::disk('public')->put('sm/ien2.xml', $en2);
        Storage::disk('public')->put('sm/iua3.xml', $ua3);
        Storage::disk('public')->put('sm/iru3.xml', $ru3);
        Storage::disk('public')->put('sm/ien3.xml', $en3);
        Storage::disk('public')->put('sm/iua4.xml', $ua4);
        Storage::disk('public')->put('sm/iru4.xml', $ru4);
        Storage::disk('public')->put('sm/ien4.xml', $en4);


        $memory_contents = Storage::disk('public')->get('sitemap.xml');

        $Md_tod = date('Y-m-d');

        $position = strpos($memory_contents, "/iua1.xml"); $content = substr($memory_contents, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/iua1.xml</loc>
             <lastmod>$Md_tod", $memory_contents);

        $position = strpos($memory_contents_new, "/iru1.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/iru1.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);

        $position = strpos($memory_contents_new, "/ien1.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/ien1.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);

        Storage::disk('public')->put('sitemap.xml', $memory_contents_new);

        $position = strpos($memory_contents, "/iua2.xml"); $content = substr($memory_contents, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/iua2.xml</loc>
             <lastmod>$Md_tod", $memory_contents);

        $position = strpos($memory_contents_new, "/iru2.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/iru2.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);

        $position = strpos($memory_contents_new, "/ien2.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/ien2.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);

        Storage::disk('public')->put('sitemap.xml', $memory_contents_new);

        $position = strpos($memory_contents, "/iua3.xml"); $content = substr($memory_contents, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/iua3.xml</loc>
             <lastmod>$Md_tod", $memory_contents);

        $position = strpos($memory_contents_new, "/iru3.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/iru3.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);

        $position = strpos($memory_contents_new, "/ien3.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/ien3.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);

        Storage::disk('public')->put('sitemap.xml', $memory_contents_new);

        $position = strpos($memory_contents, "/iua4.xml"); $content = substr($memory_contents, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/iua4.xml</loc>
             <lastmod>$Md_tod", $memory_contents);

        $position = strpos($memory_contents_new, "/iru4.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/iru4.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);

        $position = strpos($memory_contents_new, "/ien4.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/ien4.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);

        Storage::disk('public')->put('sitemap.xml', $memory_contents_new);




                print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Fiua1.xml').'<br/>';
                print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Firu1.xml').'<br/>';
                print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2ien1.xml').'<br/>';
                print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Fiua2.xml').'<br/>';
                print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Firu2.xml').'<br/>';
                print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2ien2.xml').'<br/>';
                print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Fiua3.xml').'<br/>';
                print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Firu3.xml').'<br/>';
                print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2ien3.xml').'<br/>';
                print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Fiua4.xml').'<br/>';
                print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2Firu4.xml').'<br/>';
                print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsm%2ien4.xml').'<br/>';

                print file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=https%3A%2F%2F1ua.com.ua%2Fsitemap.xml').'<br/>';


                print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/iua1.xml').'<br/>';
                print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/iru1.xml').'<br/>';
                print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/ien1.xml').'<br/>';
                print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/iua2.xml').'<br/>';
                print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/iru2.xml').'<br/>';
                print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/ien2.xml').'<br/>';
                print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/iua3.xml').'<br/>';
                print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/iru3.xml').'<br/>';
                print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/ien3.xml').'<br/>';
                print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/iua4.xml').'<br/>';
                print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/iru4.xml').'<br/>';
                print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sm/ien4.xml').'<br/>';

                print file_get_contents('https://www.bing.com/webmaster/ping.aspx?siteMap=https://1ua.com.ua/sitemap.xml').'<br/>';


    }


}
