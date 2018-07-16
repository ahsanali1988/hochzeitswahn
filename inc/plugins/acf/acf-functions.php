<?php

/**
 * fwbase acf functions and definitions
 *
 * @package fwbase
 */

//--------------------------------------------------------------------
// ACF Options
//--------------------------------------------------------------------

// Hide ACF menu
//define( 'ACF_LITE' , true );

// Activate Options menu
if( function_exists('acf_add_options_page') ) {	acf_add_options_page(); }


//--------------------------------------------------------------------
// ACF hide drafts from post object
//--------------------------------------------------------------------
function relationship_options_filter($options, $field, $the_post) {
  $options['post_status'] = array('publish');
  return $options;
}
add_filter('acf/fields/post_object/query/name=wahnbuch_repeater_id', 'relationship_options_filter', 10, 3);
add_filter('acf/fields/post_object/query/name=hw_wahnbuch_admin_post', 'relationship_options_filter', 10, 3);
//add_filter('acf/fields/post_object/query/name=featured', 'relationship_options_filter', 10, 3);
//add_filter('acf/fields/featured', '__return_false', 10, 3);
add_filter('acf/fields/post_object/query/name=flitterwochen_repeater_id', 'relationship_options_filter', 10, 3);
add_filter('acf/fields/post_object/query/name=hw_flitterwochen_admin_post', 'relationship_options_filter', 10, 3);


add_filter('acf/load_field/name=user_groups', 'populateUserGroups');

function populateUserGroups( $field )
{	
	// reset choices
	$field['choices'] = array();
	$args = array(
            'numberposts' => -1,
            'post_status' => 'publish',
            'post_type'   => 'hw_wahnbuechlein',
            'meta_key'=> 'wahn_profil_name',
            'orderby'   => 'meta_value',
            'order'   => 'ASC',
                    );
	$wahPosts = get_posts($args);
	
	foreach ($wahPosts as $post) {
		$field['choices'][ $post->ID ] = get_field('wahn_profil_name',$post->ID);
	}

	return $field;
}
//--------------------------------------------------------------------
// ACF Gallery play nice with Gravity Forms
//--------------------------------------------------------------------

// Attach images uploaded through Gravity Form to ACF Gallery Field
// @author Joshua David Nelson, josh@joshuadnelson.com
// @return void
add_filter( 'gform_after_submission_9', 'jdn_set_post_acf_gallery_field', 10, 2 );
function jdn_set_post_acf_gallery_field( $entry, $form ) {

	$gf_images_field_id = 7; // the upload field id
	$acf_field_id = 'field_54ec6eb5a4edf'; // the acf flex field id

	// get post
	if( isset( $entry['post_id'] ) ) {
		$post = get_post( $entry['post_id'] );
		if( is_null( $post ) )
			return;
	} else {
		return;
	}

	// get photographer
	$img_caption   = '';
	//$wedding_photo = rgar( $entry, '22' );
	//$style_photo   = rgar( $entry, '95' );
	//
	//if( $style_photo == '' && $wedding_photo != '') {
  //	$img_caption = $wedding_photo;
	//} elseif( $style_photo !='' && $wedding_photo == '') {
  //	$img_caption = $style_photo;
	//} else {
  //	$img_caption = '';
	//}

	$img_caption = rgar( $entry, '22' );

	// Clean up images upload and create array for gallery field
	if( isset( $entry[ $gf_images_field_id ] ) ) {
		$images = stripslashes( $entry[ $gf_images_field_id ] );
		$images = json_decode( $images, true );
		if( !empty( $images ) && is_array( $images ) ) {
			$gallery = array();
			foreach( $images as $key => $value ) {
				// NOTE: this is the other function you need: https://gist.github.com/joshuadavidnelson/164a0a0744f0693d5746
				if( function_exists( 'jdn_create_image_id' ) )
					$image_id = jdn_create_image_id( $value, $post->ID, $img_caption );

				if( $image_id ) {
					$gallery[] = $image_id;
				}
			}
		}
	}

	// Update gallery field with array
	if( ! empty( $gallery ) ) {

  	$flexfield[] = array("field_54ec6f26a4ee2" => $gallery, "acf_fc_layout" => "flex_gallery_images");
		update_field( $acf_field_id, $flexfield, $post->ID );

  	//$flexfield[] = array("flex_gallery_images_content" => $gallery, "acf_fc_layout" => "flex_gallery_images");
		//add_row( $acf_field_id, $flexfield, $post->ID );

		wp_update_post( $post );
	}

  // Now also update the caption for the feat img
	if( $img_caption != '') {
    $post_thumbnail_id = get_post_thumbnail_id( $post->ID );
    $post_thumbnail    = get_post($post_thumbnail_id);
    $post_thumbnail->post_excerpt  = $img_caption;

	  wp_update_post( $post_thumbnail );
	}
}

//
///*
//*  add a flexible content row
//*  - each row needs an extra key "acf_fc_layout" holding the name of the layout (string)
//*/
//$field_key = "field_54ec6eb5a4edf";
//$value = get_field($field_key);
//$value[] = array("flex_gallery_images_content" => "Foo1", "acf_fc_layout" => "flex_gallery_images");
//update_field( $field_key, $value, $post->ID );
//

// Create the image attachment and return the new media upload id.
// @since 1.0.0
// @see http://codex.wordpress.org/Function_Reference/wp_insert_attachment#Example
function jdn_create_image_id( $image_url, $parent_post_id = null, $caption ) {

	if( !isset( $image_url ) )
		return false;

	// Cache info on the wp uploads dir
	$wp_upload_dir = wp_upload_dir();
	// get the file path
	$path = parse_url( $image_url, PHP_URL_PATH );

	// File base name
	$file_base_name = basename( $image_url );

	require_once( ABSPATH . 'wp-admin/admin-functions.php' );

	// Full path
	$home_path = $_SERVER['DOCUMENT_ROOT'];
  // $home_path = get_home_path();
  // $$home_path = untrailingslashit( $home_path ); <- both of these caused trouble when locally in a subdomain
	$uploaded_file_path = $home_path . $path;

	// Check the type of file. We'll use this as the 'post_mime_type'.
	$filetype = wp_check_filetype( $file_base_name, null );

	// error check
	if( !empty( $filetype ) && is_array( $filetype ) ) {

		// Create attachment title
		$post_title = preg_replace( '/\.[^.]+$/', '', $file_base_name );

		// Prepare an array of post data for the attachment.
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $uploaded_file_path ),
			'post_mime_type' => $filetype['type'],
			'post_title'     => esc_attr( $post_title ),
			'post_content'   => '',
			'post_status'    => 'inherit',
			'post_excerpt'   => $caption
		);

		// Set the post parent id if there is one
		if( !is_null( $parent_post_id ) )
			$attachment['post_parent'] = $parent_post_id;

		// Insert the attachment.
		$attach_id = wp_insert_attachment( $attachment, $uploaded_file_path );
		//Error check
		if( !is_wp_error( $attach_id ) ) {
			//Generate wp attachment meta data
			if( file_exists( ABSPATH . 'wp-admin/includes/image.php') && file_exists( ABSPATH . 'wp-admin/includes/media.php') ) {
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				require_once( ABSPATH . 'wp-admin/includes/media.php' );
				$attach_data = wp_generate_attachment_metadata( $attach_id, $uploaded_file_path );
				wp_update_attachment_metadata( $attach_id, $attach_data );
			} // end if file exists check
		} // end if error check

		return $attach_id;

	} // end if $$filetype
} // end function get_image_id


//--------------------------------------------------------------------
// ACF add field to Images
//--------------------------------------------------------------------

add_filter('acf/location/rule_types', 'acf_location_rules_types');
function acf_location_rules_types( $choices ) {
  $choices[__('Diverse','acf')]['media'] = __('Medien','fwbase');
  return $choices;
}

add_filter('acf/location/rule_values/media', 'acf_location_rules_values_media');
function acf_location_rules_values_media( $choices ) {
  $choices['images'] =  __('Bilder','fwbase');
  $choices['other'] = __('Andere','fwbase');
  return $choices;
}

add_filter('acf/location/rule_match/media', 'acf_location_rules_match_media', 10, 3);
function acf_location_rules_match_media( $match, $rule, $options ) {

  if ( ! function_exists( 'get_current_screen' ) ) return;

  $screen = get_current_screen();

  if ( is_admin() && ($screen->id == 'attachment') ) {
    global $post;
    $id = $post->ID;
  }

  if( wp_attachment_is_image($id) && $rule['value'] == 'images') {
      $match = true;
  } else {
      $match = false;
  }

  return $match;
}


//--------------------------------------------------------------------
// Add a custom class box to Images
//--------------------------------------------------------------------

function fw_attachment_class( $form_fields, $post ) {
	$form_fields['media-class'] = array(
		'label' => _x('Klasse', 'fwbase'),
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'fw_media_class', true ),
	);
	return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'fw_attachment_class', 10, 2 );

function fw_attachment_class_save( $post, $attachment ) {
	if( isset( $attachment['media-class'] ) )
		update_post_meta( $post['ID'], 'fw_media_class', $attachment['media-class'] );
	return $post;
}

add_filter( 'attachment_fields_to_save', 'fw_attachment_class_save', 10, 2 );


//--------------------------------------------------------------------
// Add a custom "show in gallery" box to Images and update images when saving post
//--------------------------------------------------------------------

function fw_attachment_class_gallery( $form_fields, $post ) {
	$form_fields['show-gallery'] = array(
		'label' => _x('In Galerie anzeigen?', 'fwbase'),
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'fw_show_gallery', true ),
	);
	return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'fw_attachment_class_gallery', 10, 2 );

function fw_attachment_class_gallery_save( $post, $attachment ) {
	if( isset( $attachment['show-gallery'] ) )
		update_post_meta( $post['ID'], 'fw_show_gallery', $attachment['show-gallery'] );
	return $post;
}

add_filter( 'attachment_fields_to_save', 'fw_attachment_class_gallery_save', 10, 2 );

// Now update this value when saving a post, so you dont need to do this for every image
function my_acf_save_post( $post_id ) {

  if( empty($_POST['acf']) ) {

    return;

  }

  foreach( $_POST['acf']['field_54ec6eb5a4edf'] as $gallery_field ) {

    if( $gallery_field['acf_fc_layout'] == 'flex_gallery_images' && $gallery_field['field_54ed8ec471d26'] == 1 ) {

      foreach( $gallery_field['field_54ec6f26a4ee2'] as $image ) {

        //print_r($image);

        update_post_meta($image, 'fw_show_gallery', 'yes');

      }

    }

  }

  return $value;
}
add_filter('acf/validate_save_post', 'my_acf_save_post', 1);

?>
