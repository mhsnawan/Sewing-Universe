<?php
$_SESSION["preset"] = 4;
/*
 * Template Name: Demo 4
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Sneaker consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Sneaker
 * @since Sneaker  1.0
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<?php global $sneaker_opt; ?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
$jscomposer_templates_args = array(
	'orderby'          => 'title',
	'order'            => 'ASC',
	'post_type'        => 'templatera',
	'post_status'      => 'publish',
	'posts_per_page'   => 100,
);
$jscomposer_templates = get_posts( $jscomposer_templates_args );
if(count($jscomposer_templates) > 0) {
	foreach($jscomposer_templates as $jscomposer_template){
		if($jscomposer_template->post_title == 'Header 3' || $jscomposer_template->post_title == 'Footer 2'){
			$jscomposer_template_css = get_post_meta ( $jscomposer_template->ID, '_wpb_shortcodes_custom_css', false );
			if(isset($jscomposer_template_css[0])){
				echo '<style>'.esc_html($jscomposer_template_css[0]).'</style>';
			}
		}
	}
} ?>
<?php wp_head(); ?>
</head>
<body <?php body_class('home'); ?>>
	<div id="yith-wcwl-popup-message" style="display:none;"><div id="yith-wcwl-message"></div></div>
	<div class="wrapper">
		<div class="page-wrapper">
			<div class="header-container header-3 rs-active">  
			 	<div class="header">
					<div class="header-content">
						<div class="container">
							<?php
							if ( isset($sneaker_opt['header_layout']) && $sneaker_opt['header_layout']!="") {
								$jscomposer_templates_args = array(
									'orderby'          => 'title',
									'order'            => 'ASC',
									'post_type'        => 'templatera',
									'post_status'      => 'publish',
									'posts_per_page'      => 100,
								);
								$jscomposer_templates = get_posts( $jscomposer_templates_args );
								if(count($jscomposer_templates) > 0) {
									foreach($jscomposer_templates as $jscomposer_template){
										if($jscomposer_template->post_title == 'Header 3'){
											echo do_shortcode(apply_filters( 'the_content', $jscomposer_template->post_content ));
										}
									}
								}
							} 
							?>
						</div>
					</div>
				</div>  
				<div class="clearfix"></div>
			</div>
			<div class="main-container front-page">
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="entry-content">
							<div class="container">
								<?php the_content(); ?>
							</div>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<div class="footer footer-2">
				<div class="container">
					<?php
					if ( isset($sneaker_opt['footer_layout']) && $sneaker_opt['footer_layout']!="" ) {
						$jscomposer_templates_args = array(
							'orderby'          => 'title',
							'order'            => 'ASC',
							'post_type'        => 'templatera',
							'post_status'      => 'publish',
						);
						$jscomposer_templates = get_posts( $jscomposer_templates_args );
						if(count($jscomposer_templates) > 0) {
							foreach($jscomposer_templates as $jscomposer_template){
								if($jscomposer_template->post_title == 'Footer 2'){
									echo do_shortcode(apply_filters( 'the_content', $jscomposer_template->post_content ));
								}
							}
						}
					}
					?>
				</div>
			</div>
		</div><!-- .page -->
	</div><!-- .wrapper -->
	<!--<div class="sneaker_loading"></div>-->
	<div id="back-top" class="hidden-xs hidden-sm hidden-md"></div>
	<?php wp_footer(); ?>
</body>
</html>
<?php unset($_SESSION["preset"]); ?>