<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$has_row    = false;
$alt        = 1;
$attributes = $product->get_attributes();

ob_start(); ?>

<?php if ($attributes) { ?>

	<div class="product-specs">

		<?php
		global $product;

		$heading = apply_filters( 'woocommerce_product_additional_information_heading', __( 'Additional Information', 'woocommerce' ) ); ?>

		<h2 class="title">Specs</h2>

		<ul class="shop_attributes">

			<?php if ( $product->enable_dimensions_display() ) : ?>

				<?php if ( $product->has_dimensions() ) : $has_row = true; ?>
					<li class="<?php if ( ( $alt = $alt * -1 ) == 1 ) echo 'alt'; ?>">
						<h3><?php _e( 'Dimensions', 'woocommerce' ) ?></h3>
						<span class="product_dimensions"><?php echo $product->get_dimensions(); ?></span>
					</li>
				<?php endif; ?>

			<?php endif; ?>

			<?php foreach ( $attributes as $attribute ) :
				if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) {
					continue;
				} else {
					$has_row = true;
				}
				?>
				<li class="attribute <?php if ( ( $alt = $alt * -1 ) == 1 ) echo 'alt'; ?>">
					<span class="spec-icon <?php echo strtolower(str_replace(' ', '-', wc_attribute_label( $attribute['name'] ))); ?>"></span>
					<h3><?php echo wc_attribute_label( $attribute['name'] ); ?></h3>
					<span><?php
						if ( $attribute['is_taxonomy'] ) {

							$values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
							echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );

						} else {

							// Convert pipes to commas and display values
							$values = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );
							echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );

						}
					?></span>
				</li>
			<?php endforeach; ?>

		</ul>
		<?php
		if ( $has_row ) {
			echo ob_get_clean();
		} else {
			ob_end_clean();
		} ?>
	</div>
<?php } ?>
