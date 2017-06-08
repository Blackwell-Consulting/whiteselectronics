<?php
use WhitesElectronics\DetectorSelector\SelectorHelper;
$selectorHelper = new SelectorHelper();
$detectorsProductCategory = get_term_by('slug', 'metal-detectors', 'product_cat');

// pull metal detector products
$args = array(
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'id',
            'terms' => $detectorsProductCategory->term_id
        )
    ),
    'post_type' => 'product',
    'meta_key' => '_price',
    'orderby' => 'meta_value_num',
    'order' => 'DESC'
);
$detectors_query = new WP_Query( $args );

$questionTechSavvy = get_term_by('slug', 'question-tech-savvy', 'detector-selector-questions');
$questionFrequency = get_term_by('slug', 'question-frequency', 'detector-selector-questions');
$questionAppeal = get_term_by('slug', 'question-appeal', 'detector-selector-questions');

$jsValues = array(
    'questionSlugs' => array(
        'techSavvy' => $questionTechSavvy->slug,
        'frequency' => $questionFrequency->slug,
        'appeal' => $questionAppeal->slug
    )
);

wp_localize_script('site-main', 'detectorSelector', $jsValues);
?>


    <div class="js_detector-selector">
        <div class="wrapper">
            <div class="intro-container js_detector-selector-intro-container">
                <?php the_content(); ?>
                <hr />
                <button class="js_detector-selector-start">Let's Begin</button>
            </div>
            <div class="js_detector-selector-form detector-selector-form">
                <form name="detector-selector">
                    <div class="question-counter">Question <div class="counter">1</div>/5</div>
                    <?php foreach($selectorHelper->questions as $question) { ?>
                        <div class="question js_question <?php echo $question->slug; ?>" data-priority="<?php echo get_field('question_priority', $question); ?>">
                            <span class="question-text"><?php esc_attr_e($question->name); ?></span>
                            <div class="alert-choose">Please Choose One.</div>
                            <?php
                            if(array_key_exists($question->term_id, $selectorHelper->answers)) {
                                foreach ($selectorHelper->answers[$question->term_id] as $answer_idx => $answer) {
                                    $inputID = 'answer-' . $selectorHelper->flags[$answer->slug];
                                    $inputClass = 'answer-' . $answer->slug;
                                    $inputValue = $selectorHelper->flags[$answer->slug];
                                    $answerType = get_field('answer_type', $answer);
                                    $image =  get_field('image', $answer);
                                    $icon =  get_field('icon', $answer);
                                    $checked = ($answerType === 'slider-choice' && $answer_idx === 0) ? ' checked' : ''; ?>

                                    <div class="checkbox-container <?php echo $inputClass . ' ' . $answerType ?>">
                                        <input id="<?php echo $inputID; ?>" type="radio" name="<?php echo $question->slug; ?>" data-answerid="<?php echo $answer->term_id; ?>" value="<?php echo $inputValue; ?>"<?php echo $checked ?> />
                                        <label for="<?php echo $inputID; ?>"><div class="description"><?php esc_attr_e($answer->name); ?></div><span class="image" style="background-image: url('<?php echo $image['url']; ?>');"></span></label>
                                        <div class="checkmark"></div>
                                        <img class="icon" src="<?php echo $icon['url']; ?>" />
                                    </div>
                                    <?php
                                }
                            } ?>
                            <div class="questions-nav">
                                <button class="back js_prev">Back</button>
                                <button class="next js_next">Next</button>
                            </div>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
        <div class="results-container js_detector-selector-results-container">

                    <div class="personality-types js_personality-types" data-levels='<?php echo json_encode($selectorHelper->personalityLevelLookup); ?>'>
                    <?php while ( have_rows('personality_profiles') ) : the_row();
                        $personalityTypeTerm = get_sub_field('personality_answer', 'detector-selector');

                        // load adventurer data for personality type
                        $adventurerIds = get_sub_field('adventurers');
                        $adventurers = array();
                        
                        if (is_array($adventurerIds) && !empty($adventurerIds)) {
                            foreach ($adventurerIds as $adventurerId) {
                                $adventurers[] = array(
                                    'title'     => get_the_title($adventurerId),
                                    'image'     => wp_get_attachment_url(get_post_thumbnail_id($adventurerId)),
                                    'url'       => get_permalink($adventurerId)
                                );
                            }
                        }

                        ?>
                        <div class="personality-type js_personality-type" data-level="<?php echo the_sub_field('personality_level');
                            ?>" data-type-flags="<?php echo $selectorHelper->flags[$personalityTypeTerm->slug];
                            ?>" data-type="<?php echo the_sub_field('name');
                            ?>" data-adventurers='<?php echo json_encode($adventurers); ?>'>
                            <?php $heroBgImage = get_sub_field('hero_banner'); ?>
                                <div class="outer-wrapper">
                                    <div class="hero">
                                        <div class="bg-image" style="background-image: url('<?php echo $heroBgImage['url'] ?>')"></div>
                                        <h2>You are a</h2>
                                        <h1 class="js_adventurer-type"></h1>
                                    </div>
                                </div>
                                <div class="outer-wrapper">
                                    <a href="<?php echo home_url('/detector-selector'); ?>" class="start-over js_detector-selector-reset">Start Over</a>
                                </div>
                                <div class="wrapper">
                                    <?php echo the_sub_field('description'); ?>
                                </div>
                        </div>
                    <?php endwhile; ?>

            <div class="outer-wrapper">

                <div class="recommended-detectors-container">

                    <div class="recommended-detectors">

                        <div class="wrapper">

                            <div class="header">
                                <?php the_field("results_header_copy") ?>
                            </div>

                            <div class="js_detector-selector-results">
                                <?php while( $detectors_query->have_posts() ) {
                                    $detectors_query->the_post();
                                    $detector_product = new WC_Product( $post );
                                    $terms = get_the_terms($post, 'detector-selector-questions');
                                    $terms_flags = ($terms && !is_wp_error($terms)) ? $selectorHelper->getFlagsForTerms($terms) : "0";
                                    ?>
                                    <a class="detector-selector-result js_detector-selector-result" href="<?php echo get_permalink($post); ?>" data-flags="<?php echo $terms_flags; ?>">
                                        <div class="image-container">
                                            <?php echo $detector_product->get_image(); ?>
                                        </div>
                                        <span class="title"><?php echo the_title(); ?></span> <span class="price"><?php echo $detector_product->get_price_html(); ?></span>
                                        <span class="excerpt"><?php echo $post->post_excerpt; ?></span>
                                    </a>
                                    <?php
                                    }
                                    wp_reset_postdata();
                                ?>

                                <div class="no-detector-results js_no-results">
                                    <?php echo __("No matching metal detectors found."); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wrapper button-container">
                    <a href="<?php echo home_url('/detector-selector'); ?>" class="start-over bottom">Start Over</a>
                </div>
                <div class="used-by-adventurers-container js_other-adventurers-container">
                    <?php $bgImage = get_field('background_image','options'); ?>
                    <div class="bg-image" style="background-image: url('<?php echo $bgImage['url']; ?>');"></div>
                    <div class="used-by-adventurers">
                        <h2><?php _e('Other'); ?> <span class="js_base-adventurer-type"></span>s</h2>

                        <div class="adventurers-container">

                            <div class="adventurer adventurer-template js_other-adventurer">

                                <a href="" class="js_other-adventurer-link">
                                    <h3 class="js_other-adventurer-name"></h3>
                                    <img src="" class="js_other-adventurer-image" />
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
