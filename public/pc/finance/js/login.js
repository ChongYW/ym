    function tipShow(){
        $(".login-error").show();
    }
    function tipHide(){
        $(".login-error").hide();
    } 
    function chekNkNamefor() {
        var tip = $("#tip");
        var nkName = document.getElementById("username").value;
        if (nkName == "" || nkName == null || nkName == "�������û���/�ֻ���") {
            tip.html("�������û���/�ֻ���");
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
            tip.html("����������");
            tipShow();
            return false;
        } else if (pwd.value.length < 6) {
            tip.html("�������");
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
            $("#loginBt").val("��¼��").addClass("disabled");
            $.post(url,{
                "username" : username,
                "password" : password,
				"dosubmit" : 1,
				"cookietime" : cookietime
                    },function(data){
                        if(data==1){
                            tip.html("�û������������������ϵ");
                            tipShow();
                        }
                        else if(data==0){
                           
                            var callbackUrl = $('input[name="forward"]').val();
                            if (callbackUrl != "null")
                                window.location.href="/MemberCenter/user-init.asp";
                            else
                                window.location.href="/MemberCenter/user-init.asp";
                        }else if(data==-1){
                            tip.html("�û���������");
                            tipShow();
                        }else if(data==-2){
                            tip.html('��������û�������������<a href="/MemberCenter/user-forgetpassword.asp">���ǵ�¼���룿</a>');
                            tipShow();
						}else if(data==-3366){
                            tip.html('��������û���������');
                            tipShow();	
						}else if(data==-3377){
                            tip.html('�û����������������');
                            tipShow();	
						}else if(data==-3388){
                            tip.html('���ύ���û����������ַ����в��Ϸ��ַ��뷵����������');
                            tipShow();		
                        }else if(data==-3){
                            tip.html('�����ʺ��ѱ�����������ϵ����ԱΪ����ͨ��');
                            tipShow();
                        }else if(data==-88){
                            tip.html('���Ѷ����������û��������룬���󳬹�4�κ��˻�����������<a href="/MemberCenter/user-forgetpassword.asp">���ǵ�¼���룿</a>');
                            tipShow();
                        }
                        if (data != 0) {
                            $(".login :input").removeAttr('disabled');
                            $("#loginBt").val("�� ¼").removeClass("disabled");
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
