<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class s3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 's3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 's3';

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

        $cats = Storage::disk('public')->Directories('Photos');
        foreach ($cats as $cat){
            $filess = Storage::disk('public')->files($cat);
            $nf = 0;
            foreach ( $filess as  $files){$nf++;}

            echo"dir $cat filess $nf<br />";

            if($nf == 0){$dres = Storage::disk('public')->deleteDirectory($cat);
                if($dres){echo"delete <br />";}
            }
            break;
        }


        $cats = Storage::disk('public')->Directories('Photos');
        foreach ($cats as $cat){
            $filess = Storage::disk('public')->files($cat);
            $nf = 0;
            foreach ( $filess as  $files){$nf++;}
            echo"dir $cat filess $nf<br />";
            break;
        }


        sleep(5);


        $cats = Storage::disk('public')->Directories('Photos');
        foreach ($cats as $cat){
            $filess = Storage::disk('public')->files($cat);
            $nf2 = 0;
            foreach ( $filess as  $files){$nf2++;}
            echo" filess2 $nf2<br />";
            break;
        }

        if($nf == $nf2){

            echo"go";
            $files = Storage::disk('public')->files($cat);
            foreach ($files as $file)
            {

                $from_file = $file;
                //  if (Storage::disk('s3')->missing($nf)) {
                $from_file = Storage::disk('public')->get($file); //   if($from_file){} else {echo "$file"; }
                if($from_file){ $aff =  Storage::disk('s3')->put($file,$from_file); }
                if($aff){ $affff = Storage::disk('public')->delete($file); }
                //     if($affff){echo " delete $nf "; }
                // }
                //  }
            }
        }


    }


}
