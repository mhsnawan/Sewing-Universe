		"use strict";
		var sneaker_brandnumber = 6,
			sneaker_brandscrollnumber = 1,
			sneaker_brandpause = 3000,
			sneaker_brandanimate = 2000;
		var sneaker_brandscroll = false;
							sneaker_brandscroll = true;
					var sneaker_categoriesnumber = 6,
			sneaker_categoriesscrollnumber = 2,
			sneaker_categoriespause = 3000,
			sneaker_categoriesanimate = 700;
		var sneaker_categoriesscroll = 'false';
					var sneaker_blogpause = 3000,
			sneaker_bloganimate = 700;
		var sneaker_blogscroll = false;
					var sneaker_testipause = 3000,
			sneaker_testianimate = 2000;
		var sneaker_testiscroll = false;
							sneaker_testiscroll = false;
					var sneaker_catenumber = 6,
			sneaker_catescrollnumber = 2,
			sneaker_catepause = 3000,
			sneaker_cateanimate = 700;
		var sneaker_catescroll = false;
					var sneaker_menu_number = 8;
		var sneaker_sticky_header = false;
							sneaker_sticky_header = true;
					jQuery(document).ready(function(){
			jQuery(".ws").on('focus', function(){
				if(jQuery(this).val()==""){
					jQuery(this).val("");
				}
			});
			jQuery(".ws").on('focusout', function(){
				if(jQuery(this).val()==""){
					jQuery(this).val("");
				}
			});
			jQuery(".wsearchsubmit").on('click', function(){
				if(jQuery("#ws").val()=="" || jQuery("#ws").val()==""){
					jQuery("#ws").focus();
					return false;
				}
			});
			jQuery(".search_input").on('focus', function(){
				if(jQuery(this).val()==""){
					jQuery(this).val("");
				}
			});
			jQuery(".search_input").on('focusout', function(){
				if(jQuery(this).val()==""){
					jQuery(this).val("");
				}
			});
			jQuery(".blogsearchsubmit").on('click', function(){
				if(jQuery("#search_input").val()=="" || jQuery("#search_input").val()==""){
					jQuery("#search_input").focus();
					return false;
				}
			});
		});
		