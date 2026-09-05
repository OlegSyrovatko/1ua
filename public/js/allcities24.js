jQuery(document).ready(function ($) {
    $("#av_load").click(function (e) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
        });
        var formData = new FormData();
        formData.append("section", "general");
        formData.append("action", "previewImg");
        formData.append("image", $("input[type=file]")[0].files[0]);
        document.getElementById("load_on").style.display = "block";
        $.ajax({
            type: "POST",
            url: "/avload",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function success(data) {
                document.getElementById("avload").innerHTML = data;
            },
        });
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $("#multi-file-upload-ajax").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        let TotalFiles = $("#files")[0].files.length; //Total files
        let files = $("#files")[0];
        for (let i = 0; i < TotalFiles; i++) {
            formData.append("files" + i, files.files[i]);
        }
        formData.append("TotalFiles", TotalFiles);
        $.ajax({
            type: "POST",
            url: "{{ url('store-multi-file-ajax')}}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: (data) => {
                this.reset();
                alert("Files has been uploaded using jQuery ajax");
            },
            error: function (data) {
                alert(data.responseJSON.errors.files[0]);
                console.log(data.responseJSON.errors);
            },
        });
    });

    $("#search").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        document.getElementById("load_min").style.display = "none";
        document.getElementById("load_max").style.display = "none";

        let TotalFiles = $("#files")[0].files.length;
        if (TotalFiles == 0) {
            document.getElementById("load_min").style.display = "block";
        } else {
            if (TotalFiles > 10) {
                document.getElementById("load_max").style.display = "block";
            } else {
                document.getElementById("load_on").style.display = "block";
                let files = $("#files")[0];
                for (let i = 0; i < TotalFiles; i++) {
                    formData.append("files" + i, files.files[i]);
                }
                formData.append("TotalFiles", TotalFiles);
                var alb = document.getElementById("album0").value;
                var Adrf = document.getElementById("Adrf0").value;
                var Datef = document.getElementById("Datef0").value;
                var id = 0;

                formData.append("alb", alb);
                formData.append("Adrf", Adrf);
                formData.append("Datef", Datef);
                formData.append("id", id);

                $.ajax({
                    type: "POST",
                    url: "/load_foto",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        document.getElementById("load_foto").innerHTML = data;
                        document.getElementById("load_on").style.display =
                            "none";
                    },
                });
            }
        }
    });

    $("#obl").change(function (e) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
        });
        var formData = {
            nobl: jQuery("#obl").val(),
        };

        document.getElementById("hrayc").style.display = "block";
        document.getElementById("hrayc2").style.display = "block";
        $.ajax({
            type: "POST",
            url: "/rayc",
            data: formData,
            cache: false,
            success: function (data) {
                data = JSON.stringify(data);
                document.getElementById("rayc").innerHTML = data;
            },
        });
    });

    $("#rayc").change(function (e) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
        });
        var formData = {
            rayc: jQuery("#rayc").val(),
        };

        document.getElementById("hidc").style.display = "block";
        document.getElementById("hidc2").style.display = "block";

        $.ajax({
            type: "POST",
            url: "/idc",
            data: formData,
            cache: false,
            success: function (data) {
                data = JSON.stringify(data);
                document.getElementById("idc").innerHTML = data;
            },
        });
    });

    $("#cityInput").on("input", function () {
        var query = $(this).val();
        if (query.length > 2) {
            $.ajax({
                url: "/get-cities",
                type: "GET",
                data: { query: query },
                success: function (data) {
                    $("#cityDropdown").empty();

                    data.forEach(function (data) {
                        $("#cityDropdown").append(
                            "<li>" + data.сity + data.rayc + data.obl + "</li>"
                        );
                    });
                },
            });
        } else {
            $("#cityDropdown").empty();
        }
    });
});

function form_send(sskip) {
    document.getElementById("skip").value = sskip;
    document.forms.psee2.submit();
}
function form_send2(sort) {
    document.getElementById("sort").value = sort;
    document.getElementById("skip").value = 0;
    document.forms.psee2.submit();
}

function question(from, id, target) {
    var question = document.getElementById("question").value;

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        question: question,
        id: id,
        avt: from,
    };
    $.ajax({
        type: "POST",
        url: target,
        data: formData,
        cache: false,
        success: function (data) {
            // data = JSON.stringify(data);
            document.getElementById("question_in").innerHTML = data;
        },
    });
    document.getElementById("question").value = "";
}

function clearss(comareas) {
    var bs = comareas;
    var a = document.getElementById(bs) || bs;
    if (a) {
        a.style.overflow = "hidden";
        var e = (a.rows = a.rows > 0 ? a.rows : 2);
        bs = a.cols = a.cols > 0 ? a.cols : 20;
        var g = RegExp("([^\r\n]{" + bs + "})([^\r\n])"),
            f = RegExp("[^\n]{" + bs + "}\n?$|[^\n]{0," + bs + "}\n");
        a.onkeyup = a.onkeydown = function () {
            for (var c = 0, d = a.value; d.search(f) >= 0; ) {
                c++;
                d = d.replace(f, "");
            }
            c += 2;
            if (c < e) c = e;
            a.rows = c;
        };
    }
}

function ban_qc(box, ipq, id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        id: id,
        ipq: ipq,
    };
    $.ajax({
        type: "POST",
        url: "/ban_qc",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(box).innerHTML = data;
        },
    });
}

function del_qc(box, nq, id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        id: id,
        nq: nq,
    };
    $.ajax({
        type: "POST",
        url: "/del_qc",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(box).innerHTML = data;
            location.reload();
        },
    });
}

function clearsq(comareas, dcmes) {
    document.getElementById(dcmes).style.display = "block";
    var bs = comareas;
    var a = document.getElementById(bs) || bs;
    if (a) {
        a.style.overflow = "hidden";
        var e = (a.rows = a.rows > 0 ? a.rows : 2);
        bs = a.cols = a.cols > 0 ? a.cols : 20;
        var g = RegExp("([^\r\n]{" + bs + "})([^\r\n])"),
            f = RegExp("[^\n]{" + bs + "}\n?$|[^\n]{0," + bs + "}\n");
        a.onkeyup = a.onkeydown = function () {
            for (var c = 0, d = a.value; d.search(f) >= 0; ) {
                c++;
                d = d.replace(f, "");
            }
            c += 2;
            if (c < e) c = e;
            a.rows = c;
        };
    }
}

function askc(box, ask0, nq, id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var ask = document.getElementById(ask0).value;
    var formData = {
        ask: ask,
        id: id,
        nq: nq,
    };
    $.ajax({
        type: "POST",
        url: "/ask_publc",
        data: formData,
        cache: false,
        success: function (data) {
            var nseek = data.indexOf("235*64@75");
            if (nseek > 0) {
                data = data.replace("s235*64@75", "");
                box = box.replace("q_box", "q_err");
                document.getElementById(box).innerHTML = data;
            } else {
                document.getElementById(box).innerHTML = data;
                location.reload();
            }
        },
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
        type: "POST",
        url: n,
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById("mailfield").innerHTML = data;
        },
    });
}

function mailchangec(Pmail, id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var forum = document.getElementById("mforum").value;
    var foto = document.getElementById("mfoto").value;
    var comment = document.getElementById("mcomment").value;
    var regp = document.getElementById("mregp").value;

    var formData = {
        Pmail: Pmail,
        id: id,
        forum: forum,
        foto: foto,
        comment: comment,
        regp: regp,
    };
    $.ajax({
        type: "POST",
        url: "/mailchangecset",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById("mailfield").innerHTML = data;
        },
    });
}

function mem_delm(idrec, ddiv, id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        idrec: idrec,
        id: id,
    };
    $.ajax({
        type: "POST",
        url: "/delmc",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(ddiv).innerHTML = data;
        },
    });
}

function mem_arguem(nrec, fixblock) {
    document.getElementById(nrec).style.display = "block";
    document.getElementById(fixblock).style.display = "none";
}

function mem_not_delm(nrec, fixblock) {
    document.getElementById(nrec).style.display = "none";
    document.getElementById(fixblock).style.display = "block";
}

function publ(idrec, id, afisha) {
    var dividrec = "unsel" + idrec;
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        idrec: idrec,
        id: id,
        afisha: afisha,
    };
    $.ajax({
        type: "POST",
        url: "/fastenc",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(dividrec).innerHTML = data;
        },
    });
}

function ashow() {
    var exp = new Date();
    var oneYearFromNow = exp.getTime() + 365 * 24 * 60 * 60 * 1000;
    exp.setTime(oneYearFromNow);
    document.cookie = "achide" + "=1; expires=" + exp.toGMTString();
    document.getElementById("afisha").style.display = "block";
    document.getElementById("hidafisha").style.display = "block";
}

function ahide() {
    var exp = new Date();
    var oneYearFromNow = exp.getTime() + 365 * 24 * 60 * 60 * 1000;
    exp.setTime(oneYearFromNow);
    document.cookie = "achide" + "=0; expires=" + exp.toGMTString();
    document.getElementById("afisha").style.display = "none";
    document.getElementById("hidafisha").style.display = "none";
}

function rshow(obl) {
    var exp = new Date();
    var oneYearFromNow = exp.getTime() + 365 * 24 * 60 * 60 * 1000;
    exp.setTime(oneYearFromNow);
    document.cookie = "rhide" + "=1; expires=" + exp.toGMTString();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        obl: obl,
    };
    $.ajax({
        type: "POST",
        url: "/radar",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById("radar").innerHTML = data;
        },
    });
    document.getElementById("radar").style.display = "block";
    document.getElementById("hidradar").style.display = "block";
}

function rhide() {
    var exp = new Date();
    var oneYearFromNow = exp.getTime() + 365 * 24 * 60 * 60 * 1000;
    exp.setTime(oneYearFromNow);
    document.cookie = "rhide" + "=0; expires=" + exp.toGMTString();
    document.getElementById("hidradar").style.display = "none";
    document.getElementById("radar").innerHTML = "";
}

function mem(id, rayc, theme, page, move) {
    var fnext = "fnext" + page;
    if (page > 1) {
        document.getElementById(fnext).style.display = "none";
    }

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        id: id,
        rayc: rayc,
        theme: theme,
        page: page,
        move: move,
    };
    $.ajax({
        type: "POST",
        url: "/memc",
        data: formData,
        cache: false,
        success: function (data) {
            if (page > 1) {
                document.getElementById("mem").innerHTML += data;
            } else {
                document.getElementById("mem").innerHTML = data;
            }
        },
    });
    if (theme == "") {
        var memt = document.getElementById("theme_in");
        memt.value = "";
    }
}

function memt(id, rayc) {
    var th = document.getElementById("th");
    var theme = th.options[th.selectedIndex].value;
    if (document.getElementById("theme_in")) {
        document.getElementById("theme_in").value = theme;
    }

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        id: id,
        rayc: rayc,
        theme: theme,
        page: 1,
        move: "Desc",
    };
    $.ajax({
        type: "POST",
        url: "/memc",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById("mem").innerHTML = data;
        },
    });
}

function sml(purp) {
    var memt = document.getElementById("app_mem").innerHTML;
    var nseek = memt.indexOf("sml");
    if (nseek > 0) {
        document.getElementById("app_mem").innerHTML = "";
        document.getElementById("app_mem_add").innerHTML = "";
    } else {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
        });
        var formData = {
            purp: purp,
        };
        $.ajax({
            type: "POST",
            url: "/sml_in",
            data: formData,
            cache: false,
            success: function (data) {
                document.getElementById("app_mem").innerHTML = data;
            },
        });
    }
}

function smlin(sml) {
    sml = sml.replace(".gif", ".gif>");
    var memt = document.getElementById("memt").value;
    if (memt) {
        memt = memt + " ";
    }
    memt = memt + sml;
    var txt = document.getElementById("memt");
    txt.value = memt;
}

function sml_red(purp) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        purp: purp,
    };
    $.ajax({
        type: "POST",
        url: "/sml_add",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById("app_mem_add").innerHTML = data;
        },
    });
}

function mem_add(id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var theme_in = document.getElementById("theme_in").value;
    var memt = document.getElementById("memt").value;

    var formData = {
        theme_in: theme_in,
        id: id,
        memt: memt,
        purp: "do",
    };
    $.ajax({
        type: "POST",
        url: "/mem_add",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById("memt_res").innerHTML = data;
            var nseek = data.indexOf("avatar/s");
            if (nseek > 0) {
                var txt = document.getElementById("memt");
                txt.value = "";
                document.getElementById("mem_add").style.display = "none";
            }
        },
    });
    document.getElementById("app_mem").innerHTML = "";
    document.getElementById("app_mem_add").innerHTML = "";
}

function mem_red(id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });

    var memt = document.getElementById("memt_red").value;
    var theme_in = document.getElementById("theme_in").value;
    var idrec = document.getElementById("idrec").value;
    var md = document.getElementById("md").value;

    var formData = {
        theme_in: theme_in,
        id: id,
        memt: memt,
        purp: "red",
        idrec: idrec,
        md: md,
    };
    $.ajax({
        type: "POST",
        url: "/mem_add",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById("memt_res").innerHTML = data;
        },
    });
}

function all_alb(id, purp, domen) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        id: id,
        purp: purp,
        domen: domen,
    };
    $.ajax({
        type: "POST",
        url: "/max_alb",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById("foto_in").innerHTML = data;
        },
    });
}

function red_alb(namef, divnamef, t3) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
        t3: t3,
    };
    $.ajax({
        type: "POST",
        url: "/red_alb",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(divnamef).innerHTML = data;
        },
    });
}

function do_red_alb(namef, divnamef, albs, albt) {
    var albs = document.getElementById(albs).value;
    var albt = document.getElementById(albt).value;

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
        albs: albs,
        albt: albt,
    };

    $.ajax({
        type: "POST",
        url: "/do_red_alb",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(divnamef).innerHTML = data;
        },
    });
}

function all_ac(namef, page) {
    if (page == "1") {
        var pObj = document.getElementById("add_load");
        pObj.style.maxWidth = 800 + "px";
        document.getElementById("add_load").style.display = "block";
        $("#overlay").show();
        document.getElementById("add_script_center2").innerHTML = "";
    } else {
        var next_div = "next_div" + page;
        document.getElementById(next_div).style.display = "none";
    }
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
        page: page,
    };
    $.ajax({
        type: "POST",
        url: "/all_ac",
        data: formData,
        cache: false,
        success: function (data) {
            if (page == "1") {
                document.getElementById("add_script_center2").innerHTML = data;
            } else {
                document.getElementById("add_script_center2").innerHTML += data;
            }
        },
    });
}

function comment_c(id, namef, page) {
    if (page == "1") {
        var pObj = document.getElementById("add_load");
        pObj.style.maxWidth = 420 + "px";
        document.getElementById("add_load").style.display = "block";
        $("#overlay").show();
        document.getElementById("add_script_center2").innerHTML = "";
    } else {
        var next_div = "next_div" + page;
        document.getElementById(next_div).style.display = "none";
    }
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
        id: id,
        page: page,
    };
    $.ajax({
        type: "POST",
        url: "/comment_c",
        data: formData,
        cache: false,
        success: function (data) {
            if (page == "1") {
                document.getElementById("add_script_center2").innerHTML = data;
            } else {
                document.getElementById("add_script_center2").innerHTML += data;
            }
        },
    });
}

function abf(id, Namef) {
    document.getElementById("f_in").innerHTML = "";
    document.getElementById("abf_load").style.display = "block";
    $("#overlay_abf").show();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: Namef,
        id: id,
    };
    $.ajax({
        type: "POST",
        url: "/abf",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById("f_in").innerHTML = data;
            // фото вже показане, коментарі підвантажуємо окремим запитом, щоб не чекати на них
            abf_load_comments(id, Namef);
        },
    });
}

function abf_load_comments(id, Namef) {
    var target = document.getElementById("in" + Namef);
    if (!target) {
        return;
    }
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        type: "POST",
        url: "/abf_comments",
        data: { Namef: Namef, id: id },
        cache: false,
        success: function (data) {
            target.innerHTML = data;
        },
    });
}

function foto(id, domen, namef, page) {
    var next_div = "nextf_div" + page;
    document.getElementById(next_div).style.display = "none";

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        id: id,
        domen: domen,
        Namef: namef,
        page: page,
    };
    $.ajax({
        type: "POST",
        url: "/foto",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById("foto").innerHTML += data;
        },
    });
}

function red_foto(namef, divnamef) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
    };
    $.ajax({
        type: "POST",
        url: "/red_foto",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(divnamef).innerHTML = data;
        },
    });
}

function do_red_foto(namef, divnamef, alb, Adr, Date) {
    var albs = document.getElementById(alb).value;
    var Adrf = document.getElementById(Adr).value;
    var Datef = document.getElementById(Date).value;

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
        albs: albs,
        Adrf: Adrf,
        Datef: Datef,
    };

    $.ajax({
        type: "POST",
        url: "/do_red_foto",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(divnamef).innerHTML = data;
        },
    });
}

function publ_fc(namef, divnamef) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
    };
    $.ajax({
        type: "POST",
        url: "/publ_fc",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(divnamef).innerHTML = data;
        },
    });
}

function face_fc(namef, divnamef) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
    };
    $.ajax({
        type: "POST",
        url: "/face_fc",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(divnamef).innerHTML = data;
        },
    });
}

function del_foto(namef, divnamef) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
    };
    $.ajax({
        type: "POST",
        url: "/del_foto",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(divnamef).innerHTML = data;
        },
    });
}

function del_alb(namef, divnamef) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
    };
    $.ajax({
        type: "POST",
        url: "/del_alb",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(divnamef).innerHTML = data;
        },
    });
}

function fviewc(M5, dM5, views) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: M5,
        views: views,
        pc: "c",
    };
    $.ajax({
        type: "POST",
        url: "/fview",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(dM5).innerHTML = data;
        },
    });
}

var myImages = new Array("/on.png", "/off.png");

function ch(rate, im, ok) {
    var rim = rate + im;
    var iim = "i" + rim;
    if (rate == 1) {
        document.images[iim].src = myImages[ok];
    }
    if (rate == 2) {
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
    }
    if (rate == 3) {
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
    }
    if (rate == 4) {
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
    }
    if (rate == 5) {
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
    }
}

var myImages2 = new Array("/onm.png", "/offm.png");

function ch2(rate, im, ok) {
    var rim = rate + im;
    var iim = "im" + rim;
    if (rate == 5) {
        document.images[iim].src = myImages2[ok];
    }
}

function rate_add(rM5, M5, rate) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: M5,
        rate: rate,
    };
    $.ajax({
        type: "POST",
        url: "/rate_add",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(rM5).innerHTML = data;
        },
    });
}

function rate_h(rM5, M5) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: M5,
    };
    $.ajax({
        type: "POST",
        url: "/rate_h",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(rM5).innerHTML = data;
        },
    });
}

function rate_addm(rM5, M5, rate) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: M5,
        rate: rate,
    };
    $.ajax({
        type: "POST",
        url: "/rate_addm",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(rM5).innerHTML = data;
        },
    });
}

function rate_hm(rM5, M5) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: M5,
    };
    $.ajax({
        type: "POST",
        url: "/rate_hm",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(rM5).innerHTML = data;
        },
    });
}

function comm_add(M5, from, min) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var from_e = document.getElementById(from).value;
    var formData = {
        M5: M5,
        Aboutef: from_e,
    };
    $.ajax({
        type: "POST",
        url: "/comm_add",
        data: formData,
        cache: false,
        success: function (data) {
            var nseek = data.indexOf("s235*64@75");
            if (nseek > 0) {
                data = data.replace("s235*64@75", "");
                document.getElementById(min).innerHTML += data;
            } else {
                document.getElementById(min).innerHTML = data;
                document.getElementById(from).value = "";
            }
        },
    });
}

function comm_red(idrec, from, min) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var from_e = document.getElementById(from).value;
    var formData = {
        idrec: idrec,
        Aboutef: from_e,
    };

    $.ajax({
        type: "POST",
        url: "/comm_red",
        data: formData,
        cache: false,
        success: function (data) {
            var nseek = data.indexOf("s235*64@75");
            if (nseek > 0) {
                data = data.replace("s235*64@75", "");
                document.getElementById(min).innerHTML += data;
            } else {
                document.getElementById(min).innerHTML = data;
            }
        },
    });
}

function comm_del(min, idrec) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        idrec: idrec,
    };
    $.ajax({
        type: "POST",
        url: "/comm_del",
        data: formData,
        cache: false,
        success: function (data) {
            var nseek = data.indexOf("s235*64@75");
            if (nseek > 0) {
                data = data.replace("s235*64@75", "");
                document.getElementById(min).innerHTML += data;
            } else {
                document.getElementById(min).innerHTML = data;
            }
        },
    });
}

function commm_add(M5, from, min, purp) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var from_e = document.getElementById(from).value;
    var formData = {
        M5: M5,
        Aboutef: from_e,
        purp: purp,
    };
    $.ajax({
        type: "POST",
        url: "/commm_add",
        data: formData,
        cache: false,
        success: function (data) {
            var nseek = data.indexOf("s235*64@75");
            if (nseek > 0) {
                data = data.replace("s235*64@75", "");
                document.getElementById(min).innerHTML += data;
            } else {
                document.getElementById(min).innerHTML = data;
                document.getElementById(from).value = "";
            }
        },
    });
}

function commm_red(idrec, from, min, purp) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var from_e = document.getElementById(from).value;
    var formData = {
        idrec: idrec,
        Aboutef: from_e,
        purp: purp,
    };

    $.ajax({
        type: "POST",
        url: "/commm_red",
        data: formData,
        cache: false,
        success: function (data) {
            var nseek = data.indexOf("s235*64@75");
            if (nseek > 0) {
                data = data.replace("s235*64@75", "");
                document.getElementById(min).innerHTML += data;
            } else {
                document.getElementById(min).innerHTML = data;
            }
        },
    });
}

function commm_del(min, idrec) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        idrec: idrec,
    };
    $.ajax({
        type: "POST",
        url: "/commm_del",
        data: formData,
        cache: false,
        success: function (data) {
            var nseek = data.indexOf("s235*64@75");
            if (nseek > 0) {
                data = data.replace("s235*64@75", "");
                document.getElementById(min).innerHTML += data;
            } else {
                document.getElementById(min).innerHTML = data;
            }
        },
    });
}

function top_ask(id, na) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    if (na == 0) {
        var from_history = "";
    } else {
        var from_history = document.getElementById("from_history").value;
    }
    var formData = {
        id: id,
        na: na,
        from_history: from_history,
    };
    $.ajax({
        type: "POST",
        url: "/top_ask",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById("dask").innerHTML = data;
        },
    });
}

function answer_interview(id, na) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    if (na == 0) {
        var from_e = "";
        var from_history = "";
    } else {
        var from_e = document.getElementById("from_ask").value;
        var from_history = document.getElementById("from_history").value;
    }
    var formData = {
        id: id,
        na: na,
        from_history: from_history,
        Aboutef: from_e,
    };

    $.ajax({
        type: "POST",
        url: "/answer_interview",
        data: formData,
        cache: false,
        success: function (data) {
            var nseek = data.indexOf("s235*64@75");
            if (nseek > 0) {
                data = data.replace("s235*64@75", "");
                document.getElementById("dask").innerHTML += data;
                document.getElementById("from_ask").value = from_e;
            } else {
                $.ajax({
                    type: "POST",
                    url: "/top_ask",
                    data: formData,
                    cache: false,
                    success: function (data) {
                        document.getElementById("dask").innerHTML = data;
                    },
                });
            }
        },
    });
}

function be_admin(id, page) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        id: id,
        page: page,
    };
    $.ajax({
        type: "POST",
        url: "/be_admin",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById("be_admin").innerHTML = data;
        },
    });
}

function guesc(page, gdiv, preg, id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    document.getElementById(gdiv).style.display = "none";

    var formData = {
        id: id,
        page: page,
        preg: preg,
    };
    $.ajax({
        type: "POST",
        url: "/guesc",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById("guests").innerHTML += data;
        },
    });
}

function guesc_del(avt, Vd, t3, id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });

    var formData = {
        id: id,
        avt: avt,
        Vd: Vd,
    };
    $.ajax({
        type: "POST",
        url: "/guesc_del",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(t3).innerHTML = data;
        },
    });
}

function fguesc(page, gdiv, preg, id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    document.getElementById(gdiv).style.display = "none";

    var formData = {
        id: id,
        page: page,
        preg: preg,
    };
    $.ajax({
        type: "POST",
        url: "/fguesc",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById("guests").innerHTML += data;
        },
    });
}

function fguesc_del(avt, Vd, t3, id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });

    var formData = {
        id: id,
        avt: avt,
        Vd: Vd,
    };
    $.ajax({
        type: "POST",
        url: "/fguesc_del",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById(t3).innerHTML = data;
        },
    });
}

function life(npass1, theme, hiddiv, id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        id: id,
        npass1: npass1,
        theme: theme,
    };
    $.ajax({
        type: "POST",
        url: "/life",
        data: formData,
        cache: false,
        success: function (data) {
            if (npass1 == 1) {
                document.getElementById("aboute_life").innerHTML = data;
            } else {
                document.getElementById("aboute_life").innerHTML += data;
            }
        },
    });
    document.getElementById(hiddiv).style.display = "none";
}

function status(id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var status = document.getElementById("status").value;
    var formData = {
        id: id,
        status: status,
    };
    $.ajax({
        type: "POST",
        url: "/status",
        data: formData,
        cache: false,
        success: function (data) {
            if (data.indexOf("ok") == 1) {
                location.reload();
            }
        },
    });
}

function weatherWeek(x, y) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        x: x,
        y: y,
    };
    $.ajax({
        type: "POST",
        url: "/weather",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById("weather-week").innerHTML = data;
        },
    });
}

function ffnews(page) {
    var go_news = "";
    if (document.getElementById("cnforum").checked) {
        go_news = go_news + "1";
    } else {
        go_news = go_news + "0";
    }
    if (document.getElementById("cnfoto").checked) {
        go_news = go_news + "1";
    } else {
        go_news = go_news + "0";
    }
    if (document.getElementById("cnratef").checked) {
        go_news = go_news + "1";
    } else {
        go_news = go_news + "0";
    }
    if (document.getElementById("cncoment").checked) {
        go_news = go_news + "1";
    } else {
        go_news = go_news + "0";
    }
    // "Місцеві новини" тепер множинний вибір (чекбокси в dropdown-панелі) замість одного <select>
    var oblChecks = document.querySelectorAll("#oblMultiselectPanel .obl-check:checked");
    var oblIds = [];
    oblChecks.forEach(function (el) {
        oblIds.push(el.value);
    });
    go_news = go_news + oblIds.join(",");

    var oblLabel = document.getElementById("oblMultiselectLabel");
    var oblToggle = document.getElementById("oblMultiselectToggle");
    if (oblLabel && oblToggle) {
        if (oblIds.length > 0) {
            oblLabel.textContent = oblToggle
                .getAttribute("data-count-template")
                .replace(":n", oblIds.length);
        } else {
            oblLabel.textContent = oblToggle.getAttribute("data-choose-text");
        }
    }

    var exp = new Date();
    var oneYearFromNow = exp.getTime() + 365 * 24 * 60 * 60 * 1000;
    exp.setTime(oneYearFromNow);
    document.cookie = "go_news=" + go_news + "; expires=" + exp.toGMTString();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        go_news: go_news,
        page: 0,
    };
    $.ajax({
        type: "POST",
        url: "/news",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById("news_result").innerHTML = data;
            if (typeof newsBigPhotoInit === "function") { newsBigPhotoInit(); }
            if (typeof commAllowpInit === "function") { commAllowpInit(); }
        },
    });
}

function toggleOblPanel() {
    var panel = document.getElementById("oblMultiselectPanel");
    if (panel) {
        panel.classList.toggle("un-display");
    }
}

document.addEventListener("click", function (e) {
    var box = document.getElementById("oblMultiselect");
    var panel = document.getElementById("oblMultiselectPanel");
    if (box && panel && !box.contains(e.target)) {
        panel.classList.add("un-display");
    }
});
function news(page) {
    var next_div = "next_div" + page;
    document.getElementById(next_div).style.display = "none";

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        page: page,
    };
    $.ajax({
        type: "POST",
        url: "/news",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById("news_result").innerHTML += data;
            if (typeof newsBigPhotoInit === "function") { newsBigPhotoInit(); }
            if (typeof commAllowpInit === "function") { commAllowpInit(); }
        },
    });
}

function stat(id, purp) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });

    document.getElementById("export_id").innerHTML = id;
    var formData = {
        id: id,
        purp: purp,
    };
    $.ajax({
        type: "POST",
        url: "/stat",
        data: formData,
        cache: false,
        success: function (data) {
            document.getElementById("stat").innerHTML = data;
            // пам'ятаємо останню переглянуту область/район, щоб відновити її при наступному
            // заході (навіть після закриття браузера) — див. виклик stat_restore() на головній
            try {
                localStorage.setItem("1ua_stat_nav", JSON.stringify({ id: id, purp: purp }));
            } catch (e) {}
        },
    });
}

function stat_restore() {
    var statEl = document.getElementById("stat");
    if (!statEl) {
        return;
    }
    try {
        var saved = JSON.parse(localStorage.getItem("1ua_stat_nav"));
        if (saved && saved.id !== undefined && saved.purp) {
            stat(saved.id, saved.purp);
        }
    } catch (e) {}
}

function hid_cookie() {
    var cookie = document.getElementById("my_cookie");
    cookie.classList.add("hidden"); // Додаємо клас 'hidden' для зникнення з анімацією
    var exp = new Date();
    var oneYearFromNow = exp.getTime() + 365 * 24 * 60 * 60 * 1000;
    exp.setTime(oneYearFromNow);
    setTimeout(function () {
        document.getElementById("my_cookie").style.display = "none";
    }, 300);
    document.cookie = `my_cookie=0; expires=${exp.toUTCString()}; path=/`; // Помічаємо куки для видалення
}

function set_online() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        type: "POST",
        url: "/setonline",
        cache: false,
        contentType: false,
        processData: false,
    });
}
setInterval("set_online();", 10000);

function clearssi(comareas) {
    var bs = comareas;
    var a = document.getElementById(bs) || bs;
    if (a) {
        a.style.overflow = "hidden";
        var e = (a.rows = a.rows > 0 ? a.rows : 2);
        bs = a.cols = a.cols > 0 ? a.cols : 20;
        var g = RegExp("([^\r\n]{" + bs + "})([^\r\n])"),
            f = RegExp("[^\n]{" + bs + "}\n?$|[^\n]{0," + bs + "}\n");
        a.onkeyup = a.onkeydown = function () {
            for (var c = 0, d = a.value; d.search(f) >= 0; ) {
                c++;
                d = d.replace(f, "");
            }
            c += 2;
            if (c < e) c = e;
            a.rows = c;
        };
    }
}
function questioni(from, id, target) {
    var question = document.getElementById("question").value;
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        question: question,
        id: id,
        avt: from,
    };
    $.ajax({
        type: "POST",
        url: target,
        data: formData,
        cache: false,
        success: function success(data) {
            // data = JSON.stringify(data);
            document.getElementById("question_in").innerHTML = data;
        },
    });
    document.getElementById("question").value = "";
}
function ban_qp(box, ipq) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        ipq: ipq,
    };
    $.ajax({
        type: "POST",
        url: "/ban_qp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(box).innerHTML = data;
        },
    });
}
function del_qp(box, nq) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        nq: nq,
    };
    $.ajax({
        type: "POST",
        url: "/del_qp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(box).innerHTML = data;
            location.reload();
        },
    });
}
function clearsp(comareas, dcmes) {
    document.getElementById(dcmes).style.display = "block";
    var bs = comareas;
    var a = document.getElementById(bs) || bs;
    if (a) {
        a.style.overflow = "hidden";
        var e = (a.rows = a.rows > 0 ? a.rows : 2);
        bs = a.cols = a.cols > 0 ? a.cols : 20;
        var g = RegExp("([^\r\n]{" + bs + "})([^\r\n])"),
            f = RegExp("[^\n]{" + bs + "}\n?$|[^\n]{0," + bs + "}\n");
        a.onkeyup = a.onkeydown = function () {
            for (var c = 0, d = a.value; d.search(f) >= 0; ) {
                c++;
                d = d.replace(f, "");
            }
            c += 2;
            if (c < e) c = e;
            a.rows = c;
        };
    }
}
function askp(box, ask0, nq) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var ask = document.getElementById(ask0).value;
    var formData = {
        ask: ask,
        nq: nq,
    };
    $.ajax({
        type: "POST",
        url: "/ask_publp",
        data: formData,
        cache: false,
        success: function success(data) {
            var nseek = data.indexOf("235*64@75");
            if (nseek > 0) {
                data = data.replace("s235*64@75", "");
                box = box.replace("q_box", "q_err");
                document.getElementById(box).innerHTML = data;
            } else {
                document.getElementById(box).innerHTML = data;
                location.reload();
            }
        },
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
        type: "POST",
        url: n,
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById("mailfield").innerHTML = data;
        },
    });
}
function mailchange(Pmail, id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var forum = document.getElementById("mforum").value;
    var foto = document.getElementById("mfoto").value;
    var comment = document.getElementById("mcomment").value;
    var formData = {
        Pmail: Pmail,
        id: id,
        forum: forum,
        foto: foto,
        comment: comment,
    };
    $.ajax({
        type: "POST",
        url: "/mailchangeset",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById("mailfield").innerHTML = data;
        },
    });
}
function mem_delmp(idrec, ddiv, id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        idrec: idrec,
        id: id,
    };
    $.ajax({
        type: "POST",
        url: "/delmp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(ddiv).innerHTML = data;
        },
    });
}
function mem_arguemp(nrec, fixblock) {
    document.getElementById(nrec).style.display = "block";
    document.getElementById(fixblock).style.display = "none";
}
function mem_not_delmp(nrec, fixblock) {
    document.getElementById(nrec).style.display = "none";
    document.getElementById(fixblock).style.display = "block";
}
function publp(idrec, id, afisha) {
    var dividrec = "unsel" + idrec;
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        idrec: idrec,
        id: id,
        afisha: afisha,
    };
    $.ajax({
        type: "POST",
        url: "/fastenp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(dividrec).innerHTML = data;
        },
    });
}
function ashowp() {
    var exp = new Date();
    var oneYearFromNow = exp.getTime() + 365 * 24 * 60 * 60 * 1000;
    exp.setTime(oneYearFromNow);
    document.cookie = "aphide" + "=1; expires=" + exp.toGMTString();
    document.getElementById("afisha").style.display = "block";
    document.getElementById("hidafisha").style.display = "block";
}
function ahidep() {
    var exp = new Date();
    var oneYearFromNow = exp.getTime() + 365 * 24 * 60 * 60 * 1000;
    exp.setTime(oneYearFromNow);
    document.cookie = "aphide" + "=0; expires=" + exp.toGMTString();
    document.getElementById("afisha").style.display = "none";
    document.getElementById("hidafisha").style.display = "none";
}
function memp(id, theme, page, move) {
    var fnext = "fnext" + page;
    if (page > 1) {
        document.getElementById(fnext).style.display = "none";
    }
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        id: id,
        theme: theme,
        page: page,
        move: move,
    };
    $.ajax({
        type: "POST",
        url: "/memp",
        data: formData,
        cache: false,
        success: function success(data) {
            if (page > 1) {
                document.getElementById("mem").innerHTML += data;
            } else {
                document.getElementById("mem").innerHTML = data;
            }
        },
    });
    if (theme == "") {
        var memt = document.getElementById("theme_in");
        memt.value = "";
    }
}
function memtp(id) {
    var th = document.getElementById("th");
    var theme = th.options[th.selectedIndex].value;
    if (document.getElementById("theme_in")) {
        document.getElementById("theme_in").value = theme;
    }

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        id: id,
        theme: theme,
        page: 1,
        move: "Desc",
    };
    $.ajax({
        type: "POST",
        url: "/memp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById("mem").innerHTML = data;
        },
    });
}
function smlp(purp) {
    var memt = document.getElementById("app_mem").innerHTML;
    var nseek = memt.indexOf("sml");
    if (nseek > 0) {
        document.getElementById("app_mem").innerHTML = "";
        document.getElementById("app_mem_add").innerHTML = "";
    } else {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
        });
        var formData = {
            purp: purp,
        };
        $.ajax({
            type: "POST",
            url: "/sml_in",
            data: formData,
            cache: false,
            success: function success(data) {
                document.getElementById("app_mem").innerHTML = data;
            },
        });
    }
}
function mem_addp(id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var theme_in = document.getElementById("theme_in").value;
    var memt = document.getElementById("memt").value;
    var formData = {
        theme_in: theme_in,
        id: id,
        memt: memt,
        purp: "do",
    };
    $.ajax({
        type: "POST",
        url: "/mem_addp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById("memt_res").innerHTML = data;
            var nseek = data.indexOf("avatar/s");
            if (nseek > 0) {
                var txt = document.getElementById("memt");
                txt.value = "";
                document.getElementById("mem_add").style.display = "none";
            }
        },
    });
    document.getElementById("app_mem").innerHTML = "";
    document.getElementById("app_mem_add").innerHTML = "";
}
function mem_redp(id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var memt = document.getElementById("memt_red").value;
    var theme_in = document.getElementById("theme_in").value;
    var idrec = document.getElementById("idrec").value;
    var md = document.getElementById("md").value;
    var formData = {
        theme_in: theme_in,
        id: id,
        memt: memt,
        purp: "red",
        idrec: idrec,
        md: md,
    };
    $.ajax({
        type: "POST",
        url: "/mem_addp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById("memt_res").innerHTML = data;
        },
    });
}
function max_albp(id, purp, domen) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        id: id,
        purp: purp,
        domen: domen,
    };
    $.ajax({
        type: "POST",
        url: "/max_albp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById("foto_in").innerHTML = data;
        },
    });
}
function red_albp(namef, divnamef, t3) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
        t3: t3,
    };
    $.ajax({
        type: "POST",
        url: "/red_albp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(divnamef).innerHTML = data;
        },
    });
}
function do_red_albp(namef, divnamef, albs, albt, shs) {
    var albs = document.getElementById(albs).value;
    var albt = document.getElementById(albt).value;
    var shs = document.getElementById(shs).value;
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
        albs: albs,
        albt: albt,
        shs: shs,
    };
    $.ajax({
        type: "POST",
        url: "/do_red_albp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(divnamef).innerHTML = data;
        },
    });
}
function all_ap(namef, page) {
    if (page == "1") {
        var pObj = document.getElementById("add_load");
        pObj.style.maxWidth = 800 + "px";
        document.getElementById("add_load").style.display = "block";
        $("#overlay").show();
        document.getElementById("add_script_center2").innerHTML = "";
    } else {
        var next_div = "next_div" + page;
        document.getElementById(next_div).style.display = "none";
    }
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
        page: page,
    };
    $.ajax({
        type: "POST",
        url: "/all_ap",
        data: formData,
        cache: false,
        success: function success(data) {
            if (page == "1") {
                document.getElementById("add_script_center2").innerHTML = data;
            } else {
                document.getElementById("add_script_center2").innerHTML += data;
            }
        },
    });
}
function comment_p(id, namef, page) {
    if (page == "1") {
        var pObj = document.getElementById("add_load");
        pObj.style.maxWidth = 420 + "px";
        document.getElementById("add_load").style.display = "block";
        $("#overlay").show();
        document.getElementById("add_script_center2").innerHTML = "";
    } else {
        var next_div = "next_div" + page;
        document.getElementById(next_div).style.display = "none";
    }
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
        id: id,
        page: page,
    };
    $.ajax({
        type: "POST",
        url: "/comment_p",
        data: formData,
        cache: false,
        success: function success(data) {
            if (page == "1") {
                document.getElementById("add_script_center2").innerHTML = data;
            } else {
                document.getElementById("add_script_center2").innerHTML += data;
            }
        },
    });
}
function abfp(id, Namef) {
    document.getElementById("f_in").innerHTML = "";
    document.getElementById("abf_load").style.display = "block";
    $("#overlay_abf").show();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: Namef,
        id: id,
    };

    $.ajax({
        type: "POST",
        url: "/abfp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById("f_in").innerHTML = data;
            abfp_load_comments(id, Namef);
            if (typeof commAllowpInit === "function") { commAllowpInit(); }
        },
    });
}

function abfp_load_comments(id, Namef) {
    var target = document.getElementById("in" + Namef);
    if (!target) {
        return;
    }
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        type: "POST",
        url: "/abfp_comments",
        data: { Namef: Namef, id: id },
        cache: false,
        success: function (data) {
            target.innerHTML = data;
        },
    });
}
function fotop(id, domen, namef, page) {
    var next_div = "nextf_div" + page;
    document.getElementById(next_div).style.display = "none";
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        id: id,
        domen: domen,
        Namef: namef,
        page: page,
    };
    $.ajax({
        type: "POST",
        url: "/fotop",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById("foto").innerHTML += data;
            if (typeof commAllowpInit === "function") { commAllowpInit(); }
        },
    });
}
function red_fotop(namef, divnamef) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
    };
    $.ajax({
        type: "POST",
        url: "/red_fotop",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(divnamef).innerHTML = data;
        },
    });
}
function do_red_fotop(namef, divnamef, alb) {
    var albs = document.getElementById(alb).value;
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
        albs: albs,
    };
    $.ajax({
        type: "POST",
        url: "/do_red_fotop",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(divnamef).innerHTML = data;
        },
    });
}
function publ_fp(namef, divnamef) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
    };
    $.ajax({
        type: "POST",
        url: "/publ_fp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(divnamef).innerHTML = data;
        },
    });
}
function face_fp(namef, divnamef) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
    };
    $.ajax({
        type: "POST",
        url: "/face_fp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(divnamef).innerHTML = data;
        },
    });
}
function del_fotop(namef, divnamef) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
    };
    $.ajax({
        type: "POST",
        url: "/del_fotop",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(divnamef).innerHTML = data;
        },
    });
}
function del_albp(namef, divnamef) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: namef,
    };
    $.ajax({
        type: "POST",
        url: "/del_albp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(divnamef).innerHTML = data;
        },
    });
}
function fview(M5, dM5, views) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: M5,
        views: views,
        pc: "p",
    };
    $.ajax({
        type: "POST",
        url: "/fview",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(dM5).innerHTML = data;
        },
    });
}
var myImages = new Array("/on.png", "/off.png");
function chp(rate, im, ok) {
    var rim = rate + im;
    var iim = "i" + rim;
    if (rate == 1) {
        document.images[iim].src = myImages[ok];
    }
    if (rate == 2) {
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
    }
    if (rate == 3) {
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
    }
    if (rate == 4) {
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
    }
    if (rate == 5) {
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
        rim = rim - 1;
        iim = "i" + rim;
        document.images[iim].src = myImages[ok];
    }
}
var myImages2 = new Array("/onm.png", "/offm.png");
function chp2(rate, im, ok) {
    var rim = rate + im;
    var iim = "im" + rim;
    if (rate == 5) {
        document.images[iim].src = myImages2[ok];
    }
}
function rate_addp(rM5, M5, rate) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: M5,
        rate: rate,
    };
    $.ajax({
        type: "POST",
        url: "/rate_addp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(rM5).innerHTML = data;
        },
    });
}
function rate_hp(rM5, M5) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: M5,
    };
    $.ajax({
        type: "POST",
        url: "/rate_hp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(rM5).innerHTML = data;
        },
    });
}
function rate_addmp(rM5, M5, rate) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: M5,
        rate: rate,
    };
    $.ajax({
        type: "POST",
        url: "/rate_addmp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(rM5).innerHTML = data;
        },
    });
}
function rate_hmp(rM5, M5) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        Namef: M5,
    };
    $.ajax({
        type: "POST",
        url: "/rate_hmp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(rM5).innerHTML = data;
        },
    });
}
function see_comm(scb, scd) {
    document.getElementById(scb).style.display = "none";
    document.getElementById(scd).style.display = "block";
}
function comm_addp(M5, from, min) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var from_e = document.getElementById(from).value;
    var formData = {
        M5: M5,
        Aboutef: from_e,
    };
    $.ajax({
        type: "POST",
        url: "/comm_addp",
        data: formData,
        cache: false,
        success: function success(data) {
            var nseek = data.indexOf("s235*64@75");
            if (nseek > 0) {
                data = data.replace("s235*64@75", "");
                document.getElementById(min).innerHTML += data;
            } else {
                document.getElementById(min).innerHTML = data;
                document.getElementById(from).value = "";
            }
        },
    });
}
function comm_redp(idrec, from, min) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var from_e = document.getElementById(from).value;
    var formData = {
        idrec: idrec,
        Aboutef: from_e,
    };
    $.ajax({
        type: "POST",
        url: "/comm_redp",
        data: formData,
        cache: false,
        success: function success(data) {
            var nseek = data.indexOf("s235*64@75");
            if (nseek > 0) {
                data = data.replace("s235*64@75", "");
                document.getElementById(min).innerHTML += data;
            } else {
                document.getElementById(min).innerHTML = data;
            }
        },
    });
}
function comm_delp(min, idrec) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        idrec: idrec,
    };
    $.ajax({
        type: "POST",
        url: "/comm_delp",
        data: formData,
        cache: false,
        success: function success(data) {
            var nseek = data.indexOf("s235*64@75");
            if (nseek > 0) {
                data = data.replace("s235*64@75", "");
                document.getElementById(min).innerHTML += data;
            } else {
                document.getElementById(min).innerHTML = data;
            }
        },
    });
}
function commm_addp(M5, from, min, purp) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var from_e = document.getElementById(from).value;
    var formData = {
        M5: M5,
        Aboutef: from_e,
        purp: purp,
    };
    $.ajax({
        type: "POST",
        url: "/commm_addp",
        data: formData,
        cache: false,
        success: function success(data) {
            var nseek = data.indexOf("s235*64@75");
            if (nseek > 0) {
                data = data.replace("s235*64@75", "");
                document.getElementById(min).innerHTML += data;
            } else {
                document.getElementById(min).innerHTML = data;
                document.getElementById(from).value = "";
            }
        },
    });
}
function commm_redp(idrec, from, min, purp) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var from_e = document.getElementById(from).value;
    var formData = {
        idrec: idrec,
        Aboutef: from_e,
        purp: purp,
    };
    $.ajax({
        type: "POST",
        url: "/commm_redp",
        data: formData,
        cache: false,
        success: function success(data) {
            var nseek = data.indexOf("s235*64@75");
            if (nseek > 0) {
                data = data.replace("s235*64@75", "");
                document.getElementById(min).innerHTML += data;
            } else {
                document.getElementById(min).innerHTML = data;
            }
        },
    });
}
function commm_delp(min, idrec) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        idrec: idrec,
    };
    $.ajax({
        type: "POST",
        url: "/commm_delp",
        data: formData,
        cache: false,
        success: function success(data) {
            var nseek = data.indexOf("s235*64@75");
            if (nseek > 0) {
                data = data.replace("s235*64@75", "");
                document.getElementById(min).innerHTML += data;
            } else {
                document.getElementById(min).innerHTML = data;
            }
        },
    });
}
function top_askp(na) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    if (na == 0) {
        var from_history = "";
    } else {
        var from_history = document.getElementById("from_history").value;
    }
    var formData = {
        na: na,
        from_history: from_history,
    };
    $.ajax({
        type: "POST",
        url: "/top_askp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById("dask").innerHTML = data;
        },
    });
}
function answer_interviewp(na) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    if (na == 0) {
        var from_e = "";
        var from_history = "";
    } else {
        var from_e = document.getElementById("from_ask").value;
        var from_history = document.getElementById("from_history").value;
    }
    var formData = {
        na: na,
        from_history: from_history,
        Aboutef: from_e,
    };
    $.ajax({
        type: "POST",
        url: "/answer_interviewp",
        data: formData,
        cache: false,
        success: function success(data) {
            var nseek = data.indexOf("s235*64@75");
            if (nseek > 0) {
                data = data.replace("s235*64@75", "");
                document.getElementById("dask").innerHTML += data;
                document.getElementById("from_ask").value = from_e;
            } else {
                $.ajax({
                    type: "POST",
                    url: "/top_askp",
                    data: formData,
                    cache: false,
                    success: function success(data) {
                        document.getElementById("dask").innerHTML = data;
                    },
                });
            }
        },
    });
}
function adm_pages(id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        id: id,
    };
    $.ajax({
        type: "POST",
        url: "/adm_pages",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById("adm_pages").innerHTML += data;
        },
    });
}
function guesp(page, gdiv, preg, id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    document.getElementById(gdiv).style.display = "none";
    var formData = {
        id: id,
        page: page,
        preg: preg,
    };
    $.ajax({
        type: "POST",
        url: "/guesp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById("guests").innerHTML += data;
        },
    });
}
function guesp_del(avt, Vd, t3, id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        id: id,
        avt: avt,
        Vd: Vd,
    };
    $.ajax({
        type: "POST",
        url: "/guesp_del",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(t3).innerHTML = data;
        },
    });
}
function fguesp(page, gdiv, preg, id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    document.getElementById(gdiv).style.display = "none";
    var formData = {
        id: id,
        page: page,
        preg: preg,
    };
    $.ajax({
        type: "POST",
        url: "/fguesp",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById("guests").innerHTML += data;
        },
    });
}
function fguesp_del(avt, Vd, t3, id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        id: id,
        avt: avt,
        Vd: Vd,
    };
    $.ajax({
        type: "POST",
        url: "/fguesp_del",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(t3).innerHTML = data;
        },
    });
}
function add_fr(d_fr, fr) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        fr: fr,
    };
    $.ajax({
        type: "POST",
        url: "/add_fr",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(d_fr).innerHTML = data;
        },
    });
}
function del_fr0(d_fr0, d_fr) {
    document.getElementById(d_fr0).style.display = "none";
    document.getElementById(d_fr).style.display = "block";
}
function del_fr1(d_fr0, d_fr) {
    document.getElementById(d_fr).style.display = "none";
    document.getElementById(d_fr0).style.display = "block";
}
function del_fr(d_fr, fr) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        fr: fr,
    };
    $.ajax({
        type: "POST",
        url: "/del_fr",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(d_fr).innerHTML = data;
        },
    });
}
function refuse_fr(d_fr, fr) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    var formData = {
        fr: fr,
    };
    $.ajax({
        type: "POST",
        url: "/ref_fr",
        data: formData,
        cache: false,
        success: function success(data) {
            document.getElementById(d_fr).innerHTML = data;
        },
    });
}
function redo() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        type: "POST",
        url: "/redo",
        cache: false,
        success: function success(data) {
            if (data) {
                location.reload();
            }
        },
    });
}

function act(idm, ball) {
    let icon = "i" + idm;
    let ont = "ont" + idm;
    document.getElementById(icon).classList.add("icon-yellow");
    document.getElementById(icon).classList.remove(ball);
    document.getElementById(ont).style.zIndex = "11";
    document.getElementById(ont).style.fontWeight = "bold";
}

function inact(idm, ball) {
    let icon = "i" + idm;
    let ont = "ont" + idm;
    document.getElementById(icon).classList.add(ball);
    document.getElementById(icon).classList.remove("icon-yellow");
    document.getElementById(ont).style.zIndex = "1";
    document.getElementById(ont).style.fontWeight = "normal";
}

// "Великі" фото прямо в стрічці новин (index.blade.php / AddScriptController::news()):
// оцінка і коментарі довантажуються асинхронно ПІСЛЯ показу сторінки/фрагмента, щоб не
// сповільнювати першу видачу. Викликається при DOMContentLoaded і після кожного AJAX-
// оновлення стрічки (ffnews/news), бо там знову з'являються нові непровантажені картки.
function newsBigPhotoInit() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });

    document.querySelectorAll(".news-inline-star[data-namef]:not([data-loaded])").forEach(function (el) {
        el.setAttribute("data-loaded", "1");
        $.ajax({
            type: "POST",
            url: "/news_rating_state",
            data: { Namef: el.getAttribute("data-namef"), type: el.getAttribute("data-type") },
            cache: false,
            success: function (data) {
                el.innerHTML = data;
            },
        });
    });

    document.querySelectorAll(".news-inline-comments[data-namef]:not([data-loaded])").forEach(function (el) {
        el.setAttribute("data-loaded", "1");
        var type = el.getAttribute("data-type");
        var url = type === "fotop" ? "/abfp_comments" : "/abf_comments";
        $.ajax({
            type: "POST",
            url: url,
            data: { Namef: el.getAttribute("data-namef"), id: el.getAttribute("data-cityid") },
            cache: false,
            success: function (data) {
                el.innerHTML = data;
            },
        });
    });
}

// Перевірка "чи можна коментувати" ДО показу поля вводу (фото людей, Fotop) — поле спочатку
// сховане (.comm-allowp-gate.un-display), і показується лише після асинхронної відповіді
// /comm_allowp, щоб не було ситуації "ввів коментар — і лише тоді дізнався про заборону".
function commAllowpInit() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });

    document.querySelectorAll(".comm-allowp-gate[data-namef]:not([data-loaded])").forEach(function (el) {
        el.setAttribute("data-loaded", "1");
        $.ajax({
            type: "POST",
            url: "/comm_allowp",
            data: { Namef: el.getAttribute("data-namef") },
            cache: false,
            success: function (data) {
                if (data && ("" + data).trim() === "1") {
                    el.classList.remove("un-display");
                }
            },
        });
    });
}
document.addEventListener("DOMContentLoaded", commAllowpInit);

// Поточна погода на сторінці населеного пункту — довантажується асинхронно після показу
// сторінки (замінили блокуючий file_get_contents() до OpenWeatherMap на сервері), за тим
// самим принципом, що й weatherWeek() для 5-денного прогнозу.
function weatherNowInit() {
    var el = document.getElementById("weather");
    if (!el || el.getAttribute("data-loaded") || !el.getAttribute("data-x")) {
        return;
    }
    el.setAttribute("data-loaded", "1");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        type: "POST",
        url: "/weather_now",
        data: { x: el.getAttribute("data-x"), y: el.getAttribute("data-y") },
        cache: false,
        success: function (data) {
            if (data) {
                el.innerHTML = data;
            }
        },
    });
}
document.addEventListener("DOMContentLoaded", weatherNowInit);
