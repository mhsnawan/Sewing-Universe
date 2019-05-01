<?php
/**
 * Sneaker functions and definitions
 */
/**
* Require files
*/
	//TGM-Plugin-Activation
require_once( get_template_directory().'/class-tgm-plugin-activation.php' );
	//Init the Redux Framework
if ( class_exists( 'ReduxFramework' ) && !isset( $redux_demo ) && file_exists( get_template_directory().'/theme-config.php' ) ) {
	require_once( get_template_directory().'/theme-config.php' );
}
	// Theme files
if ( !class_exists( 'roadthemes_widgets' ) && file_exists( get_template_directory().'/include/roadthemeswidgets.php' ) ) {
	require_once( get_template_directory().'/include/roadthemeswidgets.php' );
}
if ( file_exists( get_template_directory().'/include/wooajax.php' ) ) {
	require_once( get_template_directory().'/include/wooajax.php' );
}
if ( file_exists( get_template_directory().'/include/map_shortcodes.php' ) ) {
	require_once( get_template_directory().'/include/map_shortcodes.php' );
}
if ( file_exists( get_template_directory().'/include/shortcodes.php' ) ) {
	require_once( get_template_directory().'/include/shortcodes.php' );
}
Class Sneaker_Class {
	/**
	* Global values
	*/
	static function sneaker_post_odd_event(){
		global $wp_session;
		if(!isset($wp_session["sneaker_postcount"])){
			$wp_session["sneaker_postcount"] = 0;
		}
		$wp_session["sneaker_postcount"] = 1 - $wp_session["sneaker_postcount"];
		return $wp_session["sneaker_postcount"];
	}
	static function sneaker_post_thumbnail_size($size){
		global $wp_session;
		if($size!=''){
			$wp_session["sneaker_postthumb"] = $size;
		}
		return $wp_session["sneaker_postthumb"];
	}
	static function sneaker_shop_class($class){
		global $wp_session;
		if($class!=''){
			$wp_session["sneaker_shopclass"] = $class;
		}
		return $wp_session["sneaker_shopclass"];
	}
	static function sneaker_show_view_mode(){
		$sneaker_opt = get_option( 'sneaker_opt' );
		$sneaker_viewmode = 'grid-view'; //default value
		if(isset($sneaker_opt['default_view'])) {
			$sneaker_viewmode = $sneaker_opt['default_view'];
		}
		if(isset($_GET['view']) && $_GET['view']!=''){
			$sneaker_viewmode = $_GET['view'];
		}
		return $sneaker_viewmode;
	}
	static function sneaker_shortcode_products_count(){
		global $wp_session;
		$sneaker_productsfound = 0;
		if(isset($wp_session["sneaker_productsfound"])){
			$sneaker_productsfound = $wp_session["sneaker_productsfound"];
		}
		return $sneaker_productsfound;
	}
	/**
	* Constructor
	*/
	function __construct() {
		// Register action/filter callbacks
			//WooCommerce - action/filter
		add_theme_support( 'woocommerce' );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
		add_filter( 'get_product_search_form', array($this, 'sneaker_woo_search_form'));
		add_filter( 'woocommerce_shortcode_products_query', array($this, 'sneaker_woocommerce_shortcode_count'));
		add_action( 'woocommerce_share', array($this, 'sneaker_woocommerce_social_share'), 35 );
		add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
		    return array(
		        'width'  => 150,
		        'height' => 150,
		        'crop'   => 0,
		    );
		} );
			//move message to top
		remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
		add_action( 'woocommerce_show_message', 'wc_print_notices', 10 );
			//remove add to cart button after item
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
			// remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
			//Single product organize
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 15 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			//remove cart total under cross sell
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
		add_action( 'cart_totals', 'woocommerce_cart_totals', 5 );
			//Theme actions
		add_action( 'after_setup_theme', array($this, 'sneaker_setup'));
		add_action( 'tgmpa_register', array($this, 'sneaker_register_required_plugins')); 
		add_action( 'widgets_init', array($this, 'sneaker_override_woocommerce_widgets'), 15 );
		add_action( 'wp_enqueue_scripts', array($this, 'sneaker_scripts_styles') );
		add_action( 'wp_head', array($this, 'sneaker_custom_code_header'));
		add_action( 'widgets_init', array($this, 'sneaker_widgets_init'));
		add_action( 'save_post', array($this, 'sneaker_save_meta_box_data'));
		add_action('comment_form_before_fields', array($this, 'sneaker_before_comment_fields'));
		add_action('comment_form_after_fields', array($this, 'sneaker_after_comment_fields'));
		add_action( 'customize_register', array($this, 'sneaker_customize_register'));
		add_action( 'customize_preview_init', array($this, 'sneaker_customize_preview_js'));
		add_action('admin_enqueue_scripts', array($this, 'sneaker_admin_style'));
			//Theme filters
		add_filter( 'loop_shop_per_page', array($this, 'sneaker_woo_change_per_page'), 20 );
		add_filter( 'woocommerce_output_related_products_args', array($this, 'sneaker_woo_related_products_limit'));
		add_filter( 'get_search_form', array($this, 'sneaker_search_form'));
		add_filter('excerpt_more', array($this, 'sneaker_new_excerpt_more'));
		add_filter( 'excerpt_length', array($this, 'sneaker_change_excerpt_length'), 999 );
		add_filter('wp_nav_menu_objects', array($this, 'sneaker_first_and_last_menu_class'));
		add_filter( 'wp_page_menu_args', array($this, 'sneaker_page_menu_args'));
		add_filter('dynamic_sidebar_params', array($this, 'sneaker_widget_first_last_class'));
		add_filter('dynamic_sidebar_params', array($this, 'sneaker_mega_menu_widget_change'));
		add_filter( 'dynamic_sidebar_params', array($this, 'sneaker_put_widget_content'));
		add_filter( 'the_content_more_link', array($this, 'sneaker_modify_read_more_link'));
		//Adding theme support
		if ( ! isset( $content_width ) ) {
			$content_width = 625;
		}
	}
	/**
	* Filter callbacks
	* ----------------
	*/
	// read more link 
	function sneaker_modify_read_more_link() {
		$sneaker_opt = get_option( 'sneaker_opt' );
		if(isset($sneaker_opt['readmore_text']) && $sneaker_opt['readmore_text'] != ''){
			$readmore_text = esc_html($sneaker_opt['readmore_text']);
		} else { 
			$readmore_text = esc_html_e('Read more','sneaker');
		};
	    // return '<a class="more-link" href="' . get_permalink() . '">Your Read More Link Text</a>';
	    return '<div><a class="readmore" href="'. get_permalink().' ">'.$readmore_text.'</a></div>';
	}
	// Change products per page
	function sneaker_woo_change_per_page() {
		$sneaker_opt = get_option( 'sneaker_opt' );
		return $sneaker_opt['product_per_page'];
	}
	//Change number of related products on product page. Set your own value for 'posts_per_page'
	function sneaker_woo_related_products_limit( $args ) {
		global $product;
		$sneaker_opt = get_option( 'sneaker_opt' );
		$args['posts_per_page'] = $sneaker_opt['related_amount'];
		return $args;
	}
	// Count number of products from shortcode
	function sneaker_woocommerce_shortcode_count( $args ) {
		$sneaker_productsfound = new WP_Query($args);
		$sneaker_productsfound = $sneaker_productsfound->post_count;
		global $wp_session;
		$wp_session["sneaker_productsfound"] = $sneaker_productsfound;
		return $args;
	}
	//Change search form
	function sneaker_search_form( $form ) {
		if(get_search_query()!=''){
			$search_str = get_search_query();
		} else {
			$search_str = esc_html__( 'Search... ', 'sneaker' );
		}
		$form = '<form role="search" method="get" class="searchform blogsearchform" action="' . esc_url(home_url( '/' ) ). '" >
		<div class="form-input">
			<input type="text" placeholder="'.esc_attr($search_str).'" name="s" class="input_text ws">
			<button class="button-search searchsubmit blogsearchsubmit" type="submit">' . esc_html__('Search', 'sneaker') . '</button>
			<input type="hidden" name="post_type" value="post" />
			</div>
		</form>';
		return $form;
	}
	//Change woocommerce search form
	function sneaker_woo_search_form( $form ) {
		global $wpdb;
		if(get_search_query()!=''){
			$search_str = get_search_query();
		} else {
			$search_str = esc_html__( 'Search product...', 'sneaker' );
		}
		$form = '<form role="search" method="get" class="searchform productsearchform" action="'.esc_url( home_url( '/'  ) ).'">';
			$form .= '<div class="form-input">';
				$form .= '<input type="text" placeholder="'.esc_attr($search_str).'" name="s" class="ws"/>';
				$form .= '<button class="button-search searchsubmit productsearchsubmit" type="submit">' . esc_html__('Search', 'sneaker') . '</button>';
				$form .= '<input type="hidden" name="post_type" value="product" />';
			$form .= '</div>';
		$form .= '</form>';
		return $form;
	}
	// Replaces the excerpt "more" text by a link
	function sneaker_new_excerpt_more($more) {
		return '';
	}
	//Change excerpt length
	function sneaker_change_excerpt_length( $length ) {
		$sneaker_opt = get_option( 'sneaker_opt' );
		if(isset($sneaker_opt['excerpt_length'])){
			return $sneaker_opt['excerpt_length'];
		}
		return 50;
	}
	//Add 'first, last' class to menu
	function sneaker_first_and_last_menu_class($items) {
		$items[1]->classes[] = 'first';
		$items[count($items)]->classes[] = 'last';
		return $items;
	}
	/**
	 * Filter the page menu arguments.
	 *
	 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
	 *
	 * @since Sneaker 1.0
	 */
	function sneaker_page_menu_args( $args ) {
		if ( ! isset( $args['show_home'] ) )
			$args['show_home'] = true;
		return $args;
	}
	//Add first, last class to widgets
	function sneaker_widget_first_last_class($params) {
		global $my_widget_num;
		$class = '';
		$this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
		$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets	
		if(!$my_widget_num) {// If the counter array doesn't exist, create it
			$my_widget_num = array();
		}
		if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
			return $params; // No widgets in this sidebar... bail early.
		}
		if(isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
			$my_widget_num[$this_id] ++;
		} else { // If not, create it starting with 1
			$my_widget_num[$this_id] = 1;
		}
		if($my_widget_num[$this_id] == 1) { // If this is the first widget
			$class .= ' widget-first ';
		} elseif($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
			$class .= ' widget-last ';
		}
		$params[0]['before_widget'] = str_replace('first_last', ' '.$class.' ', $params[0]['before_widget']);
		return $params;
	}
	//Change mega menu widget from div to li tag
	function sneaker_mega_menu_widget_change($params) {
		$sidebar_id = $params[0]['id'];
		$pos = strpos($sidebar_id, '_menu_widgets_area_');
		if ( !$pos == false ) {
			$params[0]['before_widget'] = '<li class="widget_mega_menu">'.$params[0]['before_widget'];
			$params[0]['after_widget'] = $params[0]['after_widget'].'</li>';
		}
		return $params;
	}
	// Push sidebar widget content into a div
	function sneaker_put_widget_content( $params ) {
		global $wp_registered_widgets;
		if( $params[0]['id']=='sidebar-category' ){
			$settings_getter = $wp_registered_widgets[ $params[0]['widget_id'] ]['callback'][0];
			$settings = $settings_getter->get_settings();
			$settings = $settings[ $params[1]['number'] ];
			if($params[0]['widget_name']=="Text" && isset($settings['title']) && $settings['text']=="") { // if text widget and no content => don't push content
				return $params;
			}
			if( isset($settings['title']) && $settings['title']!='' ){
				$params[0][ 'after_title' ] .= '<div class="widget_content">';
				$params[0][ 'after_widget' ] = '</div>'.$params[0][ 'after_widget' ];
			} else {
				$params[0][ 'before_widget' ] .= '<div class="widget_content">';
				$params[0][ 'after_widget' ] = '</div>'.$params[0][ 'after_widget' ];
			}
		}
		return $params;
	}
	/**
	* Action hooks
	* ----------------
	*/
	/**
	 * Sneaker setup.
	 *
	 * Sets up theme defaults and registers the various WordPress features that
	 * Sneaker supports.
	 *
	 * @uses load_theme_textdomain() For translation/localization support.
	 * @uses add_editor_style() To add a Visual Editor stylesheet.
	 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
	 * 	custom background, and post formats.
	 * @uses register_nav_menu() To add support for navigation menus.
	 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
	 *
	 * @since Sneaker 1.0
	 */
	function sneaker_setup() {
		/*
		 * Makes Sneaker available for translation.
		 *
		 * Translations can be added to the /languages/ directory.
		 * If you're building a theme based on Sneaker, use a find and replace
		 * to change 'sneaker' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'sneaker', get_template_directory() . '/languages' );
		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();
		// Adds RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );
		// This theme supports a variety of post formats.
		add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'audio' ) );
		// Register menus
		register_nav_menu( 'primary', esc_html__( 'Primary Menu', 'sneaker' ) );
		// register_nav_menu( 'topmenu', esc_html__( 'Top Menu', 'sneaker' ) );
		register_nav_menu( 'mobilemenu', esc_html__( 'Mobile Menu', 'sneaker' ) );
		register_nav_menu( 'categories', esc_html__( 'Categories Menu', 'sneaker' ) );
		/*
		 * This theme supports custom background color and image,
		 * and here we also set up the default background color.
		 */
		add_theme_support( 'custom-background', array(
			'default-color' => 'e6e6e6',
		) );
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
		// This theme uses a custom image size for featured images, displayed on "standard" posts.
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1400, 700 ); // Unlimited height, soft crop
		add_image_size( 'sneaker-category-thumb', 1400, 700, true ); // (cropped) (post carousel)
		add_image_size( 'sneaker-post-thumb', 800, 420, true ); // (cropped) (blog sidebar)
		add_image_size( 'sneaker-post-thumbwide', 1400, 700, true ); // (cropped) (blog large img)
	}
	//Override woocommerce widgets
	function sneaker_override_woocommerce_widgets() {
		//Show mini cart on all pages
		if ( class_exists( 'WC_Widget_Cart' ) ) {
			unregister_widget( 'WC_Widget_Cart' ); 
			include_once( get_template_directory().'/woocommerce/class-wc-widget-cart.php' );
			register_widget( 'Custom_WC_Widget_Cart' );
		}
	}
	//Display social sharing on product page
	function sneaker_woocommerce_social_share(){
		$sneaker_opt = get_option( 'sneaker_opt' );
	?>
		<?php if (isset($sneaker_opt['share_code']) && $sneaker_opt['share_code']!='') { ?>
			<div class="share_buttons">
				<?php 
					echo wp_kses($sneaker_opt['share_code'], array(
						'div' => array(
							'class' => array()
						),
						'span' => array(
							'class' => array(),
							'displayText' => array()
						),
					));
				?>
			</div>
		<?php } ?>
	<?php
	}
	/**
	 * Enqueue scripts and styles for front-end.
	 *
	 * @since Sneaker 1.0
	 */
	function sneaker_scripts_styles() {
		global $wp_styles, $wp_scripts;
		$sneaker_opt = get_option( 'sneaker_opt' );
		/*
		 * Adds JavaScript to pages with the comment form to support
		 * sites with threaded comments (when in use).
		*/
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
		// Add Bootstrap JavaScript
		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '4.1.1', true );
		// Add Owl files
		wp_enqueue_script( 'owl', get_template_directory_uri() . '/js/owl.carousel.js', array('jquery'), '2.3.4', true );
		wp_enqueue_style( 'owl', get_template_directory_uri() . '/css/owl.carousel.min.css', array(), '2.3.4' );
		// Add Chosen js files
		wp_enqueue_script( 'chosen', get_template_directory_uri() . '/js/chosen/chosen.jquery.min.js', array('jquery'), '1.3.0', true );
		wp_enqueue_script( 'chosenproto', get_template_directory_uri() . '/js/chosen/chosen.proto.min.js', array('jquery'), '1.3.0', true );
		wp_enqueue_style( 'chosen', get_template_directory_uri() . '/js/chosen/chosen.min.css', array(), '1.3.0' );
		// Add parallax script files
		// Add Fancybox
		wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.pack.js', array('jquery'), '2.1.5', true );
		wp_enqueue_script( 'fancybox-buttons', get_template_directory_uri().'/js/fancybox/helpers/jquery.fancybox-buttons.js', array('jquery'), '1.0.5', true );
		wp_enqueue_script( 'fancybox-media', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-media.js', array('jquery'), '1.0.6', true );
		wp_enqueue_script( 'fancybox-thumbs', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-thumbs.js', array('jquery'), '1.0.7', true );
		wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.css', array(), '2.1.5' );
		wp_enqueue_style( 'fancybox-buttons', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-buttons.css', array(), '1.0.5' );
		wp_enqueue_style( 'fancybox-thumbs', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-thumbs.css', array(), '1.0.7' );
		//Superfish
		wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish/superfish.min.js', array('jquery'), '1.3.15', true );
		//Add Shuffle js
		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.min.js', array('jquery'), '2.6.2', true );
		wp_enqueue_script( 'shuffle', get_template_directory_uri() . '/js/jquery.shuffle.min.js', array('jquery'), '3.0.0', true );
		//Add mousewheel
		wp_enqueue_script( 'mousewheel', get_template_directory_uri() . '/js/jquery.mousewheel.min.js', array('jquery'), '3.1.12', true );
		// Add jQuery countdown file
		wp_enqueue_script( 'countdown', get_template_directory_uri() . '/js/jquery.countdown.min.js', array('jquery'), '2.0.4', true );
		// Add jQuery counter files
		wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array('jquery'), '1.0', true );
		wp_enqueue_script( 'counterup', get_template_directory_uri() . '/js/jquery.counterup.min.js', array('jquery'), '1.0', true );
		// Add variables.js file
		wp_enqueue_script( 'variables', get_template_directory_uri() . '/js/variables.js', array('jquery'), '20140826', true );
		wp_enqueue_script( 'sneaker', get_template_directory_uri() . '/js/theme-sneaker.js', array('jquery'), '20140826', true );
		$font_url = $this->sneaker_get_font_url();
		if ( ! empty( $font_url ) )
			wp_enqueue_style( 'sneaker-fonts', esc_url_raw( $font_url ), array(), null );
		// Loads our main stylesheet.
		wp_enqueue_style( 'sneaker-style', get_stylesheet_uri() );
		// Mega Main Menu
		wp_enqueue_style( 'megamenu', get_template_directory_uri() . '/css/megamenu_style.css', array(), '2.0.4' );
		// Load fontawesome css
		wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.7.0' );
		// Load Ionicons css
		wp_enqueue_style( 'ionicons', get_template_directory_uri() . '/css/ionicons.min.css', array(), null );
		// Load bootstrap css
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.1.1' );
		// Compile Less to CSS
		$previewpreset = (isset($_REQUEST['preset']) ? $_REQUEST['preset'] : null);
			//get preset from url (only for demo/preview)
		if($previewpreset){
			$_SESSION["preset"] = $previewpreset;
		}
		$presetopt = 1; /*change default preset 1 and 209-binhthuongg*/
		if(!isset($_SESSION["preset"])){
			$_SESSION["preset"] = 1;
		}
		if($_SESSION["preset"] != 1) {
			$presetopt = $_SESSION["preset"];
		} else { /* if no preset varialbe found in url, use from theme options */
			if(isset($sneaker_opt['preset_option'])){
				$presetopt = $sneaker_opt['preset_option'];
			}
		}
		if(!isset($presetopt)) $presetopt = 1; /* in case first time install theme, no options found */
		if(isset($sneaker_opt['enable_less'])){
			if($sneaker_opt['enable_less']){
				$themevariables = array(
					'body_font'=> $sneaker_opt['bodyfont']['font-family'],
					'text_color'=> $sneaker_opt['bodyfont']['color'],
					'text_selected_bg' => $sneaker_opt['text_selected_bg'],
					'text_selected_color' => $sneaker_opt['text_selected_color'],
					'text_size'=> $sneaker_opt['bodyfont']['font-size'],
					'border_color'=> $sneaker_opt['border_color']['border-color'],
					'page_content_background' => $sneaker_opt['page_content_background']['background-color'],
					'row_space' => $sneaker_opt['row_space'],
					'heading_font'=> $sneaker_opt['headingfont']['font-family'],
					'heading_color'=> $sneaker_opt['headingfont']['color'],
					'heading_font_weight'=> $sneaker_opt['headingfont']['font-weight'],
					'dropdown_font'=> $sneaker_opt['dropdownfont']['font-family'],
					'dropdown_color'=> $sneaker_opt['dropdownfont']['color'],
					'dropdown_font_size'=> $sneaker_opt['dropdownfont']['font-size'],
					'dropdown_font_weight'=> $sneaker_opt['dropdownfont']['font-weight'],
					'dropdown_bg' => $sneaker_opt['dropdown_bg'],
					'menu_font'=> $sneaker_opt['menufont']['font-family'],
					'menu_color'=> $sneaker_opt['menufont']['color'],
					'menu_font_size'=> $sneaker_opt['menufont']['font-size'],
					'menu_font_weight'=> $sneaker_opt['menufont']['font-weight'],
					'sub_menu_font'=> $sneaker_opt['submenufont']['font-family'],
					'sub_menu_color'=> $sneaker_opt['submenufont']['color'],
					'sub_menu_font_size'=> $sneaker_opt['submenufont']['font-size'],
					'sub_menu_font_weight'=> $sneaker_opt['submenufont']['font-weight'],
					'sub_menu_bg' => $sneaker_opt['sub_menu_bg'],
					'categories_font'=> $sneaker_opt['categoriesfont']['font-family'],
					'categories_font_size'=> $sneaker_opt['categoriesfont']['font-size'],
					'categories_font_weight'=> $sneaker_opt['categoriesfont']['font-weight'],
					'categories_color'=> $sneaker_opt['categoriesfont']['color'],
					'categories_menu_bg' => $sneaker_opt['categories_menu_bg'],
					'categories_sub_menu_font'=> $sneaker_opt['categoriessubmenufont']['font-family'],
					'categories_sub_menu_font_size'=> $sneaker_opt['categoriessubmenufont']['font-size'],
					'categories_sub_menu_font_weight'=> $sneaker_opt['categoriessubmenufont']['font-weight'],
					'categories_sub_menu_color'=> $sneaker_opt['categoriessubmenufont']['color'],
					'categories_sub_menu_bg' => $sneaker_opt['categories_sub_menu_bg'],
					'link_color' => $sneaker_opt['link_color']['regular'],
					'link_hover_color' => $sneaker_opt['link_color']['hover'],
					'link_active_color' => $sneaker_opt['link_color']['active'],
					'primary_color' => $sneaker_opt['primary_color'],
					'sale_color' => $sneaker_opt['sale_color'],
					'saletext_color' => $sneaker_opt['saletext_color'],
					'rate_color' => $sneaker_opt['rate_color'],
					'price_font'=> $sneaker_opt['pricefont']['font-family'],
					'price_color'=> $sneaker_opt['pricefont']['color'],
					'price_font_size'=> $sneaker_opt['pricefont']['font-size'],
					'price_font_weight'=> $sneaker_opt['pricefont']['font-weight'],
					'topbar_color' => $sneaker_opt['topbar_color'],
					'topbar_link_color' => $sneaker_opt['topbar_link_color']['regular'],
					'topbar_link_hover_color' => $sneaker_opt['topbar_link_color']['hover'],
					'topbar_link_active_color' => $sneaker_opt['topbar_link_color']['active'],
					'header_color' => $sneaker_opt['header_color'],
					'header_link_color' => $sneaker_opt['header_link_color']['regular'],
					'header_link_hover_color' => $sneaker_opt['header_link_color']['hover'],
					'header_link_active_color' => $sneaker_opt['header_link_color']['active'],
					'footer_color' => $sneaker_opt['footer_color'],
					'footer_link_color' => $sneaker_opt['footer_link_color']['regular'],
					'footer_link_hover_color' => $sneaker_opt['footer_link_color']['hover'],
					'footer_link_active_color' => $sneaker_opt['footer_link_color']['active'],
				);
				if(isset($sneaker_opt['header_sticky_bg']['rgba']) && $sneaker_opt['header_sticky_bg']['rgba']!="") {
					$themevariables['header_sticky_bg'] = $sneaker_opt['header_sticky_bg']['rgba'];
				} else {
					$themevariables['header_sticky_bg'] = 'rgba(255, 255, 255, 0.95)';
				}
				if(isset($sneaker_opt['header_bg']['background-color']) && $sneaker_opt['header_bg']['background-color']!="") {
					$themevariables['header_bg'] = $sneaker_opt['header_bg']['background-color'];
				} else {
					$themevariables['header_bg'] = '#2f333a';
				}
				if(isset($sneaker_opt['footer_bg']['background-color']) && $sneaker_opt['footer_bg']['background-color']!="") {
					$themevariables['footer_bg'] = $sneaker_opt['footer_bg']['background-color'];
				} else {
					$themevariables['footer_bg'] = '#26292e';
				}
				switch ($presetopt) {
					case 2:
						$themevariables['menu_color'] = '#2f333a';
						$themevariables['header_sticky_bg'] = 'rgba(47, 51, 58, 0.95)';
					break;
					case 3:
						$themevariables['header_sticky_bg'] = 'rgba(47, 51, 58, 0.95)';
					break;
					case 4:
						$themevariables['header_sticky_bg'] = 'rgba(47, 51, 58, 0.95)';
					break;
				}
				if(function_exists('compileLessFile')){
					compileLessFile('theme.less', 'theme'.$presetopt.'.css', $themevariables);
				}
			}
		}
		// Load main theme css style files
		wp_enqueue_style( 'sneaker-theme', get_template_directory_uri() . '/css/theme'.$presetopt.'.css', array('bootstrap'), '1.0.0' );
		wp_enqueue_style( 'sneaker-custom', get_template_directory_uri() . '/css/opt_css.css', array('sneaker-theme'), '1.0.0' );
		if(function_exists('WP_Filesystem')){
			if ( ! WP_Filesystem() ) {
				$url = wp_nonce_url();
				request_filesystem_credentials($url, '', true, false, null);
			}
			global $wp_filesystem;
			//add custom css, sharing code to header
			if($wp_filesystem->exists(get_template_directory(). '/css/opt_css.css')){
				$customcss = $wp_filesystem->get_contents(get_template_directory(). '/css/opt_css.css');
				if(isset($sneaker_opt['custom_css']) && $customcss!=$sneaker_opt['custom_css']){ //if new update, write file content
					$wp_filesystem->put_contents(
						get_template_directory(). '/css/opt_css.css',
						$sneaker_opt['custom_css'],
						FS_CHMOD_FILE // predefined mode settings for WP files
					);
				}
			} else {
				$wp_filesystem->put_contents(
					get_template_directory(). '/css/opt_css.css',
					$sneaker_opt['custom_css'],
					FS_CHMOD_FILE // predefined mode settings for WP files
				);
			}
		}
		//add javascript variables
		ob_start(); ?>
		"use strict";
		var sneaker_brandnumber = <?php if(isset($sneaker_opt['brandnumber'])) { echo esc_js($sneaker_opt['brandnumber']); } else { echo '6'; } ?>,
			sneaker_brandscrollnumber = <?php if(isset($sneaker_opt['brandscrollnumber'])) { echo esc_js($sneaker_opt['brandscrollnumber']); } else { echo '2';} ?>,
			sneaker_brandpause = <?php if(isset($sneaker_opt['brandpause'])) { echo esc_js($sneaker_opt['brandpause']); } else { echo '3000'; } ?>,
			sneaker_brandanimate = <?php if(isset($sneaker_opt['brandanimate'])) { echo esc_js($sneaker_opt['brandanimate']); } else { echo '700';} ?>;
		var sneaker_brandscroll = false;
			<?php if(isset($sneaker_opt['brandscroll'])){ ?>
				sneaker_brandscroll = <?php echo esc_js($sneaker_opt['brandscroll'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		var sneaker_categoriesnumber = <?php if(isset($sneaker_opt['categoriesnumber'])) { echo esc_js($sneaker_opt['categoriesnumber']); } else { echo '6'; } ?>,
			sneaker_categoriesscrollnumber = <?php if(isset($sneaker_opt['categoriesscrollnumber'])) { echo esc_js($sneaker_opt['categoriesscrollnumber']); } else { echo '2';} ?>,
			sneaker_categoriespause = <?php if(isset($sneaker_opt['categoriespause'])) { echo esc_js($sneaker_opt['categoriespause']); } else { echo '3000'; } ?>,
			sneaker_categoriesanimate = <?php if(isset($sneaker_opt['categoriesanimate'])) { echo esc_js($sneaker_opt['categoriesanimate']); } else { echo '700';} ?>;
		var sneaker_categoriesscroll = 'false';
			<?php if(isset($sneaker_opt['categoriesscroll'])){ ?>
				sneaker_categoriesscroll = <?php echo esc_js($sneaker_opt['categoriesscroll'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		var sneaker_blogpause = <?php if(isset($sneaker_opt['blogpause'])) { echo esc_js($sneaker_opt['blogpause']); } else { echo '3000'; } ?>,
			sneaker_bloganimate = <?php if(isset($sneaker_opt['bloganimate'])) { echo esc_js($sneaker_opt['bloganimate']); } else { echo '700'; } ?>;
		var sneaker_blogscroll = false;
			<?php if(isset($sneaker_opt['blogscroll'])){ ?>
				sneaker_blogscroll = <?php echo esc_js($sneaker_opt['blogscroll'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		var sneaker_testipause = <?php if(isset($sneaker_opt['testipause'])) { echo esc_js($sneaker_opt['testipause']); } else { echo '3000'; } ?>,
			sneaker_testianimate = <?php if(isset($sneaker_opt['testianimate'])) { echo esc_js($sneaker_opt['testianimate']); } else { echo '700'; } ?>;
		var sneaker_testiscroll = false;
			<?php if(isset($sneaker_opt['testiscroll'])){ ?>
				sneaker_testiscroll = <?php echo esc_js($sneaker_opt['testiscroll'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		var sneaker_catenumber = <?php if(isset($sneaker_opt['catenumber'])) { echo esc_js($sneaker_opt['catenumber']); } else { echo '6'; } ?>,
			sneaker_catescrollnumber = <?php if(isset($sneaker_opt['catescrollnumber'])) { echo esc_js($sneaker_opt['catescrollnumber']); } else { echo '2';} ?>,
			sneaker_catepause = <?php if(isset($sneaker_opt['catepause'])) { echo esc_js($sneaker_opt['catepause']); } else { echo '3000'; } ?>,
			sneaker_cateanimate = <?php if(isset($sneaker_opt['cateanimate'])) { echo esc_js($sneaker_opt['cateanimate']); } else { echo '700';} ?>;
		var sneaker_catescroll = false;
			<?php if(isset($sneaker_opt['catescroll'])){ ?>
				sneaker_catescroll = <?php echo esc_js($sneaker_opt['catescroll'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		var sneaker_menu_number = <?php if(isset($sneaker_opt['categories_menu_items'])) { echo esc_js((int)$sneaker_opt['categories_menu_items']); } else { echo '9';} ?>;
		var sneaker_sticky_header = false;
			<?php if(isset($sneaker_opt['sticky_header'])){ ?>
				sneaker_sticky_header = <?php echo esc_js($sneaker_opt['sticky_header'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		jQuery(document).ready(function(){
			jQuery(".ws").on('focus', function(){
				if(jQuery(this).val()=="<?php esc_html__( 'Search product...', 'sneaker' );?>"){
					jQuery(this).val("");
				}
			});
			jQuery(".ws").on('focusout', function(){
				if(jQuery(this).val()==""){
					jQuery(this).val("<?php esc_html__( 'Search product...', 'sneaker' );?>");
				}
			});
			jQuery(".wsearchsubmit").on('click', function(){
				if(jQuery("#ws").val()=="<?php esc_html__( 'Search product...', 'sneaker' );?>" || jQuery("#ws").val()==""){
					jQuery("#ws").focus();
					return false;
				}
			});
			jQuery(".search_input").on('focus', function(){
				if(jQuery(this).val()=="<?php esc_html__( 'Search...', 'sneaker' );?>"){
					jQuery(this).val("");
				}
			});
			jQuery(".search_input").on('focusout', function(){
				if(jQuery(this).val()==""){
					jQuery(this).val("<?php esc_html__( 'Search...', 'sneaker' );?>");
				}
			});
			jQuery(".blogsearchsubmit").on('click', function(){
				if(jQuery("#search_input").val()=="<?php esc_html__( 'Search...', 'sneaker' );?>" || jQuery("#search_input").val()==""){
					jQuery("#search_input").focus();
					return false;
				}
			});
		});
		<?php
		$jsvars = ob_get_contents();
		ob_end_clean();
		if(function_exists('WP_Filesystem')){
			if($wp_filesystem->exists(get_template_directory(). '/js/variables.js')){
				$jsvariables = $wp_filesystem->get_contents(get_template_directory(). '/js/variables.js');
				if($jsvars!=$jsvariables){ //if new update, write file content
					$wp_filesystem->put_contents(
						get_template_directory(). '/js/variables.js',
						$jsvars,
						FS_CHMOD_FILE // predefined mode settings for WP files
					);
				}
			} else {
				$wp_filesystem->put_contents(
					get_template_directory(). '/js/variables.js',
					$jsvars,
					FS_CHMOD_FILE // predefined mode settings for WP files
				);
			}
		}
		//add css for footer, header templates
		$jscomposer_templates_args = array(
			'orderby'          => 'title',
			'order'            => 'ASC',
			'post_type'        => 'templatera',
			'post_status'      => 'publish',
			'posts_per_page'   => 30,
		);
		$jscomposer_templates = get_posts( $jscomposer_templates_args );
		if(count($jscomposer_templates) > 0) {
			foreach($jscomposer_templates as $jscomposer_template){
				if($jscomposer_template->post_title == $sneaker_opt['header_layout'] || $jscomposer_template->post_title == $sneaker_opt['footer_layout']){
					$jscomposer_template_css = get_post_meta ( $jscomposer_template->ID, '_wpb_shortcodes_custom_css', false );
					if(isset($jscomposer_template_css[0]))
					wp_add_inline_style( 'sneaker-custom', $jscomposer_template_css[0] );
				}
			}
		}
		//page width
		$sneaker_opt = get_option( 'sneaker_opt' );
		if(isset($sneaker_opt['box_layout_width'])){
			wp_add_inline_style( 'sneaker-custom', '.wrapper.box-layout {max-width: '.$sneaker_opt['box_layout_width'].'px;}' );
		}
	}
	//add sharing code to header
	function sneaker_custom_code_header() {
		global $sneaker_opt;
		if ( isset($sneaker_opt['share_head_code']) && $sneaker_opt['share_head_code']!='') {
			echo wp_kses($sneaker_opt['share_head_code'], array(
				'script' => array(
					'type' => array(),
					'src' => array(),
					'async' => array()
				),
			));
		}
	}
	/**
	 * Register sidebars.
	 *
	 * Registers our main widget area and the front page widget areas.
	 *
	 * @since Sneaker 1.0
	 */
	function sneaker_widgets_init() {
		$sneaker_opt = get_option( 'sneaker_opt' );
		register_sidebar( array(
			'name' => esc_html__( 'Blog Sidebar', 'sneaker' ),
			'id' => 'sidebar-1',
			'description' => esc_html__( 'Sidebar on blog page', 'sneaker' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>',
		) );
		register_sidebar( array(
			'name' => esc_html__( 'Shop Sidebar', 'sneaker' ),
			'id' => 'sidebar-shop',
			'description' => esc_html__( 'Sidebar on shop page (only sidebar shop layout)', 'sneaker' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>',
		) );
		register_sidebar( array(
			'name' => esc_html__( 'Single product Sidebar', 'sneaker' ),
			'id' => 'sidebar-single_product',
			'description' => esc_html__( 'Sidebar on product details page', 'sneaker' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>',
		) );
		register_sidebar( array(
			'name' => esc_html__( 'Pages Sidebar', 'sneaker' ),
			'id' => 'sidebar-page',
			'description' => esc_html__( 'Sidebar on content pages', 'sneaker' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>',
		) );
		if(isset($sneaker_opt['custom-sidebars']) && $sneaker_opt['custom-sidebars']!=""){
			foreach($sneaker_opt['custom-sidebars'] as $sidebar){
				$sidebar_id = str_replace(' ', '-', strtolower($sidebar));
				if($sidebar_id!='') {
					register_sidebar( array(
						'name' => $sidebar,
						'id' => $sidebar_id,
						'description' => $sidebar,
						'before_widget' => '<aside id="%1$s" class="widget %2$s">',
						'after_widget' => '</aside>',
						'before_title' => '<h3 class="widget-title"><span>',
						'after_title' => '</span></h3>',
					) );
				}
			}
		}
	}
	static function sneaker_meta_box_callback( $post ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'sneaker_meta_box', 'sneaker_meta_box_nonce' );
		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		$value = get_post_meta( $post->ID, '_sneaker_post_intro', true );
		echo '<label for="sneaker_post_intro">';
		esc_html_e( 'This content will be used to replace the featured image, use shortcode here', 'sneaker' );
		echo '</label><br />';
		wp_editor( $value, 'sneaker_post_intro', $settings = array() );
	}
	static function sneaker_custom_sidebar_callback( $post ) {
		global $wp_registered_sidebars;
		$sneaker_opt = get_option( 'sneaker_opt' );
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'sneaker_meta_box', 'sneaker_meta_box_nonce' );
		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		//show sidebar dropdown select
		$csidebar = get_post_meta( $post->ID, '_sneaker_custom_sidebar', true );
		echo '<label for="sneaker_custom_sidebar">';
		esc_html_e( 'Select a custom sidebar for this post/page', 'sneaker' );
		echo '</label><br />';
		echo '<select id="sneaker_custom_sidebar" name="sneaker_custom_sidebar">';
			echo '<option value="">'.esc_html__('- None -', 'sneaker').'</option>';
			foreach($wp_registered_sidebars as $sidebar){
				$sidebar_id = $sidebar['id'];
				if($csidebar == $sidebar_id){
					echo '<option value="'.$sidebar_id.'" selected="selected">'.$sidebar['name'].'</option>';
				} else {
					echo '<option value="'.$sidebar_id.'">'.$sidebar['name'].'</option>';
				}
			}
		echo '</select><br />';
		//show custom sidebar position
		$csidebarpos = get_post_meta( $post->ID, '_sneaker_custom_sidebar_pos', true );
		echo '<label for="sneaker_custom_sidebar_pos">';
		esc_html_e( 'Sidebar position', 'sneaker' );
		echo '</label><br />';
		echo '<select id="sneaker_custom_sidebar_pos" name="sneaker_custom_sidebar_pos">'; ?>
			<option value="left" <?php if($csidebarpos == 'left') {echo 'selected="selected"';}?>><?php echo esc_html__('Left', 'sneaker'); ?></option>
			<option value="right" <?php if($csidebarpos == 'right') {echo 'selected="selected"';}?>><?php echo esc_html__('Right', 'sneaker'); ?></option>
		<?php echo '</select>';
	}
	function sneaker_save_meta_box_data( $post_id ) {
		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */
		// Check if our nonce is set.
		if ( ! isset( $_POST['sneaker_meta_box_nonce'] ) ) {
			return;
		}
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['sneaker_meta_box_nonce'], 'sneaker_meta_box' ) ) {
			return;
		}
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}
		/* OK, it's safe for us to save the data now. */
		// Make sure that it is set.
		if ( ! ( isset( $_POST['sneaker_post_intro'] ) || isset( $_POST['sneaker_custom_sidebar'] ) ) )  {
			return;
		}
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['sneaker_post_intro'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, '_sneaker_post_intro', $my_data );
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['sneaker_custom_sidebar'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, '_sneaker_custom_sidebar', $my_data );
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['sneaker_custom_sidebar_pos'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, '_sneaker_custom_sidebar_pos', $my_data );
	}
	//Change comment form
	function sneaker_before_comment_fields() {
		echo '<div class="comment-input">';
	}
	function sneaker_after_comment_fields() {
		echo '</div>';
	}
	/**
	 * Register postMessage support.
	 *
	 * Add postMessage support for site title and description for the Customizer.
	 *
	 * @since Sneaker 1.0
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer object.
	 */
	function sneaker_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}
	/**
	 * Enqueue Javascript postMessage handlers for the Customizer.
	 *
	 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
	 *
	 * @since Sneaker 1.0
	 */
	function sneaker_customize_preview_js() {
		wp_enqueue_script( 'sneaker-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130301', true );
	}
	function sneaker_admin_style() {
	  wp_enqueue_style('admin-styles', get_template_directory_uri().'/css/admin.css');
	}
	/**
	* Utility methods
	* ---------------
	*/
	//Add breadcrumbs
	static function sneaker_breadcrumb() {
		global $post;
		$sneaker_opt = get_option( 'sneaker_opt' );
		$brseparator = '<span class="separator">/</span>';
		if (!is_home()) {
			echo '<div class="breadcrumbs">';
			echo '<a href="';
			echo esc_url( home_url( '/' ));
			echo '">';
			echo esc_html__('Home', 'sneaker');
			echo '</a>'.$brseparator;
			if (is_category() || is_single()) {
				$categories = get_the_category();
				if ( count( $categories ) > 0 ) {
					echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
				}
				if (is_single()) {
					if ( count( $categories ) > 0 ) { echo ''.$brseparator; }
					the_title();
				}
			} elseif (is_page()) {
				if($post->post_parent){
					$anc = get_post_ancestors( $post->ID );
					$title = get_the_title();
					foreach ( $anc as $ancestor ) {
						$output = '<a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a>'.$brseparator;
					}
					echo wp_kses($output, array(
							'a'=>array(
								'href' => array(),
								'title' => array()
							),
							'span'=>array(
								'class'=>array()
							)
						)
					);
					echo '<span title="'.esc_attr($title).'"> '.esc_html($title).'</span>';
				} else {
					echo '<span> '.get_the_title().'</span>';
				}
			}
			elseif (is_tag()) {single_tag_title();}
			elseif (is_day()) {printf( esc_html__( 'Archive for: %s', 'sneaker' ), '<span>' . get_the_date() . '</span>' );}
			elseif (is_month()) {printf( esc_html__( 'Archive for: %s', 'sneaker' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'sneaker' ) ) . '</span>' );}
			elseif (is_year()) {printf( esc_html__( 'Archive for: %s', 'sneaker' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'sneaker' ) ) . '</span>' );}
			elseif (is_author()) {echo "<span>".esc_html__('Archive for','sneaker'); echo'</span>';}
			elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<span>".esc_html__('Blog Archives','sneaker'); echo'</span>';}
			elseif (is_search()) {echo "<span>".esc_html__('Search Results','sneaker'); echo'</span>';}
			echo '</div>';
		} else {
			echo '<div class="breadcrumbs">';
			echo '<a href="';
			echo esc_url( home_url( '/' ) );
			echo '">';
			echo esc_html__('Home', 'sneaker');
			echo '</a>'.$brseparator;
			if(isset($sneaker_opt['blog_header_text']) && $sneaker_opt['blog_header_text']!=""){
				echo esc_html($sneaker_opt['blog_header_text']);
			} else {
				echo esc_html__('Blog', 'sneaker');
			}
			echo '</div>';
		}
	}
	static function sneaker_limitStringByWord ($string, $maxlength, $suffix = '') {
		if(function_exists( 'mb_strlen' )) {
			// use multibyte functions by Iysov
			if(mb_strlen( $string )<=$maxlength) return $string;
			$string = mb_substr( $string, 0, $maxlength );
			$index = mb_strrpos( $string, ' ' );
			if($index === FALSE) {
				return $string;
			} else {
				return mb_substr( $string, 0, $index ).$suffix;
			}
		} else { // original code here
			if(strlen( $string )<=$maxlength) return $string;
			$string = substr( $string, 0, $maxlength );
			$index = strrpos( $string, ' ' );
			if($index === FALSE) {
				return $string;
			} else {
				return substr( $string, 0, $index ).$suffix;
			}
		}
	}
	static function sneaker_excerpt_by_id($post, $length = 70, $tags = '<a><em><p><img><h1><h2><h3><h4><h5><h6>') {
		if ( is_numeric( $post ) ) {
			$post = get_post( $post );
		} elseif( ! is_object( $post ) ) {
			return false;
		}
		if ( has_excerpt( $post->ID ) ) {
			$the_excerpt = $post->post_excerpt;
			return apply_filters( 'the_content', $the_excerpt );
		} else {
			$the_excerpt = $post->post_content;
		}

		$the_excerpt = strip_shortcodes( strip_tags( $the_excerpt, $tags ) );
		$the_excerpt = preg_split( '/\b/', $the_excerpt, $length * 2 + 1 );
		$excerpt_waste = array_pop( $the_excerpt );
		$the_excerpt = implode( $the_excerpt );
		return apply_filters( 'the_content', $the_excerpt );
	}
	/**
	 * Return the Google font stylesheet URL if available.
	 *
	 * The use of Rubik by default is localized. For languages that use
	 * characters not supported by the font, the font can be disabled.
	 *
	 * @since Sneaker 1.2
	 *
	 * @return string Font stylesheet or empty string if disabled.
	 */
	function sneaker_get_font_url() {
		$fonts_url = '';
		/* Translators: If there are characters in your language that are not
		* supported by Rubik, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$rubik = _x( 'on', 'Rubik font: on or off', 'sneaker' );
		if ( 'off' !== $rubik ) {
			$font_families = array();
			if ( 'off' !== $rubik ) {
				$font_families[] = 'Rubik:400,500,600,700,900';
			}
			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);
			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}
		return esc_url_raw( $fonts_url );
	}
	/**
	 * Displays navigation to next/previous pages when applicable.
	 *
	 * @since Sneaker 1.0
	 */
	static function sneaker_content_nav( $html_id ) {
		global $wp_query;
		$html_id = esc_attr( $html_id );
		if ( $wp_query->max_num_pages > 1 ) : ?>
			<nav id="<?php echo esc_attr($html_id); ?>" class="navigation" role="navigation">
				<h3 class="assistive-text"><?php esc_html_e( 'Post navigation', 'sneaker' ); ?></h3>
				<div class="nav-previous"><?php next_posts_link( wp_kses(__( '<span class="meta-nav">&larr;</span> Older posts', 'sneaker' ),array('span'=>array('class'=>array())) )); ?></div>
				<div class="nav-next"><?php previous_posts_link( wp_kses(__( 'Newer posts <span class="meta-nav">&rarr;</span>', 'sneaker' ), array('span'=>array('class'=>array())) )); ?></div>
			</nav>
		<?php endif;
	}
	/* Pagination */
	static function sneaker_pagination() {
		global $wp_query, $paged;
		if(empty($paged)) $paged = 1;
		$pages = $wp_query->max_num_pages;
			if(!$pages || $pages == '') {
			   	$pages = 1;
			}
		if(1 != $pages) {
			echo '<div class="pagination">';
			$big = 999999999; // need an unlikely integer
			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages,
				'prev_text'    => esc_html__('Previous', 'sneaker'),
				'next_text'    =>esc_html__('Next', 'sneaker')
			) );
			echo '</div>';
		}
	}
	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own sneaker_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since Sneaker 1.0
	 */
	static function sneaker_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
			// Display trackbacks differently than normal comments.
		?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<p><?php esc_html_e( 'Pingback:', 'sneaker' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( '(Edit)', 'sneaker' ), '<span class="edit-link">', '</span>' ); ?></p>
		<?php
				break;
			default :
			// Proceed with normal comments.
			global $post;
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<div class="comment-avatar">
					<?php echo get_avatar( $comment, 50 ); ?>
				</div>
				<div class="comment-info">
					<header class="comment-meta comment-author vcard">
						<?php
							printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
								get_comment_author_link(),
								// If current post author is also comment author, make it known visually.
								( $comment->user_id === $post->post_author ) ? '<span>' . esc_html__( 'Post author', 'sneaker' ) . '</span>' : ''
							);
							printf( '<time datetime="%1$s">%2$s</time>',
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( esc_html__( '%1$s at %2$s', 'sneaker' ), get_comment_date(), get_comment_time() )
							);
						?>
						<div class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__( 'Reply', 'sneaker' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div><!-- .reply -->
					</header><!-- .comment-meta -->
					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'sneaker' ); ?></p>
					<?php endif; ?>
					<section class="comment-content comment">
						<?php comment_text(); ?>
						<?php edit_comment_link( esc_html__( 'Edit', 'sneaker' ), '<p class="edit-link">', '</p>' ); ?>
					</section><!-- .comment-content -->
				</div>
			</article><!-- #comment-## -->
		<?php
			break;
		endswitch; // end comment_type check
	}
	/**
	 * Set up post entry meta.
	 *
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * Create your own sneaker_entry_meta() to override in a child theme.
	 *
	 * @since Sneaker 1.0
	 */
	static function sneaker_entry_meta() {
		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', ', ' );
		$num_comments = (int)get_comments_number();
		$write_comments = '';
		if ( comments_open() ) {
			if ( $num_comments == 0 ) {
				$comments = esc_html__('0 comments', 'sneaker');
			} elseif ( $num_comments > 1 ) {
				$comments = $num_comments . esc_html__(' comments', 'sneaker');
			} else {
				$comments = esc_html__('1 comment', 'sneaker');
			}
			$write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
		}
		$utility_text = null;
		if ( ( post_password_required() || !comments_open() ) && ($tag_list != false && isset($tag_list) ) ) {
			$utility_text = esc_html__( 'Tags: %2$s', 'sneaker' );
		} elseif ( $tag_list != false && isset($tag_list) && $num_comments != 0 ) {
			$utility_text = esc_html__( '%1$s / Tags: %2$s', 'sneaker' );
		} elseif ( ($num_comments == 0 || !isset($num_comments) ) && $tag_list==true ) {
			$utility_text = esc_html__( 'Tags: %2$s', 'sneaker' );
		} else {
			$utility_text = esc_html__( '%1$s', 'sneaker' );
		}
		if ( ($tag_list != false && isset($tag_list)) || $num_comments != 0 ) { ?>
			<div class="entry-meta">
				<?php printf( $utility_text, $write_comments, $tag_list); ?>
			</div>
		<?php }
	}
	static function sneaker_entry_meta_small() {
		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list(', ');
		$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( wp_kses(__( 'View all posts by %s', 'sneaker' ), array('a'=>array())), get_the_author() ) ),
			get_the_author()
		);
		$utility_text = esc_html__( 'Posted by %1$s / %2$s', 'sneaker' );
		printf( $utility_text, $author, $categories_list );
	}
	static function sneaker_entry_comments() {
		$date = sprintf( '<time class="entry-date" datetime="%3$s">%4$s</time>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
		$num_comments = (int)get_comments_number();
		$write_comments = '';
		if ( comments_open() ) {
			if ( $num_comments == 0 ) {
				$comments = wp_kses(__('<span>0</span> comments', 'sneaker'), array('span'=>array()));
			} elseif ( $num_comments > 1 ) {
				$comments = '<span>'.$num_comments .'</span>'. esc_html__(' comments', 'sneaker');
			} else {
				$comments = wp_kses(__('<span>1</span> comment', 'sneaker'), array('span'=>array()));
			}
			$write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
		}
		$utility_text = esc_html__( '%1$s', 'sneaker' );
		printf( $utility_text, $write_comments );
	}
	/**
	* TGM-Plugin-Activation
	*/
	function sneaker_register_required_plugins() {
		$plugins = array(
			array(
				'name'               => esc_html__('RoadThemes Helper', 'sneaker'),
				'slug'               => 'roadthemes-helper',
				'source'             => get_template_directory() . '/plugins/roadthemes-helper.zip',
				'required'           => true,
				'version'            => '1.0.0',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
			),
			array(
				'name'               => esc_html__('Mega Main Menu', 'sneaker'),
				'slug'               => 'mega_main_menu',
				'source'             => get_template_directory() . '/plugins/mega_main_menu.zip',
				'required'           => true,
				'external_url'       => '',
			),
			array(
				'name'               => esc_html__('Revolution Slider', 'sneaker'),
				'slug'               => 'revslider',
				'source'             => get_template_directory() . '/plugins/revslider.zip',
				'required'           => true,
				'external_url'       => '',
			),
			array(
				'name'               => esc_html__('Import Sample Data', 'sneaker'),
				'slug'               => 'road-importdata',
				'source'             => get_template_directory() . '/plugins/road-importdata.zip',
				'required'           => true,
				'external_url'       => '',
			),
			array(
				'name'               => esc_html__('Visual Composer', 'sneaker'),
				'slug'               => 'js_composer',
				'source'             => get_template_directory() . '/plugins/js_composer.zip',
				'required'           => true,
				'external_url'       => '',
			),
			array(
				'name'               => esc_html__('Templatera', 'sneaker'),
				'slug'               => 'templatera',
				'source'             => get_template_directory() . '/plugins/templatera.zip',
				'required'           => true,
				'external_url'       => '',
			),
			array(
				'name'               => esc_html__('Essential Grid', 'sneaker'),
				'slug'               => 'essential-grid',
				'source'             => get_template_directory() . '/plugins/essential-grid.zip',
				'required'           => true,
				'external_url'       => '',
			),
			// Plugins from the WordPress Plugin Repository.
			array(
				'name'               => esc_html__('Redux Framework', 'sneaker'),
				'slug'               => 'redux-framework',
				'required'           => true,
				'force_activation'   => false,
				'force_deactivation' => false,
			),
			array(
				'name'      => esc_html__('Contact Form 7', 'sneaker'),
				'slug'      => 'contact-form-7',
				'required'  => true,
			),
			array(
				'name'      => esc_html__('MailChimp for WordPress', 'sneaker'),
				'slug'      => 'mailchimp-for-wp',
				'required'  => true,
			),
			array(
				'name'      => esc_html__('Shortcodes Ultimate', 'sneaker'),
				'slug'      => 'shortcodes-ultimate',
				'required'  => true,
			),
			array(
				'name'      => esc_html__('Simple Local Avatars', 'sneaker'),
				'slug'      => 'simple-local-avatars',
				'required'  => false,
			),
			array(
				'name'      => esc_html__('Testimonials', 'sneaker'),
				'slug'      => 'testimonials-by-woothemes',
				'required'  => true,
			),
			array(
				'name'      => esc_html__('TinyMCE Advanced', 'sneaker'),
				'slug'      => 'tinymce-advanced',
				'required'  => false,
			),
			array(
				'name'      => esc_html__('Widget Importer & Exporter', 'sneaker'),
				'slug'      => 'widget-importer-exporter',
				'required'  => true,
			),
			array(
				'name'      => esc_html__('WooCommerce', 'sneaker'),
				'slug'      => 'woocommerce',
				'required'  => true,
			),
			array(
				'name'      => esc_html__('YITH WooCommerce Compare', 'sneaker'),
				'slug'      => 'yith-woocommerce-compare',
				'required'  => false,
			),
			array(
				'name'      => esc_html__('YITH WooCommerce Wishlist', 'sneaker'),
				'slug'      => 'yith-woocommerce-wishlist',
				'required'  => false,
			),
			array(
				'name'      => esc_html__('YITH WooCommerce Zoom Magnifier', 'sneaker'),
				'slug'      => 'yith-woocommerce-zoom-magnifier',
				'required'  => false,
			),
		);
		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'default_path' => '',                      // Default absolute path to pre-packaged plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
			'strings'      => array(
				'page_title'                      => esc_html__( 'Install Required Plugins', 'sneaker' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'sneaker' ),
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'sneaker' ), // %s = plugin name.
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'sneaker' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'sneaker' ), // %1$s = plugin name(s).
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'sneaker' ), // %1$s = plugin name(s).
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'sneaker' ), // %1$s = plugin name(s).
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'sneaker' ), // %1$s = plugin name(s).
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'sneaker' ), // %1$s = plugin name(s).
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'sneaker' ), // %1$s = plugin name(s).
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'sneaker' ), // %1$s = plugin name(s).
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'sneaker' ), // %1$s = plugin name(s).
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'sneaker' ),
				'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'sneaker' ),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'sneaker' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'sneaker' ),
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'sneaker' ), // %s = dashboard link.
				'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
			)
		);
		tgmpa( $plugins, $config );
	}
}
// Instantiate theme
$Sneaker_Class = new Sneaker_Class();
//Fix duplicate id of mega menu
function sneaker_mega_menu_id_change($params) {
	ob_start('sneaker_mega_menu_id_change_call_back');
}
function sneaker_mega_menu_id_change_call_back($html){
	$html = preg_replace('/id="mega_main_menu"/', 'id="mega_main_menu_first"', $html, 1);
	$html = preg_replace('/id="mega_main_menu_ul"/', 'id="mega_main_menu_ul_first"', $html, 1);
	return $html;
}
add_action('wp_loaded', 'sneaker_mega_menu_id_change');
function theme_prefix_enqueue_script() {
	wp_add_inline_script( 'sneaker', 'var ajaxurl = "'.admin_url('admin-ajax.php').'";','before' );
}
add_action( 'wp_enqueue_scripts', 'theme_prefix_enqueue_script' );