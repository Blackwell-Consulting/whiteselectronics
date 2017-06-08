<?php
get_header(); ?>

<main role="main">
    <?php
    $heroBgImage = get_field('hero_background', 13);
    $title = get_field('page_title', 13);
    $subtitle = get_field('subtitle', 13); ?>

    <div class="outer-wrapper">
      <div class="hero">
        <div class="bg-image" style="background-image: url('<?php echo $heroBgImage['url'] ?>')"></div>
        <?php
        if(!$subtitle) {
            echo '<h1 class="no-subtitle">' . $title . '</h1>';
        }
        else {
            echo '<h1>' . $title . '</h1>';
            echo '<h2>' . $subtitle . '</h2>';
        } ?>
      </div>
    </div>

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

                $page_id = $wp_query->get_queried_object();
        	    $find_categories = get_terms( 'video-type', $args );
                $categories_count = wp_count_posts( 'videos');

        	    $count = count($find_categories);
        	     if ( $count > 0 ){
        	        echo "<ul>";
                    //echo'<li><a href="/detecting-101">All<span>(' . $categories_count->publish . ')</span></a></li>';
        	        foreach ( $find_categories as $find_category ) {
        	          $className = strtolower( str_replace(' ', '-', $find_category->name ) );
                      $classActive = '';
                      if ($page_id->slug == $className ) {
                        $classActive = "active ";
                      }
        	          echo '<li><a href="' . get_term_link( $find_category ) . '" class="' . $classActive . $className . '">' . $find_category->name . '</a><span>(' . $find_category->count . ')</span></li>';

        	         }
        	         echo "</ul>";
        	     }
        	     ?>
        	    </div>
            </div>

        	<?php
        	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        	$args = array( 'posts_per_page' => 12, 'paged' => $paged );
        	$loop = new WP_Query( $args );

        	if ( have_posts() ) { ?>

        		<div class="how-to-videos grid-items">

          	 	<?php
            	while ( have_posts() ) : the_post();
            	$img = get_field('video_thumbnail'); ?>

              	<div class="how-to grid-item" style="background-image: url('<?php echo $img['sizes']['large'] ?>');">
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