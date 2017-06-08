<?php
/*
Template Name: Device Care
*/
get_header(); ?>

<main role="main">
	<?php include(get_stylesheet_directory() . '/partials/hero.php'); ?>

	<div class="outer-wrapper">

		<div class="pages grid-items">
			<a href="<?php echo home_url('/device-care/troubleshooting'); ?>" class="page grid-item troubleshooting">
				<h2><?php echo __('Troubleshooting'); ?></h2>
			</a>
			<a href="<?php echo home_url('/device-care/find-a-service-center'); ?>" class="page grid-item find-a-service-center">
				<h2><?php echo __('Find A<br>Service Center'); ?></h2>
			</a>
			<a href="<?php echo home_url('/device-care/how-to-send-in-your-machine'); ?>" class="page grid-item how-to-send-in-your-machine">
				<h2><?php echo __('How To Send In Your Machine'); ?></h2>
			</a>
			<a href="<?php echo home_url('/device-care/check-your-repair-status'); ?>" class="page grid-item check-your-repair-status">
				<h2><?php echo __('Check Your<br>Repair Status'); ?></h2>
			</a>
			<a href="<?php echo home_url('/device-care/manuals'); ?>" class="page grid-item manuals">
				<h2><?php echo __('Manuals'); ?></h2>
			</a>
			<a href="<?php echo home_url('/device-care/warranty-registration'); ?>" class="page grid-item warranty-registration">
				<h2><?php echo __('Warranty Registration'); ?></h2>
			</a>
		</div>
	</div>

</main>

<?php
get_footer(); ?>
