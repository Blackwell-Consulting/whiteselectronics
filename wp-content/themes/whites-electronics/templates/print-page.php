<?php
/*
Template Name: Print Page
*/
get_header(); ?>

<main role="main" class="print-this-page">
  <?php include(get_stylesheet_directory() . '/partials/hero.php'); ?>

  <div class="wrapper">
    <div class="content text-wrapper wysiwyg">
      <?php the_content(); ?>
      <div class="button-container">
        <a class="print-button" href="javascript:window.print()">Print</a>
      </div>
    </div>
  </div>
</main>

<?php
get_footer(); ?>