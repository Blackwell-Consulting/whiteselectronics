<?php

// --------------------------------
// Required
// --------------------------------

// Forcing IE Compatibility Mode
header('X-UA-Compatible: IE=Edge');

// Clean up WP Header
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

// Add Wordpress Feature Support
add_theme_support('menus');
add_theme_support('post-thumbnails');
add_theme_support('html5');

// Disable WP emoji
function disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}

add_action('init', 'disable_emojis');
function disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

//Add custom ACF option pages
if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
    acf_add_options_sub_page('Adventurers');
    acf_add_options_sub_page('Finds');
    acf_add_options_sub_page('Footer');
    acf_add_options_sub_page('Models');
}


// --------------------------------
// Fixes
// --------------------------------

// Fix translate-z with chrome in the admin
add_action('admin_enqueue_scripts', 'chrome_fix');
function chrome_fix()
{
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false) {
        wp_add_inline_style('wp-admin', '#adminmenu { transform: translateZ(0) }');
    }
}

function add_query_vars_filter( $vars ){
    $vars[] = "ms";
    return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

add_filter('woocommerce_default_address_fields', function ($fields) {
    if (!empty($fields['city']['label'])) {
        $fields['city']['label'] = __('City', 'woocommerce');
    }
    
    return $fields;
}, 10, 1);

//---------------------------------
// Optional
//---------------------------------

// Hide WP Admin Bar
// add_filter( 'show_admin_bar', '__return_false' );


// Add responsive container to embed videos
// function forty_responsive_video( $html ) {
// 	//add http protocol
//     $html = str_replace('<iframe src="//', '<iframe src="http://', $html);
//     return '<div class="flex-video">' . $html . '</div>';
// }
// add_filter( 'embed_oembed_html', 'forty_responsive_video', 10, 3 );
// add_filter( 'video_embed_html', 'forty_responsive_video' );


// Add Wysiwyg styles to the Wordpress editor.
// You need to create your own 'style-wysiwyg.scss' inside of _src/sass
// function wysiwyg_editor_styles() {
// 	add_editor_style( 'style-wysiwyg.css' );
// }
// add_action( 'admin_init', 'wysiwyg_editor_styles' );


// Returns Timthumbified URL
// function forty_timthumbify($src){
// 	global $blog_id;
// 	if(is_multisite()){
// 		$blog_upload_dir = get_site_url(1).'/wp-content/blogs.dir/'.$blog_id;
// 		$src = get_site_url(1).'/functions/timthumb/timthumb.php?src='.$blog_upload_dir.strstr($src, '/files/');
// 	}else
// 		$src = get_stylesheet_directory_uri() . '/functions/timthumb/timthumb.php?src=' . $src;
// 	return $src;
// }

// numbered pagination
function pagination($pages = '', $range = 1)
{
    $showitems = ($range * 2) + 1;
    
    global $paged;
    if (empty($paged)) {
        $paged = 1;
    }
    
    if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (!$pages) {
            $pages = 1;
        }
    }
    
    if (1 != $pages) {
        if ($paged > 1 && $showitems < $pages) {
            echo "<a class=\"page-number\" href='" . get_pagenum_link($paged - 1) . "'>&leftarrow;</a>";
        }
        
        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
                echo ($paged == $i) ? "<span class=\"page-number current\">" . $i . "</span>" : "<a href='" . get_pagenum_link($i) . "' class=\"page-number inactive\">" . $i . "</a>";
            }
        }
        
        if ($paged < $pages && $showitems < $pages) {
            echo "<a class=\"page-number\" href=\"" . get_pagenum_link($paged + 1) . "\">&rightarrow;</a>";
        }
        echo "</div>\n";
    }
}


//--------------------------------------------------------------
// Whites API
//--------------------------------------------------------------
function we_get_api_response($api, $params = null)
{
    $key = 'SAKMgFYBrmwJhOtsdpGP';
    $baseurl = 'https://database.whiteselectronics.com/api/';
    
    $varstring = array();
    
    $varstring[] = 'key=' . $key;
    if ($params != null) {
        foreach ($params as $key => $value) {
            $varstring[] = $key . "=" . urlencode($value);
        }
    }
    $query_string = implode('&', $varstring);
    
    $url = $baseurl . $api . '?' . $query_string;
    $retval = file_get_contents($url);
    return $retval;
}

//--------------------------------------------------------------
// Form utility
//--------------------------------------------------------------
function echoFormFieldError(array& $errors, $field)
{
    if (empty($errors[$field])) {
        echo '';
        return;
    }
    
    
    if (is_array($errors[$field])) {
        foreach ($errors[$field] as $error) {
            echo '<div class="form-error-collection">';
            echo '<p class="field-error">' . __($error) . '</p>';
            echo '</div>';
        }
        
        return;
    }
    
    echo '<p class="field-error">' . __($errors[$field]) . '</p>';
}


function we_echoFormValue($name, $default = '')
{
    echo (!empty($_POST[$name])) ? $_POST[$name] : $default;
}


function we_returnFormValue($name, $default = '')
{
    return (!empty($_POST[$name])) ? $_POST[$name] : $default;
}


function we_printDropdown(array &$values, $name = '', $default = '', array $classes = array())
{
    echo '<select name="' . $name . '" class="' . implode(', ', $classes) . '">';
    foreach ($values as $code => $value) {
        $selected = ($code == $default) ? 'selected="selected"' : '';
        echo '<option value="' . $code . '" ' . $selected . '>' . $value . '</option>';
    }
    echo '</select>';
}


function we_locations()
{
    return array(
        ''          => '',
        'Mid-West'  => 'Mid-West',
        'Northeast' => 'Northeast',
        'Northwest' => 'Northwest',
        'Southeast' => 'Southeast',
        'Southwest' => 'Southwest',
        'unknown'   => 'unknown'
    );
}


function we_states()
{
    return array(
        ''   => '',
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AZ' => 'Arizona',
        'AR' => 'Arkansas',
        'CA' => 'California',
        'CO' => 'Colorado',
        'CT' => 'Connecticut',
        'DE' => 'Delaware',
        'DC' => 'District Of Columbia',
        'FL' => 'Florida',
        'GA' => 'Georgia',
        'HI' => 'Hawaii',
        'ID' => 'Idaho',
        'IL' => 'Illinois',
        'IN' => 'Indiana',
        'IA' => 'Iowa',
        'KS' => 'Kansas',
        'KY' => 'Kentucky',
        'LA' => 'Louisiana',
        'ME' => 'Maine',
        'MD' => 'Maryland',
        'MA' => 'Massachusetts',
        'MI' => 'Michigan',
        'MN' => 'Minnesota',
        'MS' => 'Mississippi',
        'MO' => 'Missouri',
        'MT' => 'Montana',
        'NE' => 'Nebraska',
        'NV' => 'Nevada',
        'NH' => 'New Hampshire',
        'NJ' => 'New Jersey',
        'NM' => 'New Mexico',
        'NY' => 'New York',
        'NC' => 'North Carolina',
        'ND' => 'North Dakota',
        'OH' => 'Ohio',
        'OK' => 'Oklahoma',
        'OR' => 'Oregon',
        'PA' => 'Pennsylvania',
        'RI' => 'Rhode Island',
        'SC' => 'South Carolina',
        'SD' => 'South Dakota',
        'TN' => 'Tennessee',
        'TX' => 'Texas',
        'UT' => 'Utah',
        'VT' => 'Vermont',
        'VA' => 'Virginia',
        'WV' => 'West Virginia',
        'WA' => 'Washington',
        'WI' => 'Wisconsin',
        'WY' => 'Wyoming',
        'AB' => 'Alberta',
        'BC' => 'British Columbia',
        'MB' => 'Manitoba',
        'NB' => 'New Brunswick',
        'NL' => 'Newfoundland',
        'NT' => 'Northwest Terr.',
        'NS' => 'Nova Scotia',
        'ON' => 'Ontario',
        'QC' => 'Quebec',
        'SK' => 'Saskatchewan',
        'AA' => 'Air Atlantic (AA)',
        'AE' => 'Air Europe (AE)',
        'AP' => 'Air Pacific (AP)',
        'AS' => 'American Samoa',
        'CI' => 'Caroline Islands',
        'GU' => 'Guam',
        'MP' => 'Marianas Islands',
        'MH' => 'Marshall Islands',
        'FM' => 'Micronesia',
        'PW' => 'Palau',
        'PR' => 'Puerto Rico',
        'VI' => 'US Virgin Islands',
        'YT' => 'Yukon Territory',
        'NU' => 'Nunavut',
        'PE' => 'Prince Edward Island'
    );
}


function we_countries()
{
    return array(
        'us' => 'United States',
        'NA' => 'N/A',
        'af' => 'Afghanistan',
        'al' => 'Albania',
        'dz' => 'Algeria',
        'as' => 'American Samoa',
        'ad' => 'Andorra',
        'ao' => 'Angola',
        'ai' => 'Anguilla',
        'aq' => 'Antarctica',
        'ag' => 'Antigua and Barbuda',
        'ar' => 'Argentina',
        'am' => 'Armenia',
        'aw' => 'Aruba',
        'au' => 'Australia',
        'at' => 'Austria',
        'az' => 'Azerbaijan',
        'bs' => 'Bahamas',
        'bh' => 'Bahrain',
        'bd' => 'Bangladesh',
        'bb' => 'Barbados',
        'by' => 'Belarus',
        'be' => 'Belgium',
        'bz' => 'Belize',
        'bj' => 'Benin',
        'bm' => 'Bermuda',
        'bt' => 'Bhutan',
        'bo' => 'Bolivia',
        'ba' => 'Bosnia and Herzegowina',
        'bw' => 'Botswana',
        'bv' => 'Bouvet Island',
        'br' => 'Brazil',
        'io' => 'British Indian Ocean Territory',
        'bn' => 'Brunei Darussalam',
        'bg' => 'Bulgaria',
        'bf' => 'Burkina Faso',
        'bi' => 'Burundi',
        'kh' => 'Cambodia',
        'cm' => 'Cameroon',
        'ca' => 'Canada',
        'cv' => 'Cape Verde',
        'ky' => 'Cayman Islands',
        'cf' => 'Central African Republic',
        'td' => 'Chad',
        'cl' => 'Chile',
        'cn' => 'China',
        'cx' => 'Christmas Island',
        'cc' => 'Cocos (Keeling) Islands',
        'co' => 'Colombia',
        'km' => 'Comoros',
        'cg' => 'Congo',
        'ck' => 'Cook Islands',
        'cr' => 'Costa Rica',
        'ci' => 'Cote D\'Ivoire',
        'hr' => 'Croatia',
        'cu' => 'Cuba',
        'cy' => 'Cyprus',
        'cz' => 'Czech Republic',
        'dk' => 'Denmark',
        'dj' => 'Djibouti',
        'dm' => 'Dominica',
        'do' => 'Dominican Republic',
        'tp' => 'East Timor',
        'ec' => 'Ecuador',
        'eg' => 'Egypt',
        'sv' => 'El Salvador',
        'gq' => 'Equatorial Guinea',
        'er' => 'Eritrea',
        'ee' => 'Estonia',
        'et' => 'Ethiopia',
        'fk' => 'Falkland Islands (Malvinas)',
        'fo' => 'Faroe Islands',
        'fj' => 'Fiji',
        'fi' => 'Finland',
        'fr' => 'France',
        'fx' => 'France, Metropolitan',
        'gf' => 'French Guiana',
        'pf' => 'French Polynesia',
        'tf' => 'French Southern Territories',
        'ga' => 'Gabon',
        'gm' => 'Gambia',
        'ge' => 'Georgia',
        'de' => 'Germany',
        'gh' => 'Ghana',
        'gi' => 'Gibraltar',
        'gr' => 'Greece',
        'gl' => 'Greenland',
        'gd' => 'Grenada',
        'gp' => 'Guadeloupe',
        'gu' => 'Guam',
        'gt' => 'Guatemala',
        'gn' => 'Guinea',
        'gw' => 'Guinea-bissau',
        'gy' => 'Guyana',
        'ht' => 'Haiti',
        'hm' => 'Heard and Mc Donald Islands',
        'hn' => 'Honduras',
        'hk' => 'Hong Kong',
        'hu' => 'Hungary',
        'is' => 'Iceland',
        'in' => 'India',
        'id' => 'Indonesia',
        'ir' => 'Iran (Islamic Republic of)',
        'iq' => 'Iraq',
        'ie' => 'Ireland',
        'il' => 'Israel',
        'it' => 'Italy',
        'jm' => 'Jamaica',
        'jp' => 'Japan',
        'jo' => 'Jordan',
        'kz' => 'Kazakhstan',
        'ke' => 'Kenya',
        'ki' => 'Kiribati',
        'kp' => 'Korea, Democratic People\'s Republic of',
        'kr' => 'Korea, Republic of',
        'kw' => 'Kuwait',
        'kg' => 'Kyrgyzstan',
        'la' => 'Lao People\'s Democratic Republic',
        'lv' => 'Latvia',
        'lb' => 'Lebanon',
        'ls' => 'Lesotho',
        'lr' => 'Liberia',
        'ly' => 'Libyan Arab Jamahiriya',
        'li' => 'Liechtenstein',
        'lt' => 'Lithuania',
        'lu' => 'Luxembourg',
        'mo' => 'Macau',
        'mk' => 'Macedonia, The Former Yugoslav Republic of',
        'mg' => 'Madagascar',
        'mw' => 'Malawi',
        'my' => 'Malaysia',
        'mv' => 'Maldives',
        'ml' => 'Mali',
        'mt' => 'Malta',
        'mh' => 'Marshall Islands',
        'mq' => 'Martinique',
        'mr' => 'Mauritania',
        'mu' => 'Mauritius',
        'yt' => 'Mayotte',
        'mx' => 'Mexico',
        'fm' => 'Micronesia, Federated States of',
        'md' => 'Moldova, Republic of',
        'mc' => 'Monaco',
        'mn' => 'Mongolia',
        'ms' => 'Montserrat',
        'ma' => 'Morocco',
        'mz' => 'Mozambique',
        'mm' => 'Myanmar',
        'na' => 'Namibia',
        'nr' => 'Nauru',
        'np' => 'Nepal',
        'nl' => 'Netherlands',
        'an' => 'Netherlands Antilles',
        'nc' => 'New Caledonia',
        'nz' => 'New Zealand',
        'ni' => 'Nicaragua',
        'ne' => 'Niger',
        'ng' => 'Nigeria',
        'nu' => 'Niue',
        'nf' => 'Norfolk Island',
        'mp' => 'Northern Mariana Islands',
        'no' => 'Norway',
        'om' => 'Oman',
        'pk' => 'Pakistan',
        'pw' => 'Palau',
        'pa' => 'Panama',
        'pg' => 'Papua New Guinea',
        'py' => 'Paraguay',
        'pe' => 'Peru',
        'ph' => 'Philippines',
        'pn' => 'Pitcairn',
        'pl' => 'Poland',
        'pt' => 'Portugal',
        'pr' => 'Puerto Rico',
        'qa' => 'Qatar',
        're' => 'Reunion',
        'ro' => 'Romania',
        'ru' => 'Russian Federation',
        'rw' => 'Rwanda',
        'kn' => 'Saint Kitts and Nevis',
        'lc' => 'Saint Lucia',
        'vc' => 'Saint Vincent and the Grenadines',
        'ws' => 'Samoa',
        'sm' => 'San Marino',
        'st' => 'Sao Tome and Principe',
        'sa' => 'Saudi Arabia',
        'sn' => 'Senegal',
        'sc' => 'Seychelles',
        'sl' => 'Sierra Leone',
        'sg' => 'Singapore',
        'sk' => 'Slovakia (Slovak Republic)',
        'si' => 'Slovenia',
        'sb' => 'Solomon Islands',
        'so' => 'Somalia',
        'za' => 'South Africa',
        'gs' => 'South Georgia and the South Sandwich Islands',
        'es' => 'Spain',
        'lk' => 'Sri Lanka',
        'sh' => 'St. Helena',
        'pm' => 'St. Pierre and Miquelon',
        'sd' => 'Sudan',
        'sr' => 'Suriname',
        'sj' => 'Svalbard and Jan Mayen Islands',
        'sz' => 'Swaziland',
        'se' => 'Sweden',
        'ch' => 'Switzerland',
        'sy' => 'Syrian Arab Republic',
        'tw' => 'Taiwan',
        'tj' => 'Tajikistan',
        'tz' => 'Tanzania, United Republic of',
        'th' => 'Thailand',
        'tg' => 'Togo',
        'tk' => 'Tokelau',
        'to' => 'Tonga',
        'tt' => 'Trinidad and Tobago',
        'tn' => 'Tunisia',
        'tr' => 'Turkey',
        'tm' => 'Turkmenistan',
        'tc' => 'Turks and Caicos Islands',
        'tv' => 'Tuvalu',
        'ug' => 'Uganda',
        'ua' => 'Ukraine',
        'ae' => 'United Arab Emirates',
        'gb' => 'United Kingdom',
        'um' => 'United States Minor Outlying Islands',
        'uy' => 'Uruguay',
        'uz' => 'Uzbekistan',
        'vu' => 'Vanuatu',
        'va' => 'Vatican City State (Holy See)',
        've' => 'Venezuela',
        'vn' => 'Viet Nam',
        'vg' => 'Virgin Islands (British)',
        'vi' => 'Virgin Islands (U.S.)',
        'wf' => 'Wallis and Futuna Islands',
        'eh' => 'Western Sahara',
        'ye' => 'Yemen',
        'yu' => 'Yugoslavia',
        'zr' => 'Zaire',
        'zm' => 'Zambia',
        'zw' => 'Zimbabwe',
    );
}


function we_regions()
{
    return array(
        ''   => '',
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AZ' => 'Arizona',
        'AR' => 'Arkansas',
        'CA' => 'California',
        'CO' => 'Colorado',
        'CT' => 'Connecticut',
        'DE' => 'Delaware',
        'DC' => 'District Of Columbia',
        'FL' => 'Florida',
        'GA' => 'Georgia',
        'HI' => 'Hawaii',
        'ID' => 'Idaho',
        'IL' => 'Illinois',
        'IN' => 'Indiana',
        'IA' => 'Iowa',
        'KS' => 'Kansas',
        'KY' => 'Kentucky',
        'LA' => 'Louisiana',
        'ME' => 'Maine',
        'MD' => 'Maryland',
        'MA' => 'Massachusetts',
        'MI' => 'Michigan',
        'MN' => 'Minnesota',
        'MS' => 'Mississippi',
        'MO' => 'Missouri',
        'MT' => 'Montana',
        'NE' => 'Nebraska',
        'NV' => 'Nevada',
        'NH' => 'New Hampshire',
        'NJ' => 'New Jersey',
        'NM' => 'New Mexico',
        'NY' => 'New York',
        'NC' => 'North Carolina',
        'ND' => 'North Dakota',
        'OH' => 'Ohio',
        'OK' => 'Oklahoma',
        'OR' => 'Oregon',
        'PA' => 'Pennsylvania',
        'RI' => 'Rhode Island',
        'SC' => 'South Carolina',
        'SD' => 'South Dakota',
        'TN' => 'Tennessee',
        'TX' => 'Texas',
        'UT' => 'Utah',
        'VT' => 'Vermont',
        'VA' => 'Virginia',
        'WV' => 'West Virginia',
        'WA' => 'Washington',
        'WI' => 'Wisconsin',
        'WY' => 'Wyoming',
        'AB' => 'Alberta',
        'BC' => 'British Columbia',
        'MB' => 'Manitoba',
        'NB' => 'New Brunswick',
        'NL' => 'Newfoundland',
        'NT' => 'Northwest Terr.',
        'NS' => 'Nova Scotia',
        'ON' => 'Ontario',
        'QC' => 'Quebec',
        'SK' => 'Saskatchewan',
        'AA' => 'Air Atlantic (AA)',
        'AE' => 'Air Europe (AE)',
        'AP' => 'Air Pacific (AP)',
        'AS' => 'American Samoa',
        'CI' => 'Caroline Islands',
        'GU' => 'Guam',
        'MP' => 'Marianas Islands',
        'MH' => 'Marshall Islands',
        'FM' => 'Micronesia',
        'PW' => 'Palau',
        'PR' => 'Puerto Rico',
        'VI' => 'US Virgin Islands',
        'YT' => 'Yukon Territory',
        'NU' => 'Nunavut',
        'PE' => 'Prince Edward Island'
    );
}


// get taxonomies terms links
function custom_taxonomies_terms_links()
{
    global $post, $post_id;
    // get post by post id
    $post = get_post($post->ID);
    // get post type by post
    $post_type = $post->post_type;
    // get post type taxonomies
    $taxonomies = get_object_taxonomies($post_type);
    $term = '';
    foreach ($taxonomies as $taxonomy) {
        // get the terms related to post
        $terms = get_the_terms($post->ID, $taxonomy);
        if (!empty($terms)) {
            foreach ($terms as $term) {
                $term = '<span>' . $term->name . '</span>';
            }
        }
    }
    return $term;
}


/**
 * Gravity Wiz // Gravity Forms Post Content Merge Tags
 *
 * Adds support for using Gravity Form merge tags in your post content. This functionality requires that the entry ID is
 * is passed to the post via the "eid" parameter.
 *
 * Setup your confirmation page (requires GFv1.8) or confirmation URL "Redirect Query String" setting to
 * include this parameter: 'eid={entry_id}'. You can then use any entry-based merge tag in your post content.
 *
 * @version   1.2
 * @author    David Smith <david@gravitywiz.com>
 * @license   GPL-2.0+
 * @link      http://gravitywiz.com/...
 * @video     http://screencast.com/t/g6Y12zOf4
 * @copyright 2014 Gravity Wiz
 */
class GW_Post_Content_Merge_Tags
{
    
    public static $_entry = null;
    
    private static $instance = null;
    
    public static function get_instance($args = array())
    {
        
        if (self::$instance == null) {
            self::$instance = new self($args);
        }
        
        return self::$instance;
    }
    
    function __construct($args)
    {
        
        if (!class_exists('GFForms')) {
            return;
        }
        
        $this->_args = wp_parse_args($args, array(
            'auto_append_eid' => true, // true, false or array of form IDs
            'encrypt_eid'     => false,
        ));
        
        add_filter('the_content', array($this, 'replace_merge_tags'), 1);
        add_filter('gform_replace_merge_tags', array($this, 'replace_encrypt_entry_id_merge_tag'), 10, 3);
        
        if (!empty($this->_args['auto_append_eid'])) {
            add_filter('gform_confirmation', array($this, 'append_eid_parameter'), 20, 3);
        }
        
    }
    
    function replace_merge_tags($post_content)
    {
        
        $entry = $this->get_entry();
        if (!$entry) {
            return $post_content;
        }
        
        $form = GFFormsModel::get_form_meta($entry['form_id']);
        
        $post_content = $this->replace_field_label_merge_tags($post_content, $form);
        $post_content = GFCommon::replace_variables($post_content, $form, $entry, false, false, false);
        
        return $post_content;
    }
    
    function replace_field_label_merge_tags($text, $form)
    {
        
        preg_match_all('/{([^:]+?)}/', $text, $matches, PREG_SET_ORDER);
        if (empty($matches)) {
            return $text;
        }
        
        foreach ($matches as $match) {
            
            list($search, $field_label) = $match;
            
            foreach ($form['fields'] as $field) {
                
                $full_input_id = false;
                $matches_admin_label = rgar($field, 'adminLabel') == $field_label;
                $matches_field_label = false;
                
                if (is_array($field['inputs'])) {
                    foreach ($field['inputs'] as $input) {
                        if (GFFormsModel::get_label($field, $input['id']) == $field_label) {
                            $matches_field_label = true;
                            $input_id = $input['id'];
                            break;
                        }
                    }
                } else {
                    $matches_field_label = GFFormsModel::get_label($field) == $field_label;
                    $input_id = $field['id'];
                }
                
                if (!$matches_admin_label && !$matches_field_label) {
                    continue;
                }
                
                $replace = sprintf('{%s:%s}', $field_label, (string)$input_id);
                $text = str_replace($search, $replace, $text);
                
                break;
            }
            
        }
        
        return $text;
    }
    
    function replace_encrypt_entry_id_merge_tag($text, $form, $entry)
    {
        
        if (strpos($text, '{encrypted_entry_id}') === false) {
            return $text;
        }
        
        // $entry is not always a "full" entry
        $entry_id = rgar($entry, 'id');
        if ($entry_id) {
            $entry_id = $this->prepare_eid($entry['id'], true);
        }
        
        return str_replace('{encrypted_entry_id}', $entry_id, $text);
    }
    
    function append_eid_parameter($confirmation, $form, $entry)
    {
        
        $is_ajax_redirect = is_string($confirmation) && strpos($confirmation, 'gformRedirect');
        $is_redirect = is_array($confirmation) && isset($confirmation['redirect']);
        
        if (!$this->is_auto_eid_enabled($form) || !($is_ajax_redirect || $is_redirect)) {
            return $confirmation;
        }
        
        $eid = $this->prepare_eid($entry['id']);
        
        if ($is_ajax_redirect) {
            preg_match_all('/gformRedirect.+?(http.+?)(?=\'|")/', $confirmation, $matches, PREG_SET_ORDER);
            list($full_match, $url) = $matches[0];
            $redirect_url = add_query_arg(array('eid' => $eid), $url);
            $confirmation = str_replace($url, $redirect_url, $confirmation);
        } else {
            $redirect_url = add_query_arg(array('eid' => $eid), $confirmation['redirect']);
            $confirmation['redirect'] = $redirect_url;
        }
        
        return $confirmation;
    }
    
    function prepare_eid($entry_id, $force_encrypt = false)
    {
        
        $eid = $entry_id;
        $do_encrypt = $force_encrypt || $this->_args['encrypt_eid'];
        
        if ($do_encrypt && is_callable(array('GFCommon', 'encrypt'))) {
            $eid = rawurlencode(GFCommon::encrypt($eid));
        }
        
        return $eid;
    }
    
    function get_entry()
    {
        
        if (!self::$_entry) {
            
            $entry_id = $this->get_entry_id();
            if (!$entry_id) {
                return false;
            }
            
            $entry = GFFormsModel::get_lead($entry_id);
            if (empty($entry)) {
                return false;
            }
            
            self::$_entry = $entry;
            
        }
        
        return self::$_entry;
    }
    
    function get_entry_id()
    {
        
        $entry_id = rgget('eid');
        if ($entry_id) {
            return $this->maybe_decrypt_entry_id($entry_id);
        }
        
        $post = get_post();
        if ($post) {
            $entry_id = get_post_meta($post->ID, '_gform-entry-id', true);
        }
        
        return $entry_id ? $entry_id : false;
    }
    
    function maybe_decrypt_entry_id($entry_id)
    {
        
        // if encryption is enabled, 'eid' parameter MUST be encrypted
        $do_encrypt = $this->_args['encrypt_eid'];
        
        if (!$entry_id) {
            return null;
        } else {
            if (!$do_encrypt && is_numeric($entry_id) && intval($entry_id) > 0) {
                return $entry_id;
            } else {
                // gEYs6Cqzh1akKc7Y4RGkV8HtcJqQZRmNH+ONxuFEvXM
                // 0FSCGpzzmt+4Y05fFsJ4ipRZfqD/zdi2ecEeMMRKCjc=
                $entry_id = is_callable(array('GFCommon', 'decrypt')) ? GFCommon::decrypt($entry_id) : $entry_id;
                return intval($entry_id);
            }
        }
        
    }
    
    function is_auto_eid_enabled($form)
    {
        
        $auto_append_eid = $this->_args['auto_append_eid'];
        
        if (is_bool($auto_append_eid) && $auto_append_eid === true) {
            return true;
        }
        
        if (is_array($auto_append_eid) && in_array($form['id'], $auto_append_eid)) {
            return true;
        }
        
        return false;
    }
    
}

function gw_post_content_merge_tags($args = array())
{
    return GW_Post_Content_Merge_Tags::get_instance($args);
}

gw_post_content_merge_tags();


function additional_active_item_classes($classes = array(), $menu_item = false)
{
    global $wp_query;
    
    if (is_search()) {
    
        if (($index = array_search('current-menu-item', $menu_item->classes)) > 0) {
            unset($menu_item->classes[$index]);
        }
        
        if (($index = array_search('current-menu-item', $classes)) > 0) {
            unset($classes[$index]);
        }
        
        return $classes;
    }
    
    if (in_array('current-menu-item', $menu_item->classes)) {
        $classes[] = 'current-menu-item';
    }
    
    if ($menu_item->post_name == 'product' && is_post_type_archive('product')) {
        $classes[] = 'current-menu-item';
    }
    
    if ($menu_item->post_name == 'product' && is_singular('product')) {
        $classes[] = 'current-menu-item';
    }
    
    return $classes;
}

add_filter('nav_menu_css_class', 'additional_active_item_classes', 10, 2);

// show products first in search results
add_filter('relevanssi_hits_filter', 'products_first');
function products_first($hits)
{
    $types = array();
    
    $types['page'] = array();
    $types['post'] = array();
    $types['product'] = array();
    $types['adventurers'] = array();
    $types['videos'] = array();
    $types['find'] = array();
    $types['manuals'] = array();
    
    // Split the post types in array $types
    if (!empty($hits)) {
        foreach ($hits[0] as $hit) {
            array_push($types[$hit->post_type], $hit);
        }
    }
    
    // Merge back to $hits in the desired order
    $hits[0] = array_merge($types['product'], $types['adventurers'], $types['find'], $types['videos'], $types['post'],
        $types['page'], $types['manuals']);
    return $hits;
}

add_filter('post_limits', 'postsperpage');
function postsperpage($limits)
{
    if (is_search()) {
        global $wp_query;
        $wp_query->query_vars['posts_per_page'] = 10;
    }
    return $limits;
}

// gravity forms scroll-to-top after form submission
add_filter('gform_confirmation_anchor', function () {
    return 20;
});

function remove_thickbox() {
    wp_deregister_script( 'thickbox' );
    wp_enqueue_script( 'jquery' );
}    

add_action( 'wp_enqueue_scripts', 'remove_thickbox' );

function custom_language_selector2() {
    $languages = icl_get_languages('skip_missing=0&orderby=code');
    if(!empty($languages)){
        echo '<div  class="wpml-ls-statics-shortcode_actions wpml-ls wpml-ls-legacy-dropdown js-wpml-ls-legacy-dropdown" id="lang_sel"><ul>';
        foreach($languages as $l){
            echo '<li class="wpml-ls-slot-shortcode_actions wpml-ls-item wpml-ls-item-gb wpml-ls-current-language wpml-ls-last-item wpml-ls-item-legacy-dropdown">';
            if($l['country_flag_url']){
                if(!$l['active']) echo '<a href="'.$l['url'].'" class="js-wpml-ls-item-toggle wpml-ls-item-toggle lang_sel_sel icl-gb">';
                echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
                if(!$l['active']) echo '</a>';
            }
            if(!$l['active']) echo '<a href="'.$l['url'].'">';
            echo icl_disp_language($l['native_name'], $l['translated_name']);
            if(!$l['active']) echo '</a>';
            echo '</li>';
        }
        echo '</ul></div>';
    }
}

function custom_language_selector() {
    $languages = icl_get_languages( 'skip_missing=0&orderby=code' );

    if ( ! empty( $languages ) ) {

        echo '
        <div class="wpml-ls-statics-shortcode_actions wpml-ls wpml-ls-legacy-dropdown js-wpml-ls-legacy-dropdown" id="lang_sel">
            <ul>
            <li tabindex="0" class="wpml-ls-slot-shortcode_actions wpml-ls-item wpml-ls-item-gb wpml-ls-current-language wpml-ls-last-item wpml-ls-item-legacy-dropdown">
                <a href="javascript:void(0)" class="js-wpml-ls-item-toggle wpml-ls-item-toggle lang_sel_sel icl-gb">
                    <span class="wpml-ls-native icl_lang_sel_native">Change Locale</span>
                </a>
                <ul class="wpml-ls-sub-menu">
                    <li class="icl-en wpml-ls-slot-shortcode_actions wpml-ls-item wpml-ls-item-en wpml-ls-first-item">
                        <a class="language-picker" href="?lang=gb">
                            <span class="wpml-ls-native icl_lang_sel_native">English (UK)</span>
                        </a>
                    </li>
                    <li class="icl-en wpml-ls-slot-shortcode_actions wpml-ls-item wpml-ls-item-en wpml-ls-first-item">
                        <a class="language-picker" href="?lang=us">
                            <span class="wpml-ls-native icl_lang_sel_native">English (US)</span>
                        </a>
                    </li>
                </ul>
            </li>
            </ul>
        </div>
        ';
    }
}