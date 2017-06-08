<?php

ini_set('max_execution_time', 0);
ini_set('memory_limit', '512M');
set_time_limit(0);

require(dirname(__FILE__) . '/../../../../wp-blog-header.php');
require(dirname(__FILE__) . '/../../../../wp-admin/includes/user.php');
header('Content-Type:text/plan');

ob_end_clean();
ob_start();

function excludedAttributes()
{
    return array(
        // Specific attributes
        'pa_adjustable_length',
        'pa_all_metal_audio',
        'pa_audio_output',
        'pa_batteries',
        'pa_battery_life',
        'pa_cost',
        'pa_disc_audio',
        'pa_coil_config',
        'pa_coil_weight',
        'pa_frequency',
        'pa_frequency_offset',
        'pa_preset_count',
        'pa_operating_frequency',
        'pa_operating_frequency_detail',
        'pa_height',
        'pa_optional_coils',
        'pa_size',
        'pa_ground_balance',

        // Categories
        'pa_series',
        'pa_man_model',
        'pa_man_current',
        'pa_man_recent',
        'pa_man_other',
        'pa_man_family',
        'pa_related_product_manuals',

        // Shipping
        'pa_ship_depth',
        'pa_ship_height',
        'pa_ship_width',
        'pa_usps_shipping_discount',

        // etc...
        'pa_activity_type',
        'pa_featured_description',
        'pa_recommended_for',
        'pa_skill_level',
        'pa_standard_coil',
        'pa_available_soon',

        'pa_spectrum',
        'pa_video_thumbnail_photo',
        'pa_vso_url',
        'pa_youtube_customer',
        'pa_youtube_whites'
    );
}


function allAttributes()
{
    $taxonomies = get_taxonomies();
    foreach($taxonomies as $key => $value) {
        if (substr($value, 0, 3) === "pa_")
            continue;
        unset($taxonomies[$key]);
    }

    return array_diff(array_unique($taxonomies), excludedAttributes());
}


function allProducts()
{
    $products = new WP_Query(array(
       'post_type' => 'product',
       'fields' => 'ids',
       'posts_per_page' => -1
    ));

    if ($products instanceof WP_Error || empty($products->posts))
        return array();

    return $products->posts;
}


function removeAttributeRelationships(array& $productIds, array& $removableAttributes)
{
    $count = count($productIds);
    for ($i = 0; $i < $count; $i++) {
        wp_delete_object_term_relationships($productIds[$i], $removableAttributes);
    }
}


function removeAttributes(array& $removableAttributes)
{
    $terms = get_terms($removableAttributes, array(
       'hide_empty' => 0
    ));

    foreach ($terms as $term) {
        wp_delete_term($term->term_id, $term->taxonomy);
    }
}


function removeAttributesFromWooCommerce(array $removableAttributes)
{
    global $wpdb;

    $attributes = array_map(function ($value) {
        return substr($value, 3);
    }, $removableAttributes);


    $wpdb->query("DELETE FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name IN ('" . implode("', '", $attributes) . "')");

    removeFromWpOptions($removableAttributes);
    removeFromWoocommerceTermMeta($removableAttributes);
}


function removeFromWpOptions(array $removableAttributes)
{
    global $wpdb;

    $attributes = array_map(function ($value) {
        return $value . '_children';
    }, $removableAttributes);

    $wpdb->query("DELETE FROM " . $wpdb->prefix . "options WHERE option_name IN ('" . implode("', '", $attributes) . "')");
}


function removeFromWoocommerceTermMeta(array $removableAttributes)
{
    global $wpdb;

    $attributes = array_map(function ($value) {
        return 'order_' . $value;
    }, $removableAttributes);

    $wpdb->query("DELETE FROM " . $wpdb->prefix . "woocommerce_termmeta WHERE meta_key IN ('" . implode("', '", $attributes) . "')");
}


function updateProductMeta(array& $productIds, array& $removableAttributes, array& $attributes)
{
    $meta_key = '_product_attributes';
    $count = count($productIds);

    for ($i = 0; $i < $count; $i++) {
        $meta = get_post_meta($productIds[$i], $meta_key, true);
        $old = $meta;

        if (empty($meta))
            continue;

        foreach ($attributes as $attr) {
            if (!isset($meta[$attr]))
                continue;

            $meta[$attr]['is_visible'] = 1;
        }

        foreach ($removableAttributes as $attr) {
            if (!isset($meta[$attr])) {
                continue;
            }

            unset($meta[$attr]);
        }

        update_post_meta($productIds[$i], $meta_key, $meta, $old);
    }
}


function displayMessage($message)
{
    print($message . "\n");
    flush();
    ob_flush();
}


if (current_user_can('manage_woocommerce')) {
    displayMessage("START\n");

    $excludedAttributes = excludedAttributes();
    $removableAttributes = allAttributes();
    $products = allProducts();

    // unlink products from attributes
    displayMessage("BEGIN REMOVE ATTRIBUTE RELATIONSHIPS");
    removeAttributeRelationships($products, $removableAttributes);
    displayMessage("END REMOVE ATTRIBUTE RELATIONSHIPS\n");

    // remove terms
    displayMessage("BEGIN REMOVE ATTRIBUTE TERMS & TAXONOMIES");
    removeAttributes($removableAttributes);
    displayMessage("END REMOVE ATTRIBUTES TERMS & TAXONOMIES\n");

    // Remove attributes directly from DB
    displayMessage("BEGIN REMOVE ATTRIBUTES FROM DB");
    removeAttributesFromWooCommerce($removableAttributes);
    displayMessage("END REMOVE ATTRIBUTES FROM DB\n");

    // Set custom attributes to visible by default
    displayMessage("BEGIN UPDATE PRODUCT META");
    updateProductMeta($products, $removableAttributes, $excludedAttributes);
    displayMessage("END UPDATE PRODUCT META\n");

    // Repair tables
    displayMessage("BEGIN CLEAR CACHES");
    delete_transient('wc_attribute_taxonomies');
    displayMessage("END CLEAR CACHES\n");

    displayMessage("DONE");
} else {
    displayMessage("INSUFFICIENT PERMISSIONS TO EXECUTE SCRIPT");
}

ob_end_clean();
exit;
