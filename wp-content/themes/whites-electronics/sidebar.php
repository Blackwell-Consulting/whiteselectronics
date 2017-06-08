<div class="sidebar">
<h1><?php _e("Filter By"); ?></h1>
  
  <?php if ( is_active_sidebar( 'product_filters' ) ) : ?>
    <?php dynamic_sidebar( 'product_filters' ); ?>
  <?php endif; ?>

  <?php if ( is_active_sidebar( 'active_filters' ) ) : ?>
    <?php dynamic_sidebar( 'active_filters' ); ?>
  <?php endif; ?>

  <?php if ( is_or_descendant_tax( 2073, 'product_cat' ) ) : ?>

  <?php
  endif; ?>

  <?php if ( is_or_descendant_tax( 2086, 'product_cat' ) ) : ?>

  <?php
  endif; ?>
</div>
