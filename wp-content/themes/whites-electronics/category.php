<?php
    get_header();

    $category = get_category( get_query_var( 'cat' ) );
    $category_id = $category->cat_ID;
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
        <h1 class="no-subtitle"><?php single_cat_title(); ?></h1>
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
                        $args = array(
                            'post_type' => 'dealer',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'category',
                                    'field'    => 'term_id',
                                    'terms'    => $category_id,
                                ),
                            )
                        );

                    $query = new WP_Query( $args ); ?>

                            <?php if ( $query->have_posts() ): ?>
                            <ul>
                                <li><a href="/find-a-dealer-uk/?lang=gb">All</a></li>
                                <li><?php single_cat_title(); ?>
                                <ul>
                                    <?php while($query -> have_posts()) : $query -> the_post(); ?>
                                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                    <?php endwhile; ?>
                                </ul>
                                </li>
                            </ul>
                    <?php endif; ?>
                <?php wp_reset_query(); ?>
                </div><!-- /.parent-categories -->
            </div><!-- /.sidebar -->
        </div><!-- /.outer-wrapper -->
            <?php
                $args = array(
                    'post_type' => 'dealer',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field'    => 'term_id',
                            'terms'    => $category_id,
                            ),
                        ),
                    );

                $query = new WP_Query( $args );
            ?>

                <?php if ( $query->have_posts() ): ?>
                    <div class="finds grid-items">
                        <?php while($query -> have_posts()) : $query -> the_post(); ?>
                            <?php
                                //vars
                                $logo = get_field( 'logo' );
                            ?>
                            <div class="find grid-item">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if( !empty( $logo ) ): ?>
                                        <img src="<?php echo $logo['sizes']['large']; ?>" alt="<?php echo $logo['alt']; ?>" />
                                    <?php endif; ?>
                                    <h2><?php the_title(); ?></h2>
                                </a>
                            </div><!-- /.find grid-item -->
                        <?php endwhile; ?>
                    </div><!-- /.finds grid-items -->
                    <div class="clearfix"></div><!-- /.clearfix -->
            <?php endif; ?>
            <?php wp_reset_query(); ?>
	</div>

</main>

<?php
get_footer(); ?>