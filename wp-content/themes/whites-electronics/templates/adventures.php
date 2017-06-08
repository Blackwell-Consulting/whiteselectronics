<?php
/*
Template Name: Adventures
*/
get_header(); ?>

<main role="main">
  <?php include(get_stylesheet_directory() . '/partials/hero.php'); ?>

    <?php
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $args = array( 'post_type' => 'adventurers', 'posts_per_page' => 12, 'paged' => $paged );
    $loop = new WP_Query( $args );

    if ( $loop->have_posts() ) { ?>

      <div class="adventurers grid-items">

      <?php
      while ( $loop->have_posts() ) : $loop->the_post();
      $url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium'); ?>

      	<div class="adventurer grid-item" style="background-image: url('<?php echo $url[0] ?>');">
          <a href="<?php the_permalink(); ?>">
            <h1><?php the_title(); ?></h1>
          </a>
      	</div>

      <?php
      endwhile; ?>
  	  </div>
      <?php if (function_exists("pagination")) { ?>
        <div class="posts-nav-container">
          <div class="posts-nav">
            <?php pagination($loop->max_num_pages); ?>
          </div>
        </div>
      <?php } ?>
  <?php } ?>
</main>

<?php
get_footer(); ?>