<!DOCTYPE html>
<!--[if lte IE 9]><html class="no-js lt-ie10"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />

  <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>

  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-148738-1', 'auto'); ga('require', 'displayfeatures'); ga('send', 'pageview');

    // Set up site configuration
    window.config = window.config || {};

    // The base URL for the WordPress theme
    window.config.baseUrl = "<?php echo get_bloginfo('url'); ?>";

    // Empty default Gravity Forms spinner function
    var gformInitSpinner = function() {};
  </script>

  <!-- Facebook Pixel Code -->
  <script>
  !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
  n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
  document,'script','https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '176888629358247');
  fbq('track', "PageView");</script>
  <noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=176888629358247&ev=PageView&noscript=1"
  /></noscript>
  <!-- End Facebook Pixel Code -->

  <script src="https://use.typekit.net/iqf0fge.js"></script>
  <script>try{Typekit.load({ async: true });}catch(e){}</script>

  <?php
  // Make sure you go through this file and remove what you aren't using
  include( get_stylesheet_directory() . '/functions/site/theme-meta.php' );
  ?>

  <link href='https://fonts.googleapis.com/css?family=Rajdhani:400,500,700' rel='stylesheet' type='text/css'>

  <?php wp_head(); ?>
</head>
<body <?php body_class(ICL_LANGUAGE_CODE); ?>>
