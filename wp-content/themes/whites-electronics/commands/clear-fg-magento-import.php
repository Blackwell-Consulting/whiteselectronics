<?php
/**
 * Created by PhpStorm.
 * User: bbierman
 * Date: 2/1/16
 * Time: 10:20 AM
 */
ini_set('memory_limit', '512M');
require(dirname(__FILE__) . '/../../../../wp-blog-header.php');
require(dirname(__FILE__) . '/../../../../wp-admin/includes/user.php');
header('Content-Type:text/plan');

function remove_magento_posts_for(array $options)
{
    $args = array(
        'posts_per_page' => -1,
        'post_status' => 'any',
        'fields' => 'ids'
    );

    $args = $args + $options;

    $delete_query = new WP_Query($args);

    printf("Removing %d posts for post type %s\n", $delete_query->post_count, $options['post_type']);

    if ($delete_query->have_posts()) {
        foreach ($delete_query->posts as $post_id) {
            wp_delete_post($post_id);
            printf("Removed Post ID: %d\n", $post_id);
        }
    }
}

function remove_magento_terms() {
    $taxonomies = get_taxonomies();

    foreach($taxonomies as $key => $value) {
        if(substr($value, 0, 3) === "pa_" || substr($value, 0, 8) === "product_") {
            continue;
        }
        unset($taxonomies[$key]);
    }

    $taxonomies = array_unique($taxonomies);

    $args = array(
        'hide_empty' => false,
//        'meta_query' => array(
//            array(
//                'key' => '_fgm2wc_old_product_category_id',
//                'compare' => 'EXISTS'
//            )
//        )
    );

    $terms = get_terms($taxonomies, $args);

    printf("Removing %d terms imported from magento\n", count($terms));

    foreach($terms as $term) {
        wp_delete_term($term->term_id, $term->taxonomy);

        printf("Removed Term: %d - %s\n", $term->term_id, $term->name);
    }
}

function remove_magento_users() {
    $args = array(
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'magento_user_id',
                'compare' => 'EXISTS',

            ),
            array(
                'key' => 'magento_customer_id',
                'compare' => 'EXISTS'
            )
        ),
        'fields' => 'ID',
        'count_total' => true
    );

    $users = new WP_User_Query($args);

    if ( !empty( $users->results ) ) {
        printf("Removing %d users imported from magento\n", $users->get_total());

        foreach ($users->results as $user) {
            wp_delete_user($user);
            printf("Removed User: %d\n", $user);
        }
    }
}

// verify user
if(current_user_can('manage_woocommerce')) {
    // 50 custom post types are being deleted everytime you refresh the page.
    remove_magento_posts_for(array('post_type' => 'product', 'meta_key' => '_fgm2wc_old_product_id'));
    remove_magento_posts_for(array('post_type' => 'product_variation', 'meta_key' => '_fgm2wc_old_product_id'));

    remove_magento_terms();
    remove_magento_users();

    print("Resetting last magento product import to 0\n");
    update_option('fgm2wc_last_magento_product_id', 0);
    print("Resetting last magento user import to 0\n");
    update_option('fgm2wc_last_user_id', 0);
    print("Resetting last magento customer import to 0\n");
    update_option('fgm2wc_last_magento_customer_id', 0);
}

?>
