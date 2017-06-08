<?php
/**
 * Template Name: Manuals
 */
get_header();
$args = array(
    'post_type' => 'manuals',
    's' => get_query_var('ms'),
    'posts_per_page' => 10,
    'orderby' => 'date',
    'order' => 'DESC'
);
$search = new WP_Query($args);
relevanssi_do_query($search);
$heroBgImage = get_field('hero_background', 4643); ?>

<main role="main">
    
    <div class="hero">
        <div class="bg-image" style="background-image: url('<?php echo $heroBgImage['sizes']['large'] ?>')"></div>
        <h1 class="no-subtitle">Manuals</h1>
    </div>
    
    <div class="wrapper">
        <div class="manuals-container">
            <div class="sorting">
                <form role="search" method="get" class="search-form" id="manuals-search"
                      action="<?php echo home_url('/device-care/manuals/'); ?>">
                    <label>
                        <span class="screen-reader-text"><?php echo _x('SEARCH MANUALS', 'label') ?></span>
                        <input type="search" class="search-field"
                               value="<?php echo get_query_var('ms'); ?>" name="ms"
                               title="<?php echo esc_attr_x('SEARCH', 'label') ?>"/>
                        <input type="hidden" name="site_section" value="manuals"/>
                        <input type="hidden" name="lang" value="<?php echo ICL_LANGUAGE_CODE; ?>"/>
                        <input type="submit" class="search-submit" value="Search" form="manuals-search">
                    </label>
                </form>
            </div>
            <div class="manuals">
                <?php
                if ($search->have_posts()): ?>
                    <div class="heading">
                        <span class="model-number">Model</span>
                        <span class="title">Name</span>
                    </div>
                    <?php
                    while ($search->have_posts()) : $search->the_post();
                        $manual = get_field('manual_pdf'); ?>
                        <div class="manual">
                            <div class="model-number">
                                <a target="_blank"
                                   href="<?php echo $manual['url'] ?>"><?php the_field('model_number') ?></a>
                            </div>
                            <div class="title">
                                <a target="_blank"
                                   href="<?php echo $manual['url'] ?>"><?php the_field('product_title') ?></a>
                            </div>
                            <a target="_blank" class="download" href="<?php echo $manual['url'] ?>">Download</a>
                        </div>
                        <?php
                    endwhile;
                else: ?>
                    <div class="no-results">
                        Sorry, there are no results.
                    </div>
                    <?php
                endif; ?>
                <?php wp_reset_query(); ?>
            </div>
        </div>
    </div>
</main>

<?php
get_footer(); ?>
