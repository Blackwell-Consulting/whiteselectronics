<?php

global $we_available_warranty_forms;
$we_available_warranty_forms = array(4, 12);

/**
 * Enqueue javascript into the warranty registration form
 */
add_action('gform_enqueue_scripts', function ($form, $is_ajax) {
    global $we_available_warranty_forms;

    if (!in_array($form['id'], $we_available_warranty_forms)) {
        return;
    }

    if ($is_ajax) {
        wp_register_script('warranty_registration_script', '/wp-content/themes/whites-electronics/public/assets/js/warranty-registration.js', false, false, true);
        wp_enqueue_script('warranty_registration_script');
    }
}, 10, 2);


/**
 * Inject the model information into the form
 */
add_action('gform_form_tag', function ($form_tag, $form) {

    $availableForms = array(4, 12);
    if (!in_array($form['id'], $availableForms)) {
        return $form_tag;
    }

    $models = get_transient('whites-models');

    // If transient doesn't exist perform parsing and save in transient
    if ($models == false || WP_DEBUG) {
        $transientModels = array();
        $modelsFromOption = get_option('options_models', '');
        if (empty($modelsFromOption))
            return $form_tag;

        $splitModels = explode("\r\n", $modelsFromOption);
        $len = count($splitModels);

        for ($i = 0; $i < $len; $i++) {
            $model = explode('=', $splitModels[$i]);
            $transientModels[$model[0]] = $model[1];
        }

        $models = htmlspecialchars(json_encode($transientModels), ENT_QUOTES, 'UTF-8');

        // expire in 10 min
        set_transient('whites-models', $models, 10 * 60);
    }
    
    $form_tag = rtrim($form_tag, '>');
    $form_tag .= 'data-available-models="' . $models . '">';

    return $form_tag;
}, 10, 2);
