jQuery(document).ready(function($){



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



});



function clearssi(comareas) {
    var bs = comareas;
    var a = document.getElementById(bs) || bs;
    if (a) {
        a.style.overflow = "hidden";
        var e = a.rows = a.rows > 0 ? a.rows : 2;
        bs = a.cols = a.cols > 0 ? a.cols : 20;
        var g = RegExp("([^\r\n]{" + bs + "})([^\r\n])"),
            f = RegExp("[^\n]{" + bs + "}\n?$|[^\n]{0," + bs + "}\n");
        a.onkeyup = a.onkeydown = function () {

            for (var c = 0, d = a.value; d.search(f) >= 0;) {
                c++;
                d = d.replace(f, "")
            }
            c += 2;
            if (c < e) c = e;
            a.rows = c
        }
    }
}



function questioni(from,id,target) {
    var question = document.getElementById('question').value;

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        question: question,
        id: id,
        avt: from,
    };
    $.ajax({
        type: 'POST',
        url: target,
        data: formData,
        cache: false,
        success:function(data){
            // data = JSON.stringify(data);
            document.getElementById("question_in").innerHTML=data;}
    });
    document.getElementById('question').value="";
}



function ban_qp(box,ipq) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        ipq: ipq,
    };
    $.ajax({
        type: 'POST',
        url: '/ban_qp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(box).innerHTML=data;}
    });

}



function del_qp(box,nq) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        nq: nq,
    };
    $.ajax({
        type: 'POST',
        url: '/del_qp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(box).innerHTML=data;  location.reload();}
    });

}



function clearsp(comareas,dcmes) {
    document.getElementById(dcmes).style.display = 'block';
    var bs = comareas;
    var a = document.getElementById(bs) || bs;
    if (a) {
        a.style.overflow = "hidden";
        var e = a.rows = a.rows > 0 ? a.rows : 2;
        bs = a.cols = a.cols > 0 ? a.cols : 20;
        var g = RegExp("([^\r\n]{" + bs + "})([^\r\n])"),
            f = RegExp("[^\n]{" + bs + "}\n?$|[^\n]{0," + bs + "}\n");
        a.onkeyup = a.onkeydown = function () {

            for (var c = 0, d = a.value; d.search(f) >= 0;) {
                c++;
                d = d.replace(f, "")
            }
            c += 2;
            if (c < e) c = e;
            a.rows = c
        }
    }
}







function askp(box,ask0,nq) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var ask = document.getElementById(ask0).value;
    var formData = {
        ask: ask,
        nq: nq,
    };
    $.ajax({
        type: 'POST',
        url: '/ask_publp',
        data: formData,
        cache: false,
        success:function(data){
            var nseek = data.indexOf("235*64@75");
            if(nseek>0){
                data=data.replace("s235*64@75", "");
                box=box.replace("q_box", "q_err");
                document.getElementById(box).innerHTML=data;
            }
            else{
                document.getElementById(box).innerHTML=data; location.reload();
            }

        }
    });
}


function dataSelectp() {
    var n = document.getElementById("mailnp").value;
    var Pmail = document.getElementById("Pmail").value;
    var id = document.getElementById("id").value;
    var formData = {
        Pmail: Pmail,
        id: id,
    };

    $.ajax({
        type: 'POST',
        url: n,
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById("mailfield").innerHTML=data;
        }
    });
}



function mailchange(Pmail,id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var forum = document.getElementById('mforum').value;
    var foto = document.getElementById('mfoto').value;
    var comment = document.getElementById('mcomment').value;

    var formData = {
        Pmail: Pmail, id: id, forum: forum, foto: foto, comment: comment
    };
    $.ajax({
        type: 'POST',
        url: '/mailchangeset',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById("mailfield").innerHTML=data;
        }
    });
}



function mem_delmp(idrec,ddiv,id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        idrec: idrec, id: id
    };
    $.ajax({
        type: 'POST',
        url: '/delmp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(ddiv).innerHTML=data;
        }
    });
}

function mem_arguemp(nrec,fixblock) {
    document.getElementById(nrec).style.display = 'block'; document.getElementById(fixblock).style.display = 'none';
}

function mem_not_delmp(nrec,fixblock) {
    document.getElementById(nrec).style.display = 'none'; document.getElementById(fixblock).style.display = 'block';
}

function publp(idrec,id,afisha)
{ var dividrec = "unsel" + idrec;
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        idrec: idrec, id: id, afisha: afisha
    };
    $.ajax({
        type: 'POST',
        url: '/fastenp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(dividrec).innerHTML=data;
        }
    });
}

function ashowp() {

    var exp = new Date();
    var oneYearFromNow = exp.getTime() + (365*24*60*60*1000);
    exp.setTime (oneYearFromNow);
    document.cookie = "aphide" + "=1; expires=" + exp.toGMTString()
    document.getElementById("afisha").style.display = 'block';
    document.getElementById("hidafisha").style.display = 'block';
}

function ahidep() {

    var exp = new Date();
    var oneYearFromNow = exp.getTime() + (365*24*60*60*1000);
    exp.setTime (oneYearFromNow);
    document.cookie = "aphide" + "=0; expires=" + exp.toGMTString()
    document.getElementById("afisha").style.display = 'none';
    document.getElementById("hidafisha").style.display = 'none';
}



function memp(id,theme,page,move)
{
    var fnext = "fnext" + page;
    if(page >1){document.getElementById(fnext).style.display = 'none';}

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        id: id, theme: theme, page: page, move: move
    };
    $.ajax({
        type: 'POST',url: '/memp',data: formData,cache: false,
        success:function(data){
            if(page >1){document.getElementById("mem").innerHTML+=data;}
           else{document.getElementById("mem").innerHTML=data;}
        }
    });
    if(theme==""){
        var memt = document.getElementById('theme_in');
        memt.value = "";
    }
}

function memtp(id)
{
    var th = document.getElementById("th");
    var theme = th.options[th.selectedIndex].value;

    var memt = document.getElementById('theme_in');
    memt.value = theme;

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        id: id, theme: theme, page: 1, move: 'Desc'
    };
    $.ajax({
        type: 'POST',url: '/memp',data: formData,cache: false,
        success:function(data){
            document.getElementById("mem").innerHTML=data;
        }
    });
}



function smlp(purp) {

    var memt = document.getElementById('app_mem').innerHTML;
    var nseek = memt.indexOf("sml");
    if(nseek>0){
        document.getElementById('app_mem').innerHTML = "";
        document.getElementById('app_mem_add').innerHTML = "";
    }
    else {
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
        });
        var formData = {
            purp: purp
        };
        $.ajax({
            type: 'POST',
            url: '/sml_in',
            data: formData,
            cache: false,
            success: function (data) {
                document.getElementById('app_mem').innerHTML = data;
            }
        });
    }
}






function mem_addp(id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var theme_in = document.getElementById('theme_in').value;
    var memt = document.getElementById('memt').value;

    var formData = {
        theme_in: theme_in, id: id, memt: memt, 'purp': 'do'
    };
    $.ajax({
        type: 'POST',
        url: '/mem_addp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById("memt_res").innerHTML=data;
            var nseek = data.indexOf("avatar/s");
            if(nseek>0){
                var txt = document.getElementById('memt');
                txt.value = "";
                document.getElementById('mem_add').style.display = 'none';
            }
        }
    });
    document.getElementById('app_mem').innerHTML = "";
    document.getElementById('app_mem_add').innerHTML = "";

}




function mem_redp(id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });

    var memt = document.getElementById('memt_red').value;
    var theme_in = document.getElementById('theme_in').value;
    var idrec = document.getElementById('idrec').value;
    var md = document.getElementById('md').value;

    var formData = {
        theme_in: theme_in, id: id, memt: memt, 'purp': 'red', 'idrec': idrec, 'md': md
    };
    $.ajax({
        type: 'POST',
        url: '/mem_addp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById("memt_res").innerHTML=data;
        }
    });
}



function max_albp(id,purp,domen) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        id: id, purp:purp, domen:domen
    };
    $.ajax({
        type: 'POST',
        url: '/max_albp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById("foto_in").innerHTML=data;
        }
    });
}



function red_albp(namef,divnamef,t3) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: namef, t3:t3
    };

    $.ajax({
        type: 'POST',
        url: '/red_albp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(divnamef).innerHTML=data;
        }
    });


}

function do_red_albp(namef,divnamef,albs,albt,shs) {

    var albs = document.getElementById(albs).value;
    var albt = document.getElementById(albt).value;
    var shs = document.getElementById(shs).value;

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: namef, 'albs':albs, 'albt':albt, 'shs':shs
    };

    $.ajax({
        type: 'POST',
        url: '/do_red_albp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(divnamef).innerHTML=data;
        }
    });

}



function all_ap(namef,page) {
    if(page=="1"){
        var pObj = document.getElementById ("add_load");
        pObj.style.maxWidth = 800 + "px";
        document.getElementById("add_load").style.display ='block';
        $("#overlay").show();
        document.getElementById("add_script_center2").innerHTML="";
    }
    else{
        var next_div = "next_div" + page;
        document.getElementById(next_div).style.display = 'none';
    }
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: namef, page:page
    };
    $.ajax({
        type: 'POST',
        url: '/all_ap',
        data: formData,
        cache: false,
        success:function(data){
            if(page=="1"){document.getElementById("add_script_center2").innerHTML=data;}
            else{document.getElementById("add_script_center2").innerHTML+=data;}
        }
    });


}



function comment_p(id,namef,page) {
    if(page=="1"){
        var pObj = document.getElementById ("add_load");
        pObj.style.maxWidth = 420 + "px";
        document.getElementById("add_load").style.display ='block';
        $("#overlay").show();
        document.getElementById("add_script_center2").innerHTML="";
    }
    else{
        var next_div = "next_div" + page;
        document.getElementById(next_div).style.display = 'none';
    }
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: namef, id:id, page:page
    };
    $.ajax({
        type: 'POST',
        url: '/comment_p',
        data: formData,
        cache: false,
        success:function(data){
            if(page=="1"){document.getElementById("add_script_center2").innerHTML=data;}
            else{document.getElementById("add_script_center2").innerHTML+=data;}
        }
    });
}




function abfp(id,Namef) {
    document.getElementById("f_in").innerHTML="";
    document.getElementById("abf_load").style.display = 'block';
    $("#overlay_abf").show();

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: Namef, id:id
    };
    $.ajax({
        type: 'POST',
        url: '/abfp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById("f_in").innerHTML=data;
        }
    });
}




function fotop(id,domen,namef,page) {

    var next_div = "nextf_div" + page;
    document.getElementById(next_div).style.display = 'none';

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        id:id, domen:domen, Namef: namef, page:page
    };
    $.ajax({
        type: 'POST',
        url: '/fotop',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById("foto").innerHTML+=data;
        }
    });
}





function red_fotop(namef,divnamef) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: namef
    };

    $.ajax({
        type: 'POST',
        url: '/red_fotop',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(divnamef).innerHTML=data;
        }
    });

}

function do_red_fotop(namef,divnamef,alb) {

    var albs = document.getElementById(alb).value;

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: namef, 'albs':albs
    };

    $.ajax({
        type: 'POST',
        url: '/do_red_fotop',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(divnamef).innerHTML=data;
        }
    });

}





function publ_fp(namef,divnamef) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: namef
    };
    $.ajax({
        type: 'POST',
        url: '/publ_fp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(divnamef).innerHTML=data;
        }
    });
}


function face_fp(namef,divnamef) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: namef
    };
    $.ajax({
        type: 'POST',
        url: '/face_fp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(divnamef).innerHTML=data;
        }
    });
}


function del_fotop(namef,divnamef) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: namef
    };
    $.ajax({
        type: 'POST',
        url: '/del_fotop',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(divnamef).innerHTML=data;
        }
    });
}




function del_albp(namef,divnamef) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: namef
    };
    $.ajax({
        type: 'POST',
        url: '/del_albp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(divnamef).innerHTML=data;
        }
    });
}



function fview(M5,dM5,views) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: M5, 'views':views, 'pc': "p"
    };
    $.ajax({
        type: 'POST',
        url: '/fview',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(dM5).innerHTML=data;
        }
    });

}


var myImages = new Array("/on.png", "/off.png");

function chp(rate,im,ok){var rim=rate+im; var iim="i"+rim;
    if(rate==1){document.images[iim].src=myImages[ok];}
    if(rate==2){document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok];}
    if(rate==3){document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok];}
    if(rate==4){document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok];}
    if(rate==5){document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok];}
}

var myImages2 = new Array("/onm.png", "/offm.png");

function chp2(rate,im,ok){var rim=rate+im; var iim="im"+rim;
    if(rate==5){document.images[iim].src=myImages2[ok];}
}


function rate_addp(rM5,M5,rate) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: M5, 'rate':rate
    };
    $.ajax({
        type: 'POST',
        url: '/rate_addp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(rM5).innerHTML=data;
        }
    });
}




function rate_hp(rM5,M5) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: M5
    };
    $.ajax({
        type: 'POST',
        url: '/rate_hp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(rM5).innerHTML=data;
        }
    });
}




function rate_addmp(rM5,M5,rate) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: M5, 'rate':rate
    };
    $.ajax({
        type: 'POST',
        url: '/rate_addmp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(rM5).innerHTML=data;
        }
    });
}




function rate_hmp(rM5,M5) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: M5
    };
    $.ajax({
        type: 'POST',
        url: '/rate_hmp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(rM5).innerHTML=data;
        }
    });
}


function see_comm(scb,scd) {
    document.getElementById(scb).style.display = 'none'; document.getElementById(scd).style.display = 'block';
}


function comm_addp(M5,from,min) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var from_e = document.getElementById(from).value;
    var formData = {
        M5: M5,
        Aboutef: from_e,
    };
    $.ajax({
        type: 'POST',
        url: '/comm_addp',
        data: formData,
        cache: false,
        success:function(data){
            var nseek = data.indexOf("s235*64@75");
            if(nseek>0){
                data=data.replace("s235*64@75", "");
                document.getElementById(min).innerHTML+=data;
            }
            else{
                document.getElementById(min).innerHTML=data;
                document.getElementById(from).value="";
            }
        }
    });

}




function comm_redp(idrec,from,min) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var from_e = document.getElementById(from).value;
    var formData = {
        idrec: idrec,
        Aboutef: from_e,
    };

    $.ajax({
        type: 'POST',
        url: '/comm_redp',
        data: formData,
        cache: false,
        success:function(data){
            var nseek = data.indexOf("s235*64@75");
            if(nseek>0){
                data=data.replace("s235*64@75", "");
                document.getElementById(min).innerHTML+=data;
            }
            else{
                document.getElementById(min).innerHTML=data;
            }
        }
    });

}




function comm_delp(min,idrec) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        idrec: idrec
    };
    $.ajax({
        type: 'POST',
        url: '/comm_delp',
        data: formData,
        cache: false,
        success:function(data){
            var nseek = data.indexOf("s235*64@75");
            if(nseek>0){
                data=data.replace("s235*64@75", "");
                document.getElementById(min).innerHTML+=data;
            }
            else{
                document.getElementById(min).innerHTML=data;
            }
        }
    });

}




function commm_addp(M5,from,min,purp) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var from_e = document.getElementById(from).value;
    var formData = {
        M5: M5, Aboutef: from_e, purp: purp,
    };
    $.ajax({
        type: 'POST',
        url: '/commm_addp',
        data: formData,
        cache: false,
        success:function(data){
            var nseek = data.indexOf("s235*64@75");
            if(nseek>0){
                data=data.replace("s235*64@75", "");
                document.getElementById(min).innerHTML+=data;
            }
            else{
                document.getElementById(min).innerHTML=data;
                document.getElementById(from).value="";
            }
        }
    });

}




function commm_redp(idrec,from,min,purp) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var from_e = document.getElementById(from).value;
    var formData = {
        idrec: idrec, Aboutef: from_e, purp: purp,
    };

    $.ajax({
        type: 'POST',
        url: '/commm_redp',
        data: formData,
        cache: false,
        success:function(data){
            var nseek = data.indexOf("s235*64@75");
            if(nseek>0){
                data=data.replace("s235*64@75", "");
                document.getElementById(min).innerHTML+=data;
            }
            else{
                document.getElementById(min).innerHTML=data;
            }
        }
    });

}




function commm_delp(min,idrec) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        idrec: idrec
    };
    $.ajax({
        type: 'POST',
        url: '/commm_delp',
        data: formData,
        cache: false,
        success:function(data){
            var nseek = data.indexOf("s235*64@75");
            if(nseek>0){
                data=data.replace("s235*64@75", "");
                document.getElementById(min).innerHTML+=data;
            }
            else{
                document.getElementById(min).innerHTML=data;
            }
        }
    });

}




function top_askp(na) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    if(na==0){var from_history = "";}
    else{
        var from_history = document.getElementById('from_history').value;
    }
    var formData = {
        na: na, from_history: from_history,
    };
    $.ajax({
        type: 'POST',
        url: '/top_askp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById('dask').innerHTML=data;
        }
    });
}



function answer_interviewp(na) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    if(na==0){var from_e = ""; var from_history = "";}
    else{
        var from_e = document.getElementById('from_ask').value;
        var from_history = document.getElementById('from_history').value;
    }
    var formData = {
        na: na, from_history: from_history,
        Aboutef: from_e,
    };


    $.ajax({
        type: 'POST',
        url: '/answer_interviewp',
        data: formData,
        cache: false,
        success:function(data){
            var nseek = data.indexOf("s235*64@75");
            if(nseek>0){
                data=data.replace("s235*64@75", "");
                document.getElementById('dask').innerHTML+=data;
                document.getElementById('from_ask').value = from_e;
            }
            else{
                $.ajax({
                    type: 'POST',
                    url: '/top_askp',
                    data: formData,
                    cache: false,
                    success:function(data){
                        document.getElementById('dask').innerHTML=data;
                    }
                });
            }
        }
    });
}




function adm_pages(id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });

    var formData = {
        id: id,
    };
    $.ajax({
        type: 'POST',
        url: '/adm_pages',
        data: formData,
        cache: false,
        success:function(data){
                document.getElementById("adm_pages").innerHTML+=data;
        }
    });
}


function guesp(page,gdiv,preg,id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    document.getElementById(gdiv).style.display = 'none';

    var formData = {
        id: id, page: page, preg: preg,
    };
    $.ajax({
        type: 'POST',
        url: '/guesp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById('guests').innerHTML+=data;
        }
    });
}


function guesp_del(avt,Vd,t3,id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });

    var formData = {
        id: id, avt: avt, Vd: Vd,
    };
    $.ajax({
        type: 'POST',
        url: '/guesp_del',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(t3).innerHTML=data;
        }
    });

}



function fguesp(page,gdiv,preg,id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    document.getElementById(gdiv).style.display = 'none';

    var formData = {
        id: id, page: page, preg: preg,
    };
    $.ajax({
        type: 'POST',
        url: '/fguesp',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById('guests').innerHTML+=data;
        }
    });
}


function fguesp_del(avt,Vd,t3,id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });

    var formData = {
        id: id, avt: avt, Vd: Vd,
    };
    $.ajax({
        type: 'POST',
        url: '/fguesp_del',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(t3).innerHTML=data;
        }
    });

}

function add_fr(d_fr,fr) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });

    var formData = {
        fr: fr,
    };
    $.ajax({
        type: 'POST',
        url: '/add_fr',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(d_fr).innerHTML=data;
        }
    });

}
function del_fr0(d_fr0,d_fr) {
    document.getElementById(d_fr0).style.display = 'none';
    document.getElementById(d_fr).style.display = 'block';
}
function del_fr1(d_fr0,d_fr) {
    document.getElementById(d_fr).style.display = 'none';
    document.getElementById(d_fr0).style.display = 'block';
}
function del_fr(d_fr,fr) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });

    var formData = {
        fr: fr,
    };
    $.ajax({
        type: 'POST',
        url: '/del_fr',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(d_fr).innerHTML=data;
        }
    });

}


function refuse_fr(d_fr,fr) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });

    var formData = {
        fr: fr,
    };
    $.ajax({
        type: 'POST',
        url: '/ref_fr',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(d_fr).innerHTML=data;
        }
    });

}


function redo() {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });

    $.ajax({
        type: 'POST',
        url: '/redo',
        cache: false,
        success:function(data){
           if(data){location.reload();}
        }
    });

}
