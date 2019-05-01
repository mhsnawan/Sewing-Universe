<?php 

if( ! function_exists( 'road_get_slider_setting' ) ) {
	function road_get_slider_setting() {
		return array(
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Style', 'sneaker' ),
				'param_name'  => 'style',
				'value'       => array(
					__( 'Grid view', 'sneaker' )                    => 'product-grid',
					__( 'List view', 'sneaker' )                    => 'product-list',
					__( 'Countdown', 'sneaker' )                    => 'product-countdown',
					__( 'Grid view with countdown', 'sneaker' )     => 'product-grid-countdown',
				),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => __( 'Enable slider', 'sneaker' ),
				'description' => __( 'If slider is enabled, the "column" ins General group is the number of rows ', 'sneaker' ),
				'param_name'  => 'enable_slider',
				'value'       => true,
				'save_always' => true, 
				'group'       => __( 'Slider Options', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Number of columns (screen: over 1500px)', 'sneaker' ),
				'param_name' => 'items_1500up',
				'group'      => __( 'Slider Options', 'sneaker' ),
				'value'      => esc_html__( '4', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Number of columns (screen: 1200px - 1499px)', 'sneaker' ),
				'param_name' => 'items_1200_1499',
				'group'      => __( 'Slider Options', 'sneaker' ),
				'value'      => esc_html__( '4', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Number of columns (screen: 992px - 1199px)', 'sneaker' ),
				'param_name' => 'items_992_1199',
				'group'      => __( 'Slider Options', 'sneaker' ),
				'value'      => esc_html__( '4', 'sneaker' ),
			), 
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Number of columns (screen: 768px - 991px)', 'sneaker' ),
				'param_name' => 'items_768_991',
				'group'      => __( 'Slider Options', 'sneaker' ),
				'value'      => esc_html__( '3', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Number of columns (screen: 640px - 767px)', 'sneaker' ),
				'param_name' => 'items_640_767',
				'group'      => __( 'Slider Options', 'sneaker' ),
				'value'      => esc_html__( '2', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Number of columns (screen: 480px - 639px)', 'sneaker' ),
				'param_name' => 'items_480_639',
				'group'      => __( 'Slider Options', 'sneaker' ),
				'value'      => esc_html__( '2', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Number of columns (screen: under 479px)', 'sneaker' ),
				'param_name' => 'items_0_479',
				'group'      => __( 'Slider Options', 'sneaker' ),
				'value'      => esc_html__( '1', 'sneaker' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => __( 'Navigation', 'sneaker' ),
				'param_name'  => 'navigation',
				'save_always' => true,
				'group'       => __( 'Slider Options', 'sneaker' ),
				'value'       => array(
					__( 'Yes', 'sneaker' ) => true,
					__( 'No', 'sneaker' )  => false,
				),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => __( 'Pagination', 'sneaker' ),
				'param_name'  => 'pagination',
				'save_always' => true,
				'group'       => __( 'Slider Options', 'sneaker' ),
				'value'       => array(
					__( 'No', 'sneaker' )  => false,
					__( 'Yes', 'sneaker' ) => true,
				),
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Item Margin (unit: pixel)', 'sneaker' ),
				'param_name'  => 'item_margin',
				'value'       => 30,
				'save_always' => true,
				'group'       => __( 'Slider Options', 'sneaker' ),
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Slider speed number (unit: second)', 'sneaker' ),
				'param_name'  => 'speed',
				'value'       => '500',
				'save_always' => true,
				'group'       => __( 'Slider Options', 'sneaker' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => __( 'Slider loop', 'sneaker' ),
				'param_name'  => 'loop',
				'value'       => true,
				'group'       => __( 'Slider Options', 'sneaker' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => __( 'Slider Auto', 'sneaker' ),
				'param_name'  => 'auto',
				'value'       => true,
				'group'       => __( 'Slider Options', 'sneaker' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Navigation style', 'sneaker' ),
				'param_name'  => 'navigation_style',
				'group'       => __( 'Slider Options', 'sneaker' ),
				'value'       => array(
					'Navigation center horizontal'	=> 'navigation-style1',
					'Navigation top-right'	        => 'navigation-style2',
				),
			),
		);
	}
}