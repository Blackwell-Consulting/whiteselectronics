<?php
/*
Template Name: Home
*/
get_header();

$image = get_post_meta(get_the_ID(), 'image', true);
$tile1bg = get_field('tile_1_bg');
$tile2bg = get_field('tile_2_bg');
$tile3bg = get_field('tile_3_bg');
$layout = get_post_meta(get_the_ID(), 'choose_layout', true);
?>

<main role="main">
  <div class="outer-wrapper">
  	<div class="hero-home">

    <?php
    if ( $layout == 'layout-1' ):
      $post_object = get_field('select_adventurer');
      if( $post_object ):
          // override $post
          $post = $post_object;
          setup_postdata( $post );
          $gallery = get_field('gallery');
          $first_img = $gallery[0]; ?>

    		<div class="image" style="background-image: url('<?php echo $first_img['sizes']['large'] ?>');"></div>
    		<div class="blue-bg-round"></div>
    		<div class="intro">
    			<h1><span><span><?php _e("Since 1950"); ?>, </span><?php _e("your adventures have driven us to build</span> <span>the best</span> <span>metal detectors on the planet."); ?></span></h1>
    		</div>
        <div class="wrapper">
      		<div class="text-content">
            <h1><?php _e("Adventures"); ?></h1>
            <div class="text">
              <a href="<?php the_permalink(); ?>">
                <h2><?php _e("Meet"); ?></h2>
                <h3><?php the_title(); ?></h3>
              </a>
            </div>
      		</div>
        </div>

      <?php wp_reset_postdata(); ?>
      <?php endif;
    else:
      $image2 = get_field('hero_image'); ?>
      <div class="image" style="background-image: url('<?php echo $image2['url']; ?>');"></div>
        <div class="blue-bg-round"></div>
        <div class="intro">
          <h1><span><span><?php _e("Since 1950"); ?>, </span><?php _e("your adventures have driven us to build</span> <span>the best</span> <span>metal detectors on the planet."); ?></span></h1>
        </div>
        <?php
        $text = get_post_meta($post->ID, 'hero_text_content', true);
        if ($text): ?>
            <div class="text-content alt-layout">
              <div class="text">
                  <p><?php echo $text; ?></p>
              </div>
            </div>
        <?php
        endif; ?>
    <?php
    endif; ?>
  </div>
    <div class="outer-wrapper">
  	<div class="alert">
  	  <p><span><?php _e("Need Help?"); ?></span> <?php _e("We'll point you to the metal detector that's right for you."); ?></p>
  	  <a class="capitalize" href="<?php echo home_url('/detector-selector'); ?>"><?php _e("Detector Selector"); ?></a>
  	  <span class="dismiss capitalize"><?php _e("Dismiss"); ?></span>
  	</div>
  	<div class="tile-grid">
  		<div class="tile" style="background-image: url('<?php echo $tile1bg['url'] ?>');">
        <a href="<?php the_field('link-to'); ?>">
          <div class="custom-content">
            <?php the_field('text_content_featured_product'); ?>
          </div>
        </a>
      </div>
  		<div class="tile latest-finds" style="background-image: url('<?php echo $tile2bg['url'] ?>');">
  			<h2><?php _e("Latest Finds"); ?></h2>
        <div class="slider">

          <?php
          $args = array( 'post_type' => 'find', 'posts_per_page' => '4' ) ;
          $loop = new WP_Query( $args );

          if ( $loop->have_posts() ) :
            while ( $loop->have_posts($post) ) : $loop->the_post();
              $gallery = get_field('photos');
              $first_img = $gallery[0]; ?>

              <div class="slide" style="background-image: url(<?php echo $first_img['url']; ?>);"><a href="<?php the_permalink(); ?>"></a></div>

            <?php
            endwhile;
            wp_reset_postdata();
          endif; ?>
        </div>
  		</div>
  		<div class="tile how-to" style="background-image: url('<?php echo $tile3bg['url'] ?>');">
        <?php if( have_rows('video_post_links') ): ?>
          <div class="slider">
            <?php while ( have_rows('video_post_links') ) : the_row(); ?>
              <div class="slide">
                <?php $post_object = get_sub_field('video_post');
                if( $post_object ):
                $post = $post_object; setup_postdata( $post ); ?>
                  <div class="container">
                    <a class="tile-link" href="<?php the_permalink(); ?>"></a>
                    <h2><?php _e("Detecting 101"); ?></h2>
                    <hr>
                    <div class="title">
                      <h3><?php the_title(); ?></h3>
                    </div>
                  </div>
                <?php wp_reset_postdata();
                endif; ?>
              </div>
            <?php endwhile; ?>
          </div>
        <?php endif; ?>
      </div>
  	</div>
  </div>
</main>

<?php
get_footer();