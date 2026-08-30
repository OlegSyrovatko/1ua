@php
if(isset($_POST['sm'])){$sm = $_REQUEST['sm'];}
$sm = "sm/$sm";
$memory_ips = Storage::disk('public')->get($sm);
echo"$memory_ips";

@endphp
