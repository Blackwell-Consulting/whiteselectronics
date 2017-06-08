<?php
/**
 * Display single product reviews (comments)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.2
 */
global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div id="reviews-only">
	<div id="comments">

			<?php if ( have_comments() ) { ?>

				<?php
				global $product;

				$rating_count = $product->get_rating_count();
				$review_count = $product->get_review_count();
				$average      = $product->get_average_rating();

				if ( $rating_count > 1 ) { ?>

					<div class="review-pagination">

						<div class="comment-number">Reviews 1/<?php comments_number( '%', '%', '%' ); ?></div>

						<div class="woocommerce-product-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
							<div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>">
								<span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
									<strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average ); ?></strong> <?php printf( __( 'out of %s5%s', 'woocommerce' ), '<span itemprop="bestRating">', '</span>' ); ?>
									<?php printf( _n( 'based on %s customer rating', 'based on %s customer ratings', $rating_count, 'woocommerce' ), '<span itemprop="ratingCount" class="rating">' . $rating_count . '</span>' ); ?>
								</span>
							</div>
						</div>
					</div>

					<ol class="commentlist">
						<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
					</ol>

				<?php
				} elseif ( $rating_count == 1 ) { ?>

					<div class="review-pagination">

						<div class="comment-number">Reviews 1/1</div>

						<div class="woocommerce-product-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
							<div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>">
								<span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
									<strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average ); ?></strong> <?php printf( __( 'out of %s5%s', 'woocommerce' ), '<span itemprop="bestRating">', '</span>' ); ?>
									<?php printf( _n( 'based on %s customer rating', 'based on %s customer ratings', $rating_count, 'woocommerce' ), '<span itemprop="ratingCount" class="rating">' . $rating_count . '</span>' ); ?>
								</span>
							</div>
						</div>
					</div>

					<ol class="commentlist">
						<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
					</ol>

				<?php
				} elseif ( $rating_count < 1 ) { ?>

					<div class="review-pagination no-reviews">
						<div class="comment-number">Reviews</div>
					</div>

						<div class="first-to-review">
							<a class="link-to-reviews" href="#"><?php echo 'Be the first to review' . ' &ldquo;' . get_the_title() . '&rdquo;'; ?></a>
						</div>

				<?php }

		} else { ?>
		<div class="review-pagination no-reviews">
			<div class="comment-number">Reviews</div>
		</div>

			<div class="first-to-review">
				<a class="link-to-reviews" href="#"><?php echo 'Be the first to review' . ' &ldquo;' . get_the_title() . '&rdquo;'; ?></a>
			</div>

		<?php } ?>
	</div>
</div>
