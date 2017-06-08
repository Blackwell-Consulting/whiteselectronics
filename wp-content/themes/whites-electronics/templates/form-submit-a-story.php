<?php
/**
 * Template Name: Form - Submit a Story
 */


function validate_email($field, $value)
{
    if (strlen($value) == 0)
        return 'This field is required.';

    if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return '';
    }

    return 'Email address is invalid.';
}

function validate_zip($field, $value)
{
    $matches = preg_match('/^\d{5}(?:[-]\d{4})?$/', $value);
    if ($matches > 0 && false !== $matches) {
        return '';
    }
    return 'A valid zip-code is required. #####';
}

$errors = array();
$formSubmittedSuccessfully = false;

$required = array(
    'we_first_name'  => array(
        'type' => 'acf',
        'key'  => 'field_56953339a4320'
    ),
    'we_last_name' => array(
        'type' => 'acf',
        'key'  => 'field_56953345a4321'
    ),
    'we_address'     => array(
        'type' => 'acf',
        'key'  => 'field_56953360a4324'
    ),
    'we_city'        => array(
        'type' => 'acf',
        'key'  => 'field_5695336da4325'
    ),
    'we_state'       => array(
        'type' => 'acf',
        'key'  => 'field_56953371a4326'
    ),
    'we_zip'         => array(
        'type' => 'acf',
        'key'  => 'field_5695337aa4327'
    ),
    'we_country'     => array(
        'type' => 'acf',
        'key'  => 'field_569533aba4328'
    ),
    'we_location'    => array(
        'type' => 'acf',
        'key'  => 'field_578d3df118340'
    ),
    'we_series'      => array(
        'type' => 'acf',
        'key'  => 'field_569533f8a432b'
    ),
    'we_type'        => array(
        'type' => 'term',
        'key'  => 'find-type'
    ),
    'we_title'       => array(
        'type' => 'post',
        'key'  => 'post_title'
    ),
    'we_description' => array(
        'type' => 'post',
        'key'  => 'post_content'
    ),
);

$availableFields = array(
        'we_email'     => array(
            'type' => 'acf',
            'key'  => 'field_5695334ba4322'
        ),
        'we_model'     => array(
            'type' => 'acf',
            'key'  => 'field_56953400a432c'
        ),
        'we_photos'    => array(
            'type' => 'acf',
            'key'  => 'field_5695342fa432f'
        )
    ) + $required;

if (!empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'submit_a_story') && isset($_POST['we_submit'])) {

    // Loop and validate
    foreach ($_POST as $postField => $value) {
        if (!key_exists($postField, $availableFields)) {
            continue;
        }

        if (key_exists($postField, $required) && empty($value)) {
            $errors[$postField] = 'This field is required.';
            continue;
        }

        $customValidationFunction = 'validate_' . str_replace('we_', '', $postField);
        if (function_exists($customValidationFunction)) {
            $return = call_user_func($customValidationFunction, $postField, $value);
            if (is_string($return) && !empty($return)) {
                $errors[$postField] = $return;
            }
        }
    }

    // Post content
    if (empty($errors)) {

        // Create the post
        $postObj = array(
            'post_title'   => wp_strip_all_tags($_POST['we_title']),
            'post_name'    => sanitize_title_for_query($_POST['we_title']),
            'post_status'  => 'draft',
            'post_type'    => 'find',
            'post_date'    => date('Y-m-d H:i:s', time()),
            'post_content' => wp_strip_all_tags($_POST['we_description'])
        );

        $id = wp_insert_post($postObj, true);
        if ($id instanceof \WP_Error) {
            $errors['general-errors'] = 'There was an error when submitting the form. Please try again.';
        } else {
            // Once post has been created attach all the meta...
            foreach ($_POST as $postField => $value) {
                if (!key_exists($postField, $availableFields)) {
                    continue;
                }

                $availableField = $availableFields[$postField];
                $fieldType = $availableField['type'];
                $relationKey = $availableField['key'];

                if ($fieldType == 'post') {
                    continue;
                }

                if ($postField == 'we_photos') {
                    continue;
                }

                if ($fieldType == 'term') {
                    wp_set_post_terms($id, $value, $relationKey);
                }

                if ($fieldType == 'acf') {
                    update_field($relationKey, sanitize_text_field($value), $id);
                }

            }

            if (isset($_FILES['we_photos'])) {
                // Require files not normally required on wordpress load
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                $attachmentIDs = array();
                $uploadedCount = count($_FILES['we_photos']['name']);
                $formattedFilesarray = array();

                // Reformat the files array
                for ($i = 0; $i < $uploadedCount; $i++) {
                    foreach ($_FILES['we_photos'] as $part => $val) {
                        $formattedFilesarray[$i][$part] = $val[$i];
                    }
                }

                // Upload files into wordpress
                for ($i = 0; $i < $uploadedCount; $i++) {

                    if (empty($formattedFilesarray[$i]['tmp_name'])) {
                        continue;
                    }

                    $fileType = wp_check_filetype_and_ext($formattedFilesarray[$i]['tmp_name'],
                        $formattedFilesarray[$i]['name'], array(
                            'jpg'  => 'image/jpg',
                            'jpeg' => 'image/jpeg',
                            'gif'  => 'image/gif',
                            'png'  => 'image/png'
                        ));

                    // Deny file types not allowed
                    if (false === $fileType['type']) {
                        $errors['we_photos'][] = 'File #' . $i . ' must be an image.';
                    }

                    // Move the file to the dir
                    $uploadedFile = wp_handle_upload($formattedFilesarray[$i], array(
                        //'action' => 'editpost',
                        //'test_form' => false
                        'action' => 'wp_handle_upload'
                    ));

                    // Check for correct file type
                    $fileName = basename($uploadedFile['file']);
                    $fileType = wp_check_filetype($fileName, null);
                    $uploadDir = wp_upload_dir();

                    // Prepare an array of post data for the attachment.
                    $attachment = array(
                        'guid'           => $uploadDir['url'] . DIRECTORY_SEPARATOR . $fileName,
                        'post_mime_type' => $fileType['type'],
                        'post_title'     => preg_replace('/\.[^.]+$/', '', $fileName),
                        'post_content'   => '',
                        'post_status'    => 'inherit'
                    );

                    // Insert the attachment.
                    $attachID = wp_insert_attachment($attachment, $uploadedFile['file'], $id);

                    // Generate the metadata for the attachment, and update the database record.
                    $attachData = wp_generate_attachment_metadata($attachID, $uploadedFile['file']);
                    wp_update_attachment_metadata($attachID, $attachData);

                    $attachmentIDs[] = $attachID;
                }

                // Attach the uploaded images to the gallery
                update_field($availableFields['we_photos']['key'], $attachmentIDs, $id);
            }

            $formSubmittedSuccessfully = empty($errors);
        }

        // Remove old post data to prevent resubmition
        foreach (array_keys($availableFields) as $key) {
            unset($_POST[$key]);
        }
        unset($_POST['_wpnonce']);
        unset($_POST['we_submit']);

    }

}

$states = we_states();
$countries = we_countries();
$locations = we_locations();

$series = array();
$seriesTerms = get_terms(array('pa_series'), array(
    'hide_empty' => 0
));

if (!($seriesTerms instanceof WP_Error)) {
    foreach ($seriesTerms as $term) {
        $series[$term->name] = $term->name;
    }
}

$models = array();
$modelTerms = get_terms(array(
    'pa_man_model',
    'pa_man_current',
    'pa_man_recent',
    'pa_man_other'
), array(
    'hide_empty' => 0
));

if (!($modelTerms instanceof WP_Error)) {
    foreach ($modelTerms as $term) {
        $models[$term->name] = $term->name;
    }
}

$types = array();
$typeTerms = get_terms(array('find-type'), array(
    'hide_empty' => 0
));

if (!($typeTerms instanceof WP_Error)) {
    foreach ($typeTerms as $term) {
        $types[$term->term_id] = $term->name;
    }
}

?>

<?php get_header(); ?>

<main role="main" class="submit-a-story">

    <?php if (!is_page('cart') && !is_page('checkout')) {
        include(get_stylesheet_directory() . '/partials/hero.php');
    } ?>

    <div class="wrapper">
        <div class="content text-wrapper wysiwyg">

            <?php echoFormFieldError($errors, 'general-errors'); ?>

            <?php if ($formSubmittedSuccessfully) : ?>

                <p class="success-msg"><?php _e("THANK YOU FOR SUBMITTING YOUR FIND"); ?><span>After review we will post on the website – check back soon!</span>
                </p>

            <?php endif; ?>

            <form action="<?php the_permalink(); ?>" enctype="multipart/form-data" method="POST">
                <?php wp_nonce_field('submit_a_story'); ?>
                <input type="hidden" name="we_submit" value="submit">
                <input type="hidden" name="action" value="wp_handle_upload">

                <ul class="finds-form">
                    <li class="first_name">
                        <label for="we_first_name"><?php _e("First Name"); ?><span class="required">*</span></label>
                        <input id="we_first_name" type="text" name="we_first_name"
                               value="<?php we_echoFormValue('we_first_name'); ?>">
                        <?php echoFormFieldError($errors, 'we_first_name'); ?>
                    </li>
                    <li class="last_name">
                        <label for="we_last_name"><?php _e("Last Name"); ?><span class="required">*</span></label>
                        <input id="we_last_name" type="text" name="we_last_name"
                               value="<?php we_echoFormValue('we_last_name'); ?>">
                        <?php echoFormFieldError($errors, 'we_last_name'); ?>
                    </li>
                    <li>
                        <label for="we_email"><?php _e("Email"); ?><span class="required">*</span></label>
                        <input id="we_email" type="text" name="we_email"
                               value="<?php we_echoFormValue('we_email'); ?>">
                        <?php echoFormFieldError($errors, 'we_email'); ?>
                    </li>
                    <li>
                        <label for="we_address"><?php _e("Address"); ?><span class="required">*</span></label>
                        <input id="we_address" type="text" name="we_address"
                               value="<?php we_echoFormValue('we_address'); ?>">
                        <?php echoFormFieldError($errors, 'we_address'); ?>
                    </li>
                    <li class="city">
                        <label for="we_city"><?php _e("City"); ?><span class="required">*</span></label>
                        <input id="we_city" type="text" name="we_city" value="<?php we_echoFormValue('we_city'); ?>">
                        <?php echoFormFieldError($errors, 'we_city'); ?>
                    </li>
                    <li class="state">
                        <label for="we_state"><?php _e("State"); ?><span class="required">*</span></label>
                        <?php we_printDropdown($states, 'we_state', we_returnFormValue('we_state')); ?>
                        <?php echoFormFieldError($errors, 'we_state'); ?>
                    </li>
                    <li>
                        <label for="we_zip"><?php _e("Zip"); ?><span class="required">*</span></label>
                        <input id="we_zip" class="we_zip" type="text" name="we_zip"
                               value="<?php we_echoFormValue('we_zip'); ?>">
                        <?php echoFormFieldError($errors, 'we_zip'); ?>
                    </li>
                    <li>
                        <label for="we_country"><?php _e("Country"); ?><span class="required">*</span></label>
                        <?php we_printDropdown($countries, 'we_country', we_returnFormValue('we_country')); ?>
                        <?php echoFormFieldError($errors, 'we_country'); ?>
                    </li>
                    <li>
                        <label for="we_location"><?php _e("Find Location"); ?><span class="required">*</span></label>
                        <?php we_printDropdown($locations, 'we_location', we_returnFormValue('we_location')); ?>
                        <?php echoFormFieldError($errors, 'we_location'); ?>
                    </li>
                    <li class="product-info">
                        <label for="we_series"><?php _e("Series"); ?><span class="required">*</span></label>
                        <?php we_printDropdown($series, 'we_series', we_returnFormValue('we_series')); ?>
                        <?php echoFormFieldError($errors, 'we_series'); ?>
                        <label for="we_model"><?php _e("Model"); ?></label>
                        <?php we_printDropdown($models, 'we_model', we_returnFormValue('we_model')); ?>
                        <?php echoFormFieldError($errors, 'we_model'); ?>
                    </li>
                    <li>
                        <label for="we_type"><?php _e("Find Type"); ?><span class="required">*</span></label>
                        <?php we_printDropdown($types, 'we_type', we_returnFormValue('we_type')); ?>
                        <?php echoFormFieldError($errors, 'we_type'); ?>
                    </li>
                    <li>
                        <label for="we_title"><?php _e("Title"); ?><span class="required">*</span></label>
                        <input id="we_title" type="text" name="we_title" value="<?php we_echoFormValue('we_title'); ?>">
                        <?php echoFormFieldError($errors, 'we_title'); ?>
                    </li>
                    <li>
                        <label for="we_description"><?php _e("Description"); ?><span class="required">*</span></label>
                        <textarea id="we_description" name="we_description"><?php we_echoFormValue('we_description'); ?></textarea>
                        <?php echoFormFieldError($errors, 'we_description'); ?>
                    </li>

                    <li class="file-uploads">
                        <?php echoFormFieldError($errors, 'we_photos'); ?>

                        <div class="uploadable-container">
                            <div class="container">
                                <label for="we_photos"></label>
                                <?php _e("Photo Upload"); ?>: <input id="we_photos" type="file" name="we_photos[]">
                            </div>
                        </div>

                        <button type="button" class="add-another"><?php _e("Add Another Photo"); ?></button>
                    </li>

                    <li>
                        <button type="submit" class="submit"><?php _e("Submit"); ?></button>
                    </li>
                </ul>
            </form>
        </div>
    </div>

</main>

<?php get_footer(); ?>
