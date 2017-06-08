<?php
	// http://codex.wordpress.org/Function_Reference/register_taxonomy

function register_custom_taxonomies() {

	/*
	 * Duplicate this for each taxonomy.

	// --------------------------------
	// Taxonomy Name
	// --------------------------------

	register_taxonomy(
		'market', // taxonomy ID. Make this unique from CPTs and Pages to avoid URL rewrite headaches.
		array(
			'portfolio' // applicable post type
		),
		array(
			'hierarchical' => true,
			'show_ui' => true,
			'public' => true,
			'label' => __('Market'),
			'show_in_nav_menus' => false,
			'labels' => array(
				'add_new_item' => 'Add New Market'
			),
			'query_var' => true,
		)
	);

	*/

    register_taxonomy(
        'detector-selector-questions', // taxonomy ID. Make this unique from CPTs and Pages to avoid URL rewrite headaches.
        array(
            'product'
        ),
        array(
            'hierarchical' => true,
            'show_ui' => true,
            'public' => true,
            'label' => __('Detector Selector'),
            'show_in_nav_menus' => false,
            'labels' => array(
                'add_new_item' => 'Add New Question or Answer'
            ),
            'query_var' => true,
        )
    );

    register_taxonomy(
      'find-type',
      array(
        'find'
      ),
      array(
        'hierarchical' => true,
        'show_ui' => true,
        'public' => true,
        'label' => __('Find Type'),
        'show_in_nav_menus' => false,
        'labels' => array(
          'add_new_item' => 'Add New Find Type'
        ),
        'query_var' => true,
      )
    );

    register_taxonomy(
      'video-type',
      array(
        'videos'
      ),
      array(
        'hierarchical' => true,
        'show_ui' => true,
        'public' => true,
        'label' => __('Video Type'),
        'show_in_nav_menus' => false,
        'labels' => array(
          'add_new_item' => 'Add New Video Type'
        ),
        'query_var' => true,
      )
    );

    register_taxonomy(
      'models',
      array(
        'manuals'
      ),
      array(
        'hierarchical' => true,
        'show_ui' => true,
        'public' => true,
        'label' => __('Model'),
        'show_in_nav_menus' => false,
        'labels' => array(
          'add_new_item' => 'Add New Model'
        ),
        'query_var' => true,
      )
    );
}
add_action( 'init', 'register_custom_taxonomies' );
