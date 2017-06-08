<?php
  include(get_partial_path('header'));
  if ( ICL_LANGUAGE_CODE == "en" ) {
    $header_menus_from_cache = cacheGetWpNavMenus('cache_wp_nav_menus');
  } else {
    $header_menus_from_cache = cacheGetWpNavMenus('cache_wp_nav_menus_uk');
  }
?>

<header>
  <div class="wrapper">
    <div class="secondary-nav">
      <div class="my-account">
        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My Account', 'woocommerce' ); ?></a>
      </div>
      <div class="language-select">
        <?php do_action('icl_language_selector'); ?>
      </div>
    </div>
    <nav class="nav-header">
      <div id="nav-icon">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span class="visually-hidden"><?php _e("Navigation Menu"); ?></span>
      </div>
      <div class="menu-header-left">
        <?php echo $header_menus_from_cache->header_menu_left; ?>
      </div>
      <a href="<?php echo get_home_url(); ?>" class="logo"><span>White's Electronics</span></a>
      <div class="menu-header-right">
        <?php echo $header_menus_from_cache->header_menu_right; ?>

        <div class="menu-header-right-container mobile-addon">
          <ul class="menu">
            <li class="menu-item menu-item-object-page">
              <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My Account', 'woocommerce' ); ?></a>
            </li>
          </ul>
        </div>

      </div>
      <div class="social">
        <h2><?php _e("Connect"); ?></h2>
        <ul>
          <li><a class="facebook" href="https://www.facebook.com/<?php echo get_option('options_facebook'); ?>"></a></li>
          <li><a class="twitter" href="https://twitter.com/<?php echo get_option('options_twitter'); ?>"></a></li>
          <li><a class="youtube" href="https://www.youtube.com/user/<?php echo get_option('options_youtube'); ?>"></a></li>
          <li><a class="instagram" href="https://www.instagram.com/<?php echo get_option('options_instagram'); ?>"></a></li>
        </ul>
      </div>
      <div class="nav-icons">
        <a class="shopping-cart" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>">
          <span class="shopping-cart-icon">
            <span>
              <?php _e("Shopping Cart"); ?>
            </span>
            <div class="number-of-items"></div>
          </span>
        </a>
        <span id="search-icon" class="search-icon"><span><?php _e("Search"); ?></span></span>
        <div id="search-box">
          <div class="search-content">
            <form role="search" id="searchform" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
              <label>
                  <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ) ?></span>
                  <input type="search" class="search-field"
                      placeholder="<?php echo esc_attr_x( 'Search', 'placeholder' ) ?>"
                      value="<?php echo get_search_query() ?>" name="s"
                      title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
                  <input type="hidden" name="site_section" value="site-search" />
              </label>
              <input type="submit" class="search-submit"
                  value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" form="searchform" />
              <input type="hidden" name="lang" value="<?php echo ICL_LANGUAGE_CODE; ?>"/>
            </form>
            <div id="close-search">
              <div class="close-icon">
                <span></span>
                <span></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</header>

