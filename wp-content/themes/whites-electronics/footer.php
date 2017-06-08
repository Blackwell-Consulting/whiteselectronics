  <div class="detector-selector-banner">
    <div class="wrapper">
      <h2><?php _e("Need help choosing the right metal detector?"); ?></h2>
      <div class="button">
        <a href="<?php echo home_url('/detector-selector'); ?>"><?php _e("Detector Selector"); ?></a>
      </div>
    </div>
  </div>

  <footer>
    <div class="wrapper">
      <div class="language-select">
        <?php do_action('icl_language_selector'); ?>
      </div>
      <div class="social">
        <h2><?php _e("Connect");?></h2>
        
 <?php if (ICL_LANGUAGE_CODE=="en"){
	      
	      echo'<ul>
          <li><a target="_blank" class="facebook" href="https://www.facebook.com/whiteselectronics"></a></li>
          <li><a target="_blank" class="twitter" href="https://twitter.com/whitesdetector"></a></li>
          <li><a target="_blank" class="youtube" href="https://www.youtube.com/user/WhitesElectronics"></a></li>
          <li><a target="_blank" class="instagram" href="https://www.instagram.com/whiteselectronics"></a></li>
        </ul>';
       } else {
	       echo'<ul>
          <li><a target="_blank" class="facebook" href="https://www.facebook.com/WhitesUKLTD"></a></li>
          <li><a target="_blank" class="twitter" href="https://twitter.com/WhitesUKLTD"></a></li>
          <li><a target="_blank" class="youtube" href="https://www.youtube.com/user/WhitesElectronics"></a></li>
          <li><a target="_blank" class="instagram" href="https://www.instagram.com/WhitesUKLTD"></a></li>
        </ul>';
       }
       
       ?>
      </div>
      <nav>
        <?php
        $phone = get_field('phone_number', 'option');
        $operatingHours = get_field('operating_hours', 'option');
        $operatingDays = get_field('operating_days', 'option');
        if ( ICL_LANGUAGE_CODE == "en" ) {
          $footer_menus_from_cache = cacheGetWpNavMenus('cache_wp_nav_menus');
        } else {
          $footer_menus_from_cache = cacheGetWpNavMenus('cache_wp_nav_menus_uk');
        }
        ?>
        <div class="reorder">
          <div class="call-us">
            <h2><?php echo get_option('options_column_4_label_row_1'); ?></h2>
            <a href="tel://<?php echo $phone; ?>"><?php echo $phone; ?></a>
            <span class="tel"><?php echo $phone; ?></span>
            <p><?php echo $operatingHours; ?>,<span><?php _e($operatingDays); ?></span></p>
          </div>
          <div class="contact-us">
            <h2><?php echo get_option('options_column_4_label_row_2'); ?></h2>
            <?php echo $footer_menus_from_cache->footer_menu_contact_us; ?>
          </div>
        </div>
        <div id="show-more">
          <h2><span><?php _e("More"); ?></span></h2>
        </div>
        <div class="more-nav">
          <div class="about-whites">
            <h2><?php echo get_option('options_column_1_label'); ?></h2>
            <?php echo $footer_menus_from_cache->footer_menu_about_whites; ?>
          </div>
          <div class="more-info">
            <h2><?php echo get_option('options_column_2_label'); ?></h2>
            <?php echo $footer_menus_from_cache->footer_menu_more_info; ?>
          </div>
          <div class="where-to-buy">
            <h2><?php echo get_option('options_column_3_label'); ?></h2>
            <?php echo $footer_menus_from_cache->footer_menu_where_to_buy; ?>
          </div>
        </div>
      </nav>
      <div class="logo">
        <h2><?php _e("Crafting Adventure"); ?></h2>
        <span><?php _e("Since 1950"); ?></span>
      </div>
      <div class="copyright">
        <span><?php echo '&copy; '.date('Y')." White's Electronics"; ?></span>
        <a href="<?php echo home_url('/privacy-policy'); ?>"><?php _e("Privacy Policy"); ?></a>
      </div>
    </div>
  </footer>

<?php include(get_partial_path('footer')); ?>

<script type="text/javascript">
  $(function() {
    $.get('/wp-admin/admin-ajax.php?action=current_cart_icon', function (data) {
      var $nav = $('div.nav-icons');
      $nav.find("a.shopping-cart").remove();
      $nav.prepend(data);
    });
  });
</script>
