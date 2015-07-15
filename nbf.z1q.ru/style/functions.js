$(document).ready(function() {
	//Phone validator
	$("#CustomerPhone").mask("8 (999) 999-9999");
	
	//Preload Items images
	jQuery.preloadImages = function() {
		if (typeof arguments[arguments.length - 1] == 'function') {
			var callback = arguments[arguments.length - 1];
		} else {
			var callback = false;
		} if (typeof arguments[0] == 'object') {
			var images = arguments[0];
			var n = images.length;
		} else {
			var images = arguments;
			var n = images.length - 1;
		}
		var not_loaded = n;
		for (var i = 0; i < n; i++) {
			jQuery(new Image()).attr('src', images[i]).load(function() {
				if (--not_loaded < 1 && typeof callback == 'function') {
					callback();
				}
			});
		}
	}
	var preloadIMG = $('ul.Items li img').map(function() {
		var i = $(this);
		var src = $(i).attr("src");
		src = src.substring(0, src.lastIndexOf("."));
		return [src + '_h.jpg', src + '_s.jpg', src + '.jpg'];
	});
	$.preloadImages(preloadIMG, function() {
			$('#Loading').remove();
		});
	/*
	if ($('ul.Items li img').length > 0) {
		$('body').prepend('<div id="Loading"><div>загрузка...</div></div>');
	}
	*/
	
	//Hash scrolling
	$('a[href*="#"]').click(function() {
		if (location.pathname.replace(/^\//, ") == this.pathname.replace(/^\//,") && location.hostname == this.hostname) {
			var $target = $(this.hash);
			$target = $target.length && $target || $('[name=' + this.hash.slice(1) + ']');
			if ($target.length) {
				var targetOffset = $target.offset().top;
				$('html,body').animate({
					scrollTop: targetOffset - 20
				}, 2000);
				return false;
			}
		}
	});
	//Current nav lighting
	var url = document.location.search; //?cat=*n
	var s = url.substr(5); //convert ?cat=*n to *n
	if (url = '?cat=' + s + '') { $('A.Menu-' + s + '').addClass('Sel'); } 
	if (document.location.search == '') { var MainPage = 'T'; }
	if (document.location.href.indexOf('action') > -1) {
		$('A.Menu-15').addClass('Sel');
		MainPage = 'F';
	} if (document.location.href.indexOf('about') > -1) {
		$('A.Menu-11').addClass('Sel');
		MainPage = 'F';
	} if (document.location.href.indexOf('delivery') > -1) {
		$('A.Menu-12').addClass('Sel');
		MainPage = 'F';
	} if (document.location.href.indexOf('contacts') > -1) {
		$('A.Menu-13').addClass('Sel');
		MainPage = 'F';
	} if (document.location.href.indexOf('news') > -1) {
		$('A.Menu-14').addClass('Sel');
		MainPage = 'F';
	} 
	if (MainPage == 'T'){
		$('A.Menu-2').addClass('Sel');
	}
	//Cart Scroll
	var offset = $("#Cart").offset();
	var topPadding = -10;
	$(window).scroll(function() {
		if ($(window).scrollTop() > offset.top) {
			$("#Cart").stop().animate({
				marginTop: $(window).scrollTop() - offset.top + topPadding
			});
		} else {
			$("#Cart").stop().animate({
				marginTop: +topPadding
			});
		};
	});
	//Item hover
	$(".Products [id^=Item_] div").hover(function() {
		var $img = $(this).children('img'),
			src = $img.attr('src').replace(".jpg", "_h.jpg");
		$img.hide().attr('src', src).show();
		Item = $(this).closest('li');
		Category = $(this).closest('ul');
		//for very big items
		if($(this).closest('li').hasClass('Bigger')){
			$(Item).addClass('VeryFull');
		} else {
			$(Item).addClass('Full');
		}
		//$(Item).addClass('Full');
		//Add to cart fastest
		if (($(Item).hasClass('Full')) || ($(Item).hasClass('VeryFull'))) {
		//1
		/* if(Category.hasClass('Pizza')){
			
		} else { */
				$(this).find('img').unbind('click').bind('click', function() {
					$(Item).find('form:first').submit(function(e) {
						e.preventDefault();
						$img.stop().fadeTo(300, 0.5).fadeTo(300, 1);
					}).submit();
				});
			//}
		}
		var Name = $(this).parents('li').find('h3').text();
		var Price = $(this).parents('li').find('span > b').text().split(' ')[0];
		var Buy = $(this).parents('li').find('span > i').get(0);
		var Rel = $(this).parents('li').find('span > i').attr('rel');
		
		if(Category.hasClass('Pizza')){
			$(this).prepend('<div><h3>' + Name + '</h3><span><input type="submit" name="my-add-button" value=" " class="AddCart33"/><input type="submit" name="my-add-button" value=" " class="AddCart45"/></i><b>' + Price + '</b></span></div>');
		} else {
			$(this).prepend('<div><h3>' + Name + '</h3><span><input type="submit" name="my-add-button" value=" " class="AddCart"></i><b>' + Price + ' р.</b></span></div>');
		}
		
	}, function() {
		var $img = $(this).children('img'),
			src = $img.attr('src').replace("_h.jpg", ".jpg");
		$img.attr('src', src);
		$(Item).removeClass('Full').removeClass('VeryFull');
		$(this).children('div').remove();
	});
	
	
	//////////////////

	//check posotion after operation in cart
	function CheckPosition(){
		$("#Scrollable").each(function(){
			var relposition = $(this).attr('rel');
			//console.log(relposition);
			$(this).delay(200).animate({
				marginTop: "" + relposition + "px"
			}, 10);
			//console.log('each '+relposition);
		});
	}
	//Scrollable Cart	
	function Scrollable() {
		var height = 57;
		var count = 5;
		var imgs = $("#ItemList").find('dl');
		var position = 0;
		if (imgs.length > count) {
			$("div.Bottom").animate({
				opacity: 1
			}, 0);
			$("div.Top").click(function() {
				checkTop();
				position = Math.min(position + height * count, 0);
				$("#Scrollable").animate({
					marginTop: "" + position + "px"
				}, 800);
				checkTop();
				$("#Scrollable").attr('rel', ''+position+'');			
			});
			$("div.Bottom").click(function() {
				checkBottom();
				position = Math.max(position - height * count, -height * (imgs.length - count));
				$("#Scrollable").animate({
					marginTop: "" + position + "px"
				}, 800);				
				checkBottom();
				$("#Scrollable").attr('rel', ''+position+'');
			});
		}
		CheckPosition();
		//scroll to top
		function checkTop() {
			if (position >= 0 & imgs.length > count) {
				$("div.Top").animate({
					opacity: 0.2
				}, 200);
				$("div.Bottom").animate({
					opacity: 1
				}, 200);
			} else if (position <= 0 & position < height * count) {
				$("div.Top").animate({
					opacity: 1
				}, 200);
				$("div.Bottom").animate({
					opacity: 1
				}, 200);
			}
		}
		//scroll to bottom
		function checkBottom() {
			if (position <= -height * (imgs.length - count) & position < height * count) {
				$("div.Top").animate({
					opacity: 1
				}, 200);
				$("div.Bottom").animate({
					opacity: 0.2
				}, 200);
			} else if (position >= 0 & position < height * count) {
				$("div.Top").animate({
					opacity: 1
				}, 200);
				$("div.Bottom").animate({
					opacity: 1
				}, 200);
			}
		}
	}
	
	//JCART namespace operations
	var JCART = (function() {
		var path = 'inc',
			container = $('#Cart'),
			token = $('[name=Token]').val(),
			tip = $('#jcart-tooltip');
		var config = (function() {
			var config = null;
			$.ajax({
				url: path + '/config-loader.php',
				data: {
					"ajax": "true"
				},
				dataType: 'json',
				async: false,
				success: function(response) {
					config = response;
				},
				error: function() {
					alert('Ajax error: Edit the path in jcart.js to fix.');
				}
			});
			return config;
		}());
		var setup = (function() {
			Scrollable();
			$.ajaxSetup({
				type: 'POST',
				url: path + '/relay.php',
				success: function(response) {
					if ($.browser.msie && $.browser.version <= 9 ) {
						document.getElementById('Cart').innerHTML = response;
						Scrollable();
					} else {
						container.html(response);
						Scrollable();
					}					
				},
				error: function(x, e) {
					var s = x.status,
						m = 'Ajax error: ';
					if (s === 0) {
						m += 'Check your network connection.';
					}
					if (s === 404 || s === 500) {
						m += s;
					}
					if (e === 'parsererror' || e === 'timeout') {
						m += e;
					}
					alert(m);
				}
			});
		}());
		var isCheckout = $('#jcart-is-checkout').val();
		//add to cart
		function add(form) {
			var itemQty = form.find('[name=' + config.item.qty + ']'),
				itemAdd = form.find('[name=' + config.item.add + ']');
			$.ajax({
				data: form.serialize() + '&' + config.item.add + '=' + itemAdd.val(),
				success: function(response) {
					if ($.browser.msie && $.browser.version <= 9 ) {
						document.getElementById('Cart').innerHTML = response;
						Scrollable();
					} else {
						container.html(response);
						Scrollable();
					}
				}
			});
		}
		//update in checkout page
		function update(input) {
			var updateId = input.parent().find('[name="jcartItemId[]"]').val();
			var newQty = input.val();
			if (newQty) {
				var updateTimer = window.setTimeout(function() {
					$.ajax({
						data: {
							"jcartUpdate": 1,
							"itemId": updateId,
							"itemQty": newQty,
							"jcartIsCheckout": isCheckout,
							"jcartToken": token
						}
					});
					Scrollable();
				}, 1000);
			}
			input.keydown(function(e) {
				if (e.which !== 9) {
					window.clearTimeout(updateTimer);
				}
			});
		}
		//remove item in cart
		function remove(link) {
			var queryString = link.attr('href');
			queryString = queryString.split('=');
			var removeId = queryString[1];
			$.ajax({
				type: 'GET',
				data: {
					"jcartRemove": removeId,
					"jcartIsCheckout": isCheckout
				}
			});
		}
		//plus one in cart
		function plus(link) {
			var queryString = link.attr('href');
			queryString = queryString.split('=');
			var plusId = queryString[1];			
			var newQty = parseFloat(queryString[2]) + 1;
				$.ajax({
					data: {
						"jcartUpdate": 1,
						"itemId": plusId,
						"itemQty": newQty,
						"jcartIsCheckout": isCheckout,
						"jcartToken": token
					}
				});
		}
		//minus one in cart
		function minus(link) {
			var queryString = link.attr('href');
			queryString = queryString.split('=');
			var minusId = queryString[1];			
			var newQty = parseFloat(queryString[2]) - 1;
				$.ajax({
					data: {
						"jcartUpdate": 1,
						"itemId": minusId,
						"itemQty": newQty,
						"jcartIsCheckout": isCheckout,
						"jcartToken": token
					}
				});
		}
		
		$('.jcart').submit(function(e) {
			add($(this));
			e.preventDefault();
		});
		container.keydown(function(e) {
			if (e.which === 13) {
				e.preventDefault();
			}
		});
		container.delegate('[name="jcartItemQty[]"]', 'keyup', function() {
			update($(this));
		});
		container.delegate('.jcart-plus', 'click', function(e) {
			plus($(this));
			e.preventDefault();
		});
		container.delegate('.jcart-minus', 'click', function(e) {
			minus($(this));
			e.preventDefault();
		});
		container.delegate('.jcart-remove', 'click', function(e) {
			remove($(this));
			e.preventDefault();
		});
	}()); // End JCART namespace
	
});

/*-------validation chekout -----*/


$(document).ready(function(){
	$('#krest').click(function (){
		$('p').remove();
		$("#validEr").animate({ opacity: "hide" }, "slow");
	});

	var jVal = {
		'person' : function() {
			var QtyPerson = $('#QtyPerson');
			var patt = /[0-9]/;
			if(!patt.test(QtyPerson.val()) || QtyPerson.val().length < 1 || QtyPerson.val()=='0' || QtyPerson.val().length > 3) {
		        jVal.errors = true;
		        QtyPerson.removeClass('SendQtyPersonG').addClass('SendQtyPersonE').show();
			} else {
				QtyPerson.removeClass('SendQtyPersonE').addClass('SendQtyPersonG').show();
				
			}
		},
		
		'phone' : function() {
			var phone = $('#CustomerPhone');
			var patt = /^[8] \([0-9]{3}\)\ [0-9]{3}\-[0-9]{4}$/i;
			if(!patt.test(phone.val())  || phone.val().length < 1) {
		        jVal.errors = true;
		        phone.removeClass('SendPhoneG').addClass('SendPhoneE').show();
			} else {
				phone.removeClass('SendPhoneE').addClass('SendPhoneG').show();
				
			}
		},

		'yees' : function (){
			var yes = $('#yes') ;
            if($('#QtyPerson').hasClass('SendQtyPersonG') && $('#CustomerPhone').hasClass('SendPhoneG')) {
            	yes.removeClass('yes01').addClass('yes02').show();
			} else {
				jVal.errors = true;
//				yes.removeClass('yes02').addClass('yes01').show();
			}
		},
		
		'sendIt' : function (){
		      if(!jVal.errors) {
//		    	chekRes();
				$("#jform").submit();
		      } else {
				$("#validEr").animate({ opacity: "show" }, "slow");
				$('p').remove();
				$('#validEr').append('<p style="margin-left: 82px; margin-top: 69px; font-size: 18px;">Вы не заполнили форму</p>');
			  }
		}
	};
/*----------------------*/
	$('#jcart-checkout-ok').click(function (){
	    var obj = $.browser.webkit ? $('body') : $('html');
	    obj.animate(
				{ scrollTop: $('#jform').offset().top }, 750, function (){
	            jVal.errors = false;
	            jVal.yees(); //обязательно вернуть
	            jVal.sendIt();
	    });
	    return false;
	});
/*-------------------*/
	
	$('#QtyPerson').keyup(jVal.person)//.bind(keyup, jVal.yees);
//	$('#number').change(jVal.code).change(jVal.yees);
//	$('#fio').change(jVal.fio).change(jVal.yees);
	$('#CustomerPhone').change(jVal.phone).change(jVal.yees);
//	$('#mail').change(jVal.mail).change(jVal.yees);
	
});