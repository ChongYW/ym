var flag = 0;
(function(win, undefined) {
	var $ = win.jQuery;	
	
	var cancellationId = "";
	
	//��������齱
//	$("#drawMoon").click( function(){
//		window.location = "/appV1/weiMoonLotteryNewUI";
//		return false ;
//	})
	//����Ͷ��
	
	$("#returnInvest").click( function(){
		$("#drawdiv").hide();
		return false ;
	})
	//����ر�
	$("#closeDraw").click( function(){
		/*var lay = $('.lay_cw');
		$("#title").html("Ͷ�ʳɹ�");
		$('#indiv').addClass("dn");
		$('#drawdiv').removeClass("dn");
		lay.show();
		notice(lay);
	$("#wait").addClass("dn");
	$(".appdiv").hide();
	clearInterval(internal);*/
		$("#drawdiv").hide();
		
		return false ;
	})
	$("#detail_title").click(function(){
		var h = $(this).parent().attr('hf');
		if (typeof h != 'undefined'){
			location.href = h;
		}
	});
	$("#detail_content").click(function(){
		var h = $(this).parent().attr('hf');
		if (typeof h != 'undefined'){
			location.href = h;
		}
	});
	
	$("#recharge").click( function(){
		var lackMoney = $("#lackMoney").html();
		if ( isEmpty(retQuery)){
			window.location = ""+murl+"pay-mpay.asp?rechargeMoney=" +lackMoney ;
		}else{
			window.location = ""+murl+"pay-mpay.asp?rechargeMoney=" +lackMoney+"&ret="+ retQuery ;
		}
		return false ;
	})
	var canSubmit = true;
	var internal;
	
	$('div[t="cswj"]').click(function() {
		$('div[t="cswj"]').addClass('dn');
	});

    $(".yesJoin").click(function(){
        flag=1;
        elevendayFlag=1;
        $(".elevenday").addClass("dn");
    });

    $(".noJoin").click(function(){
        flag=1;
        elevendayFlag=0;
        $(".elevenday").addClass("dn");
    });

    $(".closeBtn").click(function(){
        flag=1;
        elevendayFlag=0;
        $(".elevenday").addClass("dn");
    });
	
	$('#investBtn').click(function(){
		if(flag==0){
            if(elevenDayShow=="true"||elevenDayShow){
                $(".elevenday").removeClass("dn");
                return;
            }else{
                investMethod();
            }
		}else{
            investMethod();
		}
	});

    $("#useHuoqiInvest").click(function(){
        $("div[t=lackMoneyId2]").addClass("dn");
        $("#appdiv").addClass("dn");

        useHuoqi = true;
        checkHuoqiAmount = true;
        $("#huoqiAmount").prop('checked', true);
        investMethod();
    });

	function investMethod(){
        if(isXwMove){
            $("#xwRemoval").removeClass("dn");
            return false;
        }

        if(!canSubmit){
            return;
        }
        var la = $('#leftAmount').val();
        var ia = $('#money').val();
        var ua = $('#userAmount').val();
        var lay = $('.lay_cw');
		var ps = $('#password').val();

        var ckRisk = $(this).prop('checked');
        if (ckRisk) {
            lay.html('����ͬ��Э��');
            lay.show();
            notice(lay);
            return;
        }

        if(isEmpty(ia)){
            lay.html('������Ͷ�ʽ��');
            lay.show();
            notice(lay);
            return;
        }
		
        if (!isNumber(ia)) {
            lay.html('Ͷ�ʽ���ʽ����');
            lay.show();
            notice(lay);
            return;
        }
		if (ia < minAmount){
			lay.html(''+minAmount+'Ԫ��Ͷ');
            lay.show();
            notice(lay);
			return false;
		}
//        if (ia*1 % investUtilAmount != 0) {
//            lay.html('Ͷ�ʽ�������'+investUtilAmount+'��������');
//            lay.show();
//            notice(lay);
//			$("#money").val(investUtilAmount); 
//            return;
//          
//        }
		
		var _flag = ((ia - minAmount)%investUtilAmount);		
		if(_flag!=0){
        ia = ia - _flag;         
		lay.html('Ͷ�ʽ�������'+investUtilAmount+'��������');
		lay.show();
		notice(lay);
		$("#money").val(ia); 
		return false;
		 }
		
		
        /*if(ia*1 > ua*1){
            var lackOfmoney = ia*1 - ua*1;
            var moneyTwoPoint = Math.round(lackOfmoney*100)/100;
            $("#lackMoney").html(moneyTwoPoint);
            $("div[t=lackMoneyId]").removeClass("dn");
            $("#appdiv").removeClass("dn");
            return;
        }*/

        if(ia * 1 > totalAmount * 1){
            needCharge = true;
        }else{
            needCharge = false;
        }

        if((huoqiAmount * 1 > 0) && (ia * 1 > userInvest * 1)){
            if(ia * 1 <= totalAmount * 1){
                if(!checkHuoqiAmount){
                    var lackOfmoney = ia*1 - ua*1;
                    var moneyTwoPoint = Math.round(lackOfmoney*100)/100;
                    $("#lackMoney2").html(moneyTwoPoint);
                    $("div[t=lackMoneyId2]").removeClass("dn");
                    $("#appdiv").removeClass("dn");
                    return;
                }
            }else{
                if(checkHuoqiAmount){
                    var lackOfmoney = ia * 1 - ua * 1 - huoqiAmount * 1;
                    var moneyTwoPoint = Math.round(lackOfmoney*100)/100;
                    $("#lackMoney").html(moneyTwoPoint);
                    $("div[t=lackMoneyId]").removeClass("dn");
                    $("#appdiv").removeClass("dn");
                    return;
                }else{
                    var lackOfmoney = ia * 1 - ua * 1;
                    var moneyTwoPoint = Math.round(lackOfmoney*100)/100;
                    $("#lackMoney").html(moneyTwoPoint);
                    $("div[t=lackMoneyId]").removeClass("dn");
                    $("#appdiv").removeClass("dn");
                    return;
                }
            }
        }else{
            if(needCharge){
                var lackOfmoney = ia * 1 - ua * 1;
                var moneyTwoPoint = Math.round(lackOfmoney*100)/100;
                $("#lackMoney").html(moneyTwoPoint);
                $("div[t=lackMoneyId]").removeClass("dn");
                $("#appdiv").removeClass("dn");
                return;
            }
        }

        if(ia*1 > la*1){
            lay.html('�������ڿ�Ͷ���');
            lay.show();
            notice(lay);
            return;
        }
		
		if(isEmpty(ps)){
            lay.html('������֧�����룬Ĭ��Ϊ��¼����');
            lay.show();
            notice(lay);
            return;
        }

        if (!isExamTzfx) {
            $('div[t="cswj"]').removeClass('dn');
            return false;
        }

        canSubmit = false;

        $("#wait").removeClass("dn");
        $(".appdiv").show();
        internal = setInterval(function(){
            var time = $('#timeout').attr('t');
            time--;

            if(time < 0){
                time = 0;
            }
            $('#timeout').attr('t',time);
            //$('#timeout').html(time);
        },1000);


        $.ajax({
            type : 'POST',
            url : '/jsonpublic/invest.asp?appversion=V1',
            dataType : 'json',
            data : {
                'loanId' : $('#loanId').val(),
                'investAmount' : $('#money').val(),
				'password' : $('#password').val(),
                'source' : source ,
                'vlidate' : $('#yzm').val(),
				'hongbao' : hongbao,
                'selectInterest':selectInterest,
                'cancellationId':cancellationId,
                "elevendayFlag" :elevendayFlag,
                "useHq":useHuoqi
            },
            success : function(data){

                //������껪�
                if(myloanId!="0" && $.trim($("#joinAct").val()) == "1"){
                    //��Ͷ�ʲ���
                    $.ajax({
                        url: "/appV1/sumcarnActiveLoan",
                        data : {
                            "investRecordId" : data.investRecodeId,
                            "joinAct": $.trim($("#joinAct").val())
                        },
                        type: "POST",
                        dataType: 'json',
                        success: function(data){
                        }
                    });
                }

                canSubmit = true;
                var isMoon=false;
                var isOctober = false ;
				//if(data.ret){
                if(data==1){
                    if (document.getElementById("addPlan")){
                        var  status = $('#addPlan')[0].checked;

                        if (status) {
                            $.ajax({
                                type: "post",
                                url: "/appV1/addDevPlanApi?joinChannel=investPage",
                                dataType: 'json',
                                success: function (data) {
                                    if(data.ret==1) {
                                        $("#ok_h5").attr("style", "height:60px; line-height:30px;")
                                        $("#ok_h5").append("<br><p style='font-size: 14px;'>�ɹ�������ֵ�ƻ�!</p>");
                                    }

                                }
                            });
                        }
                    }
                    isMoon=data.isMoon;
                    isOctober = data.isOctober;
                    var isShowHongbao = false ;
                    var hbAmount = data.hongBaoAmount;
                    var userAmount=data.loanAccount;

                    if(data.umpHref != null){
                        if(depositType == 0){
                            window.location.href = data.umpHref;
//							$('#umpFormDiv').find('form').attr('action', data.umpHref );
//							var _p = [];
//							$.each(data.data,function(i,v){
//								_p.push('<input type="hidden" value="',v,'" name="',i,'">');
//							});
//							if(_p.length > 0){
//								$('#umpFormDiv').find('form').html(_p.join(''));
//							}
//							$('#umpFormDiv').find('form').submit();
                        }else if(depositType == 1){
                            $('#xwBank').attr('action', data.umpHref );
                            var _p = [];
                            $.each(data.data,function(i,v){
                                if(i == 'reqData'){
                                    $("#toXwReqData").html(v);
                                }
                                _p.push('<input type="hidden" value="'+v+'" name="'+i+'">');
                            });
                            if(_p.length > 0){
                                $('#xwBank').html(_p.join(''));
                            }
                            $("input[name='reqData']").val($("#toXwReqData").text());
                            $('#xwBank').submit();
                        }
                    }else{
                        $('#myinvest').html($('#money').val()+"Ԫ");
                        var investRecodeId = data.investRecodeId ;
						var hongbaoid=data.hongbao;
                        $.getJSON("/jsonpublic/getInterest.asp?investRecodeId="+investRecodeId+"&hongbaoid="+hongbaoid+"&loanId=" + $('#loanId').val() + "&amount=" + $('#money').val()+"&addinterest="+selectInterest+"&first="+first, function(data){
                            isShowHongbao = data.isShowHuobao ;
                            $('#hkAmount').html(data.hkAmount+"Ԫ");
                            if ( isHuoqi ){
                                $("#myinterest").html(data.di+"Ԫ");
                            }else if ( isJinzhi ){
                                $("#myinterest").html(data.it+"Ԫ");
                            }else {
                                $("#myinterest").html(data.it+"Ԫ");

                                var html = "<p class='inlvokp02 col6'>��Ϣ<span class='fama' id='rateAmount'>"+data.anIn+"</span>Ԫ";


                                if(data.totalReward!=null && data.totalReward > 0){
                                    html +="������ʹ���ֽ���<span class='fama' id='rwqAmount'>"+data.totalReward+"</span>Ԫ";
                                }

                                if(hbAmount > 0){
                                    html +="���������<span class='fama' id='hbAmount'>"+hbAmount+"</span>Ԫ";
                                }
                                html +="</p>";
                                $("#addReward").append(html);
                            }

                            if(isShowHongbao){
                                if ( wap ){
                                    $("div[t=share]").addClass("dn");
                                    $("div[t=shareHongbao]").removeClass("dn");
                                    $("#hongbaoCount").html(data.hongbaoCount);
                                    $("#shareImg").attr( "src" , "/getQRCode?u=" + data.shareHongbaoUrl )
                                }else {
                                    if ( data.isGetUrl){
                                        url = data.url ;
                                        appurl += "&hongbaoId=" +data.hongbaoId ;
                                    }
                                    share += data.hongbaoId;
                                    $("#hongbaoCount").html(data.hongbaoCount);
                                    $("#sendHongBao01").show();
                                    $("#sendHongbao").removeClass("dn");
                                    $("div[t=share]").addClass("dn");
                                    $("div[t=shareHongbao]").removeClass("dn");
                                    //weixinShare();
                                    if ( isEmpty ( app ) ){
                                        var shareData = {
                                            title: title,
                                            desc: desc,
                                            link: url,
                                            imgUrl: image,
                                            success: function (res) {
                                                $("#sendHongbao").addClass("dn");
                                                $(".hbyindao").hide();
                                                $(".tm").hide();

                                                $.ajax({
                                                    url: "/jsonpublic/shareHongbaoCallback.asp?hongbaoId="+share,//���ͺ��
                                                    type: "GET",
                                                    dataType: 'json',
                                                    success: function(d){
                                                        if(d.ret == 1){
                                                            //							     		    			var layobj = $('.lay_cw');
                                                            //									     		   		$(layobj).html(d.data);
                                                            //									     		   		$(layobj).show();
                                                            //									     		   		notice(layobj);
                                                        }
                                                    }
                                                });
                                            },
                                            cancel: function (res) {

                                            },
                                            fail: function (res) {

                                            }
                                        };
                                        wx.onMenuShareAppMessage(shareData);
                                        wx.onMenuShareTimeline(shareData);
                                    }

                                    //
                                    var ioshref = 'xycshare:///@@'+apptitle +'@@' + appurl + '@@' + image + '@@' + appdesc + '@@3' + data.hongbaoId +'@@3';
                                    $('#iosend').attr('href',ioshref);
                                    var androidShare = 'window.guesture.postShare("'+apptitle+'","'+appurl+'","'+image+'","'+appdesc+'","3'+ data.hongbaoId +'",3);return false;';
                                    $('#iosend').attr('onclick',androidShare);
                                }
                            }
                        });
                        if(!isHuoqi && !isJinzhi){

                            $.getJSON("/jsonpublic/getRapeseed.asp?amt=" + $('#money').val(), function(data){
                                if(data.ret){
                                    $('#rapeseed').html(data.c+"��");
                                }
                            });
                        }else{
                            $('#rapeseed').parent().addClass("dn");
                        }
                        $("#title").html("Ͷ�ʳɹ�");
                        $('#indiv').addClass("dn");
                        $('#okdiv').removeClass("dn");
                        $('#investBtn').removeClass("dn");

                        if( userAmount<2000 ){
                            $("#resultValue").text("ֻ��"+(2000-userAmount)+"Ԫ");
                        }else if( userAmount<5000){
                            $("#resultValue").text("ֻ��"+(5000-userAmount)+"Ԫ");
                        }else if( userAmount<10000 ){
                            $("#resultValue").text("ֻ��"+(10000-userAmount)+"Ԫ");
                        }else if( userAmount<20000){
                            $("#resultValue").text("ֻ��"+(20000-userAmount)+"Ԫ");
                        }else if( userAmount<50000 ){
                            $("#resultValue").text("ֻ��"+(50000-userAmount)+"Ԫ");
                        }else if ( userAmount < 100000 ){
                            $("#resultValue").text("ֻ��"+(100000-userAmount)+"Ԫ");
                        }
                        //$("#resultValue").text("ֻ��"+userAmount+"Ԫ");
                        if(isMoon || isOctober ){
                            $('#okdiv').show();
                            $('#drawdiv').removeClass("dn");
                        }else{
                            $('#okdiv').show();
                        }

						/*if(userAmount==5000 ||userAmount==10000||userAmount==20000||userAmount==50000||userAmount==100000){

						 }*/
                        //$('#drawdiv').removeClass("dn");
                    }

                    //alert("����");
					//}else{
						// lay.html(data.errmsg);
                   // lay.show();
                   // notice(lay);
				   //}
                   }
				    else if(data==-4){					
					lay.html('֧���������');
                    lay.show();
                    notice(lay);                   
                    }
					else if(data==-2){					
					lay.html('����Ƿ�����');
                    lay.show();
                    notice(lay);                   
                    }
					else if(data==-3){					
					lay.html('������֧������');
                    lay.show();
                    notice(lay);                   
                    }
					else if(data==-5){					
					lay.html('���������Ա���Ͷ�ʣ�<a href="'+murl+'pay-mpay.asp" target="_blank">������ֵ</a>');
                    lay.show();
                    notice(lay);                   
                    }
					else if(data==-6){					
					lay.html('Ͷ��������');
                    lay.show();
                    notice(lay);                   
                    }
					else if(data==-7){					
					lay.html('������Ͷ��'+leftAmount+'Ԫ');
                    lay.show();
                    notice(lay);                   
                    }
					else if(data==-8){					
					lay.html('����С����Ͷ���');
                    lay.show();
                    notice(lay);                   
                    }
					else if(data==-9){					
					lay.html('����Ŀ��Ͷһ��');
                    lay.show();
                    notice(lay);                   
                    }
					else if(data==-10){					
					lay.html('������Ƶȼ����ͣ�������ѯ�ͷ�');
                    lay.show();
                    notice(lay);                   
                    }
					else if(data==-88){					
					lay.html('�޷�ִ�����ֺ�Ͷ�ʲ�����'+useraccount+'');
                    lay.show();
                    notice(lay);                   
                    }
					else if(data==-99){					
					lay.html('δ������������������ѡ��');
                    lay.show();
                    notice(lay);                   
                    }				
					else if(data==-1){					
					lay.html('����δ����ʵ����֤,<a href="'+murl+'user-safety.asp" target="_blank"><font color=#ff0000>������֤</font></a>');
					//lay.html('����δ����ʵ����֤,���Ƚ����Ա��ʵ����֤��');
                    lay.show();
                    notice(lay);                   
                    }			

                $("#wait").addClass("dn");
                $(".appdiv").hide();
                clearInterval(internal);

                //$('#drawdiv').removeClass("dn");
				/*alert(userAmount);
				 if(userAmount>=5000){
				 window.location = "/appV1/weiMoonLotteryNewUI";  //weiLotteryNewUI
				 }*/
            }
        });

		/*	//��ѯ�û��ۼ�Ͷ�ʼ�¼
		 $.ajax({
		 type : 'get',
		 url : '/appV1/getUserLoanAccount?loanId='+$('#loanId').val()+"$userId="+$('#userId').val(),
		 dataType : 'json',
		 success : function(data){
		 alert();
		 }
		 });*/
	}


	$('.lclose').click(function(){
		$("#wait").addClass("dn");
		$(".appdiv").hide();
		clearInterval(internal);
	});

	$('.aicd').click(function(){
		var d = new Date();
		$('.sicd').find('img').attr('src','/smsVerfyCode?a=' + d.getTime());
	});
	$('.sicd').click(function(){
		$('.aicd').trigger('click');
	});

	var focustime = 0;
	$('#money').focus(function(){
		focustime = new Date().getTime();
	});

//	$('#money').keypress(function(e){
//
//		 var code = (e.keyCode ? e.keyCode : e.which);
//         if( (code >= 48 && code<= 57) || (code == 8)){
//             return true;
//         }
//         return false;
//	});

	 /*$('#money').keyup(function(e){
	        var code = (e.keyCode ? e.keyCode : e.which);
	        if( (code >= 48 && code<= 57) || (code == 8)){
                var money = $("#money").val();
                var count = 0;
                $("#addtion a").each(function(){
                    if (typeof($(this).attr("filter"))!="undefined") {
                        var mon = $(this).attr("filter");
                        if ( parseInt(mon) > parseInt(money) ) {
                            $(this).removeClass("quanhov");
                            $(this).addClass("quan_no");
                            $(this).children("img:last").attr("src","/jsonpublic/source/images/appnew/img/quan_c.png");
                            count++;
                        } else {
                            $(this).children("img:last").attr("src","/jsonpublic/source/images/appnew/img/quan_b.png");
                            $(this).removeClass("quan_no");
                        }
                    }
                });
                $(".extratitle").html("����<span class='cl08'>"+(parseInt(tickCount)-parseInt(count))+"</span>�ż�Ϣ��");
	            return true;
	        }
	        return false;
	   });*/
    $('#money').bind('input propertychange', function(e) {
        var money = $("#money").val();
        var count = 0;
        $("#addtion a").each(function(){
            if (typeof($(this).attr("filter"))!="undefined") {
                var mon = $(this).attr("filter");
                if ( parseInt(mon) > parseInt(money) ) {
                    $(this).removeClass("quanhov");
                    $(this).addClass("quan_no");
                    $(this).children("img:last").attr("src","/jsonpublic/source/images/appnew/img/quan_c.png");
                    count++;
                } else {
                    $(this).children("img:last").attr("src","/jsonpublic/source/images/appnew/img/quan_b.png");
                    $(this).removeClass("quan_no");
                }
            }
        });
        $(".extratitle").html("����<span class='cl08'>"+(parseInt(tickCount)-parseInt(count))+"</span>�ż�Ϣ��");
        return true;
    });

	var showQuanDiv = function(){
		if(!isHuoqi && !isJinzhi){
			$("#showQuan").removeClass("dn");
			if(ishasAddition){
				$("#showAddition").html("<span class='coly'>"+userAdditionList+"��</span>��Ϣȯ����");
			}else{
				$("#showAddition").html("�޼�Ϣȯ����");
				if ( canExchange ){
					$("#canExchange").removeClass("dn");
					$("#showQuan").addClass("dn");
				}
			}
		}
	};

	 $("#selectMoney").delegate("a[m]","click",function(){

		  var la = $('#leftAmount').val();
		  var ua = $('#userAmount').val();
		  var lay = $('.lay_cw');

		  var t = $(this).attr('m');

		  $('a[m]').each(function(i,v){
				$(this).parent().removeClass('hov');
		  });
		  $(this).parent().addClass('hov');

		  if(t == '0'){
			  $('#money').val($(this).attr('u'));
		  }else{
			  $('#money').val(t+"000");
		  }

		  $('#money').removeClass('pla');
		  var ia = $('#money').val();
		  if(ia*1 < 100 || ia*1 > ua*1){
				lay.html('����');
				lay.show();
				$('#money').val('');
				notice(lay);
				return;
		  }

		  if(ua*1 > la*1 && t== '0'){
			    var ll = parseInt(la/100);
				$('#money').val(ll*100);
		  }

		  $('#money').trigger('keyup');

	 });


	 function getAddtion(){

		  if(isHuoqi || isJinzhi ){
			  return;
		  }
		  $("#addtionQuan").addClass("dn");
		  $('#quan').addClass("dn");
		  $("#addtion").html('');
		  //$('#addtionNum').html('')
		 // selectInterest = "";

		  if(!isHuoqi){
			  $.ajax({
					url: "/jsonpublic/selectAddtion.asp",
					type: "POST",
					data : {
						loanId : loanId,
						invest : $('#money').val() ,
						source : source ,
						selectInterest : selectInterest
					},
					dataType: "json",
					success: function(data){
						var jxq = false ;
						if(data.ret){
							jxq = data.data.length ;
							$("#ticket_count").html(data.ticketCount+"��");
							tickCount = data.ticketCount;
                            $(".extratitle").html("����<span class='cl08'>"+tickCount+"</span>�ż�Ϣ��");
							$("#addtion").html("");
							if(data.ticketCount > 0){
								h = [];
								var raiseData = [];

								var duanwuRaiseData = [];

								$.each(data.data,function(i,v){
									var rateNotify = [];

									if(!!v.isRaise && v.isRaise == 1 && (selectInterest == null || selectInterest == "")){
										raiseData = v;
									}

									if(!!v.isDuanwuRaise && v.isDuanwuRaise == 1 && (selectInterest == null || selectInterest == "")){
										duanwuRaiseData = v;
									}

									if(!!v.ExceedMaxRate && v.ExceedMaxRate == 1){
										 var raiseRate = (2 - Number(v.rate)) > 0 ? "2" : v.rate;
										 rateNotify = "���ˣ���Ϣ��Ȩ�ѳ���ʹ�����ޣ����ѳɹ���Ϣ" + raiseRate + "%Ӵ��";
									 }else if(!!v.ExceedMaxRate && v.ExceedMaxRate == 2){
										 var raiseRate = (2 - Number(v.rate)) > 0 ? "2" : v.rate;
										 rateNotify = "���ˣ���Ϣ��Ȩ�ѳ���ʹ�����ޣ����ѳɹ���Ϣ" + raiseRate + "%Ӵ�� ";
									 }else{
										 rateNotify = "2";
									 }

									var loseReward = "";
									if(!!v.encryptActivityId && !!v.loseRewardId){
										loseReward = ' encr="' + v.encryptActivityId + '" ' + ' lose="' + v.loseRewardId + '" '
									}

									/*h.push("<div class='choexpbox' t='" + v.id+"'  v='" +  v.rate+"%��Ϣȯ-" +v.additionNum +"' rn=' " + rateNotify + "' " + loseReward + " >");
									if(selectInterest == v.id){
										h.push("<span class='choice' tar='0'><img src='/jsonpublic/source/images/appnew/icon/xz_i.png' /></span>");
										h.push("<span class='choice dn' tar='1'><img src='/jsonpublic/source/images/appnew/icon/wd_i.png' /></span>");
									}else{
										h.push("<span class='choice dn' tar='0'><img src='/jsonpublic/source/images/appnew/icon/xz_i.png' /></span>");
										h.push("<span class='choice ' tar='1'><img src='/jsonpublic/source/images/appnew/icon/wd_i.png' /></span>");
									}

									h.push("<div class='chofl colf'><h3 class='fama'><small>+</small>"+v.rate+"%</h3>");
									if(v.ltString != null){
										h.push("<p class=''>"+v.ltString+"</p>");
									}
									h.push("</div>");
									h.push("<div class='chofr colf'><p>"+v.additionNum+"</p></div>");
									h.push(" </div>");*/
                                    h.push("<a class='chosebox' filter='"+v.filterMoney+"' t='" + v.id+"'  v='" +  v.rate+"%��Ϣȯ-" +v.additionNum +"' rn=' " + rateNotify + "' " + loseReward + " >");
                                    h.push("<img class='oki' src='/jsonpublic/source/images/appnew/img/oki.png'/>");
                                    h.push("<div class='ttqu'><span class='add'>+</span>"+v.rate+"<span class='bf'>%</span></div>");
                                    if(v.ltString != null){
                                        h.push("<div class='ttqu_a'>"+v.ltString+"</div>");
                                    }
                                    h.push("<div class='ttqu_b'>"+v.additionNum+"</div>");
                                    h.push("<img src='/jsonpublic/source/images/appnew/img/quan_b.png' alt=''></a>");
								});
								$("#addtion").append(h.join(""));
								$("#quan").removeClass("dn");
								$("#showQuan").addClass("dn");
								//$('#addtionNum').html('��ѡ���Ϣȯ');
								$("#showAddition").html("��Ϣȯ");
								$('#jxq_titzs').removeClass('dn');
								if ( tickCount > 0 ) {
                                    $(".additiondata").removeClass("dn");
                                }
								if(!!raiseData && raiseData.isRaise == 1){

									 if(!!raiseData.ExceedMaxRate && raiseData.ExceedMaxRate == 1){
										 $("#rateNotify").html("���ˣ���Ϣ�����˲˵�������Χ�����ѳɹ���Ϣ2%Ӵ��");
										 $("#rateNotify").removeClass("dn");
									 }else if(!!raiseData.ExceedMaxRate && raiseData.ExceedMaxRate == 2){
										 $("#rateNotify").html("���ˣ���Ϣ�����˲˵�������Χ�����ѳɹ���Ϣ2%Ӵ��");
										 $("#rateNotify").removeClass("dn");
									 }

									 selectInterest = raiseData.id;
									 //$('#addtionNum').html(raiseData.rate+"%��Ϣȯ-" +raiseData.additionNum);
									 $('#ticket_count').addClass("dn");
								}

								if(!!duanwuRaiseData && duanwuRaiseData.isDuanwuRaise == 1){

									 if(!!duanwuRaiseData.ExceedMaxRate && duanwuRaiseData.ExceedMaxRate == 1){
										 $("#rateNotify").html("���ˣ���Ϣ�����˲˵�������Χ�����ѳɹ���Ϣ2%Ӵ��");
										 $("#rateNotify").removeClass("dn");
									 }else if(!!duanwuRaiseData.ExceedMaxRate && duanwuRaiseData.ExceedMaxRate == 2){
										 $("#rateNotify").html("���ˣ���Ϣ�����˲˵�������Χ�����ѳɹ���Ϣ2%Ӵ��");
										 $("#rateNotify").removeClass("dn");
									 }

									 selectInterest = duanwuRaiseData.id;
									 //$('#addtionNum').html(duanwuRaiseData.rate+"%��Ϣȯ-" +duanwuRaiseData.additionNum);
									 $('#ticket_count').addClass("dn");
								}

								if(useRdId > 0){
									 selectInterest = useRdId;
									 var jxq = $(".chosebox[t='" + selectInterest + "']");
									 if(jxq.attr("rn") != "1" && jxq.attr("rn") != 1){
										 $("#rateNotify").html(jxq.attr("rn"));
										 $("#rateNotify").removeClass("dn");
									 }

									 var ia = $("#money").val();
									 $.ajax({
											url: "/jsonpublic/getInterest.asp",
											type: "POST",
											data : {
												loanId : loanId,
												amount : ia,
												addinterest : selectInterest
											},
											dataType: "json",
											success: function(data){
												if(data.ret){
													if(data.rewardAmount>0){
														$("#itAmount").html(data.itAmount+"<span class='hbcss fama'>+ "+data.rewardAmount+" Ԫ�ֽ���<span>");
								              		}else{
								              			$("#itAmount").html(data.itAmount);
								              		}
												}else{

												}

											}
										});

									 //$('#addtionNum').html(jxq.attr("v"));
									 $('#ticket_count').addClass("dn");
								}

							}else{
                                $(".additiondata").addClass("dn");
								$("#quan").addClass("dn");
								$("#showQuan").removeClass("dn");
								if(ishasAddition){
									if(data.ticketCount == 0){
										$("#showAddition").html("<span class='coly'>"+data.ticketCount+"��</span>��Ϣȯ����");
									}else{
										$("#showAddition").html("<span class='coly'>"+userAdditionList+"��</span>��Ϣȯ����");
									}
								}else{
									$("#showAddition").html("�޼�Ϣȯ����");
									if ( canExchange ){
										$("#showQuan").addClass("dn");
										$("#canExchange").removeClass("dn");
									}
								}
							}
						}else{

						}

						var hasSelectInterest = data.hasSelectInterest ; //���ڼ�Ϣȯ
						if ( hasSelectInterest ){
							var selectInterestVal = data.selectInterest ;
							var hasUseInterest = data.hasUseInterest ;
							if ( hasUseInterest ){
								$("#addtion").find("a[t="+selectInterest+"]").trigger("click");
							}else {
								var layobj = $('.lay_cw');
								var desc = "��Ǹ����ǰ��Ϣȯ����ʹ��";
								if ( jxq ) {
									desc = desc + ",������ѡ���Ϣȯ";
								}
			     		   		$(layobj).html( desc );
			     		   		selectInterest = "" ;
			     		   		$(layobj).show();
			     		   		notice(layobj);
							}
						}
					}
				});
		  }
	 }
	 


	 $("#quan").delegate("li","click",function(){
		 $("#indiv").addClass("dn");
		 $("#addtionQuan").removeClass("dn");
		 $(".xycnav").addClass("dn");
	 });

	 $("#showQuan").delegate("li","click",function(){
		 var ia = $('#money').val();
		 if(ishasAddition && isEmpty(ia)){
			    var layobj = $('.lay_cw');
		   		$(layobj).html( "��������Ͷ�ʽ��" );
		   		$(layobj).show();
		   		notice(layobj);
		   		return;
		 }
	 });

	 $('#money').focus(function(){
		  $('#money').removeClass('pla');
	 });

	 $('#money').blur(function(){
		 if($(this).val() == ''){
		  $('#money').addClass('pla');
		 }
	 });


	$('#signup').click(function(){
		$('#hnoSecretFrom').submit();
	});


    $("body").delegate("a[t=sendHongBao]","click",function(){
		//	$("#sendHongbao").addClass("dn");
			if ( isEmpty(app) ) {
				$(".hbyindao").show();
				$(".tm").show();
			}else{
		 		window.appShared(image,title,url);
			}
	})

	$("#close").click(function(){
		$(".hbyindao").hide();
		$(".tm").hide();
	});

    $("#hbClose").click(function(){
  	  $("#sendHongbao").addClass("dn");
    });

    $("#appsend").delegate('a[id]','click',function(){
   	$("#sendHongbao").addClass("dn");
		window.appShared(image,title,url);

	});


    $("#jjsCheckbox").click(function(){
		if($("#jjsCheckbox").is(":checked")){
			$("#invest").removeClass("dn");
			$("#unInvest").addClass("dn");
		}else{
			$("#invest").addClass("dn");
			$("#unInvest").removeClass("dn");
		}
	});
    $("#njsCheckbox").click(function(){
        if($("#jjsCheckbox").is(":checked")){
            $("#invest").removeClass("dn");
            $("#unInvest").addClass("dn");
        }else{
            $("#invest").addClass("dn");
            $("#unInvest").removeClass("dn");
        }
    });

    $("#sunshineInsurance").click(function(){
		if($("#sunshineInsurance").is(":checked")){
			$("#invest").removeClass("dn");
			$("#unInvest").addClass("dn");
		}else{
			$("#invest").addClass("dn");
			$("#unInvest").removeClass("dn");
		}
	});

    $("a[sunshineInsurance]").click( function(){
    	$("#ygbxContent").removeClass("dn");
    	$("#appdiv").show();
    	return false ;
    });

    $("#closeYgbx").click( function(){
    	$("#ygbxContent").addClass("dn");
    	$("#appdiv").hide();
    	return false ;
    });

    $("a[jjsSms]").click( function(){
    	$("#jjsLoanExplainContent").removeClass("dn");
    	$("#appdiv").show();
    	return false ;
    });

    $("#closeJjsLoanExplain").click( function(){
    	$("#jjsLoanExplainContent").addClass("dn");
    	$("#appdiv").hide();
    	return false ;
    })

     $("a[jjsxy]").click( function(){
    	$("#jjsLoanAgreementContent").removeClass("dn");
    	$("#appdiv").show();
    	return false ;
    });

    $("#closejjsLoanAgreement").click( function(){
    	$("#jjsLoanAgreementContent").addClass("dn");
    	$("#appdiv").hide();
    	return false ;
    })

    $("#zzId,#cloId").click(function(){
    	$("div[t=lackMoneyId]").addClass("dn");
		$("#appdiv").addClass("dn");
    });

    $("#addtion").delegate(".chosebox","click",function(){
        var ia = $('#money').val();
        if(ishasAddition && isEmpty(ia)){
            var layobj = $('.lay_cw');
            $(layobj).html( "��������Ͷ�ʽ��" );
            $(layobj).show();
            notice(layobj);
            return;
        }

    	 cancellationId = "";
		 var ifSelect = true;
		 if($(this).hasClass("quanhov")){
			 ifSelect = false;
		 }
		 /*$("span[tar=0]").addClass("dn");
		 $("span[tar=1]").removeClass("dn");*/

		 if(ifSelect){
             if(!$(this).hasClass("quan_no")){
                 $("#addtion a").each(function(){
                     if($(this).hasClass("quanhov")){
                         $(this).children("img:last").attr("src","/jsonpublic/source/images/appnew/img/quan_b.png");

                         $(this).removeClass("quanhov");
                     }
                 });

                 var t = $(this).attr('t');
                 selectInterest = t;

                 $(this).children("img:last").attr("src","/jsonpublic/source/images/appnew/img/quan_a.png");

                 $(this).addClass("quanhov");
                 var ia = $("#money").val();
                 $.ajax({
                     url: "/jsonpublic/getInterest.asp",
                     type: "POST",
                     data : {
                         loanId : loanId,
                         amount : ia,
                         addinterest : selectInterest
                     },
                     dataType: "json",
                     success: function(data){
                         if(data.ret){
                             if(data.rewardAmount>0){
                                 $("#itAmount").html(data.itAmount+"<span class='hbcss fama'>+"+data.rewardAmount+"Ԫ�ֽ���<span>");
                                 rewardMoney = data.rewardAmount;
                             }else{
                                 $("#itAmount").html(data.itAmount);
                             }
                             var rateDesc = [];
                             if(!!data.ExceedMaxRate && data.ExceedMaxRate == 2){
                            	 rateDesc = "����Ϣ����2%";
                             }else{
                            	 rateDesc = "";
                             }
                             $(".extratitle").html("ʹ�ô�ȯ����׬ȡ<span class='cl08 extramoney'>"+data.addIn+"Ԫ"+rateDesc+"</span>");
                             addMoney = data.addIn;
                             totalMoney = data.itAmount;
                         }else{

                         }

                     }
                 });
             }
		 }else{
             selectInterest = "";
             var failCount = 0;
             $("#addtion a").each(function(){
                 if ($(this).hasClass("quan_no")) {
                     failCount++;
                 }
             });
             $(".extratitle").html("����<span class='cl08'>"+(tickCount-parseInt(failCount))+"</span>�ż�Ϣ��");
             $(this).children("img:last").attr("src","/jsonpublic/source/images/appnew/img/quan_b.png");
			 $(this).removeClass("quanhov");
			 var money = parseFloat(totalMoney)-parseFloat(addMoney);
			 if ( rewardMoney > 0 ) {
                 $("#itAmount").html(money.toFixed(2)+"<span class='hbcss fama'>+"+rewardMoney+"Ԫ�ֽ���<span>");
             } else {
                 $("#itAmount").html(money.toFixed(2));
             }
		 }

		 $("#loseefficacyjxq").addClass("dn");
		 $(this).parent().find("div[yzf]").remove();
		 var lose = $(this).attr("lose");
		 var encr = $(this).attr("encr");
		 if(!!lose && !!encr && !ifSelect){
			 $(this).parent().find("div[t='" + lose + "']").append('<div yzf="1">' +
																		'<div class="choexp_zz"></div>' +
																		'<div class="choexp_yzf">����</div>' +
																	'</div>');
			 var content = $(this).parent().find("div[t='" + lose + "']").attr("v");
			 content = content.substring(0, content.indexOf("--"));
			 $("#loseefficacyjxq").html("�ɹ�Ͷ��� " + content + "������").removeClass("dn");
		 }

	 });

      $("#selectId").click(function(){
    	cancellationId = "";
		//�ж�����ѡ��һ��
		var i=0;
		$('span[tar=0]').each(function(){
			 if(!$(this).hasClass("dn")){
					i = i+1;
				 }
		});

		if(i>1){
			var layobj = $('.lay_cw');
			$(layobj).html("��Ϣȯ���ɶ�ѡ");
			$(layobj).show();
			notice(layobj);
			return false;
		}

		$('span[tar=0]').each(function(){
			 if(!$(this).hasClass("dn")){
				 var t = $(this).parent().attr('t');
				 var v = $(this).parent().attr('v');
				 var rn = $(this).parent().attr('rn');
				 $("#rateNotify").addClass("dn");
				 if(parseInt(t) > 0){
					 selectInterest = t;
					 //$('#addtionNum').html(v);
					 $('#ticket_count').addClass("dn");
					 var lose = $(this).parent().attr("lose");
					 var encr = $(this).parent().attr("encr");
					 if(!!lose && !!encr){
						 cancellationId = encr;
					 }
				 }else{
					 selectInterest = "";
					 //$('#addtionNum').html('��ѡ���Ϣȯ');
					 $('#ticket_count').removeClass("dn");
				 }

				 if(!!rn && 1 != Number(rn) ){
					 $("#rateNotify").html(rn);
					 $("#rateNotify").removeClass("dn");
				 }

				 $("#indiv").removeClass("dn");
				 $("#addtionQuan").addClass("dn");
				 $(".xycnav").removeClass("dn");
				 }
		});

		 /*if(i<=0){
				selectInterest = "";

				 $("#quan").removeClass("dn");
				 $("#showQuan").addClass("dn");
				 $("#addtionNum").html('<span class="coly" id="ticket_count">'+tickCount+'��</span>��Ϣȯ����</small>');

				 $("#indiv").removeClass("dn");
				 $("#addtionQuan").addClass("dn");
				 $(".xycnav").removeClass("dn");
			}*/

		 var ia = $("#money").val();
		 $.ajax({
				url: "/jsonpublic/getInterest.asp",
				type: "POST",
				data : {
					loanId : loanId,
					amount : ia,
					addinterest : selectInterest
				},
				dataType: "json",
				success: function(data){
					if(data.ret){
						if(data.rewardAmount>0){
							$("#itAmount").html(data.itAmount+"<input type='hidden' id='hongbao' value='"+data.hongbao+"' /><span class='hbcss fama'>+"+data.rewardAmount+"Ԫ���<span>");
	              		}else{
	              			$("#itAmount").html(data.itAmount);
	              		}
                        $(".extratitle").html("ʹ�ô�ȯ����׬ȡ<span class='cl08 extramoney'>"+data.addIn+"Ԫ</span>");
					}else{

					}

				}
			});

	});

      $('#ckRisk').click(function() {
    	 var ckRisk = $(this).prop('checked');
    	 if (ckRisk) {
    		 $('#invest').removeClass('dn');
    		 $('#unInvest').addClass('dn');
    	 } else {
    		 $('#unInvest').removeClass('dn');
    		 $('#invest').addClass('dn');
    	 }
      });
	  


      $("#noSelectId").click(function(){
    	  $("#indiv").removeClass("dn");
		  $("#addtionQuan").addClass("dn");
		  $(".xycnav").removeClass("dn");
      });

      var ifGetDataByAmount ="";
      var investTask = setInterval(function(){
        var d =new Date().getTime();
        if(d-focustime < 50){
            return;
        }
        var la = $('#leftAmount').val();
  		var ia = $('#money').val();
  		var ua = $('#userAmount').val();
        if(ia==null || ia == ifGetDataByAmount){
			return ;
	    }

  		$("#preview").hide();
  		$("#itAmount").html("");

  		ifGetDataByAmount = ia;
  		if(isEmpty(ia)){
  			$('#splitDiv').hide();
  			$("#quan").addClass("dn");
  			showQuanDiv();
  			return;
  		}
  		if (!isNumber(ia)) {
  			$('#splitDiv').hide();
  			$("#quan").addClass("dn");
  			showQuanDiv();
  			return;
  		}
  		if (ia*1 % 100 != 0) {
  			$('#splitDiv').hide();
  			$("#quan").addClass("dn");
  			showQuanDiv();
  			return;
  		}

  		var ia = $("#money").val();

  		$.ajax({
  			url: "/jsonpublic/getInterest.asp",
  			type: "POST",
  			data : {
  				loanId : loanId,
				amount : ia,
				addinterest : selectInterest
  			},
  			dataType: "json",
  			success: function(data){
  				if(data.ret){
                		if(data.rewardAmount>0){
                			$("#itAmount").html(data.itAmount+"<span class='hbcss fama'>+ "+data.rewardAmount+" Ԫ�ֽ���<span>");
                		}else{
                			$("#itAmount").html(data.itAmount);
                		}
  				}else{
  					$('#splitDiv').hide();
  					$("#quan").addClass("dn");
  					$("#showQuan").removeClass("dn");
  					if(ishasAddition){
  						$("#showAddition").html("<span class='coly'>"+userAdditionList+"��</span>��Ϣȯ����");
  					}else{
  						$("#showAddition").html("�޼�Ϣȯ����");
  					}
  				}
  				
  			}
  		});
  		//getAddtion();
  	},1000);
      
    $("#noDeposit").click(function(){
    	if(isXwMove){
    		$("#xwRemoval").removeClass("dn");
			return false;
    	}
    });
      
    $("[close='1']").click(function(){
  		$("#xwRemoval").addClass("dn");
  		return false;
  	})

    getAddtion();

})(window);