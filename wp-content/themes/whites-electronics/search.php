<?php
/* Template Name: Search Results */
$search_refer = $_GET["site_section"];
if ($search_refer == 'manuals') { load_template(TEMPLATEPATH . '/manuals-search.php'); }
elseif ($search_refer == 'site-search') { load_template(TEMPLATEPATH . '/global-search.php'); }; ?>