<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

?>
<li itemprop="review" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

		<?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '60' ), '' ); ?>

		<div class="comment-text">
			<div class="meta-info">

				<?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) : ?>

					<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( __( 'Rated %d out of 5', 'woocommerce' ), $rating ) ?>">
						<span style="width:<?php echo ( $rating / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo $rating; ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?></span>
					</div>

				<?php endif; ?>

				<?php if ( $comment->comment_approved == '0' ) : ?>

					<p class="meta"><em><?php _e( 'Your comment is awaiting approval', 'woocommerce' ); ?></em></p>

				<?php else : ?>

					<p class="meta">
						<strong itemprop="author"><?php comment_author(); ?></strong>
					</p>

				<?php endif; ?>
			</div>

			<div itemprop="description" class="description"><?php comment_text(); ?></div>
		</div>
	</div>
