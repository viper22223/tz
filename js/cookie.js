    // proverka cookies esli 
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    // poluchenie cookie
    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    // proveryaem cookie
    function checkCookie() {
        var cookiePopup = document.getElementById("cookiePopup");
        var cookieAccepted = getCookie("cookieAccepted");
        if (cookieAccepted) {
            cookiePopup.style.display = "none";
        } else {
            cookiePopup.style.display = "block";
        }
    }

    // zakrivaem i ochishaaem
    document.getElementById("closeCookiePopup").addEventListener("click", function() {
        setCookie("cookieAccepted", "", 1); 
        document.getElementById("cookiePopup").style.display = "none";
    });

    // prinimaem
    document.getElementById("acceptCookies").addEventListener("click", function() {
        setCookie("cookieAccepted", true, 1);
        document.getElementById("cookiePopup").style.display = "none";
    });

    // proverka cookie 
    window.onload = checkCookie;