<?php
/**
 * Loop Add to Cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$prod_url = $product->add_to_cart_url();
if (strpos($product->add_to_cart_url(), 'products-compare') !== false) {
    /*
     * Just in case there's a bug where the compare doesn't recognize a language switch for add to cart.
     * $lang = (strcmp(ICL_LANGUAGE_CODE, 'en') != 0) ? '&lang=' . ICL_LANGUAGE_CODE : '';
     * $prod_url = home_url('/cart/?add-to-cart=' . $product->id) . $lang;
     */

    $prod_url = home_url('/cart/?add-to-cart=' . $product->id);
}

echo apply_filters( 'woocommerce_loop_add_to_cart_link',
	sprintf( '<a target="_top" href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s product_type_%s">%s</a>',
        esc_url( $prod_url ),
		esc_attr( $product->id ),
		esc_attr( $product->get_sku() ),
		esc_attr( isset( $quantity ) ? $quantity : 1 ),
		$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
		esc_attr( $product->product_type ),
		esc_html( $product->add_to_cart_text() )
	),
$product );
