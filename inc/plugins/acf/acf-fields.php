<?php
  
/**
 * fwbase acf fields
 *
 * @package fwbase
 */


//--------------------------------------------------------------------
// ACF Badges
//--------------------------------------------------------------------
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_555055bf43ec7',
	'title' => 'Badges',
	'fields' => array (
		array (
			'key' => 'field_555056423a6e3',
			'label' => 'Badges',
			'name' => 'badges_repeater',
			'type' => 'repeater',
			'instructions' => 'Hier kannst du Badges hinzuf&uuml;gen.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'min' => '',
			'max' => '',
			'layout' => 'block',
			'button_label' => 'Neue Badges',
			'sub_fields' => array (
				array (
					'key' => 'field_555c5a00ea727',
					'label' => '&Uuml;berschrift',
					'name' => 'badge_headline',
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
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_555c5a18ea728',
					'label' => 'Badges hinzuf&uuml;gen',
					'name' => 'badge_single',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'min' => '',
					'max' => '',
					'layout' => 'table',
					'button_label' => 'Badge hinzuf&uuml;gen',
					'sub_fields' => array (
						array (
							'key' => 'field_5550566b3a6e4',
							'label' => 'Grafik',
							'name' => 'badge_img',
							'type' => 'image',
							'instructions' => 'Lade hier die Grafik hoch. Die Grafik muss eine transparente PNG, GIF oder SVG sein.',
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
							'mime_types' => 'png, svg, tiff, gif',
						),
						array (
							'key' => 'field_555056ce3a6e5',
							'label' => 'Code',
							'name' => 'badge_code',
							'type' => 'textarea',
							'instructions' => 'F&uuml;ge hier den Code-Schnippsel ein, mit dem Benutzer das Badge auf ihrer Seite einbinden sollen.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '<a href="http://www.hochzeitswahn.de/[ggf. Ziel-Seite oder Tracking-Infos]" target="_blank" alt="Inspiriert mit Hochzeitswahn"> <img alt="Ich bin inspiriert durch Hochzeitswahn.de" src="http://www.hochzeitswahn.de/.../link-zur-grafik.png"> </a>',
							'maxlength' => '',
							'rows' => '',
							'new_lines' => '',
							'readonly' => 0,
							'disabled' => 0,
						),
					),
				),
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'page',
				'operator' => '==',
				'value' => '19549',
			),
		),
		array (
			array (
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'template-badges.php',
			),
		),		
	),
	'menu_order' => 100,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
));

endif;


//--------------------------------------------------------------------
// ACF Image caption url
//--------------------------------------------------------------------
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_562e03a9ea3cf',
	'title' => 'Image Felder',
	'fields' => array (
		array (
			'key' => 'field_562e03b6e12cb',
			'label' => 'Fotografen URL',
			'name' => 'opt_img_photograph',
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
			'readonly' => 0,
			'disabled' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'media',
				'operator' => '==',
				'value' => 'images',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;
