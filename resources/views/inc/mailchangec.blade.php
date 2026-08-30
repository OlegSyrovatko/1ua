<br><h3>{{__('messages.subscr8')}}</h3>
<table><tr><td align=center>
    <table><tr><td align=right>
        <br>{{__('messages.subscr9')}} <SELECT id="mforum">
            <OPTION value=0 @if($forum==0||!$forum) selected @endif  >{{__('messages.note_es0')}}</OPTION>
            <OPTION value=1 @if($forum==1) selected @endif>{{__('messages.note_es1')}}</OPTION>
            <OPTION value=2 @if($forum==2) selected @endif>{{__('messages.note_es2')}}</OPTION>
            <OPTION value=3 @if($forum==3) selected @endif>{{__('messages.note_es3')}}</OPTION>
        </SELECT>
        <br>{{__('messages.subscr10')}}<SELECT id="mfoto">
            <OPTION value=0 @if($foto==0||!$foto) selected @endif>{{__('messages.note_es0')}}</OPTION>
            <OPTION value=1 @if($foto==1) selected @endif>{{__('messages.note_es1')}}</OPTION>
            <OPTION value=2 @if($foto==2) selected @endif>{{__('messages.note_es2')}}</OPTION>
            <OPTION value=3 @if($foto==3) selected @endif>{{__('messages.note_es3')}}</OPTION>
        </SELECT>
        <br>{{__('messages.subscr11')}} <SELECT id="mcomment">
            <OPTION value=0 @if($comment==0||!$comment) selected @endif>{{__('messages.note_es0')}}</OPTION>
            <OPTION value=1 @if($comment==1) selected @endif>{{__('messages.note_es1')}}</OPTION>
            <OPTION value=2 @if($comment==2) selected @endif>{{__('messages.note_es2')}}</OPTION>
            <OPTION value=3 @if($comment==3) selected @endif>{{__('messages.note_es3')}}</OPTION>
        </SELECT>
        <br>{{__('messages.subscr13')}} <SELECT id="mregp">
            <OPTION value=0 @if($regp==0||!$regp) selected @endif>{{__('messages.note_es0')}}</OPTION>
            <OPTION value=1 @if($regp==1) selected @endif>{{__('messages.note_es3')}}</OPTION>
        </SELECT>
        <table><tr><td class="fcomblue">
                <ul class="intop"><li><a onclick=mailchangec('{{$Pmail}}','{{$id}}')> {{__('messages.subscr12')}} </a></li></ul>
         </td></tr></table>

    </td></tr></table>
</td></tr></table>
