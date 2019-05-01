<?php
/**
 * The sidebar for content page
 *
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage Sneaker_Theme
 * @since Sneaker 1.0
 */
$sneaker_opt = get_option( 'sneaker_opt' );
$sneaker_page_sidebar_extra_class = NULl;
if($sneaker_opt['sidebarse_pos']=='left') {
	$sneaker_page_sidebar_extra_class = 'order-lg-first';
}
?>
<?php if ( is_active_sidebar( 'sidebar-page' ) ) : ?>
<div id="secondary" class="col-12 col-lg-3 <?php echo esc_attr($sneaker_page_sidebar_extra_class);?>">
	<?php dynamic_sidebar( 'sidebar-page' ); ?>
</div>
<?php endif; ?>