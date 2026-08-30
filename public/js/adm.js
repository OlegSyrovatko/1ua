jQuery(document).ready(function($){


    $('#ch_reg').click(function (e) {

        var r1=document.getElementById("Im").value;
        var r2=document.getElementById("Priz").value;
        var r3=document.getElementById("Who").value;
        var r4=document.getElementById("Bat").value;
        var badw=document.getElementById("badw").value;
        var r7 = " ";
        var rer = r7+r1+r7+r2+r7+r3+r7+r4+r7;

        rer = rer.toLowerCase();

        var n1 = rer.search("хуй");
        var n2 = rer.search("пизд");
        var n3 = rer.search("конч");
        var n4 = rer.search("сперм");
        var n5 = rer.search("вафл");
        var n6 = rer.search("шлюх");
        var n7 = rer.search("fuck");
        var n8 = rer.search("гом");
        var n9 = rer.search("бля");
        var n10 = rer.search("манд");
        var n11 = rer.search("член");
        var n12 = rer.search("еба");
        var n13 = rer.search("єба");
        var n14 = rer.search("суч");
        var n15 = rer.search("сук");
        var n16 = rer.search("дроч");
        var n17 = rer.search("писк");
        var n18 = rer.search("піськ");
        var n19 = rer.search("урод");
        var n20 = rer.search("соса");
        var n21 = rer.search("ублюд");
        var n22 = rer.search("соси");
        var n23 = rer.search("сран");
        var n24 = rer.search("срак");
        var n25 = rer.search("срат");
        var n26 = rer.search("хуев");
        var n27 = rer.search("костр");
        var n28 = rer.search("блев");
        var n29 = rer.search("трах");
        var n30 = rer.search("влагал");
        var n31 = rer.search("онан");

        if(n1>0||n2>0||n3>0||n4>0||n5>0||n6>0||n7>0||n8>0||n9>0||n10>0||n11>0||n12>0||n13>0||n14>0||n15>0||n16>0||n17>0||n18>0||n19>0||n20>0||n21>0||n22>0||n23>0||n24>0||n25>0||n26>0||n27>0||n28>0||n29>0||n30>0||n31>0){

            document.getElementById("chreg").innerHTML = badw;
        }
        else{
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
            });
            var formData = {
                Im3: jQuery('#Im').val(),
                Bat3: jQuery('#Bat').val(),
                Priz3: jQuery('#Priz').val(),
                Who3: jQuery('#Who').val(),
            };

            $.ajax({
                type: 'POST',
                url: '/ch_reg',
                data: formData,
                cache: false,
                success:function(data){
                    document.getElementById("chreg").innerHTML=data;
                    setTimeout(() => {document.getElementById('chreg').innerHTML="";}, 2000);
                }
            });

        }
    });




    $('#ch_eml_lgn').click(function (e) {

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
            });
            var formData = {
                email3: jQuery('#email').val(),
                passw3: jQuery('#passw').val(),
                passw23: jQuery('#passw2').val(),
            };

            $.ajax({
                type: 'POST',
                url: '/ch_eml_lgn',
                data: formData,
                cache: false,
                success:function(data){
                    document.getElementById("chemllgn").innerHTML=data;}
            });
    });



    $('#ch_adress').click(function (e) {

        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
        });
        var formData = {
            domen1: jQuery('#domen1').val(),
            domen2: jQuery('#domen2').val(),
        };

        $.ajax({
            type: 'POST',
            url: '/ch_domen',
            data: formData,
            cache: false,
            success:function(data){
                document.getElementById("chadress").innerHTML=data;}
        });
    });

    $('#setnews').click(function (e) {

        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
        });
        var mnews_s = "";
        if(document.getElementById("cnfriend").checked){mnews_s = mnews_s + "1";} else{mnews_s = mnews_s + "0";}
        if(document.getElementById("cnforum").checked){mnews_s = mnews_s + "1";} else{mnews_s = mnews_s + "0";}
        if(document.getElementById("cnfoto").checked){mnews_s = mnews_s + "1";} else{mnews_s = mnews_s + "0";}
        if(document.getElementById("cncoment").checked){mnews_s = mnews_s + "1";} else{mnews_s = mnews_s + "0";}
        if(document.getElementById("cnratef").checked){mnews_s = mnews_s + "1";} else{mnews_s = mnews_s + "0";}
        mnews_s = mnews_s + "1";
        if(document.getElementById("cnapps").checked){mnews_s = mnews_s + "1";} else{mnews_s = mnews_s + "0";}
        mnews_s = mnews_s + "1";
        if(document.getElementById("cnowns").checked){mnews_s = mnews_s + "1";} else{mnews_s = mnews_s + "0";}
        if(document.getElementById("cnvideo").checked){mnews_s = mnews_s + "1";} else{mnews_s = mnews_s + "0";}
        if(document.getElementById("cnguests").checked){mnews_s = mnews_s + "1";} else{mnews_s = mnews_s + "0";}
        mnews_s = mnews_s + "1";
        var formData = {
            mnews_s: mnews_s
        };

        $.ajax({
            type: 'POST',
            url: '/setnews',
            data: formData,
            cache: false,
            success:function(data){
                document.getElementById("set_news").innerHTML=data;
                setTimeout(() => {document.getElementById('set_news').innerHTML="";}, 2000);
            }

        });
    });


    $('#chdata').click(function (e) {

        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
        });
        var formData = {
            sex: jQuery('#sex').val(),
            partner: jQuery('#partner').val(),
            bday: jQuery('#bday').val(),
            bmonth: jQuery('#bmonth').val(),
            byear: jQuery('#byear').val(),
            bday_visib: jQuery('#bday_visib').val(),
            political: jQuery('#political').val(),
            tabak: jQuery('#tabak').val(),
            alkoh: jQuery('#alkoh').val(),
            insign: jQuery('#insign').val(),
            religion: jQuery('#religion').val(),
            mtel: jQuery('#mtel').val(),
        };

        $.ajax({
            type: 'POST',
            url: '/ch_data',
            data: formData,
            cache: false,
            success:function(data){
                document.getElementById("ch_data").innerHTML=data;
                setTimeout(() => {document.getElementById('ch_data').innerHTML="";}, 2000);
            }
        });
    });

    $('#av_load').click(function (e) {

        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
        });
        var formData = new FormData();
        formData.append('section', 'general');
        formData.append('action', 'previewImg');
        formData.append('image', $('input[type=file]')[0].files[0]);
        document.getElementById('load_on').style.display = 'block';

        $.ajax({
            type: 'POST',
            url: '/avload',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success:function(data){
                document.getElementById("avload").innerHTML=data;}
        });
    });


    $('#av_delete').click(function (e) {

        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
        });

        $.ajax({
            type: 'POST',
            url: '/del_ava',
            cache: false,
            success:function(data){
                document.getElementById("avload").innerHTML=data;}
        });
    });

    $('#adr_edit').click(function (e) {
        document.getElementById('red_enter').style.display = 'block';
        document.getElementById('red_enter0').style.display = 'none';
    });


    $('#chadrr').click(function (e) {

        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
        });
        var formData = {
            Wherer: jQuery('#Wherer').val(),
            obl: jQuery('#obl').val(),
            idc: jQuery('#idc').val(),
            Adr: jQuery('#Adr').val(),
        };


        $.ajax({
            type: 'POST',
            url: '/chadrr',
            data: formData,
            cache: false,
            success:function(data){
                document.getElementById("ch_adr").innerHTML=data;}
        });
    });





    $('#setprivate').click(function (e) {

        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
        });
        var formData = {
            mypage_show: jQuery('#mypage_show').val(),
            mypage_do_forum: jQuery('#mypage_do_forum').val(),
            s_l_visit: jQuery('#s_l_visit').val(),
            l_visit: jQuery('#l_visit').val(),
            do_message: jQuery('#do_message').val(),
            set_q: jQuery('#set_q').val(),
            ipban: jQuery('#ipban').val(),
        };
        document.getElementById('set_private').style.display = 'block';

        $.ajax({
            type: 'POST',
            url: '/setprivate',
            data: formData,
            cache: false,
            success:function(data){
                document.getElementById("set_private").innerHTML=data;
                setTimeout(() => {document.getElementById('set_private').innerHTML="";}, 5000);
            }
        });
    });



    $('#setnote').click(function (e) {

        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
        });

        if(document.getElementById("ntbd_send").checked){ntbd_send = "0";} else{ntbd_send = "1";}
        if(document.getElementById("ntadm_send").checked){ntadm_send = "0";} else{ntadm_send = "1";}

        var formData = {
            ntfriend: jQuery('#ntfriend').val(),
            ntmail: jQuery('#ntmail').val(),
            ntforum: jQuery('#ntforum').val(),
            ntfrating: jQuery('#ntfrating').val(),
            ntcomment: jQuery('#ntcomment').val(),
            ntbd_send: ntbd_send,
            ntadm_send: ntadm_send,
        };

        $.ajax({
            type: 'POST',
            url: '/setnote',
            data: formData,
            cache: false,
            success:function(data){
                document.getElementById("set_note").innerHTML=data;
                setTimeout(() => {document.getElementById('set_note').innerHTML="";}, 2000);
            }
        });
    });


});

function no_del_pmail() {
    document.getElementById('set_private').style.display = 'none';
}
function del_pmail() {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });

    $.ajax({
        type: 'POST',
        url: '/del_all_followers',
        cache: false,
        success:function(data){
            document.getElementById("set_private").innerHTML=data;}
    });
}



function user_banp() {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var user_ban = document.getElementById('linku').value;

    var formData = {
        user_ban: user_ban,
    };
    $.ajax({
        type: 'POST',
        url: '/user_banp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById('user_ban2').innerHTML=data;
            document.getElementById('linku').value="";
        }
    });
}

function user_ban_delp(Num,ddiv) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        user_ban: Num
    };
    $.ajax({
        type: 'POST',
        url: '/user_ban_delp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(ddiv).innerHTML=data;
        }
    });
}

function ban_see(Num,ddiv) {
    document.getElementById("hid_ban").style.display = 'block';
    document.getElementById("hid_ban2").style.display = 'none';
}
