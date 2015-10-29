function o(e) {
    e = e.toLowerCase();
    e = e.replace(/!|@|%|\^|\*|\(|\)|'|;|_|-|\|`|\+|\=|\<|\>|\?|\/|,|\.|\:|\~|\$|\"|\&|\#|\[|\]/g, "");
    e = e.replace(/-+-/g, "");
    return e
}

function u(e) {
    e = escape(e);
    var t = "";
    var r, i, s = "";
    var o, u, a, f = "";
    var l = 0;
    do {
        r = e.charCodeAt(l++);
        i = e.charCodeAt(l++);
        s = e.charCodeAt(l++);
        o = r >> 2;
        u = (r & 3) << 4 | i >> 4;
        a = (i & 15) << 2 | s >> 6;
        f = s & 63;
        if (isNaN(i)) {
            a = f = 64
        } else if (isNaN(s)) {
            f = 64
        }
        t = t + n.charAt(o) + n.charAt(u) + n.charAt(a) + n.charAt(f);
        r = i = s = "";
        o = u = a = f = ""
    } while (l < e.length);
    return x(15) + t
}

function a(e) {
    e = e.substring(15, e.length);
    var t = "";
    var r, i, s = "";
    var o, u, a, f = "";
    var l = 0;
    var c = /[^A-Za-z0-9\+\/\=]/g;
    if (c.exec(e)) {
        window.location = _root()
    }
    e = e.replace(/[^A-Za-z0-9\+\/\=]/g, "");
    do {
        o = n.indexOf(e.charAt(l++));
        u = n.indexOf(e.charAt(l++));
        a = n.indexOf(e.charAt(l++));
        f = n.indexOf(e.charAt(l++));
        r = o << 2 | u >> 4;
        i = (u & 15) << 4 | a >> 2;
        s = (a & 3) << 6 | f;
        t = t + String.fromCharCode(r);
        if (a != 64) {
            t = t + String.fromCharCode(i)
        }
        if (f != 64) {
            t = t + String.fromCharCode(s)
        }
        r = i = s = "";
        o = u = a = f = ""
    } while (l < e.length);
    return unescape(t)
}

function f(e) {
    return String.fromCharCode(e)
}

function l(e) {
    if (e < 128) return f(e);
    if (e < 2048) return f(192 + (e >> 6)) + f(128 + (e & 63));
    if (e < 65536) return f(224 + (e >> 12)) + f(128 + (e >> 6 & 63)) + f(128 + (e & 63));
    if (e < 2097152) return f(240 + (e >> 18)) + f(128 + (e >> 12 & 63)) + f(128 + (e >> 6 & 63)) + f(128 + (e & 63))
}

function c(e) {
    var t = new Array;
    for (var n = 0; n < e.length; n++) {
        t[n] = l(e.charCodeAt(n))
    }
    return t.join("")
}

function h(e) {
    var t = new Array;
    var n, r = 0;
    var i = "";
    while ((n = e.search(/[^\x00-\x7F]/)) != -1) {
        i = e.match(/([^\x00-\x7F]+[\x00-\x7F]{0,10})+/)[0];
        t[r++] = e.substr(0, n);
        t[r++] = c(i);
        e = e.substr(n + i.length)
    }
    t[r++] = e;
    return t.join("")
}

function p(e) {
    var t = new Array;
    var n, r, i, s, o = 0;
    for (var u = 0; u < e.length;) {
        n = e.charCodeAt(u++);
        if (n > 127) r = e.charCodeAt(u++);
        if (n > 223) i = e.charCodeAt(u++);
        if (n > 239) s = e.charCodeAt(u++);
        if (n < 128) t[o++] = f(n);
        else if (n < 224) t[o++] = f((n - 192 << 6) + (r - 128));
        else if (n < 240) t[o++] = f((n - 224 << 12) + (r - 128 << 6) + (i - 128));
        else t[o++] = f((n - 240 << 18) + (r - 128 << 12) + (i - 128 << 6) + (s - 128))
    }
    return t.join("")
}

function d(e) {
    var t = new Array;
    var n = 0;
    var r = "";
    var i = 0;
    while ((n = e.search(/[^\x00-\x7F]/)) != -1) {
        r = e.match(/([^\x00-\x7F]+[\x00-\x7F]{0,10})+/)[0];
        t[i++] = e.substr(0, n) + p(r);
        e = e.substr(n + r.length)
    }
    t[i++] = e;
    return t.join("")
}

function v(e) {
    var t = "";
    for (i = 0; i < e.length; i++) {
        if (e.charAt(i) == " ") t += "+";
        else t += e.charAt(i)
    }
    return escape(t)
}

function m(e) {
    var t = e.replace(/\+/g, " ");
    return unescape(t)
}

function g(e) {
    return unescape(encodeURIComponent(e))
}

function y(e) {
    if (window.sidebar) {
        var t = window.title;
        var n = window.location;
        window.sidebar.addPanel(t, n, "")
    } else if (window.opera && window.print) {

    } else if (document.all) {
        if (document.all) {
            e.style.behavior = "url(#default#homepage)";
        }
    }
}

function b(e, t, n) {
    var r = new Date;
    r.setDate(r.getDate() + n);
    var i = escape(t) + (n == null ? "" : ";path=/; expires=" + r.toUTCString());
    document.cookie = e + "=" + i
}

function w(e) {
    var t, n, r, i = document.cookie.split(";");
    for (t = 0; t < i.length; t++) {
        n = i[t].substr(0, i[t].indexOf("="));
        r = i[t].substr(i[t].indexOf("=") + 1);
        n = n.replace(/^\s+|\s+$/g, "");
        if (n == e) {
            return unescape(r)
        }
    }
}

function E() {
    var e = document.cookie.split(";");
    for (var t = 0; t < e.length; t++) {
        var n = e[t];
        var r = n.indexOf("=");
        var i = r > -1 ? n.substr(0, r) : n;
        document.cookie = i + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/"
    }
}

function S(e) {
    if (null == e || "" == e) {
        return true
    }
    return false
}

function x(e) {
    var t = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
    var n = "";
    for (var r = 0; r < e; r++) {
        var i = Math.floor(Math.random() * t.length);
        n += t.substring(i, i + 1)
    }
    return n
}

function T(e) {
    e = e.toLowerCase();
    e = e.replace(/A |A\A1|?|?|A\A3|A\A2|?|?|?|?|?|ã|?|?|?|?|?/g, "a");
    e = e.replace(/A\A8|A\A9|?|?|?|A\AA|?|?|?|?|?/g, "e");
    e = e.replace(/A\AC|A\AD|?|?|?/g, "i");
    e = e.replace(/A\B2|A\B3|?|?|A\B5|A\B4|?|?|?|?|?|õ|?|?|?|?|?/g, "o");
    e = e.replace(/A\B9|A\BA|?|?|?|ý|?|?|?|?|?/g, "u");
    e = e.replace(/?|A\BD|?|?|?/g, "y");
    e = e.replace(/ð/g, "d");
    e = e.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\~|\$| |\'|\"|\&|\#|\[|\]/g, "-");
    e = e.replace(/-+-/g, "-");
    e = e.replace(/_+_/g, "_");
    return e
}

function N(e) {
    if (e != "") {
        if (isNaN(Number(e))) {
            return false
        } else {
            return true
        }
    }
    return false
}

function C(e) {
    var t = "";
    t = $(e + " option:selected").text();
    return t
}
function showlike() {
    var opacity = 0;
    var faceLike = $.cookie("fVisitor");
    var likes = $("#fbl-btn");
    if (faceLike == 1) {

    } else {
        $(document).mousemove(function (e) {
            likes.css({'left': (e.pageX - 3) + 'px', 'top': (e.pageY - 3) + 'px', 'opacity':opacity})
            if ($(document.activeElement).attr('id') == "idfacebook") {
                $.cookie("fVisitor", 1, {expires: 1, path: '/'});
                likes.remove();
                if (window.addEventListener) {
                    document.removeEventListener("mousemove", mouse, false);
                }
                else if (window.attachEvent) {
                    document.detachEvent("onmousemove", mouse);
                }
            }
        });
    }
}