<?php
// Pre-Storage for WP Nav Menus
function cacheWpNavMenus() {
  $data = array();

  if ( ICL_LANGUAGE_CODE == "en" ) {

    // US

    // get each menu and push it into the array
    $data['header_menu_left'] = wp_nav_menu(array(
      'theme_location' => 'header-menu-left',
      'container' => 'false',
      'echo' => false
    ));

    $data['header_menu_right'] = wp_nav_menu(array(
      'theme_location' => 'header-menu-right',
      'container' => 'false',
      'echo' => false
    ));

    $data['footer_menu_contact_us'] = wp_nav_menu(array(
      'theme_location' => 'footer-menu-contact-us',
      'container' => 'false',
      'echo' => false
    ));

    $data['footer_menu_about_whites'] = wp_nav_menu(array(
      'theme_location' => 'footer-menu-about-whites',
      'container' => 'false',
      'echo' => false
    ));

    $data['footer_menu_more_info'] = wp_nav_menu(array(
      'theme_location' => 'footer-menu-more-info',
      'container' => 'false',
      'echo' => false
    ));

    $data['footer_menu_where_to_buy'] = wp_nav_menu(array(
      'theme_location' => 'footer-menu-where-to-buy',
      'container' => 'false',
      'echo' => false
    ));

    update_option('cache_wp_nav_menus', json_encode($data));

  } else {

    // UK

    // get each menu and push it into the array
    $data['header_menu_left'] = wp_nav_menu(array(
      'theme_location' => 'header-menu-left',
      'container' => 'false',
      'echo' => false
    ));

    $data['header_menu_right'] = wp_nav_menu(array(
      'theme_location' => 'header-menu-right',
      'container' => 'false',
      'echo' => false
    ));

    $data['footer_menu_contact_us'] = wp_nav_menu(array(
      'theme_location' => 'footer-menu-contact-us',
      'container' => 'false',
      'echo' => false
    ));

    $data['footer_menu_about_whites'] = wp_nav_menu(array(
      'theme_location' => 'footer-menu-about-whites',
      'container' => 'false',
      'echo' => false
    ));

    $data['footer_menu_more_info'] = wp_nav_menu(array(
      'theme_location' => 'footer-menu-more-info',
      'container' => 'false',
      'echo' => false
    ));

    $data['footer_menu_where_to_buy'] = wp_nav_menu(array(
      'theme_location' => 'footer-menu-where-to-buy',
      'container' => 'false',
      'echo' => false
    ));

    update_option('cache_wp_nav_menus_uk', json_encode($data));

  }

}
add_action('wp_update_nav_menu', 'CacheWpNavMenus');

// Returning WP Nav Menus
function cacheGetWpNavMenus( $cacheName ) {
  $data = get_option($cacheName);
  return json_decode($data);
}