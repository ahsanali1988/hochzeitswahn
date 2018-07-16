<?php
  
/**
 * fwbase plugin tidy up
 *
 * @package fwbase
 */


//--------------------------------------------------------------------
// OIO CSS removed
//--------------------------------------------------------------------
//remove_action('wp_head', 'oiopub_header_output', 99);


//--------------------------------------------------------------------
// Userpro Date picker and jQueryUI css
//--------------------------------------------------------------------
function fw_deregister_styles() {
	wp_deregister_style( 'userpro_jquery_ui_style' );
}
add_action( 'wp_print_styles', 'fw_deregister_styles', 100 );

// function fw_deregister_javascript() {
// 	wp_deregister_script( 'jquery-ui-datepicker' );
// }
// add_action( 'wp_print_scripts', 'fw_deregister_javascript', 100 );
// 


//--------------------------------------------------------------------
// Userpro Bookmark for non-gallery images
//-------------------------------------------------------------------- 
function imgID($match) {
  preg_match('/wp-image-(\d+)/i', $match[2], $imageID);
  $imageID[0] = preg_replace('/\D/', '', $imageID[0]);
        
  // What to replace it with.
  $replacement  =  '<div class="image-wrap">';
  $replacement .=  '  <div class="entry-meta">';
  $replacement .=  '    <span class="sharing-options" data-modal-id="'.$imageID[0].'">';
  $replacement .=         do_shortcode('[easy-social-share buttons="pinterest,fave" counters=0 hide_names="force" template="light-retina"]');
  $replacement .=  '    </span>';
  $replacement .=  '  </div>';
  $replacement .=     $match[0];
  $replacement .=  '  <div class="remodal fav-modal-window" data-remodal-id="modal-'.$imageID[0].'">';
  $replacement .=      do_shortcode('[userpro_bookmark_image bookmark_icon="show" post_id='.$imageID[0].' display="none" image_id="'.$imageID[0].'"]');
  $replacement .=  '  </div>';
  $replacement .=  '</div>';
          
  return $replacement;
}
    
function featured_image_before_content( $content ) { 
  if ( is_singular('post') ) {
    $pattern = '/(<img([^>]*)>)(?!\s*<\/a>(?:$|\s))/i';
    $content = preg_replace_callback($pattern, 'imgID', $content);
  }
  return $content;
}
add_filter( 'the_content', 'featured_image_before_content' ); 


//--------------------------------------------------------------------
// Gravity Forms - Do not save entires for DL form
//--------------------------------------------------------------------
// originally http://pastie.org/1435911
// http://www.gravityhelp.com/forums/topic/purposefully-not-save-form-in-entries-database#post-15601
// change the 1 here to your form ID
add_action('gform_after_submission_5', 'remove_form_entry', 10, 2);
function remove_form_entry($entry, $form){
  global $wpdb;

  $lead_id = $entry['id'];
  $lead_table = RGFormsModel::get_lead_table_name();
  $lead_notes_table = RGFormsModel::get_lead_notes_table_name();
  $lead_detail_table = RGFormsModel::get_lead_details_table_name();
  $lead_detail_long_table = RGFormsModel::get_lead_details_long_table_name();

  //Delete from detail long
  $sql = $wpdb->prepare(" DELETE FROM $lead_detail_long_table
                          WHERE lead_detail_id IN(
                              SELECT id FROM $lead_detail_table WHERE lead_id=%d
                          )", $lead_id);
  $wpdb->query($sql);

  //Delete from lead details
  $sql = $wpdb->prepare("DELETE FROM $lead_detail_table WHERE lead_id=%d", $lead_id);
  $wpdb->query($sql);

  //Delete from lead notes
  $sql = $wpdb->prepare("DELETE FROM $lead_notes_table WHERE lead_id=%d", $lead_id);
  $wpdb->query($sql);

  //Delete from lead
  $sql = $wpdb->prepare("DELETE FROM $lead_table WHERE id=%d", $lead_id);
  $wpdb->query($sql);
}


//--------------------------------------------------------------------
// Gravity Forms - Fill out DL email for DL form
//--------------------------------------------------------------------
function dlemail_population_function($value) {  
  global $post;  
  if( get_post_type($post->ID) === 'hw_wahnbuechlein' ) {
    $email = get_field('wahn_profil_email',$post->ID);
  } elseif ( get_post_type($post->ID) === 'hw_lookbook' ) {
    $email = get_field('look_profil_email', $post->ID);
  }
  return $email;
}
add_filter('gform_field_value_dl_email', 'dlemail_population_function');


//--------------------------------------------------------------------
// Gravity Forms - BL Bewerbung - duplicate post title into name
//--------------------------------------------------------------------
function pre_submission_handler( $form ) {
    $_POST['input_26'] = rgpost( 'input_2' );
}
add_action( 'gform_pre_submission_6', 'pre_submission_handler' );


//--------------------------------------------------------------------
// Gravity Forms - Pending registration counter
//--------------------------------------------------------------------
function dl_registration_pending($menu_items) {
	foreach ( $menu_items as &$item ) {
		if ( rgar( $item, 'name' ) == 'gf_user_registration' ) {
			require_once( GFUser::get_base_path() . '/includes/pending_activations.php' );
			$count = GFUserPendingActiviations::get_pending_activations( 'all', array( 'get_total' => true ) );
			$item['label'] .= " ({$count})";
			break;
		}
	}
	return $menu_items;
}
add_filter('gform_addon_navigation', 'dl_registration_pending', 30);

?>
