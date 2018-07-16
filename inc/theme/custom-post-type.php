<?php

// -----------------------------------------------------
//
// Custom Post Types
//
// -----------------------------------------------------

// Wahnbuechlein Posttype
// -----------------------------------------------------
class hw_wahnbuechlein {
	function hw_wahnbuechlein() {
		add_action('init',array($this,'create_post_type'));
	}

	function create_post_type() {
		$labels = array(
		    'name' => 'Wahnb&uuml;chlein',
		    'singular_name' => 'Wahnbuch',
		    'add_new' => 'Neuer Eintrag',
		    'all_items' => 'Alle Eintr&auml;ge',
		    'add_new_item' => 'Neuen Eintrag hinzuf&uuml;gen',
		    'edit_item' => 'Eintrag editieren',
		    'new_item' => 'Neuer Eintrag',
		    'view_item' => 'Eintrag ansehen',
		    'search_items' => 'Eintrag suchen',
		    'not_found' =>  'Nichts gefunden',
		    'not_found_in_trash' => 'Keine Eintr&auml;ge im Papierkorb',
		    'parent_item_colon' => 'Eltern-Eintrag:',
		    'menu_name' => 'Wahnb&uuml;chlein'
		);
		$args = array(
			'labels' => $labels,
			'description' => "Hier findest du alle Wahnb&uuml;chlein Dienstleister",
			'public' => true,
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'show_in_menu' => true,
			'show_in_admin_bar' => true,
			'menu_position' => 10,
			'menu_icon' => 'dashicons-businessman',
			'capability_type' => 'post',
			'hierarchical' => true,
			'supports' => array('title','editor','author','thumbnail','excerpt','custom-fields','comments','revisions','page-attributes'),
			'has_archive' => true,
			'rewrite' => array('slug' => 'wahnbuechlein'),
			'query_var' => true,
			'can_export' => true
		);
		register_post_type('hw_wahnbuechlein',$args);
	}
}
$hw_wahnbuechlein = new hw_wahnbuechlein();

// Lookbook Posttype
// -----------------------------------------------------
class hw_lookbook {
	function hw_lookbook() {
		add_action('init',array($this,'create_post_type'));
	}

	function create_post_type() {
		$labels = array(
		    'name' => 'Lookbook',
		    'singular_name' => 'Lookbook',
		    'add_new' => 'Neuer Eintrag',
		    'all_items' => 'Alle Eintr&auml;ge',
		    'add_new_item' => 'Neuen Eintrag hinzuf&uuml;gen',
		    'edit_item' => 'Eintrag editieren',
		    'new_item' => 'Neuer Eintrag',
		    'view_item' => 'Eintrag ansehen',
		    'search_items' => 'Eintrag suchen',
		    'not_found' =>  'Nichts gefunden',
		    'not_found_in_trash' => 'Keine Eintr&auml;ge im Papierkorb',
		    'parent_item_colon' => 'Eltern-Eintrag:',
		    'menu_name' => 'Lookbook'
		);
		$args = array(
			'labels' => $labels,
			'description' => "Hier findest du alle Lookbook Eintr&auml;ge",
			'public' => true,
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'show_in_menu' => true,
			'show_in_admin_bar' => true,
			'menu_position' => 10,
			'menu_icon' => 'dashicons-visibility',
			'capability_type' => 'post',
			'hierarchical' => true,
			'supports' => array('title','editor','author','thumbnail','excerpt','custom-fields','comments','revisions','page-attributes'),
			'has_archive' => true,
			'rewrite' => array('slug' => 'lookbook'),
			'query_var' => true,
			'can_export' => true
		);
		register_post_type('hw_lookbook',$args);
	}
}
$hw_lookbook = new hw_lookbook();





class hw_HochzeitPost {
	function hw_HochzeitPost() {
		add_action('init',array($this,'create_post_type'));
	}

	function create_post_type() {
		$labels = array(
		    'name' => 'Hochzeit Post',
		    'singular_name' => 'HochzeitPost',
		    'add_new' => 'Hochzeit Post',
		    'all_items' => 'Alle Eintr&auml;ge',
		    'add_new_item' => 'Neuen Eintrag hinzuf&uuml;gen',
		    'edit_item' => 'Eintrag editieren',
		    'new_item' => 'Neuer Eintrag',
		    'view_item' => 'Eintrag ansehen',
		    'search_items' => 'Eintrag suchen',
		    'not_found' =>  'Nichts gefunden',
		    'not_found_in_trash' => 'Keine Eintr&auml;ge im Papierkorb',
		    'parent_item_colon' => 'Eltern-Eintrag:',
		    'menu_name' => 'HochzeitPost'
		);
		$args = array(
			'labels' => $labels,
			'description' => "Hier findest du alle Lookbook Eintr&auml;ge",
			'public' => true,
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'show_in_menu' => true,
			'show_in_admin_bar' => true,
			'menu_position' => 10,
			'menu_icon' => 'dashicons-visibility',
			'capability_type' => 'post',
			'hierarchical' => true,
			'supports' => array('title','editor','author','thumbnail','excerpt','custom-fields','comments','revisions','page-attributes'),
			'has_archive' => true,
			//'rewrite' => array('slug' => 'lookbook'),
			'query_var' => true,
			'can_export' => true
		);
		register_post_type('hw_HochzeitPost',$args);
	}
}
$hw_HochzeitPost = new hw_HochzeitPost();








// -----------------------------------------------------
//
// Taxonomies
//
// -----------------------------------------------------

// Wahnbuch: Kategorie
register_taxonomy( 'wahn_categorie', array('hw_wahnbuechlein'), array(
  'hierarchical' => true,
  'labels' => array(
   	'name' => __( 'Wahnbuch Kategorien', 'fwbase' ),
    'singular_name' => __( 'Wahnbuch Kategorie', 'fwbase' ),
    'search_items' =>  __( 'Durchsuchen', 'fwbase' ),
    'all_items' => __( 'Alle Kategorien', 'fwbase' ),
    'parent_item' => __( '&Uuml;bergeordnete Kategorie', 'fwbase' ),
    'parent_item_colon' => __( '&Uuml;bergeordnete Kategorie:', 'fwbase' ),
    'edit_item' => __( 'Editieren', 'fwbase' ),
    'update_item' => __( 'Aktualisieren', 'fwbase' ),
    'add_new_item' => __( 'Hinzuf&uuml;gen', 'fwbase' ),
    'new_item_name' => __( 'Neuer Name', 'fwbase' )
  ),
    'show_admin_column' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'wahnbuechlein/kategorie' ),
	)
);

// Wahnbuch: Region
register_taxonomy( 'wahn_region', array('hw_wahnbuechlein'),	array(
  'hierarchical' => true,
	'labels' => array(
   	'name' => __( 'Regionen', 'fwbase' ),
    'singular_name' => __( 'Region', 'fwbase' ),
    'search_items' =>  __( 'Durchsuchen', 'fwbase' ),
    'all_items' => __( 'Alle Regionen', 'fwbase' ),
    'parent_item' => __( '&Uuml;bergeordnete Regionen', 'fwbase' ),
    'parent_item_colon' => __( '&Uuml;bergeordnete Regionen:', 'fwbase' ),
    'edit_item' => __( 'Editieren', 'fwbase' ),
    'update_item' => __( 'Aktualisieren', 'fwbase' ),
    'add_new_item' => __( 'Hinzuf&uuml;gen', 'fwbase' ),
    'new_item_name' => __( 'Neuer Name', 'fwbase' )
  ),
		'show_admin_column' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'wahnbuechlein/region', 'with_front' => true ),
	)
);


// Lookbook: Kategorie
register_taxonomy( 'look_categorie', array('hw_lookbook'), array(
  'hierarchical' => true,
  'labels' => array(
   	'name' => __( 'Lookbook Kategorien', 'fwbase' ),
    'singular_name' => __( 'Lookbook Kategorie', 'fwbase' ),
    'search_items' =>  __( 'Durchsuchen', 'fwbase' ),
    'all_items' => __( 'Alle Kategorien', 'fwbase' ),
    'parent_item' => __( '&Uuml;bergeordnete Kategorie', 'fwbase' ),
    'parent_item_colon' => __( '&Uuml;bergeordnete Kategorie:', 'fwbase' ),
    'edit_item' => __( 'Editieren', 'fwbase' ),
    'update_item' => __( 'Aktualisieren', 'fwbase' ),
    'add_new_item' => __( 'Hinzuf&uuml;gen', 'fwbase' ),
    'new_item_name' => __( 'Neuer Name', 'fwbase' )
  ),
    'show_admin_column' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'lookbook/kategorie' ),
	)
);

// Lookbook: Filter
register_taxonomy( 'look_filter', array('hw_lookbook'), array(
  'hierarchical' => true,
  'labels' => array(
   	'name' => __( 'Lookbook Filter', 'fwbase' ),
    'singular_name' => __( 'Lookbook Filter', 'fwbase' ),
    'search_items' =>  __( 'Durchsuchen', 'fwbase' ),
    'all_items' => __( 'Alle Filter', 'fwbase' ),
    'parent_item' => __( '&Uuml;bergeordnete Filter', 'fwbase' ),
    'parent_item_colon' => __( '&Uuml;bergeordnete Filter:', 'fwbase' ),
    'edit_item' => __( 'Editieren', 'fwbase' ),
    'update_item' => __( 'Aktualisieren', 'fwbase' ),
    'add_new_item' => __( 'Hinzuf&uuml;gen', 'fwbase' ),
    'new_item_name' => __( 'Neuer Filter', 'fwbase' )
  ),
    'show_admin_column' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'lookbook/filter' ),
	)
);


// -----------------------------------------------------
//
// Media Taxonomies
//
// -----------------------------------------------------

// register image taxonomy for categories
function fw_add_img_cats_taxonomy() {
  $labels = array(
    'name'              => __('Bilderkategorien', 'fwbase'),
    'singular_name'     => __('Bilderkategorie', 'fwbase'),
    'search_items'      => __('Suchen', 'fwbase'),
    'all_items'         => __('Alle Kategorien', 'fwbase'),
    'parent_item'       => __('Elternkategorie', 'fwbase'),
    'parent_item_colon' => __('Elternkategorie:', 'fwbase'),
    'edit_item'         => __('Editeren', 'fwbase'),
    'update_item'       => __('Aktualisieren', 'fwbase'),
    'add_new_item'      => __('Hinzuf&uuml;gen', 'fwbase'),
    'new_item_name'     => __('Neuer Kategoriename', 'fwbase'),
    'menu_name'         => __('Bilderkategorie', 'fwbase')
  );

  $args = array(
    'labels' => $labels,
    'has_archive' => true,
    'hierarchical' => true,
    'query_var' => 'true',
    'rewrite' => 'true',
    'show_admin_column' => 'true',
  );

  register_taxonomy( 'bilderkategorie', 'attachment', $args );
}
add_action( 'init', 'fw_add_img_cats_taxonomy' );

// register image taxonomy for color category
function fw_add_img_color_taxonomy() {
  $labels = array(
    'name'              => __('Bilderfarben', 'fwbase'),
    'singular_name'     => __('Bilderfarbe', 'fwbase'),
    'search_items'      => __('Suchen', 'fwbase'),
    'all_items'         => __('Alle Farben', 'fwbase'),
    'parent_item'       => __('Elternfarbe', 'fwbase'),
    'parent_item_colon' => __('Elternfarbe:', 'fwbase'),
    'edit_item'         => __('Editeren', 'fwbase'),
    'update_item'       => __('Aktualisieren', 'fwbase'),
    'add_new_item'      => __('Hinzuf&uuml;gen', 'fwbase'),
    'new_item_name'     => __('Neuer Farbe', 'fwbase'),
    'menu_name'         => __('Bilderfarbe', 'fwbase')
  );

  $args = array(
    'labels' => $labels,
    'has_archive' => false,
    'hierarchical' => true,
    'query_var' => 'true',
    'rewrite' => 'true',
    'show_admin_column' => 'true',
  );

  register_taxonomy( 'bilderfarben', 'attachment', $args );
}
add_action( 'init', 'fw_add_img_color_taxonomy' );

// register image taxonomy for tags
function fw_add_img_tags_taxonomy() {
  $labels = array(
    'name'              => __('Bild-Schlagworte', 'fwbase'),
    'singular_name'     => __('Bild-Schlagwort', 'fwbase'),
    'search_items'      => __('Suchen', 'fwbase'),
    'all_items'         => __('Alle Schlagworte', 'fwbase'),
    'parent_item'       => __('Eltern-Schlagwort', 'fwbase'),
    'parent_item_colon' => __('Eltern-Schlagwort:', 'fwbase'),
    'edit_item'         => __('Editeren', 'fwbase'),
    'update_item'       => __('Aktualisieren', 'fwbase'),
    'add_new_item'      => __('Hinzuf&uuml;gen', 'fwbase'),
    'new_item_name'     => __('Neues Schlagwort', 'fwbase'),
    'menu_name'         => __('Bild-Schlagworte', 'fwbase')
  );

  $args = array(
    'labels' => $labels,
    'has_archive' => false,
    'hierarchical' => true,
    'query_var' => 'true',
    'rewrite' => 'true',
    'show_admin_column' => 'true',
  );

  register_taxonomy( 'bildertags', 'attachment', $args );
}
add_action( 'init', 'fw_add_img_tags_taxonomy' );


// -----------------------------------------------------
//
// Change default number of posts per page for Taxonomies
//
// -----------------------------------------------------
function fw_tax_queries( $query ) {
	if( is_admin() ) { return $query; }

  if(is_tax('wahn_categorie') && $query->is_main_query() ) {
    $query->set('posts_per_page', -1);
    $query->set('orderby', 'rand');
  }
}
add_action( 'pre_get_posts', 'fw_tax_queries' );


// -----------------------------------------------------
//
// Add images to Wahnbuechlein categories
//
// -----------------------------------------------------
if( function_exists('register_field_group') ):

  register_field_group(array (
  	'key' => 'group_5549d7156371b',
  	'title' => 'Wahn&uuml;chlein Kategoriefelder',
  	'fields' => array (
  		array (
  			'key' => 'field_5549d7197f898',
  			'label' => 'Kategoriebild',
  			'name' => 'wahn_cat_img',
  			'prefix' => '',
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
        'key' => 'field_5583c1392ffbf',
        'label' => 'Lang-Beschreibung',
        'name' => 'wahn_cat_description',
        'type' => 'textarea',
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
        'maxlength' => '',
        'rows' => '',
        'new_lines' => '',
        'readonly' => 0,
        'disabled' => 0,
      ),

  	),
  	'location' => array (
  		array (
  			array (
  				'param' => 'taxonomy',
  				'operator' => '==',
  				'value' => 'wahn_categorie',
  			),
  		),
  	),
  	'menu_order' => 0,
  	'position' => 'normal',
  	'style' => 'default',
  	'label_placement' => 'top',
  	'instruction_placement' => 'label',
  	'hide_on_screen' => '',
  ));

endif;
?>
