<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$heroBgImage = get_field('hero_background', 6);
$title = get_field('page_title', 6);
$subtitle = get_field('subtitle', 6);

get_header(); ?>

<div class="outer-wrapper">
  <div class="hero">
    <div class="bg-image" style="background-image: url('<?php echo $heroBgImage['sizes']['large'] ?>')"></div>
    <?php
    if(!$subtitle) {
        echo '<h1 class="no-subtitle">' . $title . '</h1>';
    }
    else {
        echo '<h1>' . $title . '</h1>';
        echo '<h2>' . $subtitle . '</h2>';
    } ?>
  </div>
</div>
<div class="outer-wrapper">
	<div class="alert">
  	  <p><span>Need Help?</span> We'll point you to the metal detector that's right for you.</p>
  	  <a class="capitalize" href="#">Detector Selector</a>
  	  <span class="dismiss capitalize">Dismiss</span>
  	</div>

	<div class="compare-button">
		<div class="button-disable">
			<a href="<?php echo home_url('/products-compare'); ?>" title="Compare Page" class="woocommerce-products-compare-compare-link">Compare Products</a>
		</div>
  	</div>

  	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php
			/**
			 * woocommerce_archive_description hook
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>
</div>

<?php
	/**
	 * woocommerce_after_shop_loop hook
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
?>

<?php get_footer(); ?>
