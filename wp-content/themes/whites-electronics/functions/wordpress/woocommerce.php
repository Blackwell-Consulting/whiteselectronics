<?php

// --------------------------------
// WooCommerce
// --------------------------------

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

add_filter( 'get_terms', 'get_subcategory_terms', 10, 3 );

function get_subcategory_terms( $terms, $taxonomies, $args ) {

	$new_terms = array();

	// if a product category and on the shop page
	if ( in_array( 'product_cat', $taxonomies ) && is_shop() && !is_search() ) {

		foreach ( $terms as $key => $term ) {

			if ( ! in_array( $term->slug, array( 'default-category', 'whiteselectronicsuk' ) ) ) {
				$new_terms[] = $term;
			}

		}

		$terms = $new_terms;
	}

	return $terms;
}

function remove_loop_button(){
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}
add_action('init','remove_loop_button');

add_filter( 'woocommerce_enqueue_styles', '__return_false');


//-------------------------------------------------------------------------------
// Product Compare Filter
//-------------------------------------------------------------------------------
add_filter('woocommerce_products_compare_compare_button', 'we_prod_compare_btn', 10, 1);
function we_prod_compare_btn ($html) {

	global $post; $postid = $post->ID; ?>

	 	<div class="woocommerce-products-compare-compare-button checkbox-container">
	 		<input type="checkbox" class="woocommerce-products-compare-checkbox" data-product-id="<?php echo $postid ?>" id="woocommerce-products-compare-checkbox-<?php echo $postid ?>" />
	 		<label for="woocommerce-products-compare-checkbox-<?php echo $postid ?>"></label>
		</div>

	<?php
	return;
}


/* Conditional Tag to check if its a term or any of its children
*
* @param $terms - (string/array) list of term ids
*
* @param $taxonomy - (string) the taxonomy name of which the holds the terms.
*/
function is_or_descendant_tax( $terms,$taxonomy){
    if (is_tax($taxonomy, $terms)){
            return true;
    }
    foreach ( (array) $terms as $term ) {
        // get_term_children() accepts integer ID only
        $descendants = get_term_children( (int) $term, $taxonomy);
        if ( $descendants && is_tax($taxonomy, $descendants) )
            return true;
    }
    return false;
}


/**
 * Register our sidebars and widgetized areas.
 *
 */
function whites_widgets_init() {

	register_sidebar( array(
		'name'          => 'Product Filters',
		'id'            => 'product_filters',
		'before_widget' => '<div class="filters">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => 'Active Filters',
		'id'            => 'active_filters',
		'before_widget' => '<div class="active-filters">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'whites_widgets_init' );

add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 9;' ), 20 ); //products per page

function my_post_queries( $query ) {

	if( is_tax('find-type') || is_tax('video-type') ){
      // show 9 posts on custom taxonomy pages
      $query->set('posts_per_page', 9);
    }
  }
add_action( 'pre_get_posts', 'my_post_queries' );

/* Add phone validation */
function wc_validate_phone_number() {
	$phone = (isset( $_POST['billing_phone'] ) ? trim( $_POST['billing_phone'] ) : '');
	if ( ! preg_match( '/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\-([0-9]{4})/', $phone ) ) {
		wc_add_notice( __( 'Invalid Phone Number. Please enter with a valid phone number. Eg: (123) 456 7890' ), 'error' );
	}
}

//add_action( 'woocommerce_checkout_process', 'wc_validate_phone_number' );
/* End */

//remove password strength blocker
function wc_ninja_remove_password_strength() {
	if ( wp_script_is( 'wc-password-strength-meter', 'enqueued' ) ) {
		wp_dequeue_script( 'wc-password-strength-meter' );
	}
}
add_action( 'wp_print_scripts', 'wc_ninja_remove_password_strength', 100 );


function nav_parent_class($classes, $item) {
    $cpt_name = 'services';
    $parent_slug = 'sluzby';

    if ($cpt_name == get_post_type() && !is_admin()) {
        global $wpdb;

        // get page info (we really just want the post_name so it can be compared to the post type slug)
        $page = get_page_by_title($item->title, OBJECT, 'page');

        // check if slug matches post_name
        if( $page->post_name == $parent_slug ) {
            $classes[] = 'current_page_parent';
        }

    }

    return $classes;
}

add_filter('nav_menu_css_class', 'nav_parent_class', 10, 2);

/*
 * Hide Read More text if product is out of stock
 **/
if (!function_exists('woocommerce_template_loop_add_to_cart')) {
	function woocommerce_template_loop_add_to_cart() {
		global $product;
		if (!$product->is_in_stock()) return;
		woocommerce_get_template('loop/add-to-cart.php');
	}
}

add_filter('nav_menu_css_class', 'nav_parent_class', 10, 2);

/*
 * This is to ensure paypal has enough time to process the request
 **/
if (!function_exists('configure_curl_for_paypal_express_checkout')) {
    function configure_curl_for_paypal_express_checkout($handle, $r, $url) {
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
    }
}

add_action( 'http_api_curl', 'configure_curl_for_paypal_express_checkout', 10, 3 );
