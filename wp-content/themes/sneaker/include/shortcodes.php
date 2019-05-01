<?php
function sneaker_logo_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'logo_image'   => '',
		'logo_link'    => 'yes',
		'logo_width'   => '150',
		), $atts, 'roadlogo' );
	$html = '';
	ob_start(); ?>
	<?php
	if( isset($atts['logo_image']) && $atts['logo_image']!='') {
		$html .= '<div class="logo">';
			if($atts['logo_link']=='yes'){
				$html .= '<a href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" rel="home">';
			}
			if ($atts['logo_width'] == '' || ! is_numeric($atts['logo_width'])) {
				$logo_width = 'auto';
			} else {
				$logo_width = floatval($atts['logo_width']);
			}
			$html .= '<img width="'.esc_attr($logo_width).'" src="'.wp_get_attachment_url( $atts['logo_image']).'" alt="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" />';
			if($atts['logo_link']=='yes'){
				$html .= '</a>';
			}
		$html .= '</div>';
	} else {
		$html .= '<h1 class="logo">';
			if($atts['logo_link']=='yes'){
				$html .= '<a href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" rel="home">';
			}
			$html .= bloginfo( 'name' );
			if($atts['logo_link']=='yes'){
				$html .= '</a>';
			}
		$html .= '</h1>';
	} ?>
	<?php
	$html .= ob_get_contents();
	ob_end_clean();
	return $html;
}
function sneaker_mainmenu_shortcode( $atts ) {
	$sneaker_opt = get_option( 'sneaker_opt' );
	$atts = shortcode_atts( array(
		'sticky_logoimage'         => '',
		'sticky_logoimage_width'   => '150',
	), $atts, 'roadmainmenu' );
	$html = '';
	if ($atts['sticky_logoimage_width'] == '' || ! is_numeric($atts['sticky_logoimage_width'])) {
		$sticky_logoimage_width = 'auto';
	} else {
		$sticky_logoimage_width = floatval($atts['sticky_logoimage_width']);
	}
	ob_start(); ?>
	<div class="main-menu-wrapper">
		<div class="visible-small mobile-menu"> 
			<div class="mbmenu-toggler"><?php echo esc_html($sneaker_opt['mobile_menu_label']);?><span class="mbmenu-icon"><i class="fa fa-bars"></i></span></div>
			<div class="clearfix"></div>
			<?php wp_nav_menu( array( 'theme_location' => 'mobilemenu', 'container_class' => 'mobile-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
		</div>
		<div class="<?php if(isset($sneaker_opt['sticky_header']) && $sneaker_opt['sticky_header']) {echo 'header-sticky';} ?> <?php if ( is_admin_bar_showing() ) {echo 'with-admin-bar';} ?>">
			<div class="nav-container">
				<?php if( isset($atts['sticky_logoimage']) && $atts['sticky_logoimage']!=''){?>
					<div class="logo-sticky"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img width="<?php echo esc_attr($sticky_logoimage_width);?>" src="<?php echo  wp_get_attachment_url( $atts['sticky_logoimage']);?>" alt=" <?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> " /></a></div>
				<?php } ?>
				<div class="horizontal-menu visible-large">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'primary-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
				</div> 
			</div> 
		</div>
	</div>	
	<?php
	$html .= ob_get_contents();
	ob_end_clean();
	return $html;
}
function sneaker_roadcategoriesmenu_shortcode ( $atts ) {
	$sneaker_opt = get_option( 'sneaker_opt' );
	$html = '';
	ob_start();
	$cat_menu_class = '';
	if(isset($sneaker_opt['categories_menu_home']) && $sneaker_opt['categories_menu_home']) {
		$cat_menu_class .=' show_home';
	}
	if(isset($sneaker_opt['categories_menu_sub']) && $sneaker_opt['categories_menu_sub']) {
		$cat_menu_class .=' show_inner';
	}
	?>
	<div class="categories-menu-wrapper">
		<div class="categories-menu-inner">
			<div class="categories-menu visible-large <?php echo esc_attr($cat_menu_class); ?>">
				<div class="catemenu-toggler"><span><?php if(isset($sneaker_opt['categories_menu_label'])) { echo esc_html($sneaker_opt['categories_menu_label']); } else { esc_html_e('ALL CATEGORIES', 'sneaker'); } ?></span></div>
				<div class="catemenu">
					<div class="catemenu-inner">
						<?php wp_nav_menu( array( 'theme_location' => 'categories', 'container_class' => 'categories-menu-container', 'menu_class' => 'categories-menu' ) ); ?>
						<div class="morelesscate">
							<span class="morecate"><i class="fa fa-plus"></i><?php if ( isset($sneaker_opt['categories_more_label']) && $sneaker_opt['categories_more_label']!='' ) { echo esc_html($sneaker_opt['categories_more_label']); } else { esc_html_e('More Categories', 'sneaker'); } ?></span>
							<span class="lesscate"><i class="fa fa-minus"></i><?php if ( isset($sneaker_opt['categories_less_label']) && $sneaker_opt['categories_less_label']!='' ) { echo esc_html($sneaker_opt['categories_less_label']); } else { esc_html_e('Close Menu', 'sneaker'); } ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	$html .= ob_get_contents();
	ob_end_clean();
	return $html;
}
function sneaker_roadsocialicons_shortcode( $atts ) {
	$sneaker_opt = get_option( 'sneaker_opt' );
	$html = '';
	ob_start();
	if(isset($sneaker_opt['social_icons'])) {
		echo '<ul class="social-icons">';
		foreach($sneaker_opt['social_icons'] as $key=>$value ) {
			if($value!=''){
				if($key=='vimeo'){
					echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>';
				} else {
					echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'" target="_blank"><i class="fa fa-'.esc_attr($key).'"></i></a></li>';
				}
			}
		}
		echo '</ul>';
	}
	$html .= ob_get_contents();
	ob_end_clean();
	return $html;
}
function sneaker_roadminicart_shortcode( $atts ) {
	$html = '';
	ob_start();
	if ( class_exists( 'WC_Widget_Cart' ) ) {
		the_widget('Custom_WC_Widget_Cart');
	}
	$html .= ob_get_contents();
	ob_end_clean();
	return $html;
}
function sneaker_roadproductssearch_shortcode( $atts ) {
	$html = '';
	ob_start();
	if( class_exists('WC_Widget_Product_Categories') && class_exists('WC_Widget_Product_Search') ) { ?>
  		<div class="header-search">
	  		<div class="search-without-dropdown">
		  		<div class="categories-container">
		  			<div class="cate-toggler-wrapper"><div class="cate-toggler"><span class="cate-text"><?php esc_html_e('All Categories', 'sneaker');?></span></div></div>
		  			<?php the_widget('WC_Widget_Product_Categories', array('hierarchical' => true, 'title' => 'All Categories', 'orderby' => 'order')); ?>
		  		</div> 
		   		<?php the_widget('WC_Widget_Product_Search', array('title' => 'Search')); ?>
	  		</div>
  		</div>
	<?php }
	$html .= ob_get_contents();
	ob_end_clean();
	return $html;
}
function sneaker_roadproductssearchdropdown_shortcode( $atts ) {
	$html = '';
	ob_start();
	if( class_exists('WC_Widget_Product_Categories') && class_exists('WC_Widget_Product_Search') ) { ?>
		<div class="header-search">
			<div class="search-dropdown">
				<?php the_widget('WC_Widget_Product_Search', array('title' => 'Search')); ?>
			</div>
		</div>
	<?php }
	$html .= ob_get_contents();
	ob_end_clean();
	return $html;
}
function sneaker_brands_shortcode( $atts ) {
	global $sneaker_opt;
	$brand_index = 0;
	if(isset($sneaker_opt['brand_logos'])) {
		$brandfound = count($sneaker_opt['brand_logos']);
	}
	$atts = shortcode_atts( array(
		'rows'             => '1',
		'items_1200up'     => '5',
		'items_992_1199'   => '5',
		'items_768_991'    => '4',
		'items_640_767'    => '3',
		'items_480_639'    => '2',
		'items_0_479'      => '1',
		'navigation'       => '1',
		'pagination'       => '0',
		'item_margin'      => '0',
		'speed'            => '500',
		'auto'             => '0',
		'loop'             => '0',
		'style'            => 'style1',
		'navigation_style' => 'navigation-style1',
		), $atts, 'ourbrands' );
	$html = '';
	if ($atts["items_1200up"]   == '' ) {$atts["items_1200up"]   = 5; }
	if ($atts["items_992_1199"] == '' ) {$atts["items_992_1199"] = 5; }
	if ($atts["items_768_991"]  == '' ) {$atts["items_768_991"]  = 4; }
	if ($atts["items_640_767"]  == '' ) {$atts["items_640_767"]  = 3; }
	if ($atts["items_480_639"]  == '' ) {$atts["items_480_639"]  = 2; }
	if ($atts["items_0_479"]    == '' ) {$atts["items_0_479"]    = 1; }
	if ($atts["item_margin"]    == '' ) {$atts["item_margin"]    = 0; }
	if ($atts["speed"]    		== '' ) {$atts["speed"]          = 500; }
	$navigation = 1;
	if ($atts["navigation"] == 0) {
		$navigation = 0;
	}
	$pagination = 0;
	if ($atts["pagination"] == 1) {
		$pagination = 1;
	}
	$margin = 0;
	if (isset($atts["item_margin"]) && $atts["item_margin"] != '') {
		$margin = $atts["item_margin"];
	} 
	$loop = 0;
	if ($atts["loop"] == true) {
		$loop = 1;
	}
	$auto = 0;
	if ($atts["auto"] == true) {
		$auto = 1;
	}
	if(isset($sneaker_opt['brand_logos']) && $sneaker_opt['brand_logos']) {
		$html .= '<div class="brands-carousel roadthemes-slider '.$atts["navigation_style"].' '.$atts["style"].'" data-margin='.$margin.' data-1200up='.$atts["items_1200up"].' data-992-1199='.$atts["items_992_1199"].' data-768-991='.$atts["items_768_991"].' data-640-767='.$atts["items_640_767"].' data-480-639='.$atts["items_480_639"].' data-0-479='.$atts["items_0_479"].' data-navigation='.$navigation.' data-pagination='.$pagination.' data-speed='.$atts["speed"].' data-loop='.$loop.' data-auto='.$auto.'>';
			foreach($sneaker_opt['brand_logos'] as $brand) {
				if(is_ssl()){
					$brand['image'] = str_replace('http:', 'https:', $brand['image']);
				}
				$brand_index ++;
				if ( (0 == ( $brand_index - 1 ) % $atts['rows'] ) || $brand_index == 1) {
					$html .= '<div class="group">';
				}
				$html .= '<div>';
				$html .= '<a href="'.esc_url($brand['url']).'" title="'.esc_attr($brand['title']).'">';
					$html .= '<img src="'.esc_url($brand['image']).'" alt="'.esc_attr($brand['title']).'" />';
				$html .= '</a>';
				$html .= '</div>';
				if ( ( ( 0 == $brand_index % $atts['rows'] || $brandfound == $brand_index ))  ) {
					$html .= '</div>';
				}
			}
		$html .= '</div>';
	}
	return $html;
}
function sneaker_imageslider_shortcode( $atts ) {
	global $sneaker_opt;
	$image_slider_index = 0;
	if(isset($sneaker_opt['image_slider'])) {
		$image_slider_found = count($sneaker_opt['image_slider']);
	}
	$atts = shortcode_atts( array(
		'rows'             => '1',
		'items_1200up'     => '4',
		'items_992_1199'   => '4',
		'items_768_991'    => '3',
		'items_640_767'    => '2',
		'items_480_639'    => '2',
		'items_0_479'      => '1',
		'navigation'       => '1',
		'pagination'       => '0',
		'item_margin'      => '30',
		'speed'            => '500',
		'auto'             => '0',
		'loop'             => '0',
		'style'            => 'style1',
		'navigation_style' => 'navigation-style1',
		), $atts, 'image_slider' );
	$html = '';
	if ($atts["items_1200up"]   == '' ) {$atts["items_1200up"]   = 4; }
	if ($atts["items_992_1199"] == '' ) {$atts["items_992_1199"] = 4; }
	if ($atts["items_768_991"]  == '' ) {$atts["items_768_991"]  = 3; }
	if ($atts["items_640_767"]  == '' ) {$atts["items_640_767"]  = 2; }
	if ($atts["items_480_639"]  == '' ) {$atts["items_480_639"]  = 2; }
	if ($atts["items_0_479"]    == '' ) {$atts["items_0_479"]    = 1; }
	if ($atts["item_margin"]    == '' ) {$atts["item_margin"]    = 30; }
	if ($atts["speed"]    		== '' ) {$atts["speed"]          = 500; }
	$navigation = 1;
	if ($atts["navigation"] == 0) {
		$navigation = 0;
	}
	$pagination = 0;
	if ($atts["pagination"] == 1) {
		$pagination = 1;
	}
	$margin = 0;
	if (isset($atts["item_margin"]) && $atts["item_margin"] != '') {
		$margin = $atts["item_margin"];
	} 
	$loop = 0;
	if ($atts["loop"] == true) {
		$loop = 1;
	}
	$auto = 0;
	if ($atts["auto"] == true) {
		$auto = 1;
	}
	if(isset($sneaker_opt['image_slider']) && $sneaker_opt['image_slider']) {
		$html .= '<div class="image-slider roadthemes-slider '.$atts["navigation_style"].' '.$atts["style"].'" data-margin='.$margin.' data-1200up='.$atts["items_1200up"].' data-992-1199='.$atts["items_992_1199"].' data-768-991='.$atts["items_768_991"].' data-640-767='.$atts["items_640_767"].' data-480-639='.$atts["items_480_639"].' data-0-479='.$atts["items_0_479"].' data-navigation='.$navigation.' data-pagination='.$pagination.' data-speed='.$atts["speed"].' data-loop='.$loop.' data-auto='.$auto.'>';
			foreach($sneaker_opt['image_slider'] as $image) {
				if(is_ssl()){
					$image['image'] = str_replace('http:', 'https:', $image['image']);
				}
				$image_slider_index ++;
				if ( (0 == ( $image_slider_index - 1 ) % $atts['rows'] ) || $image_slider_index == 1) {
					$html .= '<div class="group">';
				}
				$html .= '<div class="image-slider-inner">';
					$html .= '<div class="image">';
						$html .= '<a href="'.esc_url($image['url']).'" title="'.esc_attr($image['title']).'">';
							$html .= '<img src="'.esc_url($image['image']).'" alt="'.esc_attr($image['title']).'" />';
						$html .= '</a>';
					$html .= '</div>';
					$html .= '<div class="title">';
						$html .= '<h3><a href="'.$image['url'].'" title="'.esc_attr($image['title']).'">';
							$html .= esc_attr($image['title']);
						$html .= '</a></h3>';
					$html .= '</div>';
				$html .= '</div>';
				if ( ( ( 0 == $image_slider_index % $atts['rows'] || $image_slider_found == $image_slider_index ))  ) {
					$html .= '</div>';
				}
			}
		$html .= '</div>';
	}
	return $html;
}
function sneaker_counter_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'image'  => '',
		'number' => '100',
		'text'   => 'Demo text',
		), $atts, 'sneaker_counter' );
	$html = '';
	$html.='<div class="sneaker-counter">';
		$html.='<div class="counter-image">';
			$html.='<img src="'.wp_get_attachment_url($atts['image']).'" alt="'.esc_attr( $atts['text'] ).'" />';
		$html.='</div>';
		$html.='<div class="counter-info">';
			$html.='<div class="counter-number">';
				$html.='<span>'.$atts['number'].'</span>';
			$html.='</div>';
			$html.='<div class="counter-text">';
				$html.='<span>'.$atts['text'].'</span>';
			$html.='</div>';
		$html.='</div>';
	$html.='</div>';
	return $html;
}
function sneaker_popular_categories_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'category' => '',
		'image'    => ''
	), $atts, 'popular_categories' );
	$html = '';
	$html .= '<div class="category-wrapper">';
		$pcategory = get_term_by( 'slug', $atts['category'], 'product_cat', 'ARRAY_A' );
		if($pcategory){
			$html .= '<div class="category-list">';
				$html .= '<h3><a href="'. get_term_link($pcategory['slug'], 'product_cat') .'">'. $pcategory['name'] .'</a></h3>';
				$html .= '<ul>';
					$args2 = array(
						'taxonomy'     => 'product_cat',
						'child_of'     => 0,
						'parent'       => $pcategory['term_id'],
						'orderby'      => 'name',
						'show_count'   => 0,
						'pad_counts'   => 0,
						'hierarchical' => 0,
						'title_li'     => '',
						'hide_empty'   => 0
					);
					$sub_cats = get_categories( $args2 );
					if($sub_cats) {
						foreach($sub_cats as $sub_category) {
							$html .= '<li><a href="'.get_term_link($sub_category->slug, 'product_cat').'">'.$sub_category->name.'</a></li>';
						}
					}
				$html .= '</ul>';
			$html .= '</div>';
			if ($atts['image']!='') {
			$html .= '<div class="cat-img">';
				$html .= '<a href="'.get_term_link($pcategory['slug'], 'product_cat').'"><img class="category-image" src="'.esc_attr($atts['image']).'" alt="'.esc_attr($pcategory['name']).'" /></a>';
			$html .= '</div>';
			}
		}
	$html .= '</div>';
	return $html;
}
function sneaker_latestposts_shortcode( $atts ) {
	global $sneaker_opt;
	$post_index = 0;
	$atts = shortcode_atts( array(
		'posts_per_page'   => 10,
		'category' 		   => 0,
		'order'            => 'DESC',
		'orderby'          => 'post_date',
		'image'            => 'wide', //square
		'length'           => 20,
		'colsnumber'       => '1',
		'image1'           => 'square',
		'style'            => 'style1',
		'enable_slider'    => '1',
		'rowsnumber'       => '1',
		'items_1200up'     => '1',
		'items_992_1199'   => '3',
		'items_768_991'    => '3',
		'items_640_767'    => '2',
		'items_480_639'    => '2',
		'items_0_479'      => '1',
		'navigation'       => '1',
		'pagination'       => '0',
		'item_margin'      => '0',
		'speed'            => '500',
		'auto'             => '0',
		'loop'             => '0',
		'navigation_style' => 'navigation-style1',
	), $atts, 'latestposts' );
	if($atts['image']=='wide'){
		$imagesize = 'sneaker-post-thumbwide';
	} else {
		$imagesize = 'sneaker-post-thumb';
	}
	if($atts['category']=='0'){
		$atts['category'] = '';
	}
	$html = '';
	$postargs = array(
		'posts_per_page'   => $atts['posts_per_page'],
		'offset'           => 0,
		'category_name'    => $atts['category'],
		'orderby'          => $atts['orderby'],
		'order'            => $atts['order'],
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'post',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true );
	$postslist = get_posts( $postargs );
	$post_col_width = round(12/$atts['colsnumber']);
	$post_col_class = ' col-12 col-md-'.$post_col_width ;
	if ($atts["enable_slider"] == true) {
		$atts["items_1200up"] 		=   $atts["colsnumber"];
		if ($atts["items_1200up"] 	== '' ) {$atts["items_1200up"] 	 = 1; }
		if ($atts["items_992_1199"] == '' ) {$atts["items_992_1199"] = 3; }
		if ($atts["items_768_991"]  == '' ) {$atts["items_768_991"]  = 3; }
		if ($atts["items_640_767"]  == '' ) {$atts["items_640_767"]  = 2; }
		if ($atts["items_480_639"]  == '' ) {$atts["items_480_639"]  = 2; }
		if ($atts["items_0_479"]    == '' ) {$atts["items_0_479"]    = 1; }
		if ($atts["item_margin"]    == '' ) {$atts["item_margin"]    = 0; }
		if ($atts["speed"]    		== '' ) {$atts["speed"]          = 500; }
		$slider = 'roadthemes-slider';
		$navigation = 1;
		if ($atts["navigation"] == 0) {
			$navigation = 0;
		}
		$pagination = 0;
		if ($atts["pagination"] == 1) {
			$pagination = 1;
		}
		$margin = 30;
		if (isset($atts["item_margin"]) && $atts["item_margin"] != '') {
			$margin = $atts["item_margin"];
		} 
		$loop = 0;
		if ($atts["loop"] == true) {
			$loop = 1;
		}
		$auto = 0;
		if ($atts["auto"] == true) {
			$auto = 1;
		}
		$html.='<div class="posts-carousel '.$atts["navigation_style"].' '.$atts["style"].' '.$slider.'" data-margin='.$margin.' data-1200up='.$atts["items_1200up"].' data-992-1199='.$atts["items_992_1199"].' data-768-991='.$atts["items_768_991"].' data-640-767='.$atts["items_640_767"].' data-480-639='.$atts["items_480_639"].' data-0-479='.$atts["items_0_479"].' data-navigation='.$navigation.' data-pagination='.$pagination.' data-speed='.$atts["speed"].' data-loop='.$loop.' data-auto='.$auto.'>';
	} else {
		$html.='<div class="posts-carousel '.$atts["style"].'" data-col="'.$atts['colsnumber'].'">';
	};
			foreach ( $postslist as $post ) {
				$post_index ++;
				if ( $atts["enable_slider"] == true && ((0 == ( $post_index - 1 ) % $atts['rowsnumber'] ) || $post_index == 1)) {
					$html .= '<div class="group">';
				}
				if ( $atts["enable_slider"] == false && ((0 == ( $post_index - 1 ) % $atts['colsnumber'] ) || $post_index == 1)) {
					$html .= '<div class="group row">';
				}
				$html.='<div class="item-col'.$post_col_class.' ">';
					$html.='<div class="post-wrapper">';
					// author link
					$author_id = $post->post_author;
					$author_url = get_author_posts_url( get_the_author_meta( 'ID', $author_id ) );
					$author_name = get_the_author_meta( 'user_nicename', $author_id );
					//comment variables
					$num_comments = (int)get_comments_number($post->ID);
					$write_comments = '';
					if ( comments_open($post->ID) ) {
						if ( $num_comments == 0 ) {
							$comments = wp_kses(__('<span>0</span> comments', 'sneaker'), array('span'=>array()));
						} elseif ( $num_comments > 1 ) {
							$comments = '<span>'.$num_comments .'</span>'. esc_html__(' comments', 'sneaker');
						} else {
							$comments = wp_kses(__('<span>1</span> comment', 'sneaker'), array('span'=>array()));
						}
						$write_comments = '<a href="' . get_comments_link($post->ID) .'">'. $comments.'</a>';
					};
					if ( has_post_thumbnail( $post->ID ) ) {
						$html.='<div class="post-thumb">'; 
							$html.='<a href="'.get_the_permalink($post->ID).'">'.get_the_post_thumbnail($post->ID, $imagesize).'</a>';
						$html.='</div>';
					};
					$html.='<div class="post-info">';
						$html.='<h3 class="post-title"><a href="'.get_the_permalink($post->ID).'">'.get_the_title($post->ID).'</a></h3>';
						$html.='<div class="post-meta">';
							$html.='<div class="post-date">'.get_the_date().'</div>';
							$html.='<p class="post-comment">'.$write_comments.'</p>';
						$html.='</div>';
						$html.='<div class="post-excerpt">';
							$html.= Sneaker_Class::sneaker_excerpt_by_id($post, $length = $atts['length']);
						$html.='</div>';
						$html.='<p class="post-author">';
							$html.= sprintf(get_avatar($author_id));
							$html.= sprintf( wp_kses(__( '%s', 'sneaker' ), array('a'=>array('href'=>array()))), __('Posted by ', 'sneaker').'<a href="'.$author_url.'">'.$author_name.' </a>' );
						$html.='</p>';
						$html.='<a class="readmore" href="'.get_the_permalink($post->ID).'">'.'<span>' .esc_html($sneaker_opt['readmore_text']). '</span>'.'</a>';
					$html.='</div>';
				$html.='</div>';
			$html.='</div>';
			if ( $atts["enable_slider"] == true && ( ( 0 == $post_index % $atts['rowsnumber'] || $atts['posts_per_page'] == $post_index ))  ) {
				$html .= '</div>';
			}
			if ( $atts["enable_slider"] == false && ( ( 0 == $post_index % $atts['colsnumber'] || $atts['posts_per_page'] == $post_index ))  ) {
				$html .= '</div>';
			}
		}
	$html.='</div>';
	wp_reset_postdata();
	return $html;
}
function sneaker_magnifier_options($att) {  
	$enable_slider 	= get_option('yith_wcmg_enableslider') == 'yes' ? true : false;
	$slider_items = get_option( 'yith_wcmg_slider_items', 3 ); 
	if ( !isset($slider_items) || ( $slider_items == null ) ) $slider_items = 3;
	wp_enqueue_script('sneaker-magnifier', get_template_directory_uri() . '/js/product-magnifier-var.js');
	wp_localize_script('sneaker-magnifier', 'sneaker_magnifier_vars', array(
			'responsive'    => get_option('yith_wcmg_slider_responsive') == 'yes' ? 'true' : 'false',
			'circular'      => get_option('yith_wcmg_slider_circular') == 'yes' ? 'true' : 'false',
			'infinite'      => get_option('yith_wcmg_slider_infinite') == 'yes' ? 'true' : 'false',
			'visible'       => esc_js(apply_filters( 'woocommerce_product_thumbnails_columns', $slider_items )),
			'zoomWidth'     => get_option('yith_wcmg_zoom_width'),
			'zoomHeight'    => get_option('yith_wcmg_zoom_height'),
			'position'      => get_option('yith_wcmg_zoom_position'),
			'lensOpacity'   => get_option('yith_wcmg_lens_opacity'),
			'softFocus'     => get_option('yith_wcmg_softfocus') == 'yes' ? 'true' : 'false',
			'phoneBehavior' => get_option('yith_wcmg_zoom_mobile_position'),
			'loadingLabel'  => stripslashes(get_option('yith_wcmg_loading_label')),
		)
	);
}
function sneaker_heading_title_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'heading_title'      => 'Title',
		'sub_heading_title'  => '',
		'style'              => 'style1',
	), $atts, 'roadthemes_title' );
	$html = '';
	$html.='<div class="heading-title '.$atts["style"].' ">';
		$html.='<h3><span>';
			$html.= wp_kses($atts["heading_title"], array(
						'span'=>array(),
						'strong'=>array(),
						'em'=>array(),
						'br'=>array(),
					));
		$html.='</span></h3>';
		if ($atts["sub_heading_title"] != '') {
			$html.='<p>';
				$html.= wp_kses($atts["sub_heading_title"], array(
							'span'=>array(),
							'strong'=>array(),
							'em'=>array(),
							'br'=>array(),
						));
			$html.='</p>';
		}
	$html.='</div>';
	return $html;
}
function sneaker_countdown_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'countdown_day'    => '1',
		'countdown_month'  => '1',
		'countdown_year'   => '2020',
		'style'            => 'style1',
	), $atts, 'roadthemes_countdown' );
	$date = $atts["countdown_day"].'/'.$atts["countdown_month"].'/'.$atts["countdown_year"];
	$html = '';
	$html.='<div class="countdown '.$atts["style"].'" data-time="'.$date.'"></div>';
	return $html;
}
?>