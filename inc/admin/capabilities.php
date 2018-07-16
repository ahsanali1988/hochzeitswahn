<?php
/**
 * fwbase user roles and capabilities
 *
 * @package fwbase
 */


//--------------------------------------------------------------------
// customize admin bar for contributors
//--------------------------------------------------------------------
function remove_admin_bar_links() {
  global $wp_admin_bar;
    
  if (!current_user_can('administrator')) {
    $wp_admin_bar->remove_menu('updates');          // Remove the updates link
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
    $wp_admin_bar->remove_menu('new-content');      // Remove the content link
    $wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
    $wp_admin_bar->remove_menu('wpseo-menu');       // Remove SEO
    $wp_admin_bar->remove_menu('search');           // Remove Search
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('site-name');
  }
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

function fw_custom_toolbar_link($wp_admin_bar) {
  $args = array(
    'id' => 'wahnbuch-profil',
    'title' => __('Dein Wahnb&uuml;chlein Profil', 'fwbase'),
    'href' => admin_url( 'edit.php?post_type=hw_wahnbuechlein' ),
    'meta' => array(
      'class' => 'wahnbuch-profil',
      'title' => __('Dein Wahnb&uuml;chlein Profil', 'fwbase'),
    )
  );
  $wp_admin_bar->add_node($args);
}
add_action('admin_bar_menu', 'fw_custom_toolbar_link', 999);

function fw_footer_shh() {
  if ( !current_user_can('administrator') ) {
    remove_filter( 'update_footer', 'core_update_footer' ); 
  }
}
add_action( 'admin_menu', 'fw_footer_shh' );

function fw_hide_admin_infos() {
  if ( !current_user_can('administrator') && !current_user_can( 'externalhelper' ) ) {
    $css  = '<style>';
    $css .= '.subsubsub a .count, li.all, li.publish, .update-nag, .updated, .toplevel_page_acf-options, .menu-icon-tools, #wp-admin-bar-wp-logo, #menu-dashboard, #menu-media, #footer-thankyou, #menu-users, #wahn_categoriediv, #wahn_regiondiv, #wpseo_meta { display: none; visibility:hidden; }';
    $css .= '</style>';
    echo $css;
  }  
}
add_action( 'admin_head', 'fw_hide_admin_infos' );


//--------------------------------------------------------------------
// filter posts so that author can only see theirs
//--------------------------------------------------------------------
add_action('pre_get_posts', 'filter_posts_list');
function filter_posts_list($query) {
  global $pagenow;
  global $current_user;
  
  get_currentuserinfo();
   
  if(!current_user_can('administrator') && current_user_can('edit_posts') && ('edit.php' == $pagenow)) {
    $query->set('author', $current_user->ID); 
  }
}


//--------------------------------------------------------------------
// Remove comment notification for non-admins
//--------------------------------------------------------------------
function stopBuggingMe($emails) {
  // only send notification to the admin:
  return array( get_option( 'admin_email' ) );
}
add_filter( 'comment_moderation_recipients', 'stopBuggingMe', PHP_INT_MAX );


//--------------------------------------------------------------------
// filter screen options for DLs
//--------------------------------------------------------------------
function remove_screen_options_tab() {        
  return current_user_can( 'manage_options' );   
}   
add_filter('screen_options_show_screen', 'remove_screen_options_tab');

function manage_columns( $columns ) { 
  if ( !current_user_can('administrator') ) {
    unset( $columns['taxonomy-wahn_region'] );
    unset( $columns['taxonomy-wahn_categorie'] );
    unset( $columns['wpseo-metadesc'] );
    unset( $columns['wpseo-score'] );
    unset( $columns['wpseo-title'] );
    unset( $columns['subscribe-reloaded'] );
    unset( $columns['wpseo-focuskw'] );
  }
  return $columns;
}
add_filter('manage_posts_columns' , 'manage_columns');

function remove_publish_box() {
  if(!current_user_can('administrator')) {
  	remove_meta_box( 'slugdiv', 'hw_wahnbuechlein', 'normal' );
  }
}
add_action( 'admin_menu', 'remove_publish_box' );


//--------------------------------------------------------------------
// filter uploaded media so that author can only see theirs
//--------------------------------------------------------------------
function restrict_file_view( $wp_query ) {  
  if ( isset($wp_query->query['post_type']) && $wp_query->query_vars['post_type']=="attachment" && is_admin() ){
    if ( !current_user_can( 'administrator' ) && !current_user_can( 'externalhelper' )  ) {
      global $current_user;
      $wp_query->set( 'author', $current_user->id );
    }   
  }
}
add_filter('parse_query', 'restrict_file_view' );


//--------------------------------------------------------------------
// remove menu items from dashboard for non-admins
//--------------------------------------------------------------------
add_action( 'admin_init', 'my_remove_menu_pages' );
function my_remove_menu_pages() {
 
  global $user_ID;
 
  if ( current_user_can( 'contributor' ) ) {
    remove_menu_page( 'edit.php?post_type=hw_hochzeitpost' );
    remove_menu_page( 'edit.php?post_type=ttshowcase' );
    remove_menu_page( 'instagramJournal' );
    remove_menu_page( 'edit.php?post_type=hw_lookbook' );
    remove_menu_page( 'edit.php?post_type=hw_gallery' );
    remove_menu_page( 'edit-comments.php' );        
    remove_menu_page( 'edit.php' );  
    remove_menu_page( 'edit.php?post_type=page' );
  }
}

function remove_dashboard_widgets() {
	global $wp_meta_boxes;

  if (!current_user_can('manage_options')) {
	  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	  //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
	  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  }
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );


//--------------------------------------------------------------------
// Set post to draft for another revision if contributor edits it
//--------------------------------------------------------------------
// add_filter('wp_insert_post_data', 'change_post_status', '99');
// function change_post_status($data){
//   if( (current_user_can('contributor')) && ($data['post_type'] == 'hw_wahnbuechlein') ) {
//     if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
//       $data['post_status'] = 'draft';     
//     }
//   return $data;
// }


//--------------------------------------------------------------------
// Set wahnbuch to new status on updates
// http://wordpress.stackexchange.com/questions/183553/revert-one-revision-of-a-post-progmattically-via-code
//--------------------------------------------------------------------
function fw_custom_post_status() {
  register_post_status( 'awaiting', array(
    'label'                     => _x( 'Warten auf Freigabe', 'hw_wahnbuechlein' ),
    'public'                    => true,
    'exclude_from_search'       => false,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count'               => _n_noop( 'Warten auf Freigabe: <span class="count">(%s)</span>', 'Warten auf Freigabe: <span class="count">(%s)</span>' ),
   ) );
 }
add_action( 'init', 'fw_custom_post_status' );

function get_current_user_role() {
  global $wp_roles;
  $current_user = wp_get_current_user();
  $roles = $current_user->roles;
  $role = array_shift($roles);

  return $role;
}

function published_to_pending( $post_id ) {
  global $post, $current_user, $wp_meta_boxes ;

  if ( !is_object( $post ) ) $post = get_post( $post_id );

  if ( !current_user_can( 'edit_post', $post_id ) ) return $post_id;

  if (get_current_user_role()!="contributor") { return; }
  
  if ( $post->post_status=="publish" ) {
    global $wpdb;
    $result = $wpdb->update(
      $wpdb->posts,
      array( 'post_status' => "awaiting" ),
      array( 'ID' => $post_id )
    );
  }
}
add_action( 'post_updated', 'published_to_pending', 13, 2 );

function fw_class_pending( $classes ) { 
  global $post;
  if( $post->post_status=="awaiting" ) {    
    return "$classes post_is_awaiting";
  }    
}
add_action( 'admin_body_class', 'fw_class_pending' );

function fw_hide_admin_infos1() {
  if ( !current_user_can('administrator') ) {
    $css  = '<style>';
    $css .=   '.post_is_awaiting #publish { display: none; visibility:hidden; } .post_is_awaiting #publishing-action:after {content:"'.__('Wird geprueft', 'fwbase').'"; position: relative; top: 3px;}';
    $css .= '</style>';
    echo $css;
  }  
}
add_action( 'admin_head', 'fw_hide_admin_infos1' );


//--------------------------------------------------------------------
// Email Admin when Wahnbuch Entry was changed 
//--------------------------------------------------------------------
function wahnbuch_updated( $post_id ) {
  
	if( wp_is_post_revision( $post_id ) ) return;
	if( wp_is_post_autosave( $post_id ) ) return;

  if( get_post_status($post_id) == 'awaiting' || get_post_status($post_id) == 'pending' || get_post_status($post_id) == 'publish') {
    if( get_post_type($post_id) == 'hw_wahnbuechlein' ) {
      $post_title = get_the_title( $post_id );
      $post_url = get_permalink( $post_id );
      $subject = 'Ein Wahnbuch-Eintrag wurde aktualisiert und bedarf einer Freischaltung';
        
      $message = "Folgender Wahnbuch-Eintrag wurde vom Dienstleister aktualisiert:\n\n";
      $message .= $post_title . ": " . $post_url . "\n";
      $message .= "Bitte pruefe die Aenderungen und veroeffentliche den Beitrag, wenn alles in Ordnung ist.";
	      
      // Send email to admin.
      wp_mail( 'info@hochzeitswahn.de', $subject, $message );
	  }
  }
}
add_action( 'save_post', 'wahnbuch_updated' );


//--------------------------------------------------------------------
// Email DL when his/her post gets published
//--------------------------------------------------------------------     
// function a_new_post( $new_status, $old_status, $post ) {
// 
//   if ( 'hw_wahnbuechlein' !== $post->post_type && 'publish' === $new_status ) {
//     
//     $author    = $post->ID;
//     $name      = get_the_author_meta( 'display_name', $author );
//     $email     = get_the_author_meta( 'user_email', $author );
//     $title     = $post->post_title;
//     $permalink = get_permalink( $post->ID );
//     $edit      = get_edit_post_link( $post->ID, '' );
//     $to[]      = sprintf( '%s <%s>', $name, $email );
//     $subject   = sprintf( 'Dein Hochzeitswahn-Eintrag: %s', $title );
//     $message   = sprintf ('Herzlichen Gl&uuml;ckwunsch, %s! Dein Beitrag "%s" ist live.' . "\n\n", $name, $title );
//     $message  .= sprintf( 'Ansehen: %s', $permalink );
// 
//     wp_mail( $to, $subject, $message );
//     
//   }
// }
// add_action( 'transition_post_status', 'a_new_post', 10, 3 );
// 
?>
