<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('mailtrap') && defined('WP_ENV') && WP_ENV == 'development') {
    
    function mailtrap($phpmailer) {
        $phpmailer->isSMTP();
        $phpmailer->Host = 'mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = '3ddaebd5835839';
        $phpmailer->Password = 'ee0d4e3cb3bb5a';
    }
    
    add_action('phpmailer_init', 'mailtrap');
}
