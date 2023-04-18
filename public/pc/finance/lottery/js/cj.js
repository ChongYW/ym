		$(function() {
			$("#startbtn").click(function() {
				lottery();
			});
		});

		function lottery() {


						$("#startbtn").unbind('click').css("cursor", "default");
						//var a = json.angle;
						//var p = json.prize;
						var a = 22.5*7;
						var p = 'sss';
						$("#startbtn").rotate({
							duration: 3000,
							//转动时间
							angle: 0, //默认角度
							animateTo:1800+a, //转动角度
							easing: $.easing.easeOutSine, callback: function(){
								alert('恭喜你，抽中'+'"'+p+'"!');
								$("#startbtn").rotate({angle:0});
								$("#startbtn").click(function(){
									lottery();
								}).css("cursor","pointer");
							}
						});






		}