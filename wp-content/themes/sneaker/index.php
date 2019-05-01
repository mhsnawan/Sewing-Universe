<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
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
$sneaker_blog_main_extra_class = NULl;
if($sneaker_blogsidebar=='left') {
	$sneaker_blog_main_extra_class = 'order-lg-last';
}
$main_column_class = NULL;
switch($sneaker_bloglayout) {
	case 'sidebar':
		$sneaker_blogclass = 'blog-sidebar';
		$sneaker_blogcolclass = 9;
		$main_column_class = 'main-column';
		Sneaker_Class::sneaker_post_thumbnail_size('sneaker-post-thumb');
		break;
	case 'largeimage':
		$sneaker_blogclass = 'blog-large';
		$sneaker_blogcolclass = 9;
		$main_column_class = 'main-column';
		Sneaker_Class::sneaker_post_thumbnail_size('sneaker-post-thumbwide');
		break;
	case 'grid':
		$sneaker_blogclass = 'grid';
		$sneaker_blogcolclass = 9;
		$main_column_class = 'main-column';
		Sneaker_Class::sneaker_post_thumbnail_size('sneaker-post-thumbwide');
		break;
	default:
		$sneaker_blogclass = 'blog-nosidebar';
		$sneaker_blogcolclass = 12;
		$sneaker_blogsidebar = 'none';
		Sneaker_Class::sneaker_post_thumbnail_size('sneaker-post-thumb');
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
			<div class="col-12 <?php echo 'col-lg-'.$sneaker_blogcolclass; ?> <?php echo ''.$main_column_class; ?> <?php echo esc_attr($sneaker_blog_main_extra_class);?>">
				<div class="page-content blog-page blogs <?php echo esc_attr($sneaker_blogclass); ?>">
					<header class="entry-header">
						<h1 class="entry-title"><?php if(isset($sneaker_opt) && ($sneaker_opt !='')) { echo esc_html($sneaker_opt['blog_header_text']); } else { esc_html_e('Blog', 'sneaker');}  ?></h1>
					</header>
					<div class="blog-wrapper">
						<?php if ( have_posts() ) : ?>
							<div class="post-container">
								<?php /* Start the Loop */ ?>
								<?php while ( have_posts() ) : the_post(); ?>
									<?php get_template_part( 'content', get_post_format() ); ?>
								<?php endwhile; ?>
							</div>
							<?php Sneaker_Class::sneaker_pagination(); ?>
						<?php else : ?>
							<article id="post-0" class="post no-results not-found">
							<?php if ( current_user_can( 'edit_posts' ) ) :
								// Show a different message to a logged-in user who can add posts.
							?>
								<header class="entry-header">
									<h1 class="entry-title"><?php esc_html_e( 'No posts to display', 'sneaker' ); ?></h1>
								</header>
								<div class="entry-content">
									<p><?php printf( wp_kses(__( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'sneaker' ), array('a'=>array('href'=>array()))), admin_url( 'post-new.php' ) ); ?></p>
								</div><!-- .entry-content -->
							<?php else :
								// Show the default message to everyone else.
							?>
								<header class="entry-header">
									<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'sneaker' ); ?></h1>
								</header>
								<div class="entry-content">
									<p><?php esc_html_e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'sneaker' ); ?></p>
									<?php get_search_form(); ?>
								</div><!-- .entry-content -->
							<?php endif; // end current_user_can() check ?>
							</article><!-- #post-0 -->
						<?php endif; // end have_posts() check ?>
					</div>
				</div>
			</div>
			<?php if($sneaker_bloglayout!='nosidebar' && is_active_sidebar('sidebar-1')): ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
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