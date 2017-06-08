<?php
/**
 * Created by PhpStorm.
 * User: bbierman
 * Date: 2/1/16
 * Time: 10:20 AM
 */

require(dirname(__FILE__) . '/../../../../wp-blog-header.php');
ini_set("auto_detect_line_endings", true);

// verify user
if(current_user_can('manage_woocommerce')) {

    function get_post_id_by_sku($sku)
    {
        global $wpdb;
        $post_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku));
        return $post_id;
    }

    // Mapping of WP term slugs to the order shown in the detector selector grid from client
    $answerSlugs = array(
        array('around-town', 'the-beach', 'rugged-terrain'),
        array('coins-jewelry', 'historical-relics', 'gold'),
        array('not-much', 'somewhat', 'very'),
        array('weekly', 'monthly', 'not-as-often')
    );

    // Lookup of detector model to terms
    $modelOptions = array(
        array('Spectra V3i with Headphones', '800-0329-HP', array(
            // each question on new line
            array(true, true, true),
            array(true, true, false),
            array(false, false, true),
            array(true, false, false)
        )),
        array('TREASUREmaster®', '800-0345', array(
            array(true, false, true),
            array(true, false, false),
            array(true, false, false),
            array(true, true, true))
        ),
        array('TREASUREpro', '800-0346', array(
            array(true, true, true),
            array(true, true, false),
            array(true, false, false),
            array(true, true, true))
        ),
        array('MXT All Pro', '800-0342-configurable', array(
            // each question on new line
            array(true, true, true),
            array(true, true, true),
            array(false, true, true),
            array(true, true, false)
        )),
        array('Coinmaster', '800-0325', array(
            // each question on new line
            array(true, false, false),
            array(true, false, false),
            array(true, false, false),
            array(true, false, true)
        )),
        array('MX Sport', '800-0347', array(
            array(true, true, true),
            array(true, true, false),
            array(false, true, false),
            array(true, true, false))
        ),
        array('Spectra VX3', '800-0331', array(
            // each question on new line
            array(true, true, true),
            array(true, true, false),
            array(false, false, true),
            array(true, true, false)
        )),
        array('Spectra V3i', '800-0329', array(
            // each question on new line
            array(true, true, true),
            array(true, true, false),
            array(false, false, true),
            array(true, false, false)
        )),
        array('GMT', '800-0294', array(
            // each question on new line
            array(false, false, true),
            array(false, false, true),
            array(false, true, false),
            array(true, true, false)
        )),
        array('BeachHunter 300', '800-0293-1', array(
            // each question on new line
            array(false, true, false),
            array(true, false, false),
            array(true, false, false),
            array(true, false, false)
        )),
        array('Surfmaster PI Dual Field', '800-0323', array(
            // each question on new line
            array(false, true, false),
            array(true, false, false),
            array(true, false, false),
            array(true, false, false)
        )),
        array('TDI™ SL Metal Detector with 12" Coil', '800-0332-12', array(
            // each question on new line
            array(false, true, true),
            array(false, true, true),
            array(false, true, false),
            array(true, false, false)
        )),
        array('TDI™ Pro Metal Detector', '800-0321-1', array(
            // each question on new line
            array(false, true, true),
            array(false, true, true),
            array(false, false, true),
            array(true, true, false)
        )),
        array('GMZ', '800-0324', array(
            // each question on new line
            array(false, false, true),
            array(false, false, true),
            array(true, false, false),
            array(true, false, true)
        ))
    );

    // pull questions from taxonomy
    $questions_query_args = array(
        'hierarchical' => true,
        'hide_empty' => false
    );

    // build lookup for terms
    $answerTerms = array();
    $terms = get_terms('detector-selector-questions', $questions_query_args);
    foreach ($terms as $term) {
        if ($term->parent === 0) continue;

        $answerTerms[$term->slug] = $term;
    }

    foreach ($modelOptions as $model) {
        $modelTerms = array();
        // 4 questions
        for ($r = 0; $r < 4; $r++) {
            for ($c = 0; $c < 3; $c++) {
                if ($model[2][$r][$c] === true) {
                    $modelTerms[] = $answerSlugs[$r][$c];
                }
            }
        }

        var_dump($modelTerms);

        // get post for model
        $post_id = get_post_id_by_sku($model[1]);

        if ($post_id) {
            echo "Updating $post_id\n<br />";
            // insert terms
            $result = wp_set_object_terms($post_id, $modelTerms, 'detector-selector-questions');
            var_dump($result);
        }
    }
    
}
