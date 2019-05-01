<?php
if( ! function_exists( 'sneaker_get_slider_setting' ) ) {
	function sneaker_get_slider_setting() {
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
//Shortcodes for Visual Composer
add_action( 'vc_before_init', 'sneaker_vc_shortcodes' );
function sneaker_vc_shortcodes() { 
	//Site logo
	vc_map( array(
		'name' => esc_html__( 'Logo', 'sneaker'),
		'description' => __( 'Insert logo image', 'sneaker' ),
		'base' => 'roadlogo',
		'class' => '',
		'category' => esc_html__( 'Theme', 'sneaker'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params' => array(
			array(
				'type'       => 'attach_image',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Upload logo image', 'sneaker' ),
				'description'=> esc_html__( 'Note: For retina screen, logo image size is at least twice as width and height (width is set below) to display clearly', 'sneaker' ),
				'param_name' => 'logo_image',
				'value'      => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Insert logo link or not', 'sneaker' ),
				'param_name' => 'logo_link',
				'value' => array(
					'Yes'	=> 'yes',
					'No'	=> 'no',
				),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Logo width (unit: px)', 'sneaker' ),
				'description'=> esc_html__( 'Insert number. Leave blank if you want to use original image size', 'sneaker' ),
				'param_name' => 'logo_width',
				'value'      => esc_html__( '150', 'sneaker' ),
			),
		)
	) );
	//Main Menu
	vc_map( array(
		'name'        => esc_html__( 'Main Menu', 'sneaker'),
		'description' => __( 'Set Primary Menu in Apperance - Menus - Manage Locations', 'sneaker' ),
		'base'        => 'roadmainmenu',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'sneaker'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(
			array(
				'type'       => 'attach_image',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Upload sticky logo image', 'sneaker' ),
				'description'=> esc_html__( 'Note: For retina screen, sticky logo image size is at least twice as width and height (width is set below) to display clearly', 'sneaker' ),
				'param_name' => 'sticky_logoimage',
				'value'      => '',
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Sticky logo width (unit: px)', 'sneaker' ),
				'description'=> esc_html__( 'Insert number. Leave blank if you want to use original image size', 'sneaker' ),
				'param_name' => 'sticky_logoimage_width',
				'value'      => esc_html__( '150', 'sneaker' ),
			),
		)
	) );
	//Categories Menu
	vc_map( array(
		'name'        => esc_html__( 'Categories Menu', 'sneaker'),
		'description' => __( 'Set Categories Menu in Apperance - Menus - Manage Locations', 'sneaker' ),
		'base'        => 'roadcategoriesmenu',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'sneaker'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(),
	) );
	//Social Icons
	vc_map( array(
		'name'        => esc_html__( 'Social Icons', 'sneaker'),
		'description' => __( 'Configure icons and links in Theme Options', 'sneaker' ),
		'base'        => 'roadsocialicons',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'sneaker'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(),
	) );
	//Mini Cart
	vc_map( array(
		'name'        => esc_html__( 'Mini Cart', 'sneaker'),
		'description' => __( 'Mini Cart', 'sneaker' ),
		'base'        => 'roadminicart',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'sneaker'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(),
	) );
	//Products Search without dropdown
	vc_map( array(
		'name'        => esc_html__( 'Product Search (No dropdown)', 'sneaker'),
		'description' => __( 'Product Search (No dropdown)', 'sneaker' ),
		'base'        => 'roadproductssearch',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'sneaker'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(),
	) );
	//Products Search with dropdown
	vc_map( array(
		'name'        => esc_html__( 'Product Search (Dropdown)', 'sneaker'),
		'description' => __( 'Product Search (Dropdown)', 'sneaker' ),
		'base'        => 'roadproductssearchdropdown',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'sneaker'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(),
	) );
	//Image slider
	vc_map( array(
		'name'        => esc_html__( 'Image slider', 'sneaker' ),
		'description' => __( 'Upload images and links in Theme Options', 'sneaker' ),
		'base'        => 'image_slider',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'sneaker'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of rows', 'sneaker' ),
				'param_name' => 'rows',
				'value'      => array(
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
				),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Number of columns (screen: over 1201px)', 'sneaker' ),
				'param_name' => 'items_1201up',
				'value'      => esc_html__( '4', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Number of columns (screen: 992px - 1199px)', 'sneaker' ),
				'param_name' => 'items_992_1199',
				'value'      => esc_html__( '4', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Number of columns (screen: 768px - 991px)', 'sneaker' ),
				'param_name' => 'items_768_991',
				'value'      => esc_html__( '3', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Number of columns (screen: 640px - 767px)', 'sneaker' ),
				'param_name' => 'items_640_767',
				'value'      => esc_html__( '2', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Number of columns (screen: 480px - 639px)', 'sneaker' ),
				'param_name' => 'items_480_639',
				'value'      => esc_html__( '2', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Number of columns (screen: under 479px)', 'sneaker' ),
				'param_name' => 'items_0_479',
				'value'      => esc_html__( '1', 'sneaker' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Navigation', 'sneaker' ),
				'param_name' => 'navigation',
				'value'      => array(
					__( 'Yes', 'sneaker' ) => true,
					__( 'No', 'sneaker' )  => false,
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Pagination', 'sneaker' ),
				'param_name' => 'pagination',
				'value'      => array(
					__( 'No', 'sneaker' )  => false,
					__( 'Yes', 'sneaker' ) => true,
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Item Margin (unit: pixel)', 'sneaker' ),
				'param_name' => 'item_margin',
				'value'      => 30,
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Slider speed number (unit: second)', 'sneaker' ),
				'param_name' => 'speed',
				'value'      => '500',
			),
			array(
				'type'       => 'checkbox',
				'value'      => true,
				'heading'    => __( 'Slider loop', 'sneaker' ),
				'param_name' => 'loop',
			),
			array(
				'type'       => 'checkbox',
				'value'      => true,
				'heading'    => __( 'Slider Auto', 'sneaker' ),
				'param_name' => 'auto',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'sneaker' ),
				'param_name' => 'style',
				'value'      => array(
					__( 'Style 1', 'sneaker' )  => 'style1',
				),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Navigation style', 'sneaker' ),
				'param_name'  => 'navigation_style',
				'value'       => array(
					__( 'Navigation top-right', 'sneaker' )          => 'navigation-style1',
					__( 'Navigation center horizontal', 'sneaker' )  => 'navigation-style2',
				),
			),
		),
	) );
	//Brand logos
	vc_map( array(
		'name'        => esc_html__( 'Brand Logos', 'sneaker' ),
		'description' => __( 'Upload images and links in Theme Options', 'sneaker' ),
		'base'        => 'ourbrands',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'sneaker'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of rows', 'sneaker' ),
				'param_name' => 'rows',
				'value'      => array(
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
				),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Number of columns (screen: over 1201px)', 'sneaker' ),
				'param_name' => 'items_1201up',
				'value'      => esc_html__( '5', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Number of columns (screen: 992px - 1199px)', 'sneaker' ),
				'param_name' => 'items_992_1199',
				'value'      => esc_html__( '5', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Number of columns (screen: 768px - 991px)', 'sneaker' ),
				'param_name' => 'items_768_991',
				'value'      => esc_html__( '4', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Number of columns (screen: 640px - 767px)', 'sneaker' ),
				'param_name' => 'items_640_767',
				'value'      => esc_html__( '3', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Number of columns (screen: 480px - 639px)', 'sneaker' ),
				'param_name' => 'items_480_639',
				'value'      => esc_html__( '2', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Number of columns (screen: under 479px)', 'sneaker' ),
				'param_name' => 'items_0_479',
				'value'      => esc_html__( '1', 'sneaker' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Navigation', 'sneaker' ),
				'param_name' => 'navigation',
				'value'      => array(
					__( 'Yes', 'sneaker' ) => true,
					__( 'No', 'sneaker' )  => false,
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Pagination', 'sneaker' ),
				'param_name' => 'pagination',
				'value'      => array(
					__( 'No', 'sneaker' )  => false,
					__( 'Yes', 'sneaker' ) => true,
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Item Margin (unit: pixel)', 'sneaker' ),
				'param_name' => 'item_margin',
				'value'      => 0,
			),
			array(
				'type'       => 'textfield',
				'heading'    =>  __( 'Slider speed number (unit: second)', 'sneaker' ),
				'param_name' => 'speed',
				'value'      => '500',
			),
			array(
				'type'       => 'checkbox',
				'value'      => true,
				'heading'    => __( 'Slider loop', 'sneaker' ),
				'param_name' => 'loop',
			),
			array(
				'type'       => 'checkbox',
				'value'      => true,
				'heading'    => __( 'Slider Auto', 'sneaker' ),
				'param_name' => 'auto',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'sneaker' ),
				'param_name' => 'style',
				'value'      => array(
					__( 'Style 1', 'sneaker' )       => 'style1',
				),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Navigation style', 'sneaker' ),
				'param_name'  => 'navigation_style',
				'value'       => array(
					__( 'Navigation top-right', 'sneaker' )          => 'navigation-style1',
					__( 'Navigation center horizontal', 'sneaker' )  => 'navigation-style2',
				),
			),
		),
	) );
	//Latest posts
	vc_map( array(
		'name'        => esc_html__( 'Latest posts', 'sneaker' ),
		'description' => __( 'List posts', 'sneaker' ),
		'base'        => 'latestposts',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'sneaker'),
		"icon"        => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of posts', 'sneaker' ),
				'param_name' => 'posts_per_page',
				'value'      => esc_html__( '10', 'sneaker' ),
			),
			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'class'       => '',
				'heading'     => esc_html__( 'Category', 'sneaker' ),
				'param_name'  => 'category',
				'value'       => esc_html__( '0', 'sneaker' ),
				'description' => esc_html__( 'Slug of the category (example: slug-1, slug-2). Default is 0 : show all posts', 'sneaker' ),
			),
			array(
				'type'       => 'dropdown',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Image scale', 'sneaker' ),
				'param_name' => 'image',
				'value'      => array(
					'Wide'	=> 'wide',
					'Square'=> 'square',
				),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Excerpt length', 'sneaker' ),
				'param_name' => 'length',
				'value'      => esc_html__( '20', 'sneaker' ),
			),
			array(
				'type'       => 'dropdown',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of columns', 'sneaker' ),
				'param_name' => 'colsnumber',
				'value'      => array(
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
				),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Style', 'sneaker' ),
				'param_name'  => 'style',
				'value'       => array(
					__( 'Style 1', 'sneaker' )           => 'style1',
					__( 'Style 2 (footer)', 'sneaker' )  => 'style2',
				),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => __( 'Enable slider', 'sneaker' ),
				'param_name'  => 'enable_slider',
				'value'       => true,
				'save_always' => true, 
				'group'       => __( 'Slider Options', 'sneaker' ),
			),
			array(
				'type'       => 'dropdown',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of rows', 'sneaker' ),
				'param_name' => 'rowsnumber',
				'group'      => __( 'Slider Options', 'sneaker' ),
				'value'      => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
					),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Number of columns (screen: 992px - 1199px)', 'sneaker' ),
				'param_name' => 'items_992_1199',
				'value'      => esc_html__( '3', 'sneaker' ),
				'group'      => __( 'Slider Options', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Number of columns (screen: 768px - 991px)', 'sneaker' ),
				'param_name' => 'items_768_991',
				'value'      => esc_html__( '3', 'sneaker' ),
				'group'      => __( 'Slider Options', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Number of columns (screen: 640px - 767px)', 'sneaker' ),
				'param_name' => 'items_640_767',
				'value'      => esc_html__( '2', 'sneaker' ),
				'group'      => __( 'Slider Options', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Number of columns (screen: 480px - 639px)', 'sneaker' ),
				'param_name' => 'items_480_639',
				'value'      => esc_html__( '2', 'sneaker' ),
				'group'      => __( 'Slider Options', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => __( 'Number of columns (screen: under 479px)', 'sneaker' ),
				'param_name' => 'items_0_479',
				'value'      => esc_html__( '1', 'sneaker' ),
				'group'      => __( 'Slider Options', 'sneaker' ),
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
					__( 'Navigation center horizontal', 'sneaker' )  => 'navigation-style1',
					__( 'Navigation top-right', 'sneaker' )          => 'navigation-style2',
				),
			),
		),
	) );
	//Testimonials
	vc_map( array(
		'name'        => esc_html__( 'Testimonials', 'sneaker' ),
		'description' => __( 'Testimonial slider', 'sneaker' ),
		'base'        => 'woothemes_testimonials',
		'class'       => '',
		'category'    => esc_html__( 'Theme', 'sneaker'),
		"icon"     	  => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'      => array(
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number of testimonial', 'sneaker' ),
				'param_name' => 'limit',
				'value'      => esc_html__( '10', 'sneaker' ),
			),
			array(
				'type'       => 'dropdown',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Display Author', 'sneaker' ),
				'param_name' => 'display_author',
				'value'      => array(
					'Yes'	=> 'true',
					'No'	=> 'false',
				),
			),
			array(
				'type'       => 'dropdown',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Display Avatar', 'sneaker' ),
				'param_name' => 'display_avatar',
				'value'      => array(
					'Yes'=> 'true',
					'No' => 'false',
				),
			),
			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'class'       => '',
				'heading'     => esc_html__( 'Avatar image size', 'sneaker' ),
				'param_name'  => 'size',
				'value'       => '150',
				'description' => esc_html__( 'Avatar image size in pixels. Default is 150', 'sneaker' ),
			),
			array(
				'type'       => 'dropdown',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Display URL', 'sneaker' ),
				'param_name' => 'display_url',
				'value'      => array(
					'Yes'	=> 'true',
					'No'	=> 'false',
				),
			),
			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'class'       => '',
				'heading'     => esc_html__( 'Category', 'sneaker' ),
				'param_name'  => 'category',
				'value'       => esc_html__( '0', 'sneaker' ),
				'description' => esc_html__( 'Slug of the category. Default is 0 : show all testimonials', 'sneaker' ),
			),
		),
	) );
	//Counter
	vc_map( array(
		'name'     => esc_html__( 'Counter', 'sneaker' ),
		'description' => __( 'Counter', 'sneaker' ),
		'base'     => 'sneaker_counter',
		'class'    => '',
		'category' => esc_html__( 'Theme', 'sneaker'),
		"icon"     => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'   => array(
			array(
				'type'        => 'attach_image',
				'holder'      => 'div',
				'class'       => '',
				'heading'     => esc_html__( 'Image icon', 'sneaker' ),
				'param_name'  => 'image',
				'value'       => '',
				'description' => esc_html__( 'Upload icon image', 'sneaker' ),
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Number', 'sneaker' ),
				'param_name' => 'number',
				'value'      => '',
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Text', 'sneaker' ),
				'param_name' => 'text',
				'value'      => '',
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Style', 'sneaker' ),
				'param_name'  => 'style',
				'value'       => array(
					__( 'Style 1', 'sneaker' )   => 'style1',
				),
			),
		),
	) );
	//Heading title
	vc_map( array(
		'name'     => esc_html__( 'Heading Title', 'sneaker' ),
		'description' => __( 'Heading Title', 'sneaker' ),
		'base'     => 'roadthemes_title',
		'class'    => '',
		'category' => esc_html__( 'Theme', 'sneaker'),
		"icon"     => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'   => array(
			array(
				'type'       => 'textarea',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Heading title element', 'sneaker' ),
				'param_name' => 'heading_title',
				'value'      => 'Title',
			),
			array(
				'type'       => 'textarea',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'Heading sub-title element', 'sneaker' ),
				'param_name' => 'sub_heading_title',
				'value'      => '',
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Style', 'sneaker' ),
				'param_name'  => 'style',
				'value'       => array(
					__( 'Style 1 (Default)', 'sneaker' )    => 'style1',
					__( 'Style 2', 'sneaker' )              => 'style2',
					__( 'Style 3 (Footer)', 'sneaker' )     => 'style3',
				),
			),
		),
	) );
	//Countdown
	vc_map( array(
		'name'     => esc_html__( 'Countdown', 'sneaker' ),
		'description' => __( 'Countdown', 'sneaker' ),
		'base'     => 'roadthemes_countdown',
		'class'    => '',
		'category' => esc_html__( 'Theme', 'sneaker'),
		"icon"     => get_template_directory_uri() . "/images/road-icon.jpg",
		'params'   => array(
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'End date (day)', 'sneaker' ),
				'param_name' => 'countdown_day',
				'value'      => '1',
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'End date (month)', 'sneaker' ),
				'param_name' => 'countdown_month',
				'value'      => '1',
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'class'      => '',
				'heading'    => esc_html__( 'End date (year)', 'sneaker' ),
				'param_name' => 'countdown_year',
				'value'      => '2020',
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Style', 'sneaker' ),
				'param_name'  => 'style',
				'value'       => array(
					__( 'Style 1', 'sneaker' )      => 'style1',
				),
			),
		),
	) );
}
?>