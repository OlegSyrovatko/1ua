{{--
@if($errors->any())
    <div style="background-color: darksalmon; ">
        <table><tr><td>
        <ul>
            @foreach($errors->all() as $errmy)
                <li>{{ $errmy }}</li>
            @endforeach
        </ul>
                </td><td valign="top"><a onclick="document.getElementById('notice_center').style.display ='none';" ><b>X</b></a></td></tr></table></div>
@endif
--}}
@if(session('success'))
    <div style="background-color: MediumSpringGreen; ">
        <table><tr><td><ul>

    {{ session('success') }}

 </ul></td><td valign="top"><a onclick="document.getElementById('notice_center').style.display ='none';" ><b>X</b></a></td></tr></table></div>
@endif
