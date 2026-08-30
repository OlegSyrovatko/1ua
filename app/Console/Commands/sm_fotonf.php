<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class sm_fotonf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sm_fotonf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sm_fotonf';

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



        $Allc = DB::table('Memoryf')
            ->select('Num')
            ->orderBy('Md', 'desc')
            ->groupBy('Num')
            ->where('Num', '>', 0)
            ->where('id', '>', 0)
            ->get();

        $nnf=1;
        foreach ($Allc as $All) {
            $Num = $All->Num;
            if($nnf<49000) {
                $ua1 .= "  <url>
    <loc>https://1ua.com.ua/nf$Num</loc>
  </url>
";
                $ru1 .= "  <url>
    <loc>https://1ua.com.ua/rnf$Num</loc>
  </url>
";
                $en1 .= "  <url>
    <loc>https://1ua.com.ua/enf$Num</loc>
  </url>
";
            }
            if($nnf>=49000){
                $ua2 .= "  <url>
    <loc>https://1ua.com.ua/nf$Num</loc>
  </url>
";
                $ru2 .= "  <url>
    <loc>https://1ua.com.ua/rnf$Num</loc>
  </url>
";
                $en2 .= "  <url>
    <loc>https://1ua.com.ua/enf$Num</loc>
  </url>
";

            }
            $nnf++;
        }

        $ua1.="
</urlset>";
        $ru1.="
</urlset>";
        $en1.="
</urlset>";
        $ua2.="
</urlset>";
        $ru2.="
</urlset>";
        $en2.="
</urlset>";


        Storage::disk('public')->put('sm/nfua1.xml', $ua1);
        Storage::disk('public')->put('sm/nfru1.xml', $ru1);
        Storage::disk('public')->put('sm/nfen1.xml', $en1);
        Storage::disk('public')->put('sm/nfua2.xml', $ua2);
        Storage::disk('public')->put('sm/nfru2.xml', $ru2);
        Storage::disk('public')->put('sm/nfen2.xml', $en2);

        $memory_contents = Storage::disk('public')->get('sitemap.xml');

        $Md_tod = date('Y-m-d');


        $position = strpos($memory_contents, "/nfua1.xml"); $content = substr($memory_contents, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/nfua1.xml</loc>
             <lastmod>$Md_tod", $memory_contents);

        $position = strpos($memory_contents_new, "/nfru1.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/nfru1.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);

        $position = strpos($memory_contents_new, "/nfen1.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/nfen1.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);

        Storage::disk('public')->put('sitemap.xml', $memory_contents_new);
        $memory_contents = Storage::disk('public')->get('sitemap.xml');

        $position = strpos($memory_contents, "/nfua2.xml"); $content = substr($memory_contents, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/nfua2.xml</loc>
             <lastmod>$Md_tod", $memory_contents);

        $position = strpos($memory_contents_new, "/nfru2.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/nfru2.xml</loc>
             <lastmod>$Md_tod", $memory_contents_new);

        $position = strpos($memory_contents_new, "/nfen2.xml"); $content = substr($memory_contents_new, $position);
        $positiont = strpos($content, "</lastmod>"); $content = substr($content, 0, $positiont);
        $memory_contents_new = str_replace("$content", "/nfen2.xml</loc>
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
