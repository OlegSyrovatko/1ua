<?php
$dir    = '../apps/';
$files = scandir($dir);

foreach ($files as $value)
{
if ($value !='.' and $value !='..' ) 
{
	if(strstr($value,".txt")!=""){
			$filename = $value;
		$whattoread = @fopen($filename, "r");
		$mc = fread($whattoread, filesize($filename));  fclose($whattoread);
	 if(strstr($mc,"<h1>")!=""){echo"<font color=red>h1</font> ";}
	 if(strstr($mc,"<h2>")!=""){echo"<font color=red>h2</font> ";}
	 if(strstr($mc,"<h3>")!=""){echo"<font color=red>h3</font> ";}
	 if(strstr($mc,"<h4>")!=""){echo"<font color=red>h4</font> ";}
	 if(strstr($mc,"<h5>")!=""){echo"<font color=red>h5</font> ";}
	 if(strstr($mc,"<h6>")!=""){echo"<font color=red>h6</font> ";}
	 if(strstr($mc,"<h7>")!=""){echo"<font color=red>h7</font> ";}

	 if(strstr($mc,"<h1>")!=""||strstr($mc,"<h2>")!=""||strstr($mc,"<h4>")!=""||strstr($mc,"<h6>")!=""||strstr($mc,"<h7>")!=""||strstr($mc,"<h3>")!=""||strstr($mc,"<h5>")!=""||strstr($mc,"<h6>")!=""){echo "$value<br />";}


	}
}
else{}
}

?>