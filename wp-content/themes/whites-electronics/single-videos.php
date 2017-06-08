<?php
/*
Videos (Detecting 101) - Single
*/
get_header();

$heroBgImage = get_field('hero_background', 13);
$title = get_field('page_title', 13);
$subtitle = get_field('subtitle', 13);

get_header(); ?>

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

<?php
the_post(); ?>

<main>
  <div class="wrapper">
    <div class="video-stage">
      <a href="/detecting-101">Back</a>
      <h1><?php the_title(); ?></h1>
      <div class="video-container active">
        <iframe height="315" src="https://www.youtube.com/embed/<?php the_field('youtube_video_link_id'); ?>?rel=0" frameborder="0" allowfullscreen></iframe>
      </div>
    </div>
  </div>
</main>

<?php
get_footer(); ?>
