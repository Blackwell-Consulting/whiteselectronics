<?php

	// http://codex.wordpress.org/Function_Reference/register_post_type

function register_custom_post_types() {

	// --------------------------------
	// CPT Adventurer
	// --------------------------------

	$labels = array(
		'name' => _x('Adventurer', 'post type general name'),
		'singular_name' => _x('Adventurer', 'post type singular name'),
		'add_new' => _x('Add New', 'adventurer'),
		'add_new_item' => __('Add New Adventurer'),
		'edit_item' => __('Edit Adventurer'),
		'new_item' => __('New Adventurer'),
		'view_item' => __('View Adventurer'),
		'search_items' => __('Search Adventurers'),
		'not_found' =>  __('No Adventurers found'),
		'not_found_in_trash' => __('No Adventurers found in Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Adventurers'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => false,
		'query_var' => true,
		'rewrite' => array('slug' => 'adventurer'),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 29,
		'menu_icon' => 'dashicons-groups',
		'supports' => array('title', 'page-attributes', 'editor', 'thumbnail', 'excerpt')
	);
	register_post_type('adventurers', $args);

	// --------------------------------
	// CPT How-To Videos
	// --------------------------------

	$labels = array(
		'name' => _x('Video', 'post type general name'),
		'singular_name' => _x('Video', 'post type singular name'),
		'add_new' => _x('Add New', 'video'),
		'add_new_item' => __('Add New Video'),
		'edit_item' => __('Edit Video'),
		'new_item' => __('New Video'),
		'view_item' => __('View Video'),
		'search_items' => __('Search Videos'),
		'not_found' =>  __('No Videos found'),
		'not_found_in_trash' => __('No Videos found in Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Videos'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => false,
		'query_var' => true,
		'rewrite' => array('slug' => 'how-to'),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 29,
		'menu_icon' => 'dashicons-video-alt2',
		'supports' => array('title')
	);
	register_post_type('videos', $args);


	// --------------------------------
	// CPT Finds
	// --------------------------------

	$labels = array(
		'name' => _x('Finds', 'post type general name'),
		'singular_name' => _x('Find', 'post type singular name'),
		'add_new' => _x('Add New', 'find'),
		'add_new_item' => __('Add New Find'),
		'edit_item' => __('Edit Find'),
		'new_item' => __('New Find'),
		'view_item' => __('View Find'),
		'search_items' => __('Search Finds'),
		'not_found' =>  __('No Finds found'),
		'not_found_in_trash' => __('No Finds found in Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Finds'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => false,
		'query_var' => true,
		'rewrite' => array('slug' => 'find'),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 29,
		'menu_icon' => 'dashicons-search',
		'supports' => array('title', 'editor')
	);
	register_post_type('find', $args);

	// --------------------------------
	// CPT Manuals
	// --------------------------------

	$labels = array(
		'name' => _x('Manuals', 'post type general name'),
		'singular_name' => _x('Manual', 'post type singular name'),
		'add_new' => _x('Add New', 'manual'),
		'add_new_item' => __('Add New Manual'),
		'edit_item' => __('Edit Manual'),
		'new_item' => __('New Manual'),
		'view_item' => __('View Manual'),
		'search_items' => __('Search Manuals'),
		'not_found' =>  __('No Manuals found'),
		'not_found_in_trash' => __('No Manuals found in Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Manuals'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => false,
		'query_var' => true,
		'rewrite' => array('slug' => 'manual'),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 29,
		'menu_icon' => 'dashicons-media-text',
		'supports' => array('title')
	);
	register_post_type('manuals', $args);


}
add_action( 'init', 'register_custom_post_types' );
