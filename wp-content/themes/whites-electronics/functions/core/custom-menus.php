<?php

// --------------------------------
// Register Custom Menus
// --------------------------------

// ex: wp_nav_menu( array( 'theme_location' => 'header-menu', 'container' => 'nav', 'container_class' => 'nav-header' ) );

function register_site_menus() {
  register_nav_menus(
    array(
      'header-menu-left' => __( 'Header - Left' ),
      'header-menu-right' => __( 'Header - Right' ),
      'footer-menu-contact-us' => __( 'Footer - Contact Us' ),
      'footer-menu-about-whites' => __( "Footer - About White's" ),
      'footer-menu-more-info' => __( 'Footer - More Info' ),
      'footer-menu-where-to-buy' => __( 'Footer - Where To Buy' )
    )
  );
}
add_action( 'init', 'register_site_menus' );
