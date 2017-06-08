<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div class="outer-wrapper">

	<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="product-wrapper">

			<div class="name-and-price">
				<h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>

				<?php
				global $product; ?>

				<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
					<p class="price"><?php echo $product->get_price_html(); ?></p>
					<meta itemprop="price" content="<?php echo esc_attr( $product->get_price() ); ?>" />
					<meta itemprop="priceCurrency" content="<?php echo esc_attr( get_woocommerce_currency() ); ?>" />
				</div>

				<?php
				global $product;

				if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
					return;
				?>

				<?php if ( $rating_html = $product->get_rating_html() ) : ?>
					<?php echo $rating_html; ?>
				<?php endif; ?>

			</div>

			<?php
			global $post, $product; ?>

			<?php if ( $product->is_on_sale() ) : ?>

				<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . __( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); ?>

			<?php endif;

			global $post, $woocommerce, $product; ?>

			<div class="images-gallery">

			<?php
			/**
			 * woocommerce_before_single_product_summary hook.
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
			?>

			</div>

			<div class="buy-now">

				<?php do_action( 'woocommerce_single_product_summary' ); ?>

			</div>
		</div>

		<div class="product-information">
			<div class="bg-image"></div>

			<div class="product-wrapper">

				<div class="description-section open">

				<?php
					global $post;

					if ( ! $post->post_excerpt ) {
						return;
					} ?>

					<!-- <div itemprop="description">
						<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
					</div> -->

					<?php
					global $post;

					$heading = esc_html( apply_filters( 'woocommerce_product_description_heading', __( 'Product Description', 'woocommerce' ) ) );

					?>

					<?php if ( $heading ): ?>
					  <h2 class="title">Details</h2>
					<?php endif; ?>

					<div class="content">

						<?php the_content(); ?>

						<?php
						global $post, $product;

						$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
						$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

						?>
						<div class="product_meta">

							<?php do_action( 'woocommerce_product_meta_start' ); ?>

							<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

								<span class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ); ?></span></span>

							<?php endif; ?>

							<?php do_action( 'woocommerce_product_meta_end' ); ?>

						</div>
					</div>
				</div>
				<div class="content">
					<?php $product->list_attributes(); ?>
				</div>
				<div class="reviews-block">
					<h2 class="title">Reviews</h2>
					<div class="content">

						<?php comments_template( 'woocommerce/single-product-reviews' ); ?>
					</div>
				</div>

				<?php
				$crosssell_ids = get_post_meta( get_the_ID(), '_crosssell_ids' );

				if ( $crosssell_ids ) {
					$crosssell_ids= $crosssell_ids[0];

					if ( count($crosssell_ids) > 0 ) {
						$args = array( 'post_type' => 'product', 'posts_per_page' => 4, 'post__in' => $crosssell_ids );
						$loop = new WP_Query( $args ); ?>

						<div class="recommended-accessories">
							<h2>Accessories You Might Be Interested In</h2>
							<ul>

							<?php
							while ( $loop->have_posts() ) : $loop->the_post();
							$price = get_post_meta( get_the_ID(), '_regular_price', true); ?>
								<li>
									<a href='<?php the_permalink(); ?>'>
										<?php the_post_thumbnail( 'thumbnail' ); ?>
										<h3><?php the_title(); ?></h3>
										<span class="price">
											<?php echo $price; ?>
										</span>
									</a>
								</li>
							<?php
							endwhile; ?>

							</ul>
						</div>

					<?php
					}
				}

				wp_reset_query(); ?>

				<div id="reviews">

					<div id="review_form_wrapper">
						<div id="review_form">
						<div class="response-container"></div>
							<?php
								$commenter = wp_get_current_commenter();

								$comment_form = array(
									'title_reply'          => have_comments() ? __( 'Add a review', 'woocommerce' ) : __( 'Be the first to review', 'woocommerce' ) . ' &ldquo;' . get_the_title() . '&rdquo;',
									'title_reply_to'       => __( 'Leave a Reply to %s', 'woocommerce' ),
									'comment_notes_before' => '',
									'comment_notes_after'  => '',
									'fields'               => array(
										'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'woocommerce' ) . ' <span class="required">*</span></label> ' .
										            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
										'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'woocommerce' ) . ' <span class="required">*</span></label> ' .
										            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
									),
									'label_submit'  => __( 'Submit', 'woocommerce' ),
									'logged_in_as'  => '',
									'comment_field' => ''
								);

								if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
									$comment_form['must_log_in'] = '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'woocommerce' ), esc_url( $account_page_url ) ) . '</p>';
								}

								if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
									$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . __( 'Your Rating', 'woocommerce' ) .'</label><select name="rating" id="rating">
										<option value="">' . __( 'Rate&hellip;', 'woocommerce' ) . '</option>
										<option value="5">' . __( 'Perfect', 'woocommerce' ) . '</option>
										<option value="4">' . __( 'Good', 'woocommerce' ) . '</option>
										<option value="3">' . __( 'Average', 'woocommerce' ) . '</option>
										<option value="2">' . __( 'Not that bad', 'woocommerce' ) . '</option>
										<option value="1">' . __( 'Very Poor', 'woocommerce' ) . '</option>
									</select></p>';
								}

								$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . __( 'Your Review', 'woocommerce' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';

								comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
							?>
						</div>
					</div>
				</div>

				<meta itemprop="url" content="<?php the_permalink(); ?>" />


		</div><?php //product-wrapper ?>
	</div><!-- #product-<?php the_ID(); ?> -->

	<?php
	if ( have_rows('adventurers') ):
		$bgImage = get_field('background_image','options'); ?>

		<div class="used-by-adventurers-container">
			<div class="bg-image" style="background-image: url('<?php echo $bgImage['url']; ?>');"></div>
			<div class="product-wrapper">
				<div class="used-by-adventurers">
					<h2>Used By Adventurers</h2>

					<div class="adventurers-container">

					<?php
					while ( have_rows('adventurers') ) : the_row(); ?>

						<div class="adventurer">

							<?php $post_object = get_sub_field('adventurer');

	                    	if ( $post_object ) :

	                        	$post = $post_object; setup_postdata( $post );
	                        	$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); ?>

								<a href="<?php the_permalink(); ?>">
									<h3><?php the_title(); ?></h3>
									<img src="<?php echo $url; ?>" />
								</a>

								<?php
								wp_reset_postdata();

	                    	endif; ?>

						</div>

					<?php
					endwhile; ?>

					</div>
				</div>
			</div>
		</div>
	<?php
	endif; ?>
	</div>

</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
