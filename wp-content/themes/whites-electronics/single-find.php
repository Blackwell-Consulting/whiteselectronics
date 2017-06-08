<?php
/*
Finds - Single
*/
get_header();
the_post();
$images = get_field('photos');
$heroBgImage = get_field('hero_background', 11);
$title = get_field('page_title', 11);
$subtitle = get_field('subtitle', 11); ?>
<div class="outer-wrapper">
  <div class="hero">
      <div class="bg-image" style="background-image: url('<?php echo $heroBgImage['sizes']['large'] ?>')"></div>
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
<main class="single-finds">
  <div class="outer-wrapper">
  	<article>
  		<?php if( $images ): ?>
      <div class="wrapper text-wrapper">
        <a class="back-button" href="/finds">Back</a>
    		<div class="single-gallery finds">
    			<div class="slider">
    			<?php foreach( $images as $image ): ?>

    				<div class="slide" style="background-image: url('<?php echo $image['sizes']['large'] ?>')">
            </div>

    			<?php endforeach; ?>
          </div>
    		</div>
      </div>

  		<?php endif; ?>
      <div class="wrapper text-wrapper">
        <div class="details">
          <div class="attribute">
            <h2><?php _e("Item Found:"); ?></h2>
            <span><?php echo custom_taxonomies_terms_links();?></span>
          </div>
          <div class="attribute">
            <h2><?php _e("Location:"); ?></h2>
            <span><?php the_field('location'); ?></span>
          </div>
          <div class="attribute">
            <h2><?php _e("Metal Detector Used:"); ?></h2>
            <span><?php the_field('model'); ?></span>
          </div>
        </div>
        <hr>
        <div class="content text-content">
          <h2 class="find-title"><?php the_title(); ?><h2>
          <span class="name"><?php the_field('first_name'); ?>
          <?php $lastName = get_field('last_name');
          if ($lastName) {
            echo $lastName;
          } ?>
          </span>
          <span class="date"><?php the_date('F j, Y'); ?></span>
          <div><?php the_content(); ?></div>
        </div>
      </div>
  	</article>
  </div>
    <?php $bgImage = get_field('finds_background_image','options'); ?>
    <div class="check-out">
      <div class="bg-image" style="background-image: url('<?php echo $bgImage['sizes']['large']; ?>');"></div>
      <h2><?php _e("Also Check Out"); ?></h2>
      <?php
      $prevPost = get_adjacent_post( false, '', true, 'category' );
      $prevPostID = $prevPost->ID;
      $prevImage = get_field( 'photos', $prevPostID );
      $prevImageUrl = $prevImage[0]['sizes']['thumbnail'];
      $prevName = get_the_title( $prevPost );
      $prevUrl = get_permalink( $prevPost );

      $nextPost = get_adjacent_post( false, '', false, 'category' );
      $nextPostID = $nextPost->ID;
      $nextImage = get_field( 'photos', $nextPostID );
      $nextImageUrl = $nextImage[0]['sizes']['thumbnail'];
      $nextName = get_the_title( $nextPost );
      $nextUrl = get_permalink( $nextPost );

      if ($prevPost) { ?>

      <div class="prev-post">
        <h3><a href="<?php echo $prevUrl ?>"><?php echo $prevName ?></a></h3>
        <a href="<?php echo $prevUrl ?>"><img src="<?php echo $prevImageUrl ?>" /></a>
      </div>

      <?php }

      if ($nextPost) { ?>

      <div class="next-post">
        <h3><a href="<?php echo $nextUrl ?>"><?php echo $nextName ?></a></h3>
        <a href="<?php echo $nextUrl ?>"><img src="<?php echo $nextImageUrl ?>" /></a>
      </div>

      <?php } ?>
    </div>
</main>

<?php
get_footer(); ?>
