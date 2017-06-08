<?php get_header(); ?>

<main role="main">
    
    <div class="outer-wrapper">
        <div class="hero">
            <div class="bg-image"></div>
            <h1 class="no-subtitle">404</h1>
        </div>
    </div>
    
    <div class="wrapper">
        <div class="content text-wrapper wysiwyg">
            <p>
                <?php _e("Sorry, the page you were looking for does not exist."); ?><br />
                <a href="<?php echo home_url('/'); ?>" title="Click here to return to the homepage.">Click here to return to the homepage.</a>
            </p>
        </div>
    </div>
</main>

<?php get_footer(); ?>
