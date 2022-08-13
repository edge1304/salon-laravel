// (function($) {

    // "use strict";
    $("#btn_login").on("click", async(e) => {
        const username = $("#username").val().trim()
        const password = $("#password").val().trim()

        if (username.length == 0) {
            $("#username").addClass("is-invalid")
            return
        }
        if (password.length == 0) {
            $("#password").addClass("is-invalid")
            return
        }
        callAPI('POST', `/api/login`, {
            username: username,
            password: password
        }, (data) => {
            console.log(data)
        }, (err) => {
            console.log(err)
            alert("Đăng nhập thất bại! Tên đăng nhập hoặc mật khẩu không chính xác.")
        })
    })

    $("#username").on("input", () => {
        $("#username").removeClass("is-invalid")
        $("#password").removeClass("is-invalid")
    })
    $("#password").on("input", () => {
        $("#username").removeClass("is-invalid")
        $("#password").removeClass("is-invalid")
    })


    function callAPI(method = "GET", url, data, successAjax, errorAjax) {
        var ObjectAjax = {
            type: method,
            url: url,

            data: data,
            cache: false,
            success: function(data) {

                successAjax(data)
            },
            error: function(data) {
                errorAjax(data)
            },
        }

        $.ajax(ObjectAjax)
    }



    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }


    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
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
// })(jQuery);