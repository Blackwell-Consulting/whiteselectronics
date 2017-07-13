<?php
/*
Template Name: Find A Dealer UK
*/
get_header(); ?>

<main role="main" class="home find-a-dealer-uk">
	<?php include(get_stylesheet_directory() . '/partials/hero.php'); ?>

	<div class="outer-wrapper">
        <div class="alert">
            <p><span><?php _e("Need Help?"); ?></span> <?php _e("We'll point you to the metal detector that's right for you."); ?></p>
            <a class="capitalize" href="<?php echo home_url('/detector-selector'); ?>"><?php _e("Detector Selector"); ?></a>
            <span class="dismiss capitalize"><?php _e("Dismiss"); ?></span>
        </div>
        <div class="outer-wrapper">
             <div class="sidebar">
                <h1>Filter By</h1>
                <div class="parent-categories">
                    <h2>Country</h2>
                    <ul>
                        <li>
                            <a href="#" class="active">Active</a>
                        </li>
                        <li>
                            <a href="#">Not Active</a>
                        </li>
                        <li>
                            <a href="#">Not Active</a>
                        </li>
                        <li>
                            <a href="#">Not Active</a>
                        </li>
                        <li>
                            <a href="#">Not Active</a>
                        </li>
                    </ul>
                </div><!-- /.parent-categories -->
            </div><!-- /.sidebar -->
        </div><!-- /.outer-wrapper -->
        <div class="finds grid-items">
            <div class="find grid-item">
                <a href="#">
                    <img src="http://via.placeholder.com/550x550" alt="">
                        <h2>Country</h2>
                </a>
            </div><!-- /.find grid-item -->
            <div class="find grid-item">
                <a href="#">
                    <img src="http://via.placeholder.com/550x550" alt="">
                        <h2>Country</h2>
                </a>
            </div><!-- /.find grid-item -->
            <div class="find grid-item">
                <a href="#">
                    <img src="http://via.placeholder.com/550x550" alt="">
                        <h2>Country</h2>
                </a>
            </div><!-- /.find grid-item -->
            <div class="find grid-item">
                <a href="#">
                    <img src="http://via.placeholder.com/550x550" alt="">
                        <h2>Country</h2>
                </a>
            </div><!-- /.find grid-item -->
            <div class="find grid-item">
                <a href="#">
                    <img src="http://via.placeholder.com/550x550" alt="">
                        <h2>Country</h2>
                </a>
            </div><!-- /.find grid-item -->
            <div class="find grid-item">
                <a href="#">
                    <img src="http://via.placeholder.com/550x550" alt="">
                        <h2>Country</h2>
                </a>
            </div><!-- /.find grid-item -->
            <div class="find grid-item">
                <a href="#">
                    <img src="http://via.placeholder.com/550x550" alt="">
                        <h2>Country</h2>
                </a>
            </div><!-- /.find grid-item -->
        </div><!-- /.finds grid-items -->
        <div class="clearfix"></div><!-- /.clearfix -->
	</div>

</main>

<?php
get_footer(); ?>