$(document).ready(function(){

    $("#loginButton").on('click',function () {
        $(this).button('loading')
        var form = $("form#loginForm");
        var username = form.find("input#username").val();
        var password = form.find("input#password").val();

        if (username == "" || password == "") {
            $(this).button('reset')
            alert('Please enter User and Password');
            return false;
        };

        $.post(
            "http://120.24.83.112/cms/api/login",
            {
                user:username,
                pwd:password
            },
            function(data){
                data = jQuery.parseJSON(data);
                if (data.error == 0) {
                    $("#loginButton").css("btn btn-success index-btn");
                    $("#loginButton").button('success');
                    window.location.href='http://120.24.83.112/cms/board/index';
                }
                else {
                    $("#loginButton").button('reset');
                    alert(data.errmsg);
                }
            });
        return true;
    })

    $("#Login").find("button.close").on('click', function () {
        $("#Login").find("input").val("");//重置输入框
        $("#loginButton").button('reset');//重置登录按钮
    });






});

