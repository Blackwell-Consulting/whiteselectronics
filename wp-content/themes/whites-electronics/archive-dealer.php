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
                $args = array(
                    'orderby' => 'name',
                    'order'   => 'ASC',
                    'parent' => 0,
                    'hide_empty' => 0
                );

                $categories = get_categories( $args );
                $cat =  ceil(count( $categories ) / 2);
            ?>

            <?php
                $i = 0;
                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                $posts_per_page = 9;
                $offset = ( $posts_per_page * $paged ) - $posts_per_page;

                $args = array(
                    'orderby' => 'name',
                    'parent' => 0,
                    'hide_empty' => 0,
                    'number' => $posts_per_page,
                    'offset' => $offset,
                    'posts_per_page' => 5,
                    'paged' => $paged
                );

                $categories = get_categories( $args );
                foreach ( $categories as $category ) :
                    $i++;
                    $catname = $category->name;
                    $catttid = $category->term_taxonomy_id;
                ?>
                    <div class="find grid-item">
                        <a href="<?php echo get_category_link( $category->term_id ) ?>">
                            <?php echo do_shortcode( sprintf( '[wp_custom_image_category term_id="%s"]', $catttid ) ); ?>
                            <h2><?php echo $category->name ?></h2>
                        </a>
                    </div><!-- /.find grid-item -->
                <?php endforeach; ?>
        </div><!-- /.finds grid-items -->
        <div class="clearfix"></div><!-- /.clearfix -->



        <?php

        if ( $posts_per_page < $paged) {

            $big = 999999999; // need an unlikely integer
            echo '<div class="woocommerce archive"><nav class="woocommerce-pagination"><ul class="page-numbers">';

            echo paginate_links( array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'prev_text' => __( '←' ),
                'next_text' => __( '→' ),
                'current' => max( 1, get_query_var( 'paged' ) ),
                'total' => $cat,
                'type' => 'list'
            ) );
            echo '</ul></nav></div><!-- /.woocommerce archive -->';
        }
        ?>
	</div>

</main>

<?php
get_footer(); ?>