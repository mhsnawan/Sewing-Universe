/* Product Options Js */
jQuery('.roadthemes-products.roadthemes-slider').each(function(){ 
	var items_1500up    = parseInt(jQuery(this).attr('data-1500up'));
	var items_1200_1499 = parseInt(jQuery(this).attr('data-1200-1499'));
	var items_992_1199  = parseInt(jQuery(this).attr('data-992-1199'));
	var items_768_991   = parseInt(jQuery(this).attr('data-768-991'));
	var items_640_767   = parseInt(jQuery(this).attr('data-640-767'));
	var items_480_639   = parseInt(jQuery(this).attr('data-480-639'));
	var items_0_479     = parseInt(jQuery(this).attr('data-0-479'));
	var navigation      = true; 
	if (parseInt(jQuery(this).attr('data-navigation'))!==1)  {navigation = false} ;
	var pagination      = false; 
	if (parseInt(jQuery(this).attr('data-pagination'))==1)  {pagination = true} ;
	var item_margin     = parseInt(jQuery(this).attr('data-margin'));
	var auto            = false; 
	if (parseInt(jQuery(this).attr('data-auto'))==1)  {auto = true} ;
	var loop            = false; 
	if (parseInt(jQuery(this).attr('data-loop'))==1)  {loop = true} ;
	var speed           = parseInt(jQuery(this).attr('data-speed'));
	jQuery(this).find('.shop-products').addClass('owl-carousel owl-theme').owlCarousel({ 
		nav            : navigation, 
		dots           : pagination,
		margin         : item_margin,
		loop           : loop,
		autoplay       : auto,
		smartSpeed     : speed,
		addClassActive : false,
		responsiveClass: true,
		responsive     : {
			0: {
				items: items_0_479,
			},
			480: {
				items: items_480_639,
			},
			640: {
				items: items_640_767,
			},
			768: { 
				items: items_768_991,
			},
			992: { 
				items: items_992_1199,
			},
			1200: { 
				items: items_1200_1499,
			},
			1500: {
				items: items_1500up,
			},
		},
	});
});