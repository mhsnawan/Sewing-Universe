<?php
/**
 * The template for displaying Author Archive pages
 *
 * Used to display archive-type pages for posts by an author.
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
				<div class="page-content blog-page blogs <?php echo esc_attr($sneaker_blogclass); if($sneaker_blogsidebar=='left') {echo ' left-sidebar'; } if($sneaker_blogsidebar=='right') {echo ' right-sidebar'; } ?>">
					<header class="entry-header">
						<h2 class="entry-title"><?php the_archive_title(); ?></h2>
					</header>
					<?php if ( have_posts() ) : ?>
						<?php
							/* Queue the first post, that way we know
							 * what author we're dealing with (if that is the case).
							 *
							 * We reset this later so we can run the loop
							 * properly with a call to rewind_posts().
							 */
							the_post();
						?>
						<?php
						// If a user has filled out their description, show a bio on their entries.
						if ( get_the_author_meta( 'description' ) ) : ?>
							<div class="archive-header">
								<h3 class="archive-title"><?php printf( esc_html__( 'Author Archives: %s', 'sneaker' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h3>
								<div class="author-info archives">
									<div class="author-avatar">
										<?php
										/**
										 * Filter the author bio avatar size.
										 *
										 * @since Sneaker 1.0
										 *
										 * @param int $size The height and width of the avatar in pixels.
										 */
										$author_bio_avatar_size = apply_filters( 'sneaker_author_bio_avatar_size', 68 );
										echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
										?>
									</div><!-- .author-avatar -->
									<div class="author-description">
										<h2><?php printf( esc_html__( 'About %s', 'sneaker' ), get_the_author() ); ?></h2>
										<p><?php the_author_meta( 'description' ); ?></p>
									</div><!-- .author-description	-->
								</div><!-- .author-info -->
							</div><!-- .archive-header -->
						<?php endif; ?>
						<?php
							/* Since we called the_post() above, we need to
							 * rewind the loop back to the beginning that way
							 * we can run the loop properly, in full.
							 */
							rewind_posts();
						?>
						<div class="post-container">
							<?php /* Start the Loop */ ?>
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'content', get_post_format() ); ?>
							<?php endwhile; ?>
						</div>
						<?php Sneaker_Class::sneaker_pagination(); ?>
					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>
				</div>
			</div>
			<?php get_sidebar(); ?>
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