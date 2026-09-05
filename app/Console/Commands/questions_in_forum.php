<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class questions_in_forum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'questions_in_forum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'questions_in_forum';

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

        $Allu = DB::table('Allcities')
            ->select('id','obl','City','City2','questions',DB::raw('LENGTH(questions) AS summem'))
            ->orderBy('summem','Desc')
            ->get();

        foreach ($Allu as $Alu) {
            $id=$Alu->id; $obl=$Alu->obl; $City=$Alu->City; $City2=$Alu->City2; $questions=$Alu->questions; $kball=$Alu->summem;
            if($kball>=777){
                // if($kball==985){
                echo"$id $City $kball <br />";
                $questions_from=$questions;
                $questions_n = substr_count($questions,"#!^:*&");

                $questions = explode("#!^:*&", $questions);
                // echo"questions $questions<br /><br />";

                $ques=$questions[1];
                $aaa_n = substr_count($ques,"#!:*&");
                $que = explode("#!:*&", $ques);
                $q=$que[1]; echo"q $q<br /><br />";

                $questionin = str_replace("#!^:*&$ques", "", $questions_from);

                DB::table('Allcities')
                    ->where('id', $id)
                    ->update(['questions' => $questionin]);

                // Дата самого питання (коли його реально задали), а не часу запуску цієї команди —
                // раніше $que[2] читалось і одразу губилось, у Memory.Md писався поточний момент.
                // Формат при створенні питання (question_inc/question_inp): date('Y-m-d-H-i-s').
                $Md = date('Y-m-d H:i:s');
                $questionDateParts = explode('-', $que[2] ?? '');
                if (count($questionDateParts) === 6) {
                    [$qY, $qM, $qD, $qH, $qI, $qS] = $questionDateParts;
                    $Md = "$qY-$qM-$qD $qH:$qI:$qS";
                }
                $ans = "<b>%^&@#</b> - $q <br /><b>&@#%^</b> -";
                DB::table('Memory')
                    ->insert(['id' => $id, 'obl' => $obl, 'City' => $City, 'City2' => $City2, 'Aboutec' => $ans, 'Md' => $Md]);

            }
        }

    }


}
