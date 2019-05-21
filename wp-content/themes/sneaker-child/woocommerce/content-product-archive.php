<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product, $woocommerce_loop;
$sneaker_opt = get_option( 'sneaker_opt' );
$sneaker_viewmode = Sneaker_Class::sneaker_show_view_mode();
// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;
// Extra post classes
$classes = array();
$count   = $product->get_rating_count();
$sneaker_shopclass = Sneaker_Class::sneaker_shop_class('');
$colwidth = 3;
if($sneaker_shopclass=='shop-fullwidth') {
	if(isset($sneaker_opt)){
		$woocommerce_loop['columns'] = $sneaker_opt['product_per_row_fw'];
		if($woocommerce_loop['columns'] > 0){
			$colwidth = round(12/$woocommerce_loop['columns']);
		}
	}
	$classes[] = ' item-col col-6 col-md-4 col-xl-'.$colwidth ;
} else {
	if(isset($sneaker_opt)){
		$woocommerce_loop['columns'] = $sneaker_opt['product_per_row'];
		if($woocommerce_loop['columns'] > 0){
			$colwidth = round(12/$woocommerce_loop['columns']);
		}
	}
	$classes[] = ' item-col col-6 col-sm-6 col-md-4 col-xl-'.$colwidth ;
}
?>
<div <?php post_class( $classes ); ?>>
	<div class="product-wrapper gridview">
		<div class="list-col4">
			<div class="product-image">
				<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
				<?php //do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
				<?php 
					echo wp_kses($product->get_image('shop_catalog', array('class'=>'primary_image')), array(
						'a'=>array(
							'href'=>array(),
							'title'=>array(),
							'class'=>array(),
						),
						'img'=>array(
							'src'=>array(),
							'height'=>array(),
							'width'=>array(),
							'class'=>array(),
							'alt'=>array(),
						)
					));
					if(isset($sneaker_opt['second_image'])){
						if($sneaker_opt['second_image']){
							$attachment_ids = $product->get_gallery_image_ids();
							if ( $attachment_ids ) {
								echo wp_get_attachment_image( $attachment_ids[0], apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' ), false, array('class'=>'secondary_image') );
							}
						}
					}
				?>
				<?php if ( $product->is_on_sale() ) : ?>
					<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale"><span class="sale-bg"></span><span class="sale-text">' . esc_html__( 'Sale', 'sneaker' ) . '</span></span>', $post, $product ); ?>
				<?php endif; ?>
				<!-- end sale label -->
				<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
				<div class="count-down">
					<?php
					$countdown = false;
					$sale_end = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
					/* simple product */
					if($sale_end){
						$countdown = true;
						$sale_end = date('Y/m/d', (int)$sale_end);
						?>
						<div class="countbox hastime" data-time="<?php echo esc_attr($sale_end); ?>"></div>
					<?php } ?>
					<?php /* variable product */
					if($product->has_child()){
						$vsale_end = array();
						$pvariables = $product->get_children();
						foreach($pvariables as $pvariable){
							$vsale_end[] = (int)get_post_meta( $pvariable, '_sale_price_dates_to', true );
							if( get_post_meta( $pvariable, '_sale_price_dates_to', true ) ){
								$countdown = true;
							}
						}
						if($countdown){
							/* get the latest time */
							$vsale_end_date = max($vsale_end);
							$vsale_end_date = date('Y/m/d', $vsale_end_date);
							?>
							<div class="countbox hastime" data-time="<?php echo esc_attr($vsale_end_date); ?>"></div>
						<?php
						}
					}
					?>
				</div>
			</div>
		</div>
		<div class="list-col8">
			<div class="product-category-rating">
				<div class="product-category">
					<?php echo wc_get_product_category_list($product->get_id()); ?>
				</div>
				<?php if ($count) { ?>
					<div class="product-rating">
						<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
					</div>
				<?php } ?>
				<!-- hook rating -->
			</div>
			<div class="product-name">
				<?php do_action( 'woocommerce_shop_loop_item_title' ); ?>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</div>
			<?php if ( $product->get_price() != '' )  { ?>
				<div class="price-box">
					<div class="price-box-inner">
						<?php echo ''.$product->get_price_html(); ?>
					</div>
				</div>
			<?php } ?>
			<!-- end price -->
			<div class="product-button">
				<div class="add-to-cart">
					<?php echo do_shortcode('[add_to_cart id="'.$product->get_id().'"]') ?>
				</div>
				<ul class="actions">
					<li class="add-to-wishlist"> 
						<?php if ( class_exists( 'YITH_WCWL' ) ) {
							echo preg_replace("/<img[^>]+\>/i", " ", do_shortcode('[yith_wcwl_add_to_wishlist]'));
						} ?>
					</li>
					<li class="add-to-compare">
						<?php if( class_exists( 'YITH_Woocompare' ) ) {
							echo do_shortcode('[yith_compare_button]');
						} ?>
					</li>
					<li class="quickviewbtn">
						<a class="detail-link quickview fa fa-external-link" data-quick-id="<?php the_ID();?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php esc_html_e('Quick View', 'sneaker');?></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="product-wrapper listview">
		<div class="row">
			<div class="list-col4 <?php if($sneaker_viewmode=='list-view'){ echo ' col-12 col-md-4';} ?>">
				<div class="product-image">
					<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
					<?php //do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
					<?php 
						echo wp_kses($product->get_image('shop_catalog', array('class'=>'primary_image')), array(
							'a'=>array(
								'href'=>array(),
								'title'=>array(),
								'class'=>array(),
							),
							'img'=>array(
								'src'=>array(),
								'height'=>array(),
								'width'=>array(),
								'class'=>array(),
								'alt'=>array(),
							)
						));
						if(isset($sneaker_opt['second_image'])){
							if($sneaker_opt['second_image']){
								$attachment_ids = $product->get_gallery_image_ids();
								if ( $attachment_ids ) {
									echo wp_get_attachment_image( $attachment_ids[0], apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' ), false, array('class'=>'secondary_image') );
								}
							}
						}
					?>
					<?php if ( $product->is_on_sale() ) : ?>
						<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale"><span class="sale-bg"></span><span class="sale-text">' . esc_html__( 'Sale', 'sneaker' ) . '</span></span>', $post, $product ); ?>
					<?php endif; ?>
					<!-- end sale label -->
					<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
				</div>
			</div>
			<div class="list-col8 <?php if($sneaker_viewmode=='list-view'){ echo ' col-12 col-md-8';} ?>">
				<div class="product-category">
					<?php echo wc_get_product_category_list($product->get_id()); ?>
				</div>
				<div class="product-name">
					<?php do_action( 'woocommerce_shop_loop_item_title' ); ?>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</div>
				<?php if ($count) { ?>
					<div class="product-rating">
						<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
					</div>
				<?php } ?>
				<!-- hook rating -->
				<?php if ( $product->get_price() != '' )  { ?>
					<div class="price-box">
						<div class="price-box-inner">
							<?php echo ''.$product->get_price_html(); ?>
						</div>
					</div>
				<?php } ?>
				<!-- end price -->
				<?php if ( has_excerpt() ) { ?>
					<div class="product-desc">
						<?php the_excerpt(); ?>
					</div>
				<?php } ?>
				<!-- end desc -->
				<div class="product-button">
					<div class="add-to-cart">
						<?php echo do_shortcode('[add_to_cart id="'.$product->get_id().'"]') ?>
					</div>
					<ul class="actions">
						<li class="add-to-wishlist"> 
							<?php if ( class_exists( 'YITH_WCWL' ) ) {
								echo preg_replace("/<img[^>]+\>/i", " ", do_shortcode('[yith_wcwl_add_to_wishlist]'));
							} ?>
						</li>
						<li class="add-to-compare">
							<?php if( class_exists( 'YITH_Woocompare' ) ) {
								echo do_shortcode('[yith_compare_button]');
							} ?>
						</li>
						<li class="quickviewbtn">
							<a class="detail-link quickview fa fa-external-link" data-quick-id="<?php the_ID();?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php esc_html_e('Quick View', 'sneaker');?></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>