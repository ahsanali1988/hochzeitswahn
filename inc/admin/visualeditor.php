<?php
/*
This file handles the visual editor
*/

/************* ADD CUSTOM STYLESHEET *****************/

add_theme_support('editor_style');

add_action( 'admin_init', 'add_my_editor_style' );

function add_my_editor_style() {
	add_editor_style('inc/admin/assets/css/editor-style.css');
}

/************* CUSTOM TINY STYLE DROPDOWN *****************/

// add_filter( 'mce_buttons_2', 'my_mce_buttons_2' );
// 
// function my_mce_buttons_2( $buttons ) {
//     array_unshift( $buttons, 'styleselect' );
//     return $buttons;
// }
// 
// add_filter( 'tiny_mce_before_init', 'my_mce_before_init' );
// 
// function my_mce_before_init( $settings ) {
// 
//     $style_formats = array(
//     	array(
//     		'title' => 'Button',
//     		'selector' => 'a',
//     		'classes' => 'button'
//     	//),
//       //array(
//       //	'title' => 'Callout Box',
//       // 	'block' => 'div',
//       // 	'classes' => 'callout',
//       // 	'attributes' => array(
//       // 	  'data-custom' => 'custom',
//       // 	  'rel' => 'custom'
//       // 	),
//       // 	'wrapper' => true
//       //),
//       //array(
//       // 	'title' => 'Bold Red Text',
//       // 	'inline' => 'span',
//       // 	'styles' => array(
//       // 		'color' => '#f00',
//       // 		'fontWeight' => 'bold'
//       // 	)
//       )
//     );
// 
//     $settings['style_formats'] = json_encode( $style_formats );
// 
//     return $settings;
// }

/*
// This is the sytanx for adding styles 
//

  title [required]	=> label for this dropdown item
  
  selector OR       => selector limits the style to a specific HTML tag, and will apply the style to an existing tag instead of creating one
  block OR          => block creates a new block-level element with the style applied, and will replace the existing block element around the cursor
  inline [required]	=> inline creates a new inline element with the style applied, and will wrap whatever is selected in the editor, not replacing any tags

  classes [optional]    =>	space-separated list of classes to apply to the element
  styles [optional]	    => array of inline styles to apply to the element (two-word attributes, like font-weight, are written in Javascript-friendly camel case: fontWeight)
  attributes [optional] =>	assigns attributes to the element (same syntax as styles)

  wrapper [optional, default = false]	=> if set to true, creates a new block-level element around any selected block-level elements
  exact [optional, default = false]	  => disables the Òmerge similar stylesÓ feature, needed for some CSS inheritance issues

//  
*/

/************* ADD SHORTCODE BUTTONS TO TINY MCE *****************/

// add_action( 'init', 'sc_custom_buttons' );
// 
// function sc_custom_buttons() {
//     add_filter( "mce_external_plugins", "sc_add_buttons" );
//     add_filter( 'mce_buttons', 'sc_register_buttons' );
// }
// 
// function sc_add_buttons( $plugin_array ) {
//     $plugin_array['customsc'] = get_template_directory_uri() . '/inc/admin/assets/js/register-tinymce-sc-btns.js'; //pliugin id wptuts
//     return $plugin_array;
// }
// 
// function sc_register_buttons( $buttons ) {
//     array_push( $buttons, 'showrecent' ); // you can add multiple btns like 'btn1', 'recentposts', 'btn2'
//     return $buttons;
// }

?>