<?php
/**
 * The sidebar for shop page
 *
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage Sneaker_Theme
 * @since Sneaker 1.0
 */
$sneaker_opt = get_option( 'sneaker_opt' );
$shopsidebar = 'left';
if(isset($sneaker_opt['sidebarshop_pos']) && $sneaker_opt['sidebarshop_pos']!=''){
	$shopsidebar = $sneaker_opt['sidebarshop_pos'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$shopsidebar = $_GET['sidebar'];
}
$sneaker_shop_sidebar_extra_class = NULl;
if($shopsidebar=='left') {
	$sneaker_shop_sidebar_extra_class = 'order-lg-first';
}
?>
<?php if ( is_active_sidebar( 'sidebar-shop' ) ) : ?>
	<div id="secondary" class="col-12 col-lg-3 sidebar-shop <?php echo esc_attr($sneaker_shop_sidebar_extra_class);?>">
		<?php dynamic_sidebar( 'sidebar-shop' ); ?>
	</div>
<?php endif; ?>