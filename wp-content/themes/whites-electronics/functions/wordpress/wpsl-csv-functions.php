<?php

add_filter( 'wpsl_meta_box_fields', 'custom_meta_box_fields' );

/**
 * Filter to add additional fields to the wpsl store locator posts
 * @param array $meta_fields Meta fields for store posts
 * @return array Meta fields for store posts
 */
function custom_meta_box_fields( array $meta_fields )
{

    /**
     * Dealer ID	d.dealer_code	Date Dealer Created	d.distrib_id	Dealer First Name	Dealer Last Name	d.notes	d.active	d.deleted	d.date_deleted	d.store	d.prepared	d.prospect	d.inventory	d.date_modified	d.directions	d.html_blurb	d.html_contact	d.language_es	d.gets_referrals	d.gets_netorders	d.gets_weblookup	d.spectra	d.inetauth	d.established	d.dealer_mobile	d.flipchart	d.www_url	d.units12mo
     * If no 'type' is defined it will show a normal text input field.
     *
     * Supported field types are checkbox, textarea and dropdown.
     */
    $meta_fields[__('Additional Dealer Information', 'wpsl')] = array(
        'dealerId' => array(
            'label' => __('Dealer ID', 'wpsl'),
            'required' => false // This will place a * after the label
        ),
        'dealerCode' => array(
            'label' => __('Dealer Code', 'wpsl'),
            'required' => false // This will place a * after the label
        ),
        'premiumDealer' => array(
            'label' => __('Premium Dealer', 'wpsl'),
            'type' => 'checkbox',
            'required' => false // This will place a * after the label
        )
    );

    return $meta_fields;
}

add_filter( 'wpsl_frontend_meta_fields', 'custom_frontend_meta_fields' );

function custom_frontend_meta_fields( $premium_dealer ) {

    $premium_dealer['wpsl_premiumDealer'] = array(
        'name' => 'premium_dealer',
        'type' => 'checkbox'
    );

    return $premium_dealer;
}

add_filter( 'wpsl_listing_template', 'custom_listing_template' );

function custom_listing_template() {

    global $wpsl_settings;

    $listing_template = '<li data-store-id="<%= id %>">' . "\r\n";
    $listing_template .= "\t\t" . '<div>' . "\r\n";
    $listing_template .= "\t\t\t" . '<p><%= thumb %>' . "\r\n";
    $listing_template .= "\t\t\t" . '<% if ( premium_dealer ) { %>' . "\r\n";
    $listing_template .= "\t\t\t" . '<div class="premium-dealer">Premium<br>Dealer</div>' . "\r\n";
    $listing_template .= "\t\t\t" . '<% } %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . wpsl_store_header_template( 'listing' ) . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-street"><%= address %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% if ( address2 ) { %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-street"><%= address2 %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% } %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span>' . wpsl_address_format_placeholders() . '</span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-phone"><%= address2 %></span>' . "\r\n";
    $listing_template .= "\t\t" . '<% if ( phone ) { %>' . "\r\n";
    $listing_template .= "\t\t" . '<span class="wpsl-phone"><a href="tel:<%= phone %>"><%= phone %></a></span>' . "\r\n";
    $listing_template .= "\t\t" . '<% } %>' . "\r\n";
    $listing_template .= "\t\t" . '<% if ( email ) { %>' . "\r\n";
    $listing_template .= "\t\t" . '<span class="wpsl-email"><a href="mailto:<%= email %>"><%= email %></a></span>' . "\r\n";
    $listing_template .= "\t\t" . '<% } %>' . "\r\n";
    $listing_template .= "\t\t" . '<% if ( url ) { %>' . "\r\n";
    $listing_template .= "\t\t" . '<span class="wpsl-url"><a href="<%= url %>"><%= url %></a></span>' . "\r\n";
    $listing_template .= "\t\t" . '<% } %>' . "\r\n";
    // Check if we need to show the distance.
    if ( !$wpsl_settings['hide_distance'] ) {
        $listing_template .= "\t\t" . '<%= distance %> ' . esc_html( $wpsl_settings['distance_unit'] ) . '' . "\r\n";
    }

    $listing_template .= "\t\t" . '<%= createDirectionUrl() %>' . "\r\n";
    $listing_template .= "\t" . '</li>' . "\r\n";
    $listing_template .= "\t\t\t" . '</p>' . "\r\n";
    $listing_template .= "\t\t" . '</div>' . "\r\n";

    return $listing_template;
}

add_filter( 'wpsl_info_window_template', 'custom_info_window_template' );

function custom_info_window_template() {

    $info_window_template = '<div data-store-id="<%= id %>" class="wpsl-info-window">' . "\r\n";
    $info_window_template .= "\t\t\t" . '<% if ( premium_dealer ) { %>' . "\r\n";
    $info_window_template .= "\t\t\t" . '<div class="premium-dealer">Premium<br>Dealer</div>' . "\r\n";
    $info_window_template .= "\t\t\t" . '<% } %>' . "\r\n";
    $info_window_template .= "\t\t" . '<p>' . "\r\n";
    $info_window_template .= "\t\t\t" .  wpsl_store_header_template() . "\r\n";
    $info_window_template .= "\t\t\t" . '<span><%= address %></span>' . "\r\n";
    $info_window_template .= "\t\t\t" . '<% if ( address2 ) { %>' . "\r\n";
    $info_window_template .= "\t\t\t" . '<span><%= address2 %></span>' . "\r\n";
    $info_window_template .= "\t\t\t" . '<% } %>' . "\r\n";
    $info_window_template .= "\t\t\t" . '<span>' . wpsl_address_format_placeholders() . '</span>' . "\r\n";
    $info_window_template .= "\t\t" . '</p>' . "\r\n";
    $info_window_template .= "\t\t" . '<%= createInfoWindowActions( id ) %>' . "\r\n";
    $info_window_template .= "\t" . '</div>' . "\r\n";

    return $info_window_template;
}