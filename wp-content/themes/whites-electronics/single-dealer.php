<?php get_header(); ?>
<?php
  the_post();
  $category = get_the_category();
  $current_category_id = $category[0]->term_id;
  $current_category_name = $category[0]->name;
?>

<main role="main" class="home find-a-dealer-uk">
<?php
        $uk_dealer_page = 66238;
        $heroBgImage = get_field( 'hero_background', $uk_dealer_page );

        $backgroundImg  ='';
        if (!empty($heroBgImage) && !empty($heroBgImage['url'])) {
            $backgroundImg = "background-image: url('" . $heroBgImage['sizes']['large'] . "')";
        }
?>

    <div class="hero">
        <div class="bg-image" style="<?php echo $backgroundImg; ?>"></div>
        <h1 class="no-subtitle"><?php echo $current_category_name; ?></h1>
    </div>

	<div class="outer-wrapper">
        <div class="alert">
            <p><span><?php _e("Need Help?"); ?></span> <?php _e("We'll point you to the metal detector that's right for you."); ?></p>
            <a class="capitalize" href="<?php echo home_url('/detector-selector'); ?>"><?php _e("Detector Selector"); ?></a>
            <span class="dismiss capitalize"><?php _e("Dismiss"); ?></span>
        </div>
        <div class="outer-wrapper">
             <div class="sidebar">
                <h1>Filter By</h1>
                <div class="parent-categories">
                    <h2>Country</h2>
                      <?php
                        foreach ( $category as $cat ) {

                              $args = array(
                              'post_type' => 'dealer',
                              'tax_query' => array(
                                  array(
                                      'taxonomy' => 'category',
                                      'field'    => 'term_id',
                                      'terms'    => $cat->cat_ID,
                                      ),
                                  ),
                              );

                              $query = new WP_Query( $args ); ?>

                              <?php if ( $query->have_posts() ): ?>
                               <ul>
                                  <li><a href="/find-a-dealer-uk/?lang=gb">All</a></li>
                                  <li><?php echo $cat->cat_name ; ?>
                                    <ul>
                                      <?php while($query -> have_posts()) : $query -> the_post(); ?>
                                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                      <?php endwhile; ?>
                                    </ul>
                                  </li>
                              </ul>
                     <?php endif; ?>
                    <?php wp_reset_query(); } ?>
                </div><!-- /.parent-categories -->
            </div><!-- /.sidebar -->
        </div><!-- /.outer-wrapper -->

        <main>
          <div class="wrapper">
            <div class="video-stage">
              <h1><?php the_title(); ?></h1>
            </div>
          </div>
        </main>

        <div class="clearfix"></div><!-- /.clearfix -->
	</div>

</main>

<?php get_footer(); ?>
