<?php

get_header();
the_post();

$pid = get_the_id(); ?>

<main role="main">
	<?php if (!is_page('cart') && !is_page('checkout')) {
  		include(get_stylesheet_directory() . '/partials/hero.php');
  	} ?>
	<div class="wrapper">
		<div class="content text-wrapper wysiwyg">
			<?php the_content(); ?>
		</div>
	</div>
</main>

<?php get_footer(); ?>
