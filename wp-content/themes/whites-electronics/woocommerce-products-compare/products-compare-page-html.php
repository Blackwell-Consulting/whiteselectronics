<?php
/**
 * The compare page template file
 *
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

include(get_partial_path('header')); ?>

<noscript><?php _e( 'Sorry, you must have Javascript enabled in your browser to use compare products', 'woocommerce-products-compare' ); ?></noscript>

<div class="woocommerce-products-compare-content woocommerce">
<h1 class="compare-header">Compare Products</h1>
	<?php 

	$products = WC_Products_Compare_Frontend::get_compared_products();

	if ( $products ) {
		global $product, $post;

		$columns = count( $products );

		// calculate each columns width in percentage
		$column_width = floor( 100 / ( $columns + 1 ) ); // +1 to account for first header column

		// get all row headers
		$headers = WC_Products_Compare_Frontend::get_product_meta_headers( $products );
	?>

		<table>
			<!--thead-->
			<thead>
				<tr class="products">
					<?php do_action( 'woocommerce_before_shop_loop' ); ?>

					<th class="header-title" style="width:<?php echo esc_attr( $column_width ); ?>%">
						<h3><?php _e( 'Products', 'woocommerce-products-compare' ); ?></h3>
					</th>

					<?php foreach( $products as $product ) { 
						$product = wc_get_product( $product );

						if ( ! WC_Products_Compare::is_product( $product ) ) {
							continue;
						}

						$post = $product->post;
					?>

						<td class="product" data-product-id="<?php echo esc_attr( $product->id ); ?>" style="width:<?php echo esc_attr( $column_width ); ?>%">
							<a href="#" title="<?php esc_attr_e( 'Remove Product', 'woocommerce-products-compare' ); ?>" class="remove-compare-product" data-remove-id="<?php echo esc_attr( $product->id ); ?>"></a>
							<div class="product-link">
								
								<?php woocommerce_show_product_loop_sale_flash(); ?>
								
								<?php echo $product->get_image( 'shop_single' ); ?>

								<h3><?php echo $post->post_title; ?></h3>
													
							</div>
						</td>
					<?php } ?>
				</tr>


				<tr class="products price-row">
					<th class="header-title">
						<h3><?php _e( 'Price', 'woocommerce-products-compare' ); ?></h3>
					</th>

					<?php foreach( $products as $product ) { 
						$product = wc_get_product( $product );

						if ( ! WC_Products_Compare::is_product( $product ) ) {
							continue;
						}
					?>
						<td class="product" data-product-id="<?php echo esc_attr( $product->id ); ?>">
							<?php woocommerce_template_loop_price(); ?>			
						</td>
					<?php } ?>
				</tr>
			</thead>
			<!--thead end-->

			<!--tfoot-->
			<tfoot>
				<tr class="products">
				
					<td>&nbsp;</td>

					<?php foreach( $products as $product ) { 
						$product = wc_get_product( $product );

						if ( ! WC_Products_Compare::is_product( $product ) ) {
							continue;
						}

						$post = $product->post;
					?>

						<td class="product" data-product-id="<?php echo esc_attr( $product->id ); ?>">

							<?php woocommerce_template_loop_price(); ?>

							<?php if ($product->is_in_stock()) : ?>
								<?php woocommerce_template_loop_add_to_cart(); ?>
							<?php else : ?>
								<span class="out-of-stock"><?php _e("Out of Stock"); ?></span>
							<?php endif; ?>

						</td>
					<?php } ?>
				</tr>
			</tfoot>
			<!--tfoot end-->

			<!--tbody-->
			<tbody>

				<?php foreach( $headers as $header ) { ?>
					<tr>
						<th>
							<?php 
								if ( $header === 'stock' ) {
									echo __( 'Stock', 'woocommerce-products-compare' );

								} elseif ( $header === 'description' ) {
									echo __( 'Description', 'woocommerce-products-compare' );

								} elseif ( $header === 'sku' ) {
									echo __( 'SKU', 'woocommerce-products-compare' );

								} else { 
									echo wc_attribute_label( $header );
								} 
							?>
						</th>

						<?php foreach( $products as $product ) { 
							$product = wc_get_product( $product );

							if ( ! WC_Products_Compare::is_product( $product ) ) {
								continue;
							}
							
							$post = $product->post;
							$attributes = $product->get_attributes();
						?>
							<td class="product" data-product-id="<?php echo esc_attr( $product->id ); ?>">
								<?php 
									if ( $header === 'stock' && $product->managing_stock() ) {
										$productAvailability = $product->get_availability();
										$class = $productAvailability['class'];
										$availability = $productAvailability['availability'];

										echo '<span class="stock-status ' . esc_attr( $class ) . '">' . $availability . '</span>' . PHP_EOL;

									} elseif ( $header === 'description' ) {
										echo wp_strip_all_tags( $post->post_excerpt );

									} elseif ( $header === 'sku' ) {
										echo $product->get_sku();

									} elseif ( array_key_exists( $header, $attributes ) ) {

										if ( $attributes[ $header ]['is_taxonomy'] ) {

											$values = wc_get_product_terms( $product->id, $attributes[ $header ]['name'], array( 'fields' => 'names' ) );
											echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attributes[ $header ], $values );

										} else {

											// Convert pipes to commas and display values
											$values = array_map( 'trim', explode( WC_DELIMITER, $attributes[ $header ]['value'] ) );
											echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attributes[ $header ], $values );

										}
									}
								?>
							</td>
						<?php } ?>
					</tr>
				<?php } ?>
			</tbody>
			<!--tbody end-->

		</table>

	<?php
	} else { ?>

	<div class="no-products">

		<p>Sorry you do not have any products to compare</p>

	</div>
	<?php
	}
	?>

</div><!--.woocommerce-products-compare-content-->

<?php include(get_partial_path('footer')); ?>
