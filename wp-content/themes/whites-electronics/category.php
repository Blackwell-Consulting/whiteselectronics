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
        <div class="finds grid-items">
            <?php
                $categories = get_categories( array(
                    'orderby' => 'name',
                    'order'   => 'ASC',
                    'parent' => 0
                ) );

                foreach( $categories as $category ) :
            ?>
                <div class="find grid-item">
                    <a href="<?php echo get_category_link( $category->term_id ) ?>">
                        <?php echo do_shortcode( sprintf( '[wp_custom_image_category term_id="%s"]', $category->term_id ) ); ?>
                        <h2><?php echo $category->name ?></h2>
                    </a>
                </div><!-- /.find grid-item -->
            <?php endforeach; ?>
        </div><!-- /.finds grid-items -->
        <div class="clearfix"></div><!-- /.clearfix -->
	</div>

</main>

<?php
get_footer(); ?>