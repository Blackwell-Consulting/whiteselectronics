<?php
/*
Template Name: Troubleshooting
*/
get_header(); ?>

<main role="main">
	<?php include(get_stylesheet_directory() . '/partials/hero.php'); ?>

	<div class="wrapper">
		<div class="content text-wrapper wysiwyg">
			<?php the_content(); ?>
			<h2>Issues</h2>
			<?php if(get_field('faqs')): ?>
				<ol class="questions">
				<?php
					$i = 1;
				?>
					<?php while(has_sub_field('faqs')): ?>
						<li><a href="#q-<?php echo $i++; ?>"><?php the_sub_field('question') ?></a></li>
					<?php endwhile; ?>
				</ol>
			<?php endif; ?>
			<h2>Troubleshooting Steps</h2>
			<?php if(get_field('faqs')): ?>
				<ol class="answers">
				<?php
					$i = 1;
				?>
					<?php while(has_sub_field('faqs')): ?>
						<li>
							<span id="q-<?php echo $i++; ?>" class="question"></span>
							<h3><?php the_sub_field('question') ?></h3>
							<?php the_sub_field('answer') ?>
							<a href="#top">Back to top</a>
						</li>
					<?php endwhile; ?>
				</ol>
			<?php endif; ?>
		</div>
	</div>

</main>

<?php
get_footer(); ?>
