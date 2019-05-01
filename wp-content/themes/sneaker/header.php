<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Sneaker_Theme
 * @since Sneaker1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php $sneaker_opt = get_option( 'sneaker_opt' ); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div class="wrapper">
	<div class="page-wrapper">
		<?php if(isset($sneaker_opt['header_layout']) && $sneaker_opt['header_layout']!=''){
			$header_class = str_replace(' ', '-', strtolower($sneaker_opt['header_layout']));
		} else {
			$header_class = '';
		} 
		if( (class_exists('RevSliderFront')) && (is_front_page() && has_shortcode( $post->post_content, 'rev_slider_vc')) ) {
			$hasSlider_class = 'rs-active';
		} else {
			$hasSlider_class = '';
		}
		?>
		<div class="header-container <?php echo esc_html($header_class)." ".esc_html($hasSlider_class) ?>">
			<div class="header">
				<div class="header-content">
					<?php
					if ( isset($sneaker_opt['header_layout']) && $sneaker_opt['header_layout']!="") { 
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
								if($jscomposer_template->post_title == $sneaker_opt['header_layout']){ ?>
									<div class="container">
										<?php 
											// echo do_shortcode($jscomposer_template->post_content);
											echo do_shortcode(apply_filters( 'the_content', $jscomposer_template->post_content ));
										?>
									</div>
								<?php }
							}
						}
					} else {
						?>
						<div class="header-default">
							<div class="logo-wrapper">
								<div class="container">
									<div class="row">
										<div class="col-12 col-xl-3">
											<?php if( isset($sneaker_opt['logo_main']['url']) && $sneaker_opt['logo_main']['url']!=''){ ?>
												<div class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url($sneaker_opt['logo_main']['url']); ?>" alt=" <?php echo esc_attr( get_bloginfo( 'name', 'display' ) ) ?> " /></a></div>
											<?php
											} else { ?>
												<h1 class="logo site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
												<?php
											} ?>
										</div>
										<div class="col-12 col-xl-9">
											<div class="header-search">
												<div class="search-without-dropdown">
													<?php get_search_form(); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="nav-container">
								<div class="container">
									<?php if ( has_nav_menu( 'primary' ) ) : ?>
										<div class="horizontal-menu visible-large">
											<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'primary-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
										</div>
									<?php endif; ?>
									<?php if ( has_nav_menu( 'mobilemenu' ) ) : ?>
										<div class="visible-small mobile-menu"> 
											<div class="mbmenu-toggler"><?php echo esc_html($sneaker_opt['mobile_menu_label']);?><span class="mbmenu-icon"><i class="fa fa-bars"></i></span></div>
											<div class="clearfix"></div>
											<?php wp_nav_menu( array( 'theme_location' => 'mobilemenu', 'container_class' => 'mobile-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
										</div>
									<?php endif; ?>
								</div>
							</div> 
						</div>
						<?php
					} 
					?>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>