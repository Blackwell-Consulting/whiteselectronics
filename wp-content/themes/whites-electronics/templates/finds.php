<?php
/**
 * Template Name: Finds
 */
get_header(); ?>

<main role="main">
  <?php include(get_stylesheet_directory() . '/partials/hero.php'); ?>

    <div class="grid-container">
        <div class="outer-wrapper">
            <a href="<?php echo home_url('/finds/submit-a-find'); ?>" title="Share Your Finds" class="share-your-find">Share Your Finds</a>
            <div class="sidebar">
        	<h1><?php _e("Filter By"); ?></h1>
        	  <div class="parent-categories">
        	    <h2><?php _e("Categories"); ?></h2>

        	    <?php
        	    $args = array(
        	        'hide_empty' => true,
        	        'parent'   => 0
        	    );


        	    $find_categories = get_terms( 'find-type', $args );
                $categories_count = wp_count_posts( 'find');

        	    $count = count($find_categories);
        	     if ( $count > 0 ){
        	        echo '<ul>';
                    echo'<li><a href="/finds" class="active">All<span>(' . $categories_count->publish . ')</span></a></li>';
        	         foreach ( $find_categories as $find_category ) {
        	          $className = strtolower( str_replace(' ', '-', $find_category->name ) );
        	          echo '<li><a href="' . get_term_link( $find_category ) . '" class="' . $className . '">' . $find_category->name . '</a><span>(' . $find_category->count . ')</span></li>';

        	         }
        	         echo "</ul>";
        	     }
        	     ?>
        	    </div>
            </div>
        </div>

        	<?php
        	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        	$args = array( 'post_type' => 'find', 'orderby' => 'date', 'post_status' => 'publish', 'posts_per_page' => 9, 'paged' => $paged );
        	$loop = new WP_Query( $args );

        	if ( $loop->have_posts() ) { ?>

        		<div class="finds grid-items">

              	 	<?php
                	while ( $loop->have_posts() ) : $loop->the_post();
                	$gallery = get_field('photos');
                	$first_img = $gallery[0]['sizes']['medium']; ?>

                  	<div class="find grid-item" style="background-image: url('<?php echo $first_img; ?>');">
                      <a href="<?php the_permalink(); ?>">
                        <h1><?php the_title(); ?><span><?php the_date('F j'); ?></span></h1>
                      </a>
                  	</div>

                	<?php
                	endwhile; ?>
        		</div>
        	<?php } ?>
            <?php if (function_exists("pagination")) { ?>
            <div class="posts-nav-container">
              <div class="posts-nav">
                <?php pagination($loop->max_num_pages); ?>
              </div>
            </div>
        <?php } ?>
    </div>

</main>

<?php
get_footer(); ?>
