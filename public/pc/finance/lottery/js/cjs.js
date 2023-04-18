function maquer() {
					setInterval(function() {
						$('#rightBox li:first').animate({
							'height': '0',
							'opacity': '0'
						},
						'slow',
						function() {
							$(this).removeAttr('style').insertAfter('#rightBox li:last');
						});
					},
					1000);
					$(this).attr('disabled', true);
					return;
				}
				function maquers() {
					setInterval(function() {
						$('#rightBoxs li:first').animate({
							'height': '0',
							'opacity': '0'
						},
						'slow',
						function() {
							$(this).removeAttr('style').insertAfter('#rightBoxs li:last');
						});
					},
					1000);
					$(this).attr('disabled', true);
					return;
				}
				maquer();
				maquers();