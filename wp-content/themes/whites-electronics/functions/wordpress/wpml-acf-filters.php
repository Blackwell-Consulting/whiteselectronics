<?php

/**
 * WPML support to page rule with ACF 5
 */
add_filter('acf/location/rule_match/page', 'ruleMatchDefaultLanguagePostWpml', 10, 3);

/**
 * ruleMatchDefaultLanguagePostWpml
 *
 * This function will match a location rule to determine if the default language's post matches and return true or false
 *
 * @type filter
 * @date 5/31/16
 *
 * @param bool $match The true/false variable which must be returned
 * @param array $rule The current rule that you are matching against. This is an array with keys for ‘param’, ‘operator’, ‘value’.
 * @param array $options an array of data about the current edit screen (post_id, page_template, post_type, etc). This array will also include any data posted in an ajax call (ajax calls are made on a post / page when you change the category, page_template, etc)
 * @return bool
 */
function ruleMatchDefaultLanguagePostWpml($match, array $rule, array $options)
{
    global $sitepress;

    // validate
    if (!$options['post_id']) {
        return false;
    }

    if (!isset($sitepress)) {
        return $match;
    }

    // if not already default language and wpml is enabled then check the rule against the default language version
    $defaultLanguageCode = $sitepress->get_default_language();
    if ($options['lang'] == $defaultLanguageCode || !has_filter('wpml_object_id')) {
        return $match;
    }

    // vars
    $postId = $options['post_id'];

    // validation
    if (!$postId) {
        return false;
    }

    $ruleId = intval($rule['value']);

    // get default language id for current post
    $defaultLanguagePostId = apply_filters(
        'wpml_object_id',
        $postId,
        $options['post_type'],
        true,
        $defaultLanguageCode
    );

    // compare
    if ($rule['operator'] === "==") {
        $match = $defaultLanguagePostId === $ruleId;
    } elseif ($rule['operator'] === "!=") {
        $match = $defaultLanguagePostId !== $ruleId;
    }

    // return
    return $match;
}


/**
 * WPML support to post taxonomy rule with ACF 5
 */

add_filter( 'acf/location/rule_match/post_taxonomy', 'ruleMatchDefaultLanguagePostTaxonomyWpml', 10, 3 );

/*
 * ruleMatchDefaultLanguagePostTaxonomyWpml
 *
 * This function will match a location rule to determine if the default language's taxonomy matches and return true or false
 *
 * @type filter
 * @date 5/31/16
 *
 * @param bool $match The true/false variable which must be returned
 * @param array $rule The current rule that you are matching against. This is an array with keys for ‘param’, ‘operator’, ‘value’.
 * @param array $options an array of data about the current edit screen (post_id, page_template, post_type, etc). This array will also include any data posted in an ajax call (ajax calls are made on a post / page when you change the category, page_template, etc)
 * @return bool
*/

function ruleMatchDefaultLanguagePostTaxonomyWpml( $match, array $rule, array $options )
{
    global $sitepress;

    // validate
    if (!$options['post_id']) {
        return false;
    }

    if (!isset($sitepress)) {
        return $match;
    }

    // if not already default language and wpml is enabled then check the rule against the default language version
    $defaultLanguageCode = $sitepress->get_default_language();
    if ($options['lang'] == $defaultLanguageCode || !has_filter('wpml_object_id')) {
        return $match;
    }

    // vars
    $terms = $options['post_taxonomy'];

    // get term data
    $data = acf_decode_taxonomy_term($rule['value']);
    $field = is_numeric($data['term']) ? 'id' : 'slug';
    $term = get_term_by($field, $data['term'], $data['taxonomy']);

    // validate term
    if (empty($term)) {
        return false;
    }

    // post type
    if (!$options['post_type']) {
        $options['post_type'] = get_post_type($options['post_id']);
    }

    // get terms
    if (!$options['ajax']) {
        $terms = wp_get_post_terms($options['post_id'], $term->taxonomy, array('fields' => 'ids'));
    }

    // If no terms, this is a new post and should be treated as if it has the "Uncategorized" (1) category ticked
    if (empty($terms)) {
        if (is_object_in_taxonomy($options['post_type'], 'category')) {
            $terms = array(1);
        }
    }

    // get default language version of term id
    $defaultLanguageTermId = apply_filters(
        'wpml_object_id',
        $term->term_id,
        $data['taxonomy'],
        true,
        $defaultLanguageCode
    );

    // compare
    if ($rule['operator'] === "==") {
        $match = in_array($defaultLanguageTermId, $terms);
    } elseif ($rule['operator'] === "!=") {
        $match = !in_array($defaultLanguageTermId, $terms);
    }

    // return
    return $match;
}

