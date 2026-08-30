<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class Create_domen_for_users extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Create_domen_for_users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create_domen_for_users Scheduler';

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

        $Allus2 = DB::table('users')->select('Num', 'Im', 'Priz')->
        whereNull('domen')->
        orWhere('domen', '')->
        limit(5)->
        get();
        $nus=0;
        foreach ($Allus2 as $All2) {
            $Num = $All2->Num; $Im = $All2->Im; $Priz = $All2->Priz;
            echo"$Num $Im $Priz <br />"; $nus++;
        }

        if($nus!=0){


        $Imn=mb_strlen($Im);
        $Prizn=mb_strlen($Priz);
        $domen1="";
        $domen2="";
        echo"Imn $Imn Prizn $Prizn<br />";
        for($n=0; $n<$Imn; $n++){
            $f = mb_substr($Im, $n, 1, 'UTF-8');
            if($f=="Q"){$fl=$f;}
            else if($f=="q"){$fl=$f;}
            else if($f=="W"){$fl=$f;}
            else if($f=="w"){$fl=$f;}
            else if($f=="E"){$fl=$f;}
            else if($f=="e"){$fl=$f;}
            else if($f=="R"){$fl=$f;}
            else if($f=="r"){$fl=$f;}
            else if($f=="T"){$fl=$f;}
            else if($f=="t"){$fl=$f;}
            else if($f=="Y"){$fl=$f;}
            else if($f=="y"){$fl=$f;}
            else if($f=="U"){$fl=$f;}
            else if($f=="u"){$fl=$f;}
            else if($f=="I"){$fl=$f;}
            else if($f=="i"){$fl=$f;}
            else if($f=="O"){$fl=$f;}
            else if($f=="o"){$fl=$f;}
            else if($f=="P"){$fl=$f;}
            else if($f=="p"){$fl=$f;}
            else if($f=="A"){$fl=$f;}
            else if($f=="a"){$fl=$f;}
            else if($f=="S"){$fl=$f;}
            else if($f=="s"){$fl=$f;}
            else if($f=="D"){$fl=$f;}
            else if($f=="d"){$fl=$f;}
            else if($f=="F"){$fl=$f;}
            else if($f=="f"){$fl=$f;}
            else if($f=="G"){$fl=$f;}
            else if($f=="g"){$fl=$f;}
            else if($f=="H"){$fl=$f;}
            else if($f=="h"){$fl=$f;}
            else if($f=="J"){$fl=$f;}
            else if($f=="j"){$fl=$f;}
            else if($f=="K"){$fl=$f;}
            else if($f=="k"){$fl=$f;}
            else if($f=="L"){$fl=$f;}
            else if($f=="l"){$fl=$f;}
            else if($f=="Z"){$fl=$f;}
            else if($f=="z"){$fl=$f;}
            else if($f=="X"){$fl=$f;}
            else if($f=="x"){$fl=$f;}
            else if($f=="C"){$fl=$f;}
            else if($f=="c"){$fl=$f;}
            else if($f=="V"){$fl=$f;}
            else if($f=="v"){$fl=$f;}
            else if($f=="B"){$fl=$f;}
            else if($f=="b"){$fl=$f;}
            else if($f=="N"){$fl=$f;}
            else if($f=="n"){$fl=$f;}
            else if($f=="M"){$fl=$f;}
            else if($f=="m"){$fl=$f;}
            else if($f=="1"){$fl=$f;}
            else if($f=="2"){$fl=$f;}
            else if($f=="3"){$fl=$f;}
            else if($f=="4"){$fl=$f;}
            else if($f=="5"){$fl=$f;}
            else if($f=="6"){$fl=$f;}
            else if($f=="7"){$fl=$f;}
            else if($f=="8"){$fl=$f;}
            else if($f=="9"){$fl=$f;}
            else if($f=="0"){$fl=$f;}
            else if($f=="Й"){$fl="Y";}
            else if($f=="й"){$fl="y";}
            else if($f=="Ц"){$fl="Ts";}
            else if($f=="ц"){$fl="ts";}
            else if($f=="У"){$fl="U";}
            else if($f=="у"){$fl="u";}
            else if($f=="К"){$fl="K";}
            else if($f=="к"){$fl="k";}
            else if($f=="Е"){$fl="E";}
            else if($f=="е"){$fl="e";}
            else if($f=="Н"){$fl="N";}
            else if($f=="н"){$fl="n";}
            else if($f=="Г"){$fl="G";}
            else if($f=="г"){$fl="g";}
            else if($f=="Ш"){$fl="Sh";}
            else if($f=="ш"){$fl="sh";}
            else if($f=="Щ"){$fl="Shch";}
            else if($f=="щ"){$fl="shch";}
            else if($f=="З"){$fl="Z";}
            else if($f=="з"){$fl="z";}
            else if($f=="Х"){$fl="H";}
            else if($f=="х"){$fl="h";}
            else if($f=="Ф"){$fl="F";}
            else if($f=="ф"){$fl="f";}
            else if($f=="І"){$fl="I";}
            else if($f=="і"){$fl="i";}
            else if($f=="В"){$fl="V";}
            else if($f=="в"){$fl="v";}
            else if($f=="А"){$fl="A";}
            else if($f=="а"){$fl="a";}
            else if($f=="П"){$fl="P";}
            else if($f=="п"){$fl="p";}
            else if($f=="Р"){$fl="R";}
            else if($f=="р"){$fl="r";}
            else if($f=="О"){$fl="O";}
            else if($f=="о"){$fl="o";}
            else if($f=="Л"){$fl="L";}
            else if($f=="л"){$fl="l";}
            else if($f=="Д"){$fl="D";}
            else if($f=="д"){$fl="d";}
            else if($f=="Ж"){$fl="G";}
            else if($f=="ж"){$fl="g";}
            else if($f=="Є"){$fl="Ye";}
            else if($f=="є"){$fl="ye";}
            else if($f=="Я"){$fl="Ya";}
            else if($f=="я"){$fl="ya";}
            else if($f=="Ч"){$fl="Ch";}
            else if($f=="ч"){$fl="ch";}
            else if($f=="С"){$fl="S";}
            else if($f=="с"){$fl="s";}
            else if($f=="М"){$fl="M";}
            else if($f=="м"){$fl="m";}
            else if($f=="И"){$fl="I";}
            else if($f=="и"){$fl="y";}
            else if($f=="Т"){$fl="T";}
            else if($f=="т"){$fl="t";}
            else if($f=="Б"){$fl="B";}
            else if($f=="б"){$fl="b";}
            else if($f=="Ю"){$fl="Yu";}
            else if($f=="ю"){$fl="yu";}
            else if($f=="Ы"){$fl="Y";}
            else if($f=="ы"){$fl="y";}
            else if($f=="Э"){$fl="E";}
            else if($f=="э"){$fl="e";}
            else if($f=="Ё"){$fl="Yo";}
            else if($f=="ё"){$fl="yo";}
            else{$fl="";}
            $domen1.=$fl;
        }


        for($n=0; $n<$Prizn; $n++){

            $f = mb_substr($Priz, $n, 1, 'UTF-8');
            if($f=="Q"){$fl=$f;}
            else if($f=="q"){$fl=$f;}
            else if($f=="W"){$fl=$f;}
            else if($f=="w"){$fl=$f;}
            else if($f=="E"){$fl=$f;}
            else if($f=="e"){$fl=$f;}
            else if($f=="R"){$fl=$f;}
            else if($f=="r"){$fl=$f;}
            else if($f=="T"){$fl=$f;}
            else if($f=="t"){$fl=$f;}
            else if($f=="Y"){$fl=$f;}
            else if($f=="y"){$fl=$f;}
            else if($f=="U"){$fl=$f;}
            else if($f=="u"){$fl=$f;}
            else if($f=="I"){$fl=$f;}
            else if($f=="i"){$fl=$f;}
            else if($f=="O"){$fl=$f;}
            else if($f=="o"){$fl=$f;}
            else if($f=="P"){$fl=$f;}
            else if($f=="p"){$fl=$f;}
            else if($f=="A"){$fl=$f;}
            else if($f=="a"){$fl=$f;}
            else if($f=="S"){$fl=$f;}
            else if($f=="s"){$fl=$f;}
            else if($f=="D"){$fl=$f;}
            else if($f=="d"){$fl=$f;}
            else if($f=="F"){$fl=$f;}
            else if($f=="f"){$fl=$f;}
            else if($f=="G"){$fl=$f;}
            else if($f=="g"){$fl=$f;}
            else if($f=="H"){$fl=$f;}
            else if($f=="h"){$fl=$f;}
            else if($f=="J"){$fl=$f;}
            else if($f=="j"){$fl=$f;}
            else if($f=="K"){$fl=$f;}
            else if($f=="k"){$fl=$f;}
            else if($f=="L"){$fl=$f;}
            else if($f=="l"){$fl=$f;}
            else if($f=="Z"){$fl=$f;}
            else if($f=="z"){$fl=$f;}
            else if($f=="X"){$fl=$f;}
            else if($f=="x"){$fl=$f;}
            else if($f=="C"){$fl=$f;}
            else if($f=="c"){$fl=$f;}
            else if($f=="V"){$fl=$f;}
            else if($f=="v"){$fl=$f;}
            else if($f=="B"){$fl=$f;}
            else if($f=="b"){$fl=$f;}
            else if($f=="N"){$fl=$f;}
            else if($f=="n"){$fl=$f;}
            else if($f=="M"){$fl=$f;}
            else if($f=="m"){$fl=$f;}
            else if($f=="1"){$fl=$f;}
            else if($f=="2"){$fl=$f;}
            else if($f=="3"){$fl=$f;}
            else if($f=="4"){$fl=$f;}
            else if($f=="5"){$fl=$f;}
            else if($f=="6"){$fl=$f;}
            else if($f=="7"){$fl=$f;}
            else if($f=="8"){$fl=$f;}
            else if($f=="9"){$fl=$f;}
            else if($f=="0"){$fl=$f;}
            else if($f=="Й"){$fl="Y";}
            else if($f=="й"){$fl="y";}
            else if($f=="Ц"){$fl="Ts";}
            else if($f=="ц"){$fl="ts";}
            else if($f=="У"){$fl="U";}
            else if($f=="у"){$fl="u";}
            else if($f=="К"){$fl="K";}
            else if($f=="к"){$fl="k";}
            else if($f=="Е"){$fl="E";}
            else if($f=="е"){$fl="e";}
            else if($f=="Н"){$fl="N";}
            else if($f=="н"){$fl="n";}
            else if($f=="Г"){$fl="G";}
            else if($f=="г"){$fl="g";}
            else if($f=="Ш"){$fl="Sh";}
            else if($f=="ш"){$fl="sh";}
            else if($f=="Щ"){$fl="Shch";}
            else if($f=="щ"){$fl="shch";}
            else if($f=="З"){$fl="Z";}
            else if($f=="з"){$fl="z";}
            else if($f=="Х"){$fl="H";}
            else if($f=="х"){$fl="h";}
            else if($f=="Ф"){$fl="F";}
            else if($f=="ф"){$fl="f";}
            else if($f=="І"){$fl="I";}
            else if($f=="і"){$fl="i";}
            else if($f=="В"){$fl="V";}
            else if($f=="в"){$fl="v";}
            else if($f=="А"){$fl="A";}
            else if($f=="а"){$fl="a";}
            else if($f=="П"){$fl="P";}
            else if($f=="п"){$fl="p";}
            else if($f=="Р"){$fl="R";}
            else if($f=="р"){$fl="r";}
            else if($f=="О"){$fl="O";}
            else if($f=="о"){$fl="o";}
            else if($f=="Л"){$fl="L";}
            else if($f=="л"){$fl="l";}
            else if($f=="Д"){$fl="D";}
            else if($f=="д"){$fl="d";}
            else if($f=="Ж"){$fl="G";}
            else if($f=="ж"){$fl="g";}
            else if($f=="Є"){$fl="Ye";}
            else if($f=="є"){$fl="ye";}
            else if($f=="Я"){$fl="Ya";}
            else if($f=="я"){$fl="ya";}
            else if($f=="Ч"){$fl="Ch";}
            else if($f=="ч"){$fl="ch";}
            else if($f=="С"){$fl="S";}
            else if($f=="с"){$fl="s";}
            else if($f=="М"){$fl="M";}
            else if($f=="м"){$fl="m";}
            else if($f=="И"){$fl="I";}
            else if($f=="и"){$fl="y";}
            else if($f=="Т"){$fl="T";}
            else if($f=="т"){$fl="t";}
            else if($f=="Б"){$fl="B";}
            else if($f=="б"){$fl="b";}
            else if($f=="Ю"){$fl="Yu";}
            else if($f=="ю"){$fl="yu";}
            else if($f=="Ы"){$fl="Y";}
            else if($f=="ы"){$fl="y";}
            else if($f=="Э"){$fl="E";}
            else if($f=="э"){$fl="e";}
            else if($f=="Ё"){$fl="Yo";}
            else if($f=="ё"){$fl="yo";}
            else{$fl="";}
            $domen2.=$fl;
        }
        echo"domen1 $domen1  domen2 $domen2<br />";
        $domen1 = str_replace(" ", "", $domen1);
        $domen2 = str_replace(" ", "", $domen2);

        if($domen1==""){$domen1="user";}
        if($domen2==""){$domen2="page";}

        $alldomen = "$domen1.$domen2";
        if(strstr($alldomen, "php")=="" && strstr($alldomen, "txt")=="" && strstr($alldomen, "gif")=="" && strstr($alldomen, "bmp")=="" && strstr($alldomen, "jpg")=="" && strstr($alldomen, "js")=="" && strstr($alldomen, "png")=="" && strstr($alldomen, "xml")=="" && strstr($alldomen, "html")=="" && strstr($alldomen, "doc")=="" && strstr($alldomen, "PHP")=="" && strstr($alldomen, "TXT")=="" && strstr($alldomen, "GIF")=="" && strstr($alldomen, "BMP")=="" && strstr($alldomen, "JPF")=="" && strstr($alldomen, "JS")=="" && strstr($alldomen, "PNG")=="" && strstr($alldomen, "XML")=="" && strstr($alldomen, "HTML")=="" && strstr($alldomen, "DOC")==""){}
        else{$alldomen="user.page";}



        $alldomendef=$alldomen;
        for($a=1; $a<1000; $a++){
            $nr3 = 0;
            $Allus3 = DB::table('users')->select('Num')->
            where('domen', $alldomen)->
            limit(1)->
            get();

            foreach ($Allus3 as $All3) { $nr3++;}

            if($nr3>0){ $alldomen="$alldomendef$a";
                // echo" повтор $alldomen";
            }
            else{
                $aff = DB::table('users')
                    ->where('Num', $Num)
                    ->update(['domen' => $alldomen]);
                if ($aff) {$a=10000;}
            }

        }


        }

    }
}
