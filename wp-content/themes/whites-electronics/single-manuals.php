<?php
/*
Manuals - Single
*/
get_header();

$heroBgImage = get_field('hero_background', 4643);
$title = get_field('page_title', 4643);
$subtitle = get_field('subtitle', 4643);

get_header(); ?>

  <div class="hero">
    <div class="bg-image" style="background-image: url('<?php echo $heroBgImage['sizes']['large'] ?>')"></div>
      <h1 class="no-subtitle">Manuals</h1>
  </div>

<?php
the_post(); ?>

<main>
  <div class="wrapper">
    <div class="manuals-container">
      <div class="manuals">
        <div class="heading">
          <span class="model-number">Model</span>
          <span class="title">Name</span>
        </div>
        <?php
        $manual = get_field('manual_pdf'); ?>
        <div class="manual">
          <div class="model-number">
            <a target="_blank" href="<?php echo $manual['url'] ?>"><?php the_field('model_number') ?></a>
          </div>
          <div class="title">
            <a target="_blank" href="<?php echo $manual['url'] ?>"><?php the_field('product_title'); ?></a>
          </div>
          <a target="_blank" class="download" href="<?php echo $manual['url'] ?>">Download</a>
        </div>
      </div>
    </div>
  </div>
</main>

<?php
get_footer(); ?>
