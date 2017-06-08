<?php
/**
Template Name: Form - Repair Status
*/

$errors = array();
$formSubmittedSuccessfully = false;
$response = '';
$required = array(
    'we_phone_number' => array()
);

function validate_phone_number($field, $value) {
    if (preg_match('/\d{3}-\d{3}-\d{4}/', $value))
        return '';
    return 'Oops. Please try your phone number again';
}

function format_phone_number($value) {
    $matches = array();
    $result = preg_match_all('/\(([0-9]+)\)\s([0-9]+)-([0-9]+)/', $value, $matches, PREG_SET_ORDER);
    if ($result === 0)
        return $value;

    return $matches[0][1] . '-' . $matches[0][2] . '-' . $matches[0][3];
}

$availableFields = array() + $required;

if (!empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'check_repair_status') && isset($_POST['we_submit'])) {

    // Loop and validate
    foreach ($_POST as $postField => $value) {
        if (!key_exists($postField, $availableFields)) {
            continue;
        }

        if (key_exists($postField, $required) && empty($value)) {
            $errors[$postField] = 'Oops. Please try your phone number again.';
            continue;
        }

        $fieldFunctionPostfix = str_replace('we_', '', $postField);
        $customFieldFormatFunction = 'format_' . $fieldFunctionPostfix;
        if (function_exists($customFieldFormatFunction)) {
            $_POST[$postField] = $value = call_user_func($customFieldFormatFunction, $value);
        }

        $customValidationFunction = 'validate_' . $fieldFunctionPostfix;
        if (function_exists($customValidationFunction)) {
            $return = call_user_func($customValidationFunction, $postField, $value);
            if (is_string($return) && !empty($return)) {
                $errors[$postField] = $return;
            }
        }
    }

    if (empty($errors)) {

        $response = we_get_api_response('repairs', array(
            'phone' => $_POST['we_phone_number']
        ));

        $response = json_decode($response);

        if (empty($response->repairs)) {
            $errors['general-errors'] = '<p class="success-msg">We\'re sorry, we didn\'t find any items connected to that number<span>You can try another phone number or you can <a href="' . home_url('/contact-us') . '">contact us</a> for assistance.</span></p>';
        }

        $formSubmittedSuccessfully = empty($errors);
    }
}

?>

<?php get_header(); ?>

    <main role="main" class="repair-status submit-a-story">

        <?php if (!is_page('cart') && !is_page('checkout')) : ?>
            <?php include(get_stylesheet_directory() . '/partials/hero.php'); ?>
        <?php endif; ?>

        <div class="wrapper">
            <div class="content text-wrapper wysiwyg">

                <?php echoFormFieldError($errors, 'general-errors'); ?>

                <?php if ($formSubmittedSuccessfully) : ?>

                    <?php if (!empty($response->message)) : ?>
                        <p class="field-error"><?php _e($response->message); ?></p>
                    <?php else : ?>
                        <?php foreach ($response->repairs as $repair) : ?>
                            <h2><?php _e("Repair status of your " . $repair->fmodname); ?></h2>

                            <?php if (!empty($repair->fdtrecv) && $repair->fdtrecv != '1900-01-01') : ?>
                                <span><?php _e("Received:"); ?> </span> <?php echo date('n/d/Y', strtotime($repair->fdtrecv)); ?><br>
                            <?php endif; ?>

                            <?php if (!empty($repair->fdretd) && $repair->fdretd != '1900-01-01') : ?>
                                <span><?php _e("Returned:"); ?></span> <?php echo date('n/d/Y', strtotime($repair->fdretd)); ?><br>
                            <?php else: ?>
                                <span><?php _e("Returned:"); ?></span> <?php _e("Pending"); ?><br>
                            <?php endif; ?>

                            <?php if (!empty($repair->ftech)) : ?>
                                <p>
                                    <span class="notes"><?php _e("Notes from Technician &quot;" . $repair->ftech . "&quot;"); ?></span><br>
                                    <?php _e($repair->fcomments); ?>
                                </p>
                                <hr>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    <?php endif; ?>

                <?php endif; ?>

                <?php if (isset($_POST['we_submit']) && $formSubmittedSuccessfully) : ?>
                    <h2><?php _e("Enter another:"); ?></h2>
                <?php endif; ?>

                <p>If you have sent in a product for repair, you can enter your phone number here to find the status of your repair.</p>

                <form action="<?php the_permalink(); ?>" method="POST" class="repair-status-form">
                    <?php wp_nonce_field('check_repair_status'); ?>
                    <input type="hidden" name="we_submit" value="submit">

                    <ul class="finds-form">
                        <li>
                            <label for="we_phone_number"><?php _e("Phone Number"); ?><span class="required">*</span></label>
                            <input id="we_phone_number" type="text" name="we_phone_number" value="">
                            <?php echoFormFieldError($errors, 'we_phone_number'); ?>
                        </li>
                        <li>
                            <button type="submit" class="submit"><?php _e("Check Status"); ?></button>
                        </li>
                    </ul>
                </form>

            </div>
        </div>

    </main>

<?php get_footer(); ?>
