"use strict";
// product-magnifier var
var sneaker_magnifier_vars;
var yith_magnifier_options = {
		sliderOptions: {
			responsive: sneaker_magnifier_vars.responsive,
			circular: sneaker_magnifier_vars.circular,
			infinite: sneaker_magnifier_vars.infinite,
			direction: 'up',
			debug: false,
			auto: false,
			align: 'left',
			height: "100%", //turn vertical
			width: 100,
			prev    : {
				button  : "#slider-prev",
				key     : "left"
			},
			next    : {
				button  : "#slider-next",
				key     : "right"
			},
			scroll : {
				items     : 1,
				pauseOnHover: true
			},
			items   : {
				visible: Number(sneaker_magnifier_vars.visible),
			},
			swipe : {
				onTouch:    true,
				onMouse:    true
			},
			mousewheel : {
				items: 1
			}
		},
		showTitle: false,
		zoomWidth: sneaker_magnifier_vars.zoomWidth,
		zoomHeight: sneaker_magnifier_vars.zoomHeight,
		position: sneaker_magnifier_vars.position,
		lensOpacity: sneaker_magnifier_vars.lensOpacity,
		softFocus: sneaker_magnifier_vars.softFocus,
		adjustY: 0,
		disableRightClick: false,
		phoneBehavior: sneaker_magnifier_vars.phoneBehavior,
		loadingLabel: sneaker_magnifier_vars.loadingLabel,
	};