<?php

// --------------------------------
// Required
// --------------------------------

// Composer Autoloader
require('vendor/autoload.php');

// Environment Management
include_once('functions/environment.php');

// Enqueue Scripts
include_once('functions/wordpress/enqueue-scripts.php');

// Core Registrations
include_once('functions/core/custom-post-types.php');
include_once('functions/core/custom-taxonomies.php');
include_once('functions/core/custom-sidebars.php');
include_once('functions/core/custom-menus.php');
include_once('functions/core/custom-crops.php');

// Partials Include Function
include_once('functions/wordpress/get-partial-path.php');

// ACF Includes
include_once('functions/wordpress/wpml-acf-filters.php');

// Cached Data
include_once('functions/wordpress/nav-menu-cache.php');


// --------------------------------
// Options
// --------------------------------

// Mailtrap settings
include_once('functions/wordpress/mailtrap.php');

// Utility Functions
include_once('functions/wordpress/utility.php');

// Add Admin Menu Seperators
include_once('functions/wordpress/admin-sidebar-separators.php');

// Disable Post Type Support
// include_once('functions/wordpress/disable-post-type-support.php');

// WooCommerce Functions
include_once('functions/wordpress/woocommerce.php');

// WPSL Wordpress Store Locator Functions
include_once('functions/wordpress/wpsl-csv-functions.php');

// Gravity Forms
include_once('functions/wordpress/gravityforms.php');

// ACF Field Data
include_once('functions/acf/all.php');

add_action("wp_ajax_current_cart_icon", 'current_cart_icon');
add_action("wp_ajax_nopriv_current_cart_icon", 'current_cart_icon');

function get_id_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}

function current_cart_icon () {
	?>

		<a class="shopping-cart" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>">
			<span class="shopping-cart-icon <?php if ( WC()->cart->get_cart_contents_count() > 0 ) { echo 'has-items';} ?>">
				<span>
					<?php _e("Shopping Cart"); ?>
				</span>
				<div class="number-of-items">
					<?php
						if ( WC()->cart->get_cart_contents_count() == 0 ) {
							echo '';
						} else {
							echo sprintf (_n( '%d', '%d', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() );
						}
					?>
				</div>
			</span>
		</a>

	<?php
	exit;die;
}

function toolset_fix_custom_posts_per_page( $query_string ){
    if( is_admin() || ! is_array( $query_string ) )
        return $query_string;

    $post_types_to_fix = array(
        array(
            'post_type' => 'dealer',
            'posts_per_page' => 2
        ),
        // add another if you want
        /*
        array(
            'post_type' => 'movie',
            'posts_per_page' => 2
        ),
        */
    );

    foreach( $post_types_to_fix as $fix ) {
        if( array_key_exists( 'post_type', $query_string )
            && $query_string['post_type'] == $fix['post_type']
        ) {
            $query_string['posts_per_page'] = $fix['posts_per_page'];
            return $query_string;
        }
    }

    return $query_string;
}

add_filter( 'request', 'toolset_fix_custom_posts_per_page' );
