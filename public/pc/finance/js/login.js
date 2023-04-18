    function tipShow(){
        $(".login-error").show();
    }
    function tipHide(){
        $(".login-error").hide();
    } 
    function chekNkNamefor() {
        var tip = $("#tip");
        var nkName = document.getElementById("username").value;
        if (nkName == "" || nkName == null || nkName == "请输入用户名/手机号") {
            tip.html("请输入用户名/手机号");
            tipShow();
            return false;
        } else{
            tipHide();
            return true;
        }
    }
    function chekPwdfor_login() {
        var tip = $("#tip");
		$("#tpsmm").hide();
        var pwd = document.getElementById("password");
        if (pwd == null || pwd.value == "") {
            tip.html("请输入密码");
            tipShow();
            return false;
        } else if (pwd.value.length < 6) {
            tip.html("密码过短");
            tipShow();
            return false;
        } else {
            tipHide();
        }
        return true;
    }
    function loginSubmit(){
        var tip = $("#tip");
        if(!chekNkNamefor()){
            return;
        }else if(!chekPwdfor_login()){
            return;
        }else{
            var cookietime = 0;
            if(document.getElementById("cookietime").checked){
                cookietime = 2592000;
            }
            var url = "/MemberCenter/login_do.asp";
            var username = $("#username").val();
            var password = $("#password").val();
            $(".login :input").attr("disabled", true);
            $("#loginBt").val("登录中").addClass("disabled");
            $.post(url,{
                "username" : username,
                "password" : password,
				"dosubmit" : 1,
				"cookietime" : cookietime
                    },function(data){
                        if(data==1){
                            tip.html("用户被锁定，请与管理联系");
                            tipShow();
                        }
                        else if(data==0){
                           
                            var callbackUrl = $('input[name="forward"]').val();
                            if (callbackUrl != "null")
                                window.location.href="/MemberCenter/user-init.asp";
                            else
                                window.location.href="/MemberCenter/user-init.asp";
                        }else if(data==-1){
                            tip.html("用户名不存在");
                            tipShow();
                        }else if(data==-2){
                            tip.html('您输入的用户名或密码有误，<a href="/MemberCenter/user-forgetpassword.asp">忘记登录密码？</a>');
                            tipShow();
						}else if(data==-3366){
                            tip.html('请输入的用户名或密码');
                            tipShow();	
						}else if(data==-3377){
                            tip.html('用户名必须由数字组成');
                            tipShow();	
						}else if(data==-3388){
                            tip.html('您提交的用户名或密码字符含有不合法字符请返回重新输入');
                            tipShow();		
                        }else if(data==-3){
                            tip.html('您的帐号已被锁定，请联系管理员为您开通！');
                            tipShow();
                        }else if(data==-88){
                            tip.html('您已多次输入错误用户名或密码，错误超过4次后账户将被锁定，<a href="/MemberCenter/user-forgetpassword.asp">忘记登录密码？</a>');
                            tipShow();
                        }
                        if (data != 0) {
                            $(".login :input").removeAttr('disabled');
                            $("#loginBt").val("登 录").removeClass("disabled");
                        }  
                    },"text"
            );
        }
    }
    if (document.addEventListener) { 
        document.addEventListener("keypress", fireFoxHandler, true);
    } else {
        document.attachEvent("onkeypress", ieHandler);
    }
    function fireFoxHandler(evt) { 
        if (evt.keyCode == 13) {
            loginSubmit()
        }
    }
    function ieHandler(evt) {
        if (evt.keyCode == 13) {
            loginSubmit()
        }
    }
