<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see       https://docs.woothemes.com/document/template-structure/
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version     2.5.0
 */


if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

global $product, $yith_wcwl;
?>

<div class="gg-product-meta">

  <?php 
  /**
   * Enable/Disable Add to cart
   */
  if ( get_theme_mod('store_add_to_cart', 1) != 0 ) { ?>
  <div class="add-to-cart-wrapper">
  <?php 
  echo apply_filters( 'woocommerce_loop_add_to_cart_link',
    sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
      esc_url( $product->add_to_cart_url() ),
      esc_attr( isset( $quantity ) ? $quantity : 1 ),
      esc_attr( $product->id ),
      esc_attr( $product->get_sku() ),
      esc_attr( isset( $class ) ? $class : 'button' ),
      esc_html( $product->add_to_cart_text() )
    ),
  $product );
  ?>
  </div>
  <?php } ?>

  <div class="extra-meta-wrapper">
  <?php
  if ( class_exists( 'YITH_WCWL_Init' ) ) { 
  if (get_theme_mod('store_add_to_wishlist', 1 ) == 1) { 
  ?>
    <div class="add-to-wishlist-wrapper">
      <?php echo GG_YITH::add_to_wishlist_button( $yith_wcwl->get_wishlist_url(), $product->product_type, $yith_wcwl->is_product_in_wishlist( $product->id ) ); ?>
    </div>
  <?php } } ?>

  <?php
  if ( class_exists( 'YITH_Woocompare' ) ) { 
  if (get_theme_mod('store_add_to_compare', 1 ) == 1) { 
  ?>
  <div class="compare-wrapper">
    <?php echo do_shortcode('[yith_compare_button container="no"]'); ?>
  </div>
  <?php } } ?>

  </div>

</div>