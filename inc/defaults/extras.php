<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package fwbase
 */


//--------------------------------------------------------------------
// Adds custom classes to the array of body classes.
//--------------------------------------------------------------------
function fwbase_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'fwbase_body_classes' );


//--------------------------------------------------------------------
// Filters wp_title to print a neat <title> tag based on what is being viewed.
//--------------------------------------------------------------------
if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	function fwbase_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'fwbase' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'fwbase_wp_title', 10, 2 );

	// Title shim for sites older than WordPress 4.1.
	// @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	function fwbase_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'fwbase_render_title' );
endif;


//--------------------------------------------------------------------
// Delete Media when post is deleted
//--------------------------------------------------------------------
function delete_associated_media($id) {
  // check if its a post or wahnbuch
  if ('post' == get_post_type($id) || 'hw_wahnbuechlein' == get_post_type($id)) {
    
    $media = get_children(array(
      'post_parent' => $id,
      'post_type' => 'attachment'
    ));
    if (empty($media)) return;
    
    foreach ($media as $file) {
      // pick what you want to do
      wp_delete_attachment($file->ID);
      unlink(get_attached_file($file->ID));
    }
    
  } else {
    return;
  }
}
add_action('before_delete_post', 'delete_associated_media');


//--------------------------------------------------------------------
// Adds function to get the URL only for next/prev image link
//--------------------------------------------------------------------
function custom_get_adjacent_image_link( $prev = false, $size = 'thumbnail', $post_id = false) {
  if(!$post_id)
    $post = get_post();
  else
    $post = get_post($post_id);

  $attachments = array_values( get_children( array( 
    'post_parent' => $post->post_parent, 
    'post_status' => 'inherit', 
    'post_type' => 'attachment', 
    'post_mime_type' => 'image', 
    'order' => 'ASC', 
    'orderby' => 'menu_order ID' ) ) 
  );


  foreach ( $attachments as $k => $attachment )
    if ( $attachment->ID == $post->ID )
      break;

  $k = $prev ? $k - 1 : $k + 1;
  $link = $attachment_id = null;

  if ( isset( $attachments[ $k ] ) ) {
    $attachment_id = $attachments[ $k ]->ID;
    $link = get_attachment_link( $attachment_id);
  }

  return $link;
}


//--------------------------------------------------------------------
// Add all necessary query vars
//--------------------------------------------------------------------
function fw_query_vars($vars) {  
  
  //to detect the gallery temaplte
  $vars[] = 'details';
  
  //to filter posts by colors
  $vars[] = 'farbfilter';

  //to filter images in the gallery  
  $vars[] = 'bilderkategorie';
  $vars[] = 'bilderfarben';
  $vars[] = 'bildertags';
  $vars[] = 'attached';
  
  //lookbook filtering  
  $vars[] = 'look_categorie';
  $vars[] = 'look_filter';
  
  return $vars;
}
add_filter('query_vars', 'fw_query_vars');


//--------------------------------------------------------------------
// Gallery filter: Allow query to be modified
//--------------------------------------------------------------------
function fw_alter_gallery_query( $query ) {
	
	//if( is_admin() ) {
	// return;
	//}
  //
  //if( $query->is_main_query() || (isset($wp_query->query['post_type']) && $query->query_vars['post_type'] != 'attachment') ) {
  //	return;
	//}
	//
	//if (!is_page_template( 'template-gallery.php' ) ) {
  //	return;
	//}
	//
	//if( isset($wp_query->query['post_type']) && $query->query['post_type'] != 'attachment' ) {
  //	return;
	//}
	
	if( is_page_template( 'template-gallery.php' ) && !$query->is_main_query() && ( isset($query->query['post_type']) && $query->query['post_type'] == 'attachment' ) ) {
    
	  $tax_query = $query->get('tax_query');
    
    if( !empty($_GET['bilderkategorie']) ) {
    	
    	$imgcat = explode(',', $_GET['bilderkategorie']);
    
    	$tax_query[] = array(
	   	'taxonomy' => 'bilderkategorie',
	   	'field'    => 'slug',
	   	'terms'    => $imgcat,
	   );
    }
    
    if( !empty($_GET['bilderfarben']) ) {
    	
    	$imgcolors = explode(',', $_GET['bilderfarben']);
    
    	$tax_query[] = array(
	   	'taxonomy' => 'bilderfarben',
	   	'field'    => 'slug',
	   	'terms'    => $imgcolors,
	   );
    }
    
    if( !empty($_GET['bildertags']) ) {
    	
    	$imgtag = explode(',', $_GET['bildertags']);
     
    	$tax_query[] = array(
	   	'taxonomy' => 'bildertags',
	   	'field'    => 'slug',
	   	'terms'    => $imgtag,
	   );
    }
     
	  $query->set('tax_query', $tax_query);
    
  }
  
	return;
}
add_action('pre_get_posts', 'fw_alter_gallery_query');


//--------------------------------------------------------------------
// Media Grid View: Replace the "medium" image size with "replace_this_image_size" image size.
// @see http://www.wpquestions.com/question/showChronoLoggedIn/id/9941
//--------------------------------------------------------------------
function fw_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'headersplit-s' => __('Portrait visible'),
    ) );
}
add_filter( 'image_size_names_choose', 'fw_custom_sizes' );

function fw_mediagrid( $response, $attachment, $meta ) {
  $use_size = 'headersplit-s';

  if( 'image' === $response['type'] ) {
    if( isset( $response['sizes'][$use_size] ) ) {
      $response['sizes']['medium'] = $response['sizes'][$use_size];       
    } else {
      $response['sizes']['medium'] = $response['sizes']['full'];       
    }
  }

  return $response;
}
add_filter( 'wp_prepare_attachment_for_js', 'fw_mediagrid', 10, 3 );

// Media Grid View: CSS to display portrait images
// using object-fit.
function fw_admin_mediacss() {
  if ( current_user_can('administrator') || current_user_can('author') || current_user_can('externalhelper') ) {
    $css  = '<style>';
    $css .= '.media-frame-content .attachment-preview img { object-fit: contain; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%; }';
    $css .= '</style>';
    echo $css;
  }  
}
add_action( 'admin_head', 'fw_admin_mediacss' );

?>
