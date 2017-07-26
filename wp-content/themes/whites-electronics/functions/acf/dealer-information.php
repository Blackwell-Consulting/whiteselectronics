<?php

if( function_exists('acf_add_local_field_group') ):

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_5967f116799fe',
	'title' => 'Dealer Information',
	'fields' => array (
		array (
			'key' => 'field_5967f1336e0b1',
			'label' => 'Listing Logo',
			'name' => 'listing_logo',
			'type' => 'image',
			'instructions' => 'Logo that appears on category pages.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array (
			'key' => 'field_596e76e76f5c8',
			'label' => 'Logo',
			'name' => 'logo',
			'type' => 'image',
			'instructions' => 'Logo that appears on dealer detail page.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array (
			'key' => 'field_5978a156e88cd',
			'label' => 'Phone',
			'name' => 'phone',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array (
			'key' => 'field_596e771847cb4',
			'label' => 'Location',
			'name' => 'location',
			'type' => 'google_map',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'height' => '',
			'center_lat' => '',
			'center_lng' => '',
			'zoom' => '',
		),
		array (
			'key' => 'field_596e869e49874',
			'label' => 'About Us',
			'name' => 'about_us',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
			'default_value' => '',
			'delay' => 0,
		),
		array (
			'key' => 'field_5970b3e547ebc',
			'label' => 'Banner',
			'name' => 'banner',
			'type' => 'flexible_content',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'min' => '',
			'max' => 1,
			'button_label' => 'Add Row',
			'layouts' => array (
				array (
					'key' => '5970b3fb1a573',
					'name' => 'banner',
					'label' => 'Banner',
					'display' => 'row',
					'sub_fields' => array (
						array (
							'key' => 'field_5970b3ff47ebd',
							'label' => 'Banner',
							'name' => 'banner',
							'type' => 'image',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
							'preview_size' => 'thumbnail',
							'library' => 'all',
							'min_width' => '',
							'min_height' => '',
							'min_size' => '',
							'max_width' => '',
							'max_height' => '',
							'max_size' => '',
							'mime_types' => '',
						),
						array (
							'key' => 'field_5970b40b47ebe',
							'label' => 'URL',
							'name' => 'url',
							'type' => 'text',
							'instructions' => 'URLs open in a new window',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'maxlength' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
						),
					),
					'min' => '',
					'max' => '1',
				),
			),
		),
		array (
			'key' => 'field_5970b42847ebf',
			'label' => 'Social',
			'name' => 'social',
			'type' => 'flexible_content',
			'instructions' => 'Add your social networks below',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'min' => '',
			'max' => '',
			'button_label' => 'Add Row',
			'layouts' => array (
				array (
					'key' => '5970b432e8b4d',
					'name' => 'add',
					'label' => 'Add your social networks',
					'display' => 'block',
					'sub_fields' => array (
						array (
							'key' => 'field_5970b45947ec0',
							'label' => 'Icon',
							'name' => 'icon',
							'type' => 'select',
							'instructions' => '',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'multiple' => 0,
							'allow_null' => 0,
							'choices' => array (
								'none' => 'none',
								'facebook' => 'facebook',
								'twitter' => 'twitter',
								'youtube' => 'youtube',
								'instagram' => 'instagram',
								'linkedin' => 'linkedin',
							),
							'default_value' => array (
								0 => 'none',
							),
							'ui' => 0,
							'ajax' => 0,
							'placeholder' => '',
							'return_format' => 'value',
						),
						array (
							'key' => 'field_5970b75247ec1',
							'label' => 'URL',
							'name' => 'url',
							'type' => 'text',
							'instructions' => 'URLs open in a new window',
							'required' => 1,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'maxlength' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
						),
					),
					'min' => '',
					'max' => '',
				),
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'dealer',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array (
		0 => 'the_content',
		1 => 'excerpt',
		2 => 'custom_fields',
		3 => 'discussion',
		4 => 'revisions',
		5 => 'slug',
		6 => 'author',
		7 => 'format',
		8 => 'tags',
		9 => 'send-trackbacks',
	),
	'active' => 1,
	'description' => '',
));

endif;
