

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
      <h2><?php _e("Connect"); ?></h2>
      <ul>
        <li><a target="_blank" class="facebook" href="https://www.facebook.com/<?php the_field('facebook','option'); ?>"></a></li>
        <li><a target="_blank" class="twitter" href="https://twitter.com/<?php the_field('twitter','option'); ?>"></a></li>
        <li><a target="_blank" class="youtube" href="https://www.youtube.com/user/<?php the_field('youtube','option'); ?>"></a></li>
        <li><a target="_blank" class="instagram" href="https://www.instagram.com/<?php the_field('instagram','option'); ?>"></a></li>
      </ul>
    </div>
    <nav>
      <div class="reorder">
        <div class="call-us">
          <h2>Call Us</h2>
          <a href="tel://1-800-547-6911">1-800-547-6911</a>
          <span class="tel">1-800-547-6911</span>
          <p>8am-4:30pm PST,<span>Monday-Friday</span>
          </p>
        </div>
        <div class="contact-us">
          <h2>Contact Us</h2>
          <ul id="menu-contact-us" class="menu">
            <li id="menu-item-5676" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5676">
              <a href="http://l.whites/contact-us/">Contact Us</a>
            </li>
            <li id="menu-item-99" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-99">
              <a href="http://l.whites/newsletter-signup/">Newsletter Signup</a>
            </li>
            <li id="menu-item-41330" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-41330">
              <a href="http://l.whites/event-sponsorship/">Event Sponsorship</a>
            </li>
          </ul>
        </div>
      </div>
      <div id="show-more">
        <h2>
          <span>More</span>
        </h2>
      </div>
      <div class="more-nav">
        <div class="about-whites">
          <h2>About White's</h2>
          <ul id="menu-whites-electronics" class="menu">
            <li id="menu-item-41336" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-41336">
              <a href="http://l.whites/about-us/">About Us</a>
            </li>
            <li id="menu-item-41337" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-41337">
              <a href="http://l.whites/jobs/">Jobs</a>
            </li>
            <li id="menu-item-41338" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-41338">
              <a href="http://l.whites/our-history/">Our History</a>
            </li>
            <li id="menu-item-47099" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-47099">
              <a href="/my-account">My Account</a>
            </li>
          </ul>
        </div>
        <div class="more-info">
          <h2>More Info</h2>
          <ul id="menu-more-info" class="menu">
            <li id="menu-item-95" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-95">
              <a href="http://l.whites/gold-silver-price-feed/">Gold Silver Price Feed</a>
            </li>
            <li id="menu-item-94" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-94">
              <a href="http://l.whites/shipping-returns/">Shipping &amp; Returns</a>
            </li>
            <li id="menu-item-93" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-93">
              <a href="http://l.whites/pricing-policy/">Pricing Policy</a>
            </li>
            <li id="menu-item-41935" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-41935">
              <a href="http://l.whites/coil-and-battery-compatibility-charts/">Coil &amp; Battery Compatibility</a>
            </li>
          </ul>
        </div>
        <div class="where-to-buy">
          <h2>How To Buy</h2>
          <ul id="menu-how-to-buy" class="menu">
            <li id="menu-item-98" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-98">
              <a href="http://l.whites/find-a-dealer/">Find A Dealer</a>
            </li>
            <li id="menu-item-41920" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-41920">
              <a href="http://l.whites/request-catalog/">Request Catalog</a>
            </li>
            <li id="menu-item-41936" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-41936">
              <a href="http://l.whites/detector-selector/">Detector Selector</a>
            </li>
          </ul>
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
