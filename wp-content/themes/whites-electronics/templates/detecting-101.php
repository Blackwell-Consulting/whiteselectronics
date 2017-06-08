<?php
/**
 * Template Name: Detecting 101
 */
get_header(); ?>

<main role="main">
  <?php include(get_stylesheet_directory() . '/partials/hero.php'); ?>

    <div class="outer-wrapper">
        <div class="grid-container">
            <div class="sidebar">
        	<h1><?php _e("Filter By"); ?></h1>
        	  <div class="parent-categories">
        	    <h2><?php _e("Categories"); ?></h2>

        	    <?php
        	    $args = array(
        	        'hide_empty' => true,
        	        'parent'   => 0
        	    );


        	    $video_categories = get_terms( 'video-type', $args );
                $categories_count = wp_count_posts( 'videos');

        	    $count = count($video_categories);
        	     if ( $count > 0 ){
        	        echo '<ul>';
                    echo'<li><a href=" " class="active">All<span>(' . $categories_count->publish . ')</span></a></li>';

        	         foreach ( $video_categories as $video_category ) {
        	          $className = strtolower( str_replace(' ', '-', $video_category->name ) );
        	          echo '<li><a href="' . get_term_link( $video_category ) . '" class="' . $className . '">' . $video_category->name . '</a><span>(' . $video_category->count . ')</span></li>';

        	         }
        	         echo "</ul>";
        	     }
        	     ?>
        	    </div>
            </div>

        	<?php
        	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        	$args = array( 'post_type' => 'videos', 'posts_per_page' => 9, 'paged' => $paged );
        	$loop = new WP_Query( $args );

        	if ( $loop->have_posts() ) { ?>

        		<div class="how-to-videos grid-items">

              	 	<?php
                	while ( $loop->have_posts() ) : $loop->the_post();
                	$img = get_field('video_thumbnail'); ?>

                  	<div class="how-to grid-item" style="background-image: url('<?php echo $img['url']; ?>');">
                      <a class="how-to-link" href="<?php the_permalink(); ?>">
                        <h1><?php the_title(); ?></h1>
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
    </div>

</main>

<?php
get_footer(); ?>