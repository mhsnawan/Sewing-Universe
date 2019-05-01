<?php
/**
 * Template Name: About Template
 *
 * Description: About page template
 *
 * @package WordPress
 * @subpackage Sneaker_Theme
 * @since Sneaker 1.0
 */
$sneaker_opt = get_option( 'sneaker_opt' );

get_header();
?>
<div class="main-container about-page">
	<div class="breadcrumb-container">
		<div class="container">
			<?php Sneaker_Class::sneaker_breadcrumb(); ?> 
		</div>
	</div>
	<div class="about-container">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="container">
				<?php get_template_part( 'content', 'page' ); ?>
			</div>
		<?php endwhile; ?>
	</div>
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
<?php get_footer(); ?>