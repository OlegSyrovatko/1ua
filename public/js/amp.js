function mem_arguem(nrec, fixblock) {
    document.getElementById(nrec).classList.add('block');
    document.getElementById(fixblock).classList.add('hidden');
}

function hid_cookie() {
    var cookie = document.getElementById('my_cookie');
    cookie.classList.add('hidden');
    var exp = new Date();
    var oneYearFromNow = exp.getTime() + 365 * 24 * 60 * 60 * 1000;
    exp.setTime(oneYearFromNow);
    setTimeout(function () {
        document.getElementById("my_cookie").classList.add('hidden');
    }, 300);
    document.cookie = "my_cookie" + "=; expires=" + exp.toUTCString() + "; path=/";
}
