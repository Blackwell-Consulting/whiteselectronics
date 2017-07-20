<?php
/*
Template Name: Find A Dealer UK
*/
get_header(); ?>

<main role="main" class="home find-a-dealer-uk">
	<?php
        $uk_dealer_page = get_id_by_slug( 'find-a-dealer-uk' );
        $heroBgImage = get_field( 'hero_background', $uk_dealer_page );
        $title = get_field( 'page_title', $uk_dealer_page );
        $subtitle = get_field( 'subtitle', $uk_dealer_page );

        $backgroundImg  ='';
        if (!empty($heroBgImage) && !empty($heroBgImage['url'])) {
            $backgroundImg = "background-image: url('" . $heroBgImage['sizes']['large'] . "')";
        }

        if ($title) {
            $title = get_field( 'page_title', $uk_dealer_page );
        } else {
            $title = get_the_title();
    } ?>

        <div class="outer-wrapper">
            <div class="hero">
                <div class="bg-image" style="<?php echo $backgroundImg; ?>"></div>
                <?php if (!$subtitle) : ?>
                    <h1 class="no-subtitle"><?php echo $title; ?></h1>
                <?php else : ?>
                    <h1><?php echo $title; ?></h1>
                    <h2><?php echo $subtitle; ?></h2>
                <?php endif; ?>
            </div>
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
                    <ul>
                        <li><a href="/find-a-dealer-uk/?lang=gb">All</a></li>
                        <?php
                            wp_list_categories( array(
                                'orderby' => 'name',
                                'show_count' => true,
                                'hide_empty' => true,
                                'title_li' => '',
                                'show_option_all' => ''
                            ) );
                        ?>
                    </ul>
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