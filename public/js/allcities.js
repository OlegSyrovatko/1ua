jQuery(document).ready(function($){


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#multi-file-upload-ajax').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        let TotalFiles = $('#files')[0].files.length; //Total files
        let files = $('#files')[0];
        for (let i = 0; i < TotalFiles; i++) {
            formData.append('files' + i, files.files[i]);
        }
        formData.append('TotalFiles', TotalFiles);
        $.ajax({
            type:'POST',
            url: "{{ url('store-multi-file-ajax')}}",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: (data) => {
                this.reset();
                alert('Files has been uploaded using jQuery ajax');
            },
            error: function(data){
                alert(data.responseJSON.errors.files[0]);
                console.log(data.responseJSON.errors);
            }
        });
    });
	
	
	$('#search').submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		document.getElementById("load_min").style.display = 'none';
		document.getElementById("load_max").style.display = 'none';
		
		let TotalFiles = $('#files')[0].files.length;
		if(TotalFiles == 0){document.getElementById("load_min").style.display = 'block';}
		else{
			if (TotalFiles>10){document.getElementById("load_max").style.display = 'block';}
			else{
				document.getElementById("load_on").style.display = 'block';
				let files = $('#files')[0];
				for (let i = 0; i < TotalFiles; i++) {
					formData.append('files' + i, files.files[i]);
				}
				formData.append('TotalFiles', TotalFiles);
				var alb = document.getElementById("album0").value;
				var Adrf = document.getElementById("Adrf0").value;
				var Datef = document.getElementById("Datef0").value;
				var id = 0;

				formData.append('alb', alb);
				formData.append('Adrf', Adrf);
				formData.append('Datef', Datef);
				formData.append('id', id);

				$.ajax({
					type:'POST',
					url: "{{ url('load_foto')}}",
					data: formData,
					cache:false,
					contentType: false,
					processData: false,
					success:function(data){
						document.getElementById("load_foto").innerHTML=data;
						document.getElementById("load_on").style.display = 'none';
					}
				});
			}
		}
	});


    $('#obl').change(function (e) {
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
        });
        var formData = {
            nobl: jQuery('#obl').val(),
        };

        document.getElementById("hrayc").style.display ='block';
        document.getElementById("hrayc2").style.display ='block';
        $.ajax({
            type: 'POST',
            url: '/rayc',
            data: formData,
            cache: false,
            success:function(data){
                data = JSON.stringify(data);
                document.getElementById("rayc").innerHTML=data;}
        });
    });

    $('#rayc').change(function (e) {
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
        });
        var formData = {
            rayc: jQuery('#rayc').val(),
        };

        document.getElementById("hidc").style.display ='block';
        document.getElementById("hidc2").style.display ='block';
        $.ajax({
            type: 'POST',
            url: '/idc',
            data: formData,
            cache: false,
            success:function(data){
                data = JSON.stringify(data);
                document.getElementById("idc").innerHTML=data;}
        });
    });


});


function form_send(sskip) {
    document.getElementById('skip').value=sskip;
    document.forms.psee2.submit();
}
function form_send2(sort) {
    document.getElementById('sort').value=sort;
    document.getElementById('skip').value=0;
    document.forms.psee2.submit();
}



function question(from,id,target) {
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



function clearss(comareas) {
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



function ban_qc(box,ipq,id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        id: id,
        ipq: ipq,
    };
    $.ajax({
        type: 'POST',
        url: '/ban_qc',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(box).innerHTML=data;}
    });

}



function del_qc(box,nq,id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        id: id,
        nq: nq,
    };
    $.ajax({
        type: 'POST',
        url: '/del_qc',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(box).innerHTML=data;  location.reload();}
    });

}



function clearsq(comareas,dcmes) {
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







function askc(box,ask0,nq,id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var ask = document.getElementById(ask0).value;
    var formData = {
        ask: ask,
        id: id,
        nq: nq,
    };
    $.ajax({
        type: 'POST',
        url: '/ask_publc',
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




function dataSelect() {
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



function mailchangec(Pmail,id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var forum = document.getElementById('mforum').value;
    var foto = document.getElementById('mfoto').value;
    var comment = document.getElementById('mcomment').value;
    var regp = document.getElementById('mregp').value;

    var formData = {
        Pmail: Pmail, id: id, forum: forum, foto: foto, comment: comment, regp:regp
    };
    $.ajax({
        type: 'POST',
        url: '/mailchangecset',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById("mailfield").innerHTML=data;
        }
    });
}



function mem_delm(idrec,ddiv,id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        idrec: idrec, id: id
    };
    $.ajax({
        type: 'POST',
        url: '/delmc',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(ddiv).innerHTML=data;
        }
    });
}

function mem_arguem(nrec,fixblock) {
    document.getElementById(nrec).style.display = 'block'; document.getElementById(fixblock).style.display = 'none';
}

function mem_not_delm(nrec,fixblock) {
    document.getElementById(nrec).style.display = 'none'; document.getElementById(fixblock).style.display = 'block';
}

function publ(idrec,id,afisha)
{ var dividrec = "unsel" + idrec;
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        idrec: idrec, id: id, afisha: afisha
    };
    $.ajax({
        type: 'POST',
        url: '/fastenc',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(dividrec).innerHTML=data;
        }
    });

}

function ashow() {

    var exp = new Date();
    var oneYearFromNow = exp.getTime() + (365*24*60*60*1000);
    exp.setTime (oneYearFromNow);
    document.cookie = "achide" + "=1; expires=" + exp.toGMTString();
    document.getElementById("afisha").style.display = 'block';
    document.getElementById("hidafisha").style.display = 'block';
}

function ahide() {

    var exp = new Date();
    var oneYearFromNow = exp.getTime() + (365*24*60*60*1000);
    exp.setTime (oneYearFromNow);
    document.cookie = "achide" + "=0; expires=" + exp.toGMTString();
    document.getElementById("afisha").style.display = 'none';
    document.getElementById("hidafisha").style.display = 'none';
}


function rshow(obl) {

    var exp = new Date();
    var oneYearFromNow = exp.getTime() + (365*24*60*60*1000);
    exp.setTime (oneYearFromNow);
    document.cookie = "rhide" + "=1; expires=" + exp.toGMTString();

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        obl: obl
    };
    $.ajax({
        type: 'POST',
        url: '/radar',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById("radar").innerHTML=data;
        }
    });
    document.getElementById("radar").style.display = 'block';
    document.getElementById("hidradar").style.display = 'block';
}

function rhide() {

    var exp = new Date();
    var oneYearFromNow = exp.getTime() + (365*24*60*60*1000);
    exp.setTime (oneYearFromNow);
    document.cookie = "rhide" + "=0; expires=" + exp.toGMTString();
    document.getElementById("hidradar").style.display = 'none';
    document.getElementById("radar").innerHTML="";
}





function mem(id,rayc,theme,page,move)
{
    var fnext = "fnext" + page;
    if(page >1){document.getElementById(fnext).style.display = 'none';}

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        id: id, rayc: rayc, theme: theme, page: page, move: move
    };
    $.ajax({
        type: 'POST',url: '/memc',data: formData,cache: false,
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

function memt(id,rayc)
{
    var th = document.getElementById("th");
    var theme = th.options[th.selectedIndex].value;

    var memt = document.getElementById('theme_in');
    memt.value = theme;

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        id: id, rayc: rayc, theme: theme, page: 1, move: 'Desc'
    };
    $.ajax({
        type: 'POST',url: '/memc',data: formData,cache: false,
        success:function(data){
            document.getElementById("mem").innerHTML=data;
        }
    });
}

function sml(purp) {
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

function smlin(sml) {
    sml=sml.replace(".gif", ".gif>");
    var memt = document.getElementById('memt').value;
    if(memt){memt = memt + " "; }
    memt = memt + sml;
    var txt = document.getElementById('memt');
    txt.value = memt;
}

function sml_red(purp) {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        purp: purp
    };
    $.ajax({
        type: 'POST',
        url: '/sml_add',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById('app_mem_add').innerHTML=data;
        }
    });
}




function mem_add(id) {

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
        url: '/mem_add',
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




function mem_red(id) {

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
        url: '/mem_add',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById("memt_res").innerHTML=data;
        }
    });
}




function all_alb(id,purp,domen) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        id: id, purp:purp, domen:domen
    };
    $.ajax({
        type: 'POST',
        url: '/max_alb',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById("foto_in").innerHTML=data;
        }
    });
}

function red_alb(namef,divnamef,t3) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: namef, t3:t3
    };
    $.ajax({
        type: 'POST',
        url: '/red_alb',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(divnamef).innerHTML=data;
        }
    });
}

function do_red_alb(namef,divnamef,albs,albt) {

    var albs = document.getElementById(albs).value;
    var albt = document.getElementById(albt).value;

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: namef, 'albs':albs, 'albt':albt
    };

    $.ajax({
        type: 'POST',
        url: '/do_red_alb',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(divnamef).innerHTML=data;
        }
    });

}



function all_ac(namef,page) {
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
        url: '/all_ac',
        data: formData,
        cache: false,
        success:function(data){
                if(page=="1"){document.getElementById("add_script_center2").innerHTML=data;}
                else{document.getElementById("add_script_center2").innerHTML+=data;}
        }
    });
}


function comment_c(id,namef,page) {
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
        url: '/comment_c',
        data: formData,
        cache: false,
        success:function(data){
                if(page=="1"){document.getElementById("add_script_center2").innerHTML=data;}
                else{document.getElementById("add_script_center2").innerHTML+=data;}
        }
    });
}



function abf(id,Namef) {
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
        url: '/abf',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById("f_in").innerHTML=data;
        }
    });
}




function foto(id,domen,namef,page) {

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
        url: '/foto',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById("foto").innerHTML+=data;
        }
    });
}







function red_foto(namef,divnamef) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: namef
    };
    $.ajax({
        type: 'POST',
        url: '/red_foto',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(divnamef).innerHTML=data;
        }
    });
}

function do_red_foto(namef,divnamef,alb,Adr,Date) {

    var albs = document.getElementById(alb).value;
    var Adrf = document.getElementById(Adr).value;
    var Datef = document.getElementById(Date).value;

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: namef, 'albs':albs, 'Adrf':Adrf, 'Datef':Datef
    };

    $.ajax({
        type: 'POST',
        url: '/do_red_foto',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(divnamef).innerHTML=data;
        }
    });

}





function publ_fc(namef,divnamef) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: namef
    };
    $.ajax({
        type: 'POST',
        url: '/publ_fc',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(divnamef).innerHTML=data;
        }
    });
}


function face_fc(namef,divnamef) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: namef
    };
    $.ajax({
        type: 'POST',
        url: '/face_fc',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(divnamef).innerHTML=data;
        }
    });
}



function del_foto(namef,divnamef) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: namef
    };
    $.ajax({
        type: 'POST',
        url: '/del_foto',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(divnamef).innerHTML=data;
        }
    });
}



function del_alb(namef,divnamef) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: namef
    };
    $.ajax({
        type: 'POST',
        url: '/del_alb',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(divnamef).innerHTML=data;
        }
    });
}



function fviewc(M5,dM5,views) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: M5, 'views':views, 'pc': "c"
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

function ch(rate,im,ok){var rim=rate+im; var iim="i"+rim;
    if(rate==1){document.images[iim].src=myImages[ok];}
    if(rate==2){document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok];}
    if(rate==3){document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok];}
    if(rate==4){document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok];}
    if(rate==5){document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok]; rim=rim-1; iim="i"+rim; document.images[iim].src=myImages[ok];}
}

var myImages2 = new Array("/onm.png", "/offm.png");

function ch2(rate,im,ok){var rim=rate+im; var iim="im"+rim;
    if(rate==5){document.images[iim].src=myImages2[ok];}
}





function rate_add(rM5,M5,rate) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: M5, 'rate':rate
    };
    $.ajax({
        type: 'POST',
        url: '/rate_add',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(rM5).innerHTML=data;
        }
    });
}



function rate_h(rM5,M5) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: M5
    };
    $.ajax({
        type: 'POST',
        url: '/rate_h',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(rM5).innerHTML=data;
        }
    });
}


function rate_addm(rM5,M5,rate) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: M5, 'rate':rate
    };
    $.ajax({
        type: 'POST',
        url: '/rate_addm',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(rM5).innerHTML=data;
        }
    });
}


function rate_hm(rM5,M5) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        Namef: M5
    };
    $.ajax({
        type: 'POST',
        url: '/rate_hm',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(rM5).innerHTML=data;
        }
    });
}




function comm_add(M5,from,min) {

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
        url: '/comm_add',
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






function comm_red(idrec,from,min) {

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
        url: '/comm_red',
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








function comm_del(min,idrec) {


    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        idrec: idrec
    };
    $.ajax({
        type: 'POST',
        url: '/comm_del',
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






function commm_add(M5,from,min,purp) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var from_e = document.getElementById(from).value;
    var formData = {
        M5: M5, Aboutef: from_e, purp: purp,
    };
    $.ajax({
        type: 'POST',
        url: '/commm_add',
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






function commm_red(idrec,from,min,purp) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var from_e = document.getElementById(from).value;
    var formData = {
        idrec: idrec, Aboutef: from_e, purp: purp,
    };

    $.ajax({
        type: 'POST',
        url: '/commm_red',
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








function commm_del(min,idrec) {


    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        idrec: idrec
    };
    $.ajax({
        type: 'POST',
        url: '/commm_del',
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



function top_ask(id,na) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    if(na==0){var from_history = "";}
    else{
        var from_history = document.getElementById('from_history').value;
    }
    var formData = {
        id: id, na: na, from_history: from_history,
    };
    $.ajax({
        type: 'POST',
        url: '/top_ask',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById('dask').innerHTML=data;
        }
    });
}


function answer_interview(id,na) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    if(na==0){var from_e = ""; var from_history = "";}
    else{
        var from_e = document.getElementById('from_ask').value;
        var from_history = document.getElementById('from_history').value;
    }
    var formData = {
        id: id, na: na, from_history: from_history,
        Aboutef: from_e,
    };


    $.ajax({
        type: 'POST',
        url: '/answer_interview',
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
                    url: '/top_ask',
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


function be_admin(id,page) {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        id:id, page:page
    };
    $.ajax({
        type: 'POST',
        url: '/be_admin',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById("be_admin").innerHTML=data;
        }
    });
}


function guesc(page,gdiv,preg,id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    document.getElementById(gdiv).style.display = 'none';

    var formData = {
        id: id, page: page, preg: preg,
    };
    $.ajax({
        type: 'POST',
        url: '/guesc',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById('guests').innerHTML+=data;
        }
    });
}




function guesc_del(avt,Vd,t3,id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });

    var formData = {
        id: id, avt: avt, Vd: Vd,
    };
    $.ajax({
        type: 'POST',
        url: '/guesc_del',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(t3).innerHTML=data;
        }
    });

}



function fguesc(page,gdiv,preg,id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    document.getElementById(gdiv).style.display = 'none';

    var formData = {
        id: id, page: page, preg: preg,
    };
    $.ajax({
        type: 'POST',
        url: '/fguesc',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById('guests').innerHTML+=data;
        }
    });
}


function fguesc_del(avt,Vd,t3,id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });

    var formData = {
        id: id, avt: avt, Vd: Vd,
    };
    $.ajax({
        type: 'POST',
        url: '/fguesc_del',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById(t3).innerHTML=data;
        }
    });

}



function life(npass1,theme,hiddiv,id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        id: id, npass1: npass1, theme: theme,
    };
    $.ajax({
        type: 'POST',
        url: '/life',
        data: formData,
        cache: false,
        success:function(data){
            if(npass1==1){document.getElementById("aboute_life").innerHTML = data;}
            else{document.getElementById("aboute_life").innerHTML += data;}
        }
    });
    document.getElementById(hiddiv).style.display = 'none';
}



function status(id) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var status = document.getElementById('status').value;
    var formData = {
        id: id, status: status,
    };
    $.ajax({
        type: 'POST',
        url: '/status',
        data: formData,
        cache: false,
        success:function(data){
            if(data.indexOf('ok')==1){location.reload();}
        }
    });

}


function weatherWeek(x,y) {

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
    });
    var formData = {
        x: x,
        y: y,
    };
    $.ajax({
        type: 'POST',
        url: '/weather',
        data: formData,
        cache: false,
        success:function(data){
            document.getElementById("weather-week").innerHTML=data; }
    });
}


function ffnews(page) {

	var go_news="";
	if(document.getElementById('cnforum').checked){go_news=go_news+"1";} else{go_news=go_news+"0";}
	if(document.getElementById('cnfoto').checked){go_news=go_news+"1";} else{go_news=go_news+"0";}
	if(document.getElementById('cnratef').checked){go_news=go_news+"1";} else{go_news=go_news+"0";}
	if(document.getElementById('cncoment').checked){go_news=go_news+"1";} else{go_news=go_news+"0";}
	var oblnew = document.getElementById('oblnew').value;

	if(oblnew>=1){
		if(oblnew>=1 && oblnew<10){
			go_news=go_news+"0";
		}
		go_news=go_news+oblnew;
	} else{go_news=go_news+"00";}

	var exp = new Date();
	var oneYearFromNow = exp.getTime() + (365*24*60*60*1000);
	exp.setTime (oneYearFromNow);
	document.cookie = "go_news=" + go_news +"; expires=" + exp.toGMTString();
	$.ajaxSetup({
		headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
	});
	var formData = {
		go_news:go_news, page:0,
	};
	$.ajax({
		type: 'POST',
		url: '/news',
		data: formData,
		cache: false,
		success:function(data){
			document.getElementById("news_result").innerHTML=data;
		}
	});

}
function news(page) {

	var next_div = "next_div" + page;
	document.getElementById(next_div).style.display = 'none';

	$.ajaxSetup({
		headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
	});
	var formData = {
		page:page,
	};
	$.ajax({
		type: 'POST',
		url: '/news',
		data: formData,
		cache: false,
		success:function(data){
			document.getElementById("news_result").innerHTML+=data;
		}
	});

}


function stat(id,purp) {

	$.ajaxSetup({
		headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')}
	});
	var formData = {
		id:id, purp:purp
	};
	$.ajax({
		type: 'POST',
		url: '/stat',
		data: formData,
		cache: false,
		success:function(data){
			document.getElementById("stat").innerHTML=data;
		}
	});
}