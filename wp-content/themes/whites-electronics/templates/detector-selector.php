<?php
/**
 * Template Name: Detector Selector
 */
get_header();

?>
<main role="main" class="detector-selector">
	<?php include(get_stylesheet_directory() . '/partials/hero.php'); ?>

		<div class="questions">
    		<?php include(get_partial_path('modules.detector-selector')); ?>
    	</div>
    </div>
</main>

<?php
get_footer();
?>