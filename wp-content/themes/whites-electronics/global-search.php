<?php
get_header();
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array( 'post_type' => array( 'post', 'page', 'product', 'adventurers', 'videos', 'find', 'manuals'), 's' => get_query_var( 's' ), 'posts_per_page' => 10, 'paged' => $paged );
$search = new WP_Query( $args );
relevanssi_do_query($search);
?>
<main role="main">
	<?php
	$heroBgImage = get_field('hero_background');
	$title = get_field('page_title');
	$subtitle = get_field('subtitle');

	$backgroundImg  ='';
	if (!empty($heroBgImage) && !empty($heroBgImage['url'])) {
	    $backgroundImg = "background-image: url('" . $heroBgImage['sizes']['large'] . "')";
	}

	?>
	<div class="outer-wrapper">
	    <div class="hero">
	        <div class="bg-image" style="<?php echo $backgroundImg; ?>"></div>
	        <h1 class="no-subtitle">Search Results</h1>
	    </div>
	</div>
  	<div class="wrapper">
		<div class="content text-wrapper wysiwyg">
	      	<h2 class="search-title"> <?php echo $wp_query->found_posts; ?>
	        <?php _e( 'Search Results Found For', 'locale' ); ?>: "<?php the_search_query(); ?>" </h2>

	        <?php if( $search->have_posts() ) : ?>
	        	<ul>
	            <?php while( $search->have_posts() ) : $search->the_post(); ?>

	               <li>
	               <h3><a href="<?php the_permalink(); ?>"><?php the_title();  ?></a></h3>
	                 <?php $postThumbnail = get_the_post_thumbnail($post,'thumbnail');
	                 if ($postThumbnail) { ?>
	                 	<div class="image">
	                 		<?php echo $postThumbnail; ?>
	                 	</div>
	                 <?php } ?>
	                 <div class="excerpt">
	                 <?php
	                 	echo substr(strip_tags(get_the_excerpt()), 0,200); ?>
	                 	<div class="readmore"> <a href="<?php the_permalink(); ?>">Read More</a></div>
	                 </div>
	               </li>

	            <?php endwhile; ?>
	            </ul>
	        <?php endif; ?>

	           <?php if (function_exists("pagination")) { ?>
		        <div class="posts-nav-container">
		          <div class="posts-nav">
		            <?php pagination($search->max_num_pages); ?>
		          </div>
		        </div>
		      <?php } ?>

		    <?php wp_reset_query(); ?>

		</div>
	</div>
</main>

<?php get_footer(); ?>
