<?php
/*
Adventurers - Single
*/
get_header();
the_post();
$images = get_field('gallery'); ?>
<main>
  <div class="outer-wrapper">
  	<article>
  		<?php if( $images ): ?>

  		<div class="single-gallery">
  			<div class="slider">
  			<?php foreach( $images as $image ): ?>

  				<div class="slide" style="background-image: url('<?php echo $image['sizes']['large'] ?>');"></div>

  			<?php endforeach; ?>
        </div>
        <div class="text-content">
          <h1><?php _e("Adventures"); ?></h1>
          <div class="text">
            <h2><?php _e("Meet"); ?></h2>
            <h3><?php the_title(); ?></h3>
          </div>
        </div>
  		</div>

  		<?php endif; ?>
      <div class="wrapper text-wrapper">
        <?php
        $excerpt = get_the_excerpt();

        if ($excerpt) { ?>
          <div class="excerpt">
            <hr>
            <?php the_excerpt(); ?>
            <hr>
          </div>
        <?php } ?>

        <div class="location">
          <h2><?php _e("Location"); ?></h2>
          <span><?php the_field('location'); ?></span>
        </div>
        <div class="content">
          <?php the_content(); ?>
        </div>
      </div>
  	</article>
  </div>
    <?php $bgImage = get_field('background_image','options'); ?>
    <div class="check-out">
      <div class="bg-image" style="background-image: url('<?php echo $bgImage['url']; ?>');"></div>
      <h2><?php _e("Also Check Out"); ?></h2>
      <?php
      $prevPost = get_adjacent_post( false, '', true, 'category' );
      $prevImage = get_the_post_thumbnail( $prevPost, 'thumbnail' );
      $prevName = get_the_title( $prevPost );
      $prevUrl = get_permalink( $prevPost );

      $nextPost = get_adjacent_post( false, '', false, 'category' );
      $nextImage = get_the_post_thumbnail( $nextPost, 'thumbnail' );
      $nextName = get_the_title( $nextPost );
      $nextUrl = get_permalink( $nextPost );

      if ($prevPost) { ?>

      <div class="prev-post">
        <h3><a href="<?php echo $prevUrl ?>"><?php echo $prevName ?></a></h3>
        <a href="<?php echo $prevUrl ?>"><?php echo $prevImage ?></a>
      </div>

      <?php }

      if ($nextPost) { ?>

      <div class="next-post">
        <h3><a href="<?php echo $nextUrl ?>"><?php echo $nextName ?></a></h3>
        <a href="<?php echo $nextUrl ?>"><?php echo $nextImage ?></a>
      </div>

      <?php } ?>
    </div>
</main>

<?php
get_footer(); ?>
