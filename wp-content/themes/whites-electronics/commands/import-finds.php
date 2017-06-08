<?php

/*
 * README:
 *
 * To use this script:
 * 1. All images need to be uploaded to the asset-uploads/finds folder.
 *    These images can be found on White's server under /var/www/html/media/finds/thumbs/original/
 * 2. Grab a dump of the White's Electronics production DB (without the log tables), and create a new DB
 *    on your local MySQL server, and fill in the WE_DB_NAME below for the name of the imported magento DB.
 * 3. Run this script through browser at /wp-content/themes/whites-electronics/commands/import-finds.php
 *    (Make sure you're logged into the wp-admin first)
 *
 */

ini_set('max_execution_time', 0);
ini_set('memory_limit', '512M');
set_time_limit(0);

require(dirname(__FILE__) . '/../../../../wp-config.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

// -----------------------------------------------------------------------------------------------
// Setup
//
global $we_whiteDB;
global $we_dataMappings;
global $we_fields;
global $we_types;
global $we_allowedFileTypes;
global $we_existingFinds;

define('WE_DB_NAME', 'whites.magentodump');
define('WE_FINDS_TABLE', 'whites_customer_finds');
define('WE_IMG_DOWNLOAD_BASE_URL', 'http://www.whiteselectronics.com/media/finds/thumbs/original/');
define('WE_IMG_FIND_MEDIA_PATH', ABSPATH . 'wp-content/themes/whites-electronics/commands/asset-uploads/finds/');
define('WE_TRANSACTIONS_PER_PAGE', 50);

define('WE_OPT_CURRENT_RECORD_PAGE', 'we_find_cur_page');
define('WE_OPT_IMPORTED_FINDS', 'we_imported_finds');
define('WE_OPT_FIND_IMPORT_PROCESSING', 'we_find_import_processing');
define('WE_OPT_TRANSACTION_NUMBER', 'we_find_transaction_count');

$we_existingFinds = array();

$we_allowedFileTypes = array(
    'jpg|jpeg|jpe' => 'image/jpeg',
    'gif' => 'image/gif',
    'png' => 'image/png'
);

$we_fields = array(
    'we_first_name' => array(
        'type' => 'acf',
        'key' => 'field_56953339a4320'
    ),
    'we_address' => array(
        'type' => 'acf',
        'key' => 'field_56953360a4324'
    ),
    'we_city' => array(
        'type' => 'acf',
        'key' => 'field_5695336da4325'
    ),
    'we_state' => array(
        'type' => 'acf',
        'key' => 'field_56953371a4326'
    ),
    'we_zip' => array(
        'type' => 'acf',
        'key' => 'field_5695337aa4327'
    ),
    'we_country' => array(
        'type' => 'acf',
        'key' => 'field_569533aba4328'
    ),
    'we_region' => array(
        'type' => 'acf',
        'key' => 'field_569533bca4329'
    ),
    'we_location' => array(
        'type' => 'acf',
        'key' => 'field_569533cda432a'
    ),
    'we_series' => array(
        'type' => 'acf',
        'key' => 'field_569533f8a432b'
    ),
    'we_type' => array(
        'type' => 'term',
        'key' => 'find-type'
    ),
    'we_title' => array(
        'type' => 'post',
        'key' => 'post_title'
    ),
    'we_description' => array(
        'type' => 'post',
        'key' => 'post_content'
    ),
    'we_date' => array(
        'type' => 'post',
        'key' => 'post_date'
    ),
    'we_last_name' => array(
        'type' => 'acf',
        'key' => 'field_56953345a4321'
    ),
    'we_email' => array(
        'type' => 'acf',
        'key' => 'field_5695334ba4322'
    ),
    'we_model' => array(
        'type' => 'acf',
        'key' => 'field_56953400a432c'
    ),
    'we_photos' => array(
        'type' => 'acf',
        'key' => 'field_5695342fa432f'
    )
);

// DONT CHANGE THE ORDERING OF THE VAULES IN THIS MAPPING ARRAY
$we_dataMappings = array(
    'find_id' => null,
    'title' => 'we_title',
    'date_year' => 'we_date', // special logic
    'date_month' => 'we_date', // special logic
    'date_day' => 'we_date', // special logic
    'general_location' => 'we_region',
    'series' => 'we_series',
    'country' => 'we_country',
    'location' => 'we_location',
    'region' => 'we_state',
    'model' => 'we_model',
    'firstname' => 'we_first_name',
    'lastname' => 'we_last_name',
    'submitter' => null, // no corresponding field, needs special logic
    'types' => null, // this is a term field... needs special logic; corresponds to we_type
    'content_clean' => 'we_description',
    'images' => null
);
// -----------------------------------------------------------------------------------------------


// -----------------------------------------------------------------------------------------------
// Functions
//
function getTotalCountOfRecords()
{
    global $we_whiteDB;
    return $we_whiteDB->get_var("SELECT COUNT(*) FROM " .  WE_FINDS_TABLE . " ORDER BY find_id");
}


function getCurrentObjectsInDB($page, $limit)
{
    global $we_whiteDB;
    global $we_dataMappings;
    $columns = array_keys($we_dataMappings);
    $columns = implode(', ', $columns);

    $start = $page * $limit;

    return $we_whiteDB->get_results("SELECT " . $columns . " FROM " .  WE_FINDS_TABLE . " ORDER BY find_id LIMIT " . $start . ", " . $limit);
}


function mapObjects(array& $objects)
{
    global $we_dataMappings;

    foreach ($objects as &$obj) {
        $newObj = new stdClass();
        $postDate = '';

        foreach ($we_dataMappings as $column => $mapping) {
            if (is_null($mapping)) {
                $function  = $column . 'Map';
                if (function_exists($function)) {
                    $mappedObject = call_user_func_array($function, array(&$obj));
                    $newObj->{$mappedObject->mappedName} = $mappedObject->mappedValue;
                }
                continue;
            }

            // we can assume thanks to ordering YYYY-M-D
            if ($mapping == 'we_date') {
                $number = ($obj->{$column} < 10) ? '0' . $obj->{$column} : '' . $obj->{$column};
                $postDate .= $number . '-';
                continue;
            }

            $newObj->{$mapping} = $obj->{$column};
        }

        // Create a timestamp
        $postDate = rtrim($postDate, '-');
        $newObj->we_date = strtotime($postDate);

        $obj = $newObj;
    }
}


function submitterMap(stdClass& $obj)
{
    $returnMap = new stdClass();
    $returnMap->mappedName = 'we_first_name';
    $returnMap->mappedValue = '';

    if (is_null($obj->firstname) || empty($obj->firstname)) {
        $returnMap->mappedValue = $obj->submitter;
    }

    return $returnMap;
}


function typesMap(stdClass& $obj)
{
    global $we_types;
    $returnMap = new stdClass();
    $returnMap->mappedName = 'we_type';
    $returnMap->mappedValue = '';

    $format = ucfirst(strtolower($obj->types));

    if (isset($we_types[$format])) {
        $returnMap->mappedValue = $we_types[$format];
    } else {
        $returnMap->mappedValue = null;
    }

    return $returnMap;
}


function find_idMap(stdClass& $obj)
{
    $returnMap = new stdClass();
    $returnMap->mappedName = 'findID';
    $returnMap->mappedValue = $obj->find_id;
    return $returnMap;
}


function imagesMap(stdClass& $obj)
{
    $returnMap = new stdClass();
    $returnMap->mappedName = 'images';
    $returnMap->mappedValue = array();

    $images = preg_split("/\r\n|\n|\r/", $obj->images);
    $imgCount = count($images);

    for ($i = 0; $i < $imgCount; $i++) {
        $path = WE_IMG_FIND_MEDIA_PATH . rtrim($images[$i]);
        if (file_exists($path)) {
            $returnMap->mappedValue[] = new SplFileInfo($path);
        }
    }

    return $returnMap;
}


/**
 * Prevent type lookup n+1 queries via memoization
 */
function memoizeTypes()
{
    global $we_types;
    $we_types = array();
    $typeTerms = get_terms(array('find-type'), array(
        'hide_empty' => 0
    ));

    if (!($typeTerms instanceof WP_Error)) {
        foreach ($typeTerms as $term) {
            $we_types[$term->name] = $term->term_id;
        }
    }
}


function memoizeExistingFinds()
{
    global $we_existingFinds;

    $we_existingFinds = get_option(WE_OPT_IMPORTED_FINDS);
    if ($we_existingFinds === false) {
        $we_existingFinds = array();
        update_option(WE_OPT_IMPORTED_FINDS, array());
    }
}


function importIntoWordpress(stdClass& $model)
{
    global $we_existingFinds;

    $postTitle = wp_strip_all_tags($model->we_title);

    if (isset($we_existingFinds[$model->findID])) {
        displayMessage("Skipped " . $postTitle);
        return;
    }

    $postObj = array(
        'post_title' => $postTitle,
        'post_name' => sanitize_title_for_query($postTitle),
        'post_status' => 'publish',
        'post_type' => 'find',
        'post_date' => date('Y-m-d H:i:s', $model->we_date),
        'post_content' => wp_strip_all_tags($model->we_description)
    );

    $postID = wp_insert_post($postObj, true);
    if ($postID instanceof \WP_Error) {
        return;
    }

    // Attach meta
    attachFindMeta($postID, $model);
    attachFindImages($postID, $model);

    displayMessage("Uploaded " . $postObj['post_title']);
    $we_existingFinds[$model->findID] = $postID;
}


function attachFindMeta($postID, stdClass &$model)
{
    global $we_fields;
    foreach ($we_fields as $field => $fieldProperties) {
        if (empty($model->{$field})) {
            continue;
        }

        $type = $fieldProperties['type'];
        $key = $fieldProperties['key'];
        $value = $model->{$field};

        if ($type == 'post') {
            continue;
        }

        if ($type == 'term') {
            wp_set_post_terms($postID, $value, $key);
        }

        if ($type == 'acf') {
            update_field($key, sanitize_text_field($value), $postID);
        }
    }
}


/**
 * Assumes that $model->images is a SplFileInfo object. Also, assume that the file exists.
 *
 * @param $postID
 * @param stdClass $model
 *
 * @see \SplFileInfo
 */
function attachFindImages($postID, stdClass& $model)
{
    global $we_allowedFileTypes;
    global $we_fields;
    
    if (empty($model->images)) {
        return;
    }

    $imagesCount = count($model->images);
    $attachmentIds = array();

    for ($i = 0; $i < $imagesCount; $i++) {
        /**
         * @var SplFileInfo $image
         */
        $image = $model->images[$i];

        // Create this stupid stupid array for wordpress to move a file correctly to the uploads folder
        $fileInfo = array(
            'name' => $image->getBasename(),
            'tmp_name' => $image->getRealPath(),
            'error' => UPLOAD_ERR_OK,
            'size' => $image->getSize()
        );
        
        // Verify that the file is correct
        $checkFileType = wp_check_filetype_and_ext($fileInfo['tmp_name'], $fileInfo['name'], $we_allowedFileTypes);

        if ($checkFileType['type'] === false) {
            displayMessage($image->getRealPath() . " has a disallowed file mime-type.");
            continue;
        }

        $fileInfo['type'] = $checkFileType['type'];

        // Upload file
        $uploadDir = wp_upload_dir();
        $uploadedFile = wp_handle_upload($fileInfo, array(
            'test_form' => false,
            'action' => 'l337 no action'
        ));

        // Prepare an array of post data for the attachment.
        $attachmentTitle = preg_replace( '/\.[^.]+$/', '', $image->getBasename());
        $slug = sanitize_title_for_query($attachmentTitle);
        $attachment = array(
            'guid'           => $uploadDir['url'] . DIRECTORY_SEPARATOR . $image->getBasename(),
            'post_mime_type' => $fileInfo['type'],
            'post_title'     => $attachmentTitle,
            'post_content'   => '',
            'post_status'    => 'inherit'
        );

        // Insert the attachment.
        $attachID = wp_insert_attachment($attachment, $uploadedFile['file'], $postID);

        if ($attachID === 0) {
            displayMessage("[IMG UPLOAD FAILURE] Unable to create post attachment for " . $image->getRealPath());
            continue;
        }

        // Generate the metadata for the attachment, and update the database record.
        $attachData = wp_generate_attachment_metadata($attachID, $uploadedFile['file']);
        wp_update_attachment_metadata($attachID, $attachData);

        $attachmentIds[] = $attachID;
    }
    
    // Attach the uploaded images to the gallery
    if (!empty($attachmentIds)) {
        update_field($we_fields['we_photos']['key'], $attachmentIds, $postID);
    }
}

// -----------------------------------------------------------------------------------------------


// -----------------------------------------------------------------------------------------------
// OUTPUT
//
header('Content-Type:text/plan');
//ob_end_clean();
//ob_start();

if (current_user_can('manage_woocommerce')) {
    // Create connection
    global $we_whiteDB;
    global $we_types;
    global $we_existingFinds;

    $we_whiteDB = new wpdb(DB_USER, DB_PASSWORD, WE_DB_NAME, DB_HOST);

    $url = get_stylesheet_directory_uri() . '/commands/import-finds.php';
    $hasReset = (!empty($_GET['reset']) && $_GET['reset'] == 'true');
    $stopped = (!empty($_GET['stop']) && $_GET['stop'] == 'true');

    if ($stopped) {
        displayMessage("EXECUTION STOPPED");
        exit;
    }

    // Prevent outsiders from running script twice in a row
    $isProcessing = get_option(WE_OPT_FIND_IMPORT_PROCESSING, false);
    if ($isProcessing && !$hasReset) {
        displayMessage("IMPORT IN PROGRESS");
        exit;
    } else {
        update_option(WE_OPT_FIND_IMPORT_PROCESSING, true);
    }

    $totalPages = ceil(getTotalCountOfRecords() / WE_TRANSACTIONS_PER_PAGE) - 1;
    $page = ($hasReset) ? 0 : get_option(WE_OPT_CURRENT_RECORD_PAGE, 0);

    displayMessage("START: " . $page . " OF " . $totalPages . "\n");

    // Grab a list of pre-existing finds
    memoizeExistingFinds();

    // Memoize the types to prevent n+1 queries
    memoizeTypes();

    $currentObjects = getCurrentObjectsInDB($page, WE_TRANSACTIONS_PER_PAGE);
    mapObjects($currentObjects);

    $count = 1;
    foreach ($currentObjects as $obj) {
        importIntoWordpress($obj);
        $count++;
    }

    update_option(WE_OPT_FIND_IMPORT_PROCESSING, false);
    update_option(WE_OPT_IMPORTED_FINDS, $we_existingFinds);

    displayMessage("DONE");

    if (($page + 1) > $totalPages) {
        update_option(WE_OPT_CURRENT_RECORD_PAGE, 0);
        header("Location: " . $url . "?stop=true");
    } else {
        $page++;
        update_option(WE_OPT_CURRENT_RECORD_PAGE, $page);
        header("Location: " . $url);
    }

    exit;

} else {
    displayMessage("INSUFFICIENT PERMISSIONS TO EXECUTE SCRIPT");
}

function displayMessage($message)
{
    //print($message . "\n");
    error_log(print_r($message, 1));
    //flush();
    //ob_flush();
}

//ob_end_clean();
// -----------------------------------------------------------------------------------------------
exit;
