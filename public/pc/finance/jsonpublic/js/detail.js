(function(win, undefined) {
	var $ = win.jQuery;
	var top = 0;
	var nowRate = 0;
	
	$("#jjsInvest").click( function(){
		var ck = $(this).is(':checked');
		if( ck == true ){
			$("#tou").css("display","");
			$("#untou").css("display","none");
		}else{
			$("#tou").css("display","none");
			$("#untou").css("display","");
		}
	})
	
	$("span[tar=jjsRisk]").mouseover( function(){
		$(this).parent().find("div[tar=jjsRiskDesc]").removeClass("dn");
	})
	
	$("span[tar=jjsRisk]").mouseout( function(){
		$(this).parent().find("div[tar=jjsRiskDesc]").addClass("dn");
	})
	
	 if($("[isrp='rp']").length > 0){
		var temp = $("[isrp='rp']").html();
		temp = temp.replace(/[^0-9.]/g,"");
		nowRate = Number(temp);
	 }
	$.fn.flt = function() {
	    var position = function(element) {
	    	top = element.offset().top, pos = element.css('position');
	    	
	        var height = element.height();
	        var width = element.width();
	        $(window).scroll(function() {
	            var scrolls = $(this).scrollTop();
	            if (scrolls > top) {
	                if (window.XMLHttpRequest) {
	                    element.css({
	                        position: "fixed",
	                        top: 0,
	                        left:0
	                    });   
	                   // element.width(width);
	                    $('#folatempty').css('height',height);
	                } else {
	                    element.css({
	                    	position: "absolute",
	                        top: scrolls - top + 8
	                    }); 
	                }
	                $(element).addClass('tabfl');
	                var tdiv = finddiv(scrolls);
	                if(tdiv != null){
	                	changediv(tdiv);
	                }
	            }else {
	            	element.css({
 	                    position: "static",
 	                    top: 0
 	                }); 
	            	 $('#folatempty').css('height',0);
	            	 $(element).removeClass('tabfl');
	            }
	        });
	    };
	    return $(this).each(function() {
	        position($(this));                         
	    });
	};
	
	$('.pptab li').click(function(){
		var v = $(this).attr('v');
		if(v == '-1')
			return;
		$('.pptab li').removeClass('hov');
		$(this).addClass('hov');
		
		if($('.pptab').offset().top > $(window).scrollTop() && v == '10')
			return;
		
		var divObj = $('#tabcontent').find('div[v="' + v + '"]');
		$(window).scrollTop($(divObj).offset().top);	
		return false;
	});
	
	var changediv = function(div){
		if($(document).scrollTop() >= $(document).height() - $(window).height()){
			return;
		}
		var v = $(div).attr('v');
		$('.pptab li').removeClass('hov');
		$('.pptab li[v="' + v + '"]').addClass('hov');
	};
	
	var finddiv = function(scrolls){
		var divs = $('#tabcontent div[v]');
		var len = divs.length;
		for(var i=0; i<len; i++){
			if(i == len -1){
				if(scrolls > $(divs[i]).offset().top){
					return divs[i];
				}
			}else{
				if(scrolls >= $(divs[i]).offset().top && scrolls < $(divs[i+1]).offset().top){
					return divs[i];
				}
			}
		}
		
		return null;
	};
	var tpon = false;
	$('#tips').mouseover(function(){
		$(this).addClass('hov');
		$(this).addClass('ih');
		$(this).find('.jtxt').show();
		tpon = true;
	});
	
	$('#tips').mouseout(function(){
		$(this).removeClass('hov');
		$(this).removeClass('ih');
		var obj = this;
		tpon = false;
		setTimeout(function(){
			if (!tpon) {
				$(obj).find('.jtxt').hide();
			}
		},200);
	});
	
	$('div[t=jlin]').mouseover(function(){
		$(this).find('.jtxt').show();
	});
	
	$('div[t=jlin]').mouseout(function(){
		$(this).find('.jtxt').hide();
	});
	
	$("#myinvest").focus(function(){
		$(this).removeClass("ft");
		var ph = $(this).attr("ph");
		var v = $(this).val();
		if (v == ph) {
			$(this).val("");
		}
	});
	
	$("#myinvest").blur(function(){
		var v = $(this).val();
		var ph = $(this).attr("ph");
		if (v == "") {
			$(this).val(ph);

			$(this).addClass("ft");
		}
	});
	
	$('div[t="cswj"]').click(function() {
		$('div[t="cswj"]').addClass('dn');
	});

    $(".yesJoin").click(function(){
        elevendayFlag=1;
        $(".elevenday").addClass("dn");
        investMethod();
    });

    $(".noJoin").click(function(){
        elevendayFlag=0;
        $(".elevenday").addClass("dn");
        investMethod();
    });

    $(".closeBtn").click(function(){
        elevendayFlag=0;
        $(".elevenday").addClass("dn");
        investMethod();
    });


	$("#tou").click(function(){
		if(elevenDayShow=="true"||elevenDayShow){
			$(".elevenday").removeClass("dn");
			return;
		}else {
			investMethod();
		}
	});

	function investMethod() {
		$('#hbjnhtk').hide();
        touzihb();
    }
	
	touzihb = function(){
		if(isMove){
			$("#xwRemoval").removeClass("dn");
			return false;
		}
		
		$("#tou_errmsg").addClass("dn");
		if(isLogin && !isDeposit){
			showNoTopLay($('#depositDiv'),$('#depositMask'));
			return false;
		}
		var v = $("#myinvest").val();
		if (!isNumber(v)) {
			$("#tou_errmsg").removeClass("dn");
			$("#tou_errmsg").html("��������ȷ�Ľ��");
			$('#famout').addClass('tbts');
			$('#myinvest').parent().addClass('insuf');
			return false;
		}
		//if (v % minAmount != 0) {
//			$("#tou_errmsg").removeClass("dn");
//			$("#tou_errmsg").html(minAmount+"Ԫ��Ͷ");
//			$('#famout').addClass('tbts');
//			$('#myinvest').parent().addClass('insuf');
//			return false;
//		}
		if (v < minAmount) {
		$("#tou_errmsg").removeClass("dn");
		$("#tou_errmsg").html(minAmount+"Ԫ��Ͷ");
		$('#famout').addClass('tbts');
		$('#myinvest').parent().addClass('insuf');
		return false;
		}
		
		var _flag = ((v - minAmount)%dizengAmount);
		
		if(_flag!=0){
        v = v - _flag;         
		$("#tou_errmsg").removeClass("dn");
		$("#tou_errmsg").html("Ͷ�ʵ������Ϊ"+dizengAmount+"��������");
		$('#famout').addClass('tbts');
		$('#myinvest').parent().addClass('insuf');
		$("#myinvest").val(v); 
		return false;
		 }
		$('#famout').removeClass('tbts');
		if(v > userAmount){
			$('#puamount').addClass('tbts');
			$('#myinvest').parent().addClass('insuf');
			$('#gorecharge').removeClass('dn');
			return false;
		}
		
		if (lmt > 0) {
			$('#mtou').removeClass('tbts');
			if (v > lmt) {
				$('#mtou').addClass('tbts');
				return false;
			}
		}
		
		if (!isExamTzfx) {
			$('div[t="cswj"]').removeClass('dn');
			return false;
		}
		
		var queryRaise;
		
		
		//ͬ�����ؼ�Ϣȯ
		$.ajax({ 
				//url : "/getPcAbleAdditionList", 
				url : "/jsonpublic/getPcAbleAdditionList.asp", 
				type : "post", 
				dataType : 'json',
				async: false, 
				data:{
					myinvest:v,
					loanId:loanId
				},success : function(data) { 
					if(data.ret){
						//���ڲ���ʾ
						if(isLogin && !isHuoqi && data.ishasAddition){
							var adlis = "";
							var raiseData = [];
							var raiseIndex = [];
							var exceedValue = [];
							
							//���޼�Ϣ
							var duanwuRaiseData = [];
							var duanwuRaiseIndex = [];
							
							$.each(data.userAdditionList,function(i,v){
								var rateNotify = [];
								if(!!v.isRaise && v.isRaise == 1){
									raiseData = v;
									raiseIndex = i;
								}
								if(!!v.isDuanwuRaise && v.isDuanwuRaise == 1){
									duanwuRaiseData = v;
									duanwuRaiseIndex = i;
								}
								
								if(!!v.ExceedMaxRate && v.ExceedMaxRate == 1){
									 var raiseRate = (2 - Number(v.rate)) > 0 ? "2" : v.rate;
									 rateNotify = "�������ˣ���Ϣ��Ȩ�ѳ���ʹ�����ޣ����ѳɹ���Ϣ" + raiseRate + "%Ӵ��";
									 exceedValue = v.ExceedMaxValue;
								 }else if(!!v.ExceedMaxRate && v.ExceedMaxRate == 2){
									 var raiseRate = (2 - Number(v.rate)) > 0 ? "2" : v.rate;
									 rateNotify = "�������ˣ���Ϣ��Ȩ�ѳ���ʹ�����ޣ����ѳɹ���Ϣ" + raiseRate + "%Ӵ�� ";
									 exceedValue = v.ExceedMaxValue;
								 }else{
									 rateNotify = "1";
									 exceedValue = "1";
								 }
								
								var loseReward = "";
								if(!!v.encryptActivityId && !!v.loseRewardId){
									loseReward = ' encr="' + v.encryptActivityId + '" ' + ' lose="' + v.loseRewardId + '" '
								}
								
								adlis +='<li class=""><a ' + loseReward + ' v='+i+' chooseId= '+v.id+' rn=' + rateNotify + ' ev=' + exceedValue + '  href="javascript:void(0)">'+ v.num+'-<font class="orange">'+v.rate+'%</font></a></li>' ;   	
							});
							
							$('.affirm_input_tab').prepend('<tr add="" >'
							           +'<td width="100%" colspan="2">'
							           + '<input style="float:left; margin-top:3px; margin-right:3px;" type = "checkbox" name="ckRate" id="ckRate" /><label for="ckRate">ʹ�ü�Ϣȯ����������<label/>'
							           +'</td>'
							           +'</tr>'
							           +'<tr add="">' 
							           +'<td width="100%" id="showRates"  colspan="2"  style="display:none; padding-bottom:10px;">'
							           + '<div  ckrate="show"  fnn="down"  class="seldiv03 select01_tit" style="width:207px">'
							           + '<span id="sdown"  tp="down" ><img src="/jsonpublic/source/images/wap/img/s_i_b.png" /></span>'
							           +'<span id="sup"  tp="up" style="display:none"><img src="/jsonpublic/source/images/wap/img/s_i_t.png" /></span>'
							           +'<div class="gray" sltIn="" id="rate" >��ѡ��</div>'          
							           + '</div>'      	
							           +' <div>	'      
							           + '<ul id="rate_options" class="selbox01 dn select02_tit" style="width:200px">'      
									   + adlis       	
							           +'</ul>'      
							           +'</div>'      
							           +' </td>'
							           +'</tr>' 
									);
							
							if(!!raiseData && raiseData.isRaise == 1){
								
								 if(!!raiseData.ExceedMaxRate && raiseData.ExceedMaxRate == 1){
									 $("[isrp='rp']").html("+" + (nowRate - raiseData.ExceedMaxValue) + "%(��)");
									 $("#rateNotify").html("�������ˣ���Ϣ�����˲˵�������Χ�����ѳɹ���Ϣ2%Ӵ��");
									 $("#rateNotify").show();
								 }else if(!!raiseData.ExceedMaxRate && raiseData.ExceedMaxRate == 2){
									 $("[isrp='rp']").html("+" + (nowRate - raiseData.ExceedMaxValue) + "%(��)");
									 $("#rateNotify").html("�������ˣ���Ϣ�����˲˵�������Χ�����ѳɹ���Ϣ2%Ӵ��");
									 $("#rateNotify").show();
								 }
								
								 $("#ckRate").prop("checked",true);
								 $("#showRates").show();
								 var v = raiseIndex;
								 var selctRate = raiseData.id;
								 queryRaise = selctRate;
								 $("#rate_options li").removeClass("hov");
								 $("#rate_options li:eq(" + v + ")").addClass("hov");
								 $("#rate_options").addClass("dn");	
								 $("#rate").attr("v",v);
								 $("#rate").html("" + raiseData.num+ "-<font class='orange'>" + raiseData.rate + "%</font>");
								 $("#sup").hide();
								 $("#sdown").show();
								 $("#showRates div[ckrate]").attr("fnn","down");
								 $("#showjxqRate").parent().removeClass('dn');
								 myinvest(selctRate);
								 
							}
							if(!!duanwuRaiseData && duanwuRaiseData.isDuanwuRaise == 1){
								
								 if(!!duanwuRaiseData.ExceedMaxRate && duanwuRaiseData.ExceedMaxRate == 1){
									 $("[isrp='rp']").html("+" + (nowRate - duanwuRaiseData.ExceedMaxValue) + "%(��)");
									 $("#rateNotify").html("�������ˣ���Ϣ�����˲˵�������Χ�����ѳɹ���Ϣ2%Ӵ��");
									 $("#rateNotify").show();
								 }else if(!!duanwuRaiseData.ExceedMaxRate && duanwuRaiseData.ExceedMaxRate == 2){
									 $("[isrp='rp']").html("+" + (nowRate - duanwuRaiseData.ExceedMaxValue) + "%(��)");
									 $("#rateNotify").html("�������ˣ���Ϣ�����˲˵�������Χ�����ѳɹ���Ϣ2%Ӵ��");
									 $("#rateNotify").show();
								 }
								
								 $("#ckRate").prop("checked",true);
								 $("#showRates").show();
								 var v = duanwuRaiseIndex;
								 var selctRate = duanwuRaiseData.id;
								 queryRaise = selctRate;
								 $("#rate_options li").removeClass("hov");
								 $("#rate_options li:eq(" + v + ")").addClass("hov");
								 $("#rate_options").addClass("dn");	
								 $("#rate").attr("v",v);
								 $("#rate").html("" + duanwuRaiseData.num+ "-<font class='orange'>" + duanwuRaiseData.rate + "%</font>");
								 $("#sup").hide();
								 $("#sdown").show();
								 $("#showRates div[ckrate]").attr("fnn","down");
								 $("#showjxqRate").parent().removeClass('dn');
								 myinvest(selctRate);
								 
							}

							if(useRdId > 0){
								 var selctRate = useRdId;
								 var jxq = $("#rate_options a[chooseid='" + selctRate + "']");
								 $("#ckRate").prop("checked",true);
								 $("#showRates").show();
								 queryRaise = selctRate;
								 $("#rate_options li").removeClass("hov");
								 jxq.addClass("hov");
								 $("#rate_options").addClass("dn");	
								 $("#rate").attr("v",jxq.attr("v"));
								 var rateNum = jxq.find("font").html().replace(/%/,"");
								 $("#rate").html("" + jxq.html().substring(0, jxq.html().indexOf("-"))+ "-<font class='orange'>" + rateNum + "%</font>");
								 $("#sup").hide();
								 $("#sdown").show();
								 $("#showRates div[ckrate]").attr("fnn","down");
								 $("#showjxqRate").html("+" + rateNum + "%(��Ϣȯ)")
								 $("#showjxqRate").parent().removeClass('dn');
								 
								 if(jxq.attr("rn") != "1" && jxq.attr("rn") != 1){
									 var raise = nowRate - Number(jxq.attr("ev"));
									 $("[isrp='rp']").html("+" + raise.toFixed(2) + "%(��)");
									 $("#rateNotify").html(jxq.attr("rn"));
									 $("#rateNotify").show();
								 }
								 myinvest(selctRate);
								 
							}
							
						}else{
								
						}
							
					}else{
						return false;
						}
					} 
				});
		
		$('#puamount').removeClass('tbts');
		$('#myinvest').parent().removeClass('insuf');
		$('#gorecharge').addClass('dn');
		loandesub(queryRaise);
		return false;
	};
	
	
	$('#bkli').click(function(){
		if(isLogin){
			$(window).scrollTop($('.p_top').offset().top);
			$('#myinvest').focus();
		}else{
			window.location.href = '/toLoginPage?ret=' + window.location.href;
		}
		return false;
	});
	
	$('.investLoan').click(function(){
		if(isLogin){
			$(window).scrollTop($('.p_top').offset().top);
			$('#myinvest').focus();
		}else{
			window.location.href = '/toLoginPage?ret=' + window.location.href;
		}
		return false;
	});
	
	$('a[name="toubtn"]').click(function(){
		var v = $(this).attr('v');
		if(isLogin){
			if('1' == v){
				$(window).scrollTop($('.p_top').offset().top);
			}
			$('#myinvest').focus();
		}else{
			window.location.href = '/toLoginPage?ret=' + window.location.href;
		}
		return false;
	});
	
	$('#counter').click(function(){
		$("#TB_overlayBG").css({
			display:"block",height:$(document).height()
		});
		$("#counterDiv").css({
			left:($("body").width()-$("#counterDiv").width())/2-20+"px",
			top:($(window).height()-$("#counterDiv").height())/2+$(window).scrollTop()+"px",
			display:"block"
		});
		return false;
	});
	
	$('#counterClose').click(function(){
		$("#TB_overlayBG").css("display","none");
		$("#counterDiv").css("display","none");
		var obj = $('#counterAmount');
		$('#counterAmount').val(obj[0].defaultValue);
		$('#interestspan').html('0');
		$('#msgspan').html('');
		$('#msgspan').parent().addClass('dn');
		$('#interestspan').parent().removeClass('dn');
		return false;
	});
	
	var focustime = 0;
	$('#counterAmount').focus(function(){
		if($(this).val() == this.defaultValue){
			$(this).val('');
		}
		focustime = new Date().getTime();
	});
	
	$('#counterAmount').keypress(function(e){
		 var code = (e.keyCode ? e.keyCode : e.which);
		 if(this.value.length > $('#yue').val().length){
			 if(code != 8)
				 return false;
		 }
         return (code >= 48 && code<= 57) || (code == 8);   
	});
	
	$('#counterAmount').keyup(function(e){
		var d =new Date().getTime();
        if(d-focustime < 50){
            return;
        }
		var v = this.value;
		if(isEmpty(v)){
			return;
		}
		var regex = /^[1-9]\d*$/;
		if(!regex.test(v)){
			$('#msgspan').html('��������ȷ��Ͷ�ʽ��');
			$('#msgspan').parent().removeClass('dn');
			$('#interestspan').parent().addClass('dn');
			return;
		}
//		if (v % minAmount != 0){
//			$('#msgspan').html('Ͷ�ʶ�����'+minAmount+'��������');
//			$('#msgspan').parent().removeClass('dn');
//			$('#interestspan').parent().addClass('dn');
//			return;
//		}		
		
		if (v < minAmount) {
		$('#msgspan').html('Ͷ�ʶ��������Ͷ���'+minAmount+'');
		$('#msgspan').parent().removeClass('dn');
		$('#interestspan').parent().addClass('dn');
		return;		
		}		
		var __flag = ((v - minAmount)%dizengAmount);		
		if(__flag!=0){
        v = v - __flag;         
		$('#msgspan').html('Ͷ�ʵ������Ϊ'+dizengAmount+'��������');
		$('#msgspan').parent().removeClass('dn');
		$('#interestspan').parent().addClass('dn');
		//$("#counterAmount").val(v); 
		return;				
		 }
		
		if(v*1 > $('#yue').val()*1){
			$('#msgspan').html('Ͷ�ʶ��ѳ���ʣ���Ͷ���');
			$('#msgspan').parent().removeClass('dn');
			$('#interestspan').parent().addClass('dn');
			return;
		}
		$.ajax({
			url: "/jsonpublic/getInterestUnlogin.asp",
			type: "POST",
			data : {
				loanId : loanId,
				amount : v
			},
			dataType: "json",
			success: function(data){
				$('#interestspan').html(data.it);
				if($('#interestspan').parent().hasClass('dn')){
					$('#msgspan').html('');
					$('#msgspan').parent().addClass('dn');
					$('#interestspan').parent().removeClass('dn');
				}
				
			}
		});
	});
	
	$('#confirmClose').click(function(){
		$('#confirmDiv').hide();
		window.location.reload(true);
		return false;
	});
	
	var fillLoanInvestorsPager = function(data) {
		$("#pspan").empty();
		var h = [];
		
		var totalPage = Math.ceil( data.total / (data.pgCount));
		if (data.page > 1) {
			h.push("<a class='pagePrev' pg='t' href='javascript:void(0)' title='��һҳ' p='" + (data.page - 1) + "'><b></b></a>");
			h.push("<a  p='1' pg='t' href='javascript:void(0)' title='��1ҳ'>1</a>");
		} else {
			h.push("<a class='hov'>1</a>");
		}
	
		if (data.page <=4) {
			for(var i = 2; i <= data.page; i++) {
				if (i == data.page) {
					h.push("<a class='hov'>" + i + "</a>");
				} else {
					h.push("<a pg='t'  p='" + i + "' href='javascript:void(0)' title='��" + i + "ҳ'>" + i +"</a>");
				}
				
			}
		} else {
			h.push("<span>...</span>");
			for(var i = data.page - 2; i <= data.page; i++) {
				if (i == data.page) {
					h.push("<a class='hov'>" + i + "</a>");
				} else {
					h.push("<a pg='t'  p='" + i + "' href='javascript:void(0)' title='��" + i + "ҳ'>" + i +"</a>");
				}
			}
		}
		for(var i = data.page + 1; i <= Math.min(totalPage - 1, data.page + 2); i++) {
			h.push("<a pg='t'  p='" + i + "' href='javascript:void(0)' title='��" + i + "ҳ'>" + i +"</a>");
		}
		if (data.page + 2 < totalPage - 1) {
			h.push("<span>...</span>");
		}
		if (data.page < totalPage) {
			h.push("<a pg='t'  p='" + totalPage + "' href='javascript:void(0)' title='��" + totalPage + "ҳ'>" + totalPage +"</a>");
			h.push("<a class='pageNext' pg='t' href='javascript:void(0)' title='��һҳ' p='" + (data.page + 1) + "' ><b></b></a>");
		}
		
		h.push("�ۼ�" + data.total + "�ʳ���");
		$("#pspan").html(h.join(""));
	};
	var fillLoanInvestors = function(data) {
		$("#lis").empty();
		var h = [];
		$.each(data.data, function(i,v){
			h.push("<tr>");
			h.push("<td class='pdlf'>", v.name);
			if(v.v){
				h.push('<img src="/jsonpublic/images/v.png" />');
			}
			h.push('</td>');
			h.push("<td class='pdrt'>", v.amount , "</td>");
			h.push("<td>", v.time , "</td>");
			if(v.s == 1){
				h.push('<td class="pdlf"><span style="margin-right:5px;">����ɹ�</span>');
				if(v.m){
					h.push('<img style="margin-right:5px;" src="/jsonpublic/source/images/web/icon/w.png" />');
				}
				if(v.auto){
					h.push('<img style="margin-right:5px;" src="/jsonpublic/source/images/web/icon/zd.gif" />');
				}
				h.push('</td>');
			}else{
				h.push('<td class="pdlf">��ȷ��</td>')
			}
			h.push("</tr>");
		});
		$("#lis").html(h.join(""));
	};


	
	 
	
	$("#pspan").delegate("a[p]", "click", function(){
		var p = $(this).attr("p");
		getLoanInvestors(p);
		return false;
	});
	$('#fltab').flt();
	
	$("a[t=noun]").bind({
		mousemove:function(){$(this).parent().find("div[t=nounContent]").removeClass("dn");},
		mouseout:function(){$(this).parent().find("div[t=nounContent]").addClass("dn");}
	});
	
	var canget = true;
	$('#resetPasswdBtn').click(function(){	
		if(!canget){
			return;
		}		
		canget = false;
		$.ajax({
			url: '/getUmpPasswd',
			type: 'post',
			dataType: 'json',
			success: function(d){
				canget = true;
				if(d.ret){
					timer();
				}else{
					$(layobj).html(d.errmsg);
					$(layobj).show();
					notice(layobj);
				}
			}
		});
	});
	
	var timer = function(){
		$('#resetPasswdBtn').addClass("dn");
		$('#desspan').removeClass('dn');
		var ci = setInterval(function(){
			var ti = parseInt($('#minspan').html(), 10);
			ti--;
			if (ti <= 0) {
				$('#resetPasswdBtn').removeClass('dn');
				$('#desspan').addClass('dn');
				clearInterval(ci);
			}
			$('#minspan').html(ti);
			
		}, 1000);
	};
	
	
	//���checkBox
	$(".affirm_input_tab").delegate("#ckRate","click",function(){
		cancellationId = "";
		$("#loseefficacyjxq").parent().addClass("dn");
	/*$('#ckRate').click(function(){*/
		//��ȡԪ�ظ���
		var num = $("#rate_options li a[chooseId]").length;
		if($(this).prop("checked")==true){
			$("#showRates").show();
			/*if(num == 1){
				var selctRate = $("#rate_options li a").attr("chooseId");
				$("#showjxqRate").parent().removeClass('dn');
				 myinvest(selctRate);
				 $("#rate").html($("#rate_options li a").html());
			}*/
		}else{
			myinvest();
			$("#showRates").hide();
			$("#showjxqRate").parent().addClass('dn');
			$("#rate").attr("sltIn","");
			$("#rate").html("��ѡ��");
			$("#showReward li[tyin=addIn]").hide();
		}
	});
	
	//ѡ��������
	$(".affirm_input_tab").delegate("#showRates div[ckrate]","click",function(){
	/*$("#showRates div[ckrate]").click(function(){*/
		//��ȥ�������
		$("#showRates div[ckrate]").removeClass("redBd");
		var ss = $(this).attr("fnn");
		if(ss=='down'){
			$("#rate_options").removeClass("dn");
			$("#sdown").hide();
			$("#sup").show();
			$(this).attr("fnn","up");
		}else{
			$("#rate_options").addClass("dn");
			$("#sup").hide();
			$("#sdown").show();
			$(this).attr("fnn","down");
		}
		return false;
	});
	
	//���ѡ������
	$(".affirm_input_tab").delegate("#showRates a[v]","click",function(){
		cancellationId = "";
	/*$("#showRates").delegate("a[v]","click",function(){*/
		$("#rate_options li").removeClass("hov");
		$(this).parent().addClass("hov");
		var v=$(this).attr("v");
		var rn = $(this).attr('rn');
		var ev = $(this).attr('ev');
		$("#rateNotify").hide();
		var isck = $("#ckRate").prop('checked');
		var selctRate = $(this).attr("chooseId");
		 if(isck) {
		 $("#rate_options").addClass("dn");	 
		 $("#rate").attr("v",v);
		 
		 $("#showRates a[lose]").each(function(){
			 var font = $(this).find("font");
			 font.html(font.html().replace(/  ����/g,""));
		 })
		 
		 $("#loseefficacyjxq").parent().addClass("dn");
		 var lose = $(this).attr("lose");
		 var encr = $(this).attr("encr");
		 if(!!lose && !!encr){
			 var content = $(this).parent().parent().find("a[chooseId='" + lose + "']");
			 var html = content.html().substring(0, content.html().indexOf("-") + 1);
			 $("#loseefficacyjxq").html("�ɹ�Ͷ��� " + html + content.find("font").html() + "������")
			 $("#loseefficacyjxq").parent().removeClass("dn");
			 content.find("font").append("  ����");
			 cancellationId = encr;
		 }
		 
		 $("#rate").html($(this).html());
		 $("#rate_options").addClass("dn");	
		 //��������ͷ����
		 $("#sup").hide();
		 $("#sdown").show();
		 $("#showRates div[ckrate]").attr("fnn","down");
		 //�Լ�Ϣչʾ��������
		 $("#showjxqRate").parent().removeClass('dn');
		 
		 if(!!rn && 1 != Number(rn) ){
			 $("#rateNotify").html(rn)
			 $("#rateNotify").show();
		 }
		 
		 if(!!ev && 1 != Number(ev) ){
			 $("[isrp='rp']").html("+" + (nowRate - ev).toFixed(2) + "%(��)");
		 }else{
			 $("[isrp='rp']").html("+" + nowRate.toFixed(2) + "%(��)");
		 }
		 myinvest(selctRate);
		}
		return false;
	});
	
	//������֮�ⴥ�������������¼�
	$(document).bind("mousedown",function(ev){
		var element=ev.target;
		var ps=$(element).parents();
		var b=false;
		ps.push(element);
		$.each(ps,function(i,e){
			var c=$(e).attr("id");
			if(c=="rate_options"){
				b=true;
			}
		});
		if(b){
			return;
		}
		$("#rate_options").addClass("dn");
	});
	
	$("#showHb").delegate("a[t]", "mouseover", function(){	
		var obj = $(this).parent().find(".hbtltxt");
		obj.removeClass("dn");	
		return false;
	});
	
	$("#showHb").delegate("a[t]", "mouseout", function(){
		var obj = $(this).parent().find(".hbtltxt");
		obj.addClass("dn");
		return false;
	});
	

 
	$("#ck").click( function(){
		if($("#ck").is(":checked")){
			$("#investButton").removeClass("dn");
			$("#investUnButton").addClass("dn"); //��ɫ��ť
		}else{
			$("#investButton").addClass("dn");
			$("#investUnButton").removeClass("dn");//��ɫ��ť
		}
	});
	
	$("#jjsCk").click( function(){
		if($("#jjsCk").is(":checked")){
			$("#investButton").removeClass("dn");
			$("#investUnButton").addClass("dn"); //��ɫ��ť
		}else{
			$("#investButton").addClass("dn");
			$("#investUnButton").removeClass("dn");//��ɫ��ť
		}
	});
    $("#njsRisk").click( function(){
        if($("#njsRisk").is(":checked")){
            $("#investButton").removeClass("dn");
            $("#investUnButton").addClass("dn"); //��ɫ��ť
        }else{
            $("#investButton").addClass("dn");
            $("#investUnButton").removeClass("dn");//��ɫ��ť
        }
    });
	$("#closeMove").click(function(){
		$("#xwRemoval").addClass("dn");
		return false
	});
	
	
})(window);
