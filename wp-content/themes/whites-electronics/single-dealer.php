<?php get_header(); ?>
<?php
  the_post();
  $category = get_the_category();
  $current_category_id = $category[0]->term_id;
  $current_category_name = $category[0]->name;
?>

<main role="main" class="home find-a-dealer-uk">
<?php
        $uk_dealer_page = get_id_by_slug( 'find-a-dealer-uk' );
        $heroBgImage = get_field( 'hero_background', $uk_dealer_page );

        $backgroundImg  ='';
        if (!empty($heroBgImage) && !empty($heroBgImage['url'])) {
            $backgroundImg = "background-image: url('" . $heroBgImage['sizes']['large'] . "')";
        }
?>
	<div class="outer-wrapper">
        <div class="hero">
            <div class="bg-image" style="<?php echo $backgroundImg; ?>"></div>
            <h1 class="no-subtitle"><?php echo $current_category_name; ?></h1>
        </div>
        <div class="alert">
            <p><span><?php _e("Need Help?"); ?></span> <?php _e("We'll point you to the metal detector that's right for you."); ?></p>
            <a class="capitalize" href="<?php echo home_url('/detector-selector'); ?>"><?php _e("Detector Selector"); ?></a>
            <span class="dismiss capitalize"><?php _e("Dismiss"); ?></span>
        </div>
        <div class="outer-wrapper">
            <div class="dealer-detail">
            <?php
                //vars
                $logo = get_field( 'logo' );
                $about = get_field( 'about_us' );
                $location = get_field( 'location' );
                $banner = get_field( 'banner' );
                $social = get_field( 'social' );
            ?>

                <?php if( !empty( $logo ) ): ?>
                <div class="dealer-detail-logo gray-box">
                    <div class="gray-box-inner">
                        <img src="<?php echo $logo['sizes']['large']; ?>" alt="<?php echo $logo['alt']; ?>" />
                    </div><!-- /.gray-box-inner -->
                </div><!-- /.dealer-detail-logo -->
                <?php endif; ?>

                 <?php if( !empty( $location['address'] ) ): ?>
                <div class="dealer-detail-map gray-box">
                    <?php include(get_stylesheet_directory() . '/partials/map.php'); ?>
                </div><!-- /.dealer-detail-map -->
                <?php endif; ?>

                <div class="dealer-detail-address gray-box">
                    <h1 class="dealer-title"><?php the_title(); ?></h1>
                    <?php if( !empty( $location['address'] ) ): ?>
                    <h2 class="dealer-title-small"><?php echo $location['address']; ?></h2>
                    <?php endif; ?>
                </div><!-- /.dealer-detail-address -->

                <?php if( !empty( $about ) ): ?>
                <div class="dealer-detail-about gray-box">
                    <h3 class="dealer-title-smaller">
                        About Us
                    </h3>
                    <?php echo $about; ?>
                </div><!-- /.dealer-detail-about -->
                <?php endif; ?>

                <div class="clearfix"></div><!-- /.clearfix -->

                <?php if( have_rows( 'banner' ) ): ?>
                <div class="dealer-detail-banner gray-box">
                    <?php
                        while ( have_rows( 'banner' ) ) : the_row();

                        //vars
                        $banner = get_sub_field( 'banner' );
                        $url = get_sub_field( 'url' );
                    ?>
                        <div class="gray-box-inner">
                            <a href="<?php echo $url; ?>" target="_blank">
                                <img src="<?php echo $banner['sizes']['large']; ?>" alt="<?php echo $banner['alt']; ?>" />
                            </a>
                        </div><!-- /.gray-box-inner -->
                    <?php endwhile; ?>
                </div><!-- /.dealer-detail-banner -->
                <?php endif; ?>

                <?php if( have_rows( 'social' ) ): ?>
                <div class="dealer-detail-social gray-box">
                    <ul class="links">
                    <?php
                        while ( have_rows( 'social' ) ) : the_row();

                        //vars
                        $icon = get_sub_field( 'icon' );
                        $url = get_sub_field( 'url' );
                    ?>
                        <li><a href="<?php echo $url; ?>" target="_blank"><span class="icon-<?php echo $icon; ?>"></span></a></li>
                    <?php endwhile; ?>
                    </ul><!-- /.links -->
                </div><!-- /.dealer-detail-social -->
                <?php endif; ?>
            </div><!-- /.dealer-detail -->
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
	</div>

</main>

<?php get_footer(); ?>
