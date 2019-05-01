<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Sneaker_Theme
 * @since Sneaker 1.0
 */
$sneaker_opt = get_option( 'sneaker_opt' );
get_header();
$sneaker_bloglayout = 'sidebar';
if(isset($sneaker_opt['blog_layout']) && $sneaker_opt['blog_layout']!=''){
	$sneaker_bloglayout = $sneaker_opt['blog_layout'];
}
if(isset($_GET['layout']) && $_GET['layout']!=''){
	$sneaker_bloglayout = $_GET['layout'];
}
$sneaker_blogsidebar = 'right';
if(isset($sneaker_opt['sidebarblog_pos']) && $sneaker_opt['sidebarblog_pos']!=''){
	$sneaker_blogsidebar = $sneaker_opt['sidebarblog_pos'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$sneaker_blogsidebar = $_GET['sidebar'];
}
if ( !is_active_sidebar( 'sidebar-1' ) )  {
	$sneaker_bloglayout = 'nosidebar';
}
$main_column_class = NULL;
switch($sneaker_bloglayout) {
	case 'sidebar':
		$sneaker_blogclass = 'blog-sidebar';
		$sneaker_blogcolclass = 9;
		$main_column_class = 'main-column';
		break;
	default:
		$sneaker_blogclass = 'blog-nosidebar'; //for both fullwidth and no sidebar
		$sneaker_blogcolclass = 12;
		$sneaker_blogsidebar = 'none';
}
?>
<div class="main-container">
	<div class="breadcrumb-container">
		<div class="container">
			<?php Sneaker_Class::sneaker_breadcrumb(); ?> 
		</div>
	</div>
	<div class="container">
		<div class="row">
			<?php
			$customsidebar = get_post_meta( $post->ID, '_sneaker_custom_sidebar', true );
			$customsidebar_pos = get_post_meta( $post->ID, '_sneaker_custom_sidebar_pos', true );
			if($customsidebar != ''){
				if($customsidebar_pos == 'left' && is_active_sidebar('sidebar-1') ) {
					echo '<div id="secondary" class="col-12 col-lg-3">';
						dynamic_sidebar( $customsidebar );
					echo '</div>';
				} 
			} else {
				if($sneaker_blogsidebar=='left' && is_active_sidebar( 'sidebar-single_product' )) {
					get_sidebar();
				}
			} ?>
			<div class="col-12 <?php echo 'col-lg-'.$sneaker_blogcolclass; ?> <?php echo ''.$main_column_class; ?>">
				<div class="page-content blog-page single <?php echo esc_attr($sneaker_blogclass); if($sneaker_blogsidebar=='left') {echo ' left-sidebar'; } if($sneaker_blogsidebar=='right') {echo ' right-sidebar'; } ?>">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
						<?php comments_template( '', true ); ?>
					<?php endwhile; // end of the loop. ?>
				</div>
			</div>
			<?php
			if($customsidebar != ''){
				if($customsidebar_pos == 'right' && is_active_sidebar( $customsidebar ) ) {
					echo '<div id="secondary" class="col-12 col-lg-3">';
						dynamic_sidebar( $customsidebar );
					echo '</div>';
				} 
			} else {
				if($sneaker_blogsidebar=='right' && is_active_sidebar('sidebar-1')) {
					get_sidebar();
				}
			} ?>
		</div>
	</div> 
	<!-- brand logo -->
	<?php 
		if(isset($sneaker_opt['inner_brand']) && function_exists('sneaker_brands_shortcode') && shortcode_exists( 'ourbrands' ) ){
			if($sneaker_opt['inner_brand'] && isset($sneaker_opt['brand_logos'][0]) && $sneaker_opt['brand_logos'][0]['thumb']!=null) { ?>
				<div class="inner-brands">
					<div class="container">
						<?php if(isset($sneaker_opt['inner_brand_title']) && $sneaker_opt['inner_brand_title']!=''){ ?>
							<div class="heading-title style1 ">
								<h3><?php echo esc_html( $sneaker_opt['inner_brand_title'] ); ?></h3>
							</div>
						<?php } ?>
						<?php echo do_shortcode('[ourbrands]'); ?>
					</div>
				</div>
			<?php }
		}
	?>
	<!-- end brand logo --> 
</div>
<?php get_footer(); ?>