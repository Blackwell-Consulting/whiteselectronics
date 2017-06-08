<?php
/**
 * Template Name: Manuals
 */
get_header(); ?>

<main role="main">
  <?php include(get_stylesheet_directory() . '/partials/hero.php'); ?>

    <div class="wrapper">
    	<div class="manuals-container">
    		<div class="sorting">
				<form role="search" method="get" class="search-form" id="manuals-search" action="<?php echo home_url('/device-care/manuals/'); ?>">
					<label>
						<span class="screen-reader-text"><?php echo _x( 'SEARCH MANUALS', 'label' ) ?></span>
						<input type="search" class="search-field"
							   value="<?php echo get_query_var('ms'); ?>" name="ms"
							   title="<?php echo esc_attr_x( 'SEARCH', 'label' ) ?>" />
						<input type="hidden" name="site_section" value="manuals" />
						<input type="submit" class="search-submit" value="Search" form="manuals-search">
					</label>
				</form>
    		</div>
	    	<div class="manuals">
			    <?php
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					$search  = get_query_var('ms');
					$args = array('post_type'      => 'manuals',
								  'posts_per_page' => 15,
								  'paged'          => $paged,
								  'orderby'        => 'date',
								  'order'          => 'DESC'
					);
					if (!empty($search)) {
						$args['s'] = $search;
					}
					$loop = new WP_Query( $args );
					
					if (!empty($search)) {
						relevanssi_do_query($loop);
					}
				?>
				
				<?php if ($loop->have_posts()) : ?>
					
					<div class="heading">
						<span class="model-number">Model</span>
						<span class="title">Name</span>
					</div>
					
					<?php
						while ( $loop->have_posts() ) : $loop->the_post();
							$manual = get_field('manual_pdf');
					?>
							<div class="manual">
								<div class="model-number">
									<a target="_blank" href="<?php echo $manual['url'] ?>"><?php the_field('model_number') ?></a>
								</div>
								<div class="title">
									<a target="_blank" href="<?php echo $manual['url'] ?>"><?php the_field('product_title'); ?></a>
								</div>
								<a target="_blank" class="download" href="<?php echo $manual['url'] ?>">Download</a>
							</div>
					<?php endwhile; ?>
					<?php if (function_exists("pagination")) { ?>
						<div class="posts-nav-container">
						  <div class="posts-nav">
							<?php pagination($loop->max_num_pages); ?>
						  </div>
						</div>
					<?php } ?>
				<?php else : ?>
					<div class="no-results">
						Sorry, there are no results.
					</div>
				<?php endif; ?>
			</div>
	    </div>
	</div>
</main>

<?php
get_footer(); ?>
