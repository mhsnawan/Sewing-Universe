<?php
/**
 * Template Name: Contact Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Sneaker consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Sneaker_Theme
 * @since Sneaker 1.0
 */

$sneaker_opt = get_option( 'sneaker_opt' );

get_header();
?>
<div class="main-container contact-page">
	<div class="breadcrumb-container">
		<div class="container">
			<?php Sneaker_Class::sneaker_breadcrumb(); ?> 
		</div>
	</div>
	<?php while ( have_posts() ) : the_post(); ?>
		<div class="entry-content">
			<div class="container">
				<?php the_content(); ?>
			</div>
		</div><!-- .entry-content -->
	<?php endwhile; // end of the loop. ?>
	<!-- brand logo -->
	<?php 
		if(isset($sneaker_opt['inner_brand']) && function_exists('sneaker_brands_shortcode') && shortcode_exists( 'Sneaker' ) ){
			if($sneaker_opt['inner_brand'] && isset($sneaker_opt['brand_logos'][0]) && $sneaker_opt['brand_logos'][0]['thumb']!=null) { ?>
				<div class="inner-brands">
					<div class="container">
						<?php if(isset($sneaker_opt['inner_brand_title']) && $sneaker_opt['inner_brand_title']!=''){ ?>
							<div class="title">
								<h3><?php echo esc_html( $sneaker_opt['inner_brand_title'] ); ?></h3>
							</div>
						<?php } ?>
						<?php echo do_shortcode('[Sneaker]'); ?>
					</div>
				</div>
				
			<?php }
		}
	?>
	<!-- end brand logo -->  
</div>
<?php
if(isset($sneaker_opt['enable_map']) && $sneaker_opt['enable_map']) :
	//Add google map API
	wp_enqueue_script( 'gmap-api-js', 'http://maps.google.com/maps/api/js?sensor=false' , array(), '3', false );
	// Add jquery.gmap.js file
	wp_enqueue_script( 'jquery.gmap-js', get_template_directory_uri() . '/js/jquery.gmap.js', array(), '2.1.5', false );

	$map_desc = str_replace(array("\r\n", "\r", "\n"), "<br />", $sneaker_opt['map_desc']);
	$map_desc = addslashes($map_desc);
?>
<?php endif; ?>
<?php get_footer('contact'); ?>