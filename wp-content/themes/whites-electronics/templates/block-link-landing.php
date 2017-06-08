<?php
/*
Template Name: Block Link Landing
*/
get_header(); ?>

<main role="main">
	<?php include(get_stylesheet_directory() . '/partials/hero.php'); ?>

	<div class="outer-wrapper">
		<?php
		if( have_rows('block_link') ): ?>

		<div class="pages grid-items">

			<?php
			while ( have_rows('block_link') ) : the_row();
			$bgImage = get_sub_field('background_image'); ?>

			<a href="<?php the_sub_field('page_link'); ?>" class="page grid-item" style="background-image: url('<?php echo $bgImage['url']; ?>');">
				<h2><?php the_sub_field('page_title'); ?></h2>
			</a>

			<?php
			endwhile; ?>
		</div>

		<?php
		endif; ?>
	</div>

</main>

<?php
get_footer(); ?>
