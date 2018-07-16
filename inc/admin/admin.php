<?php
// -----------------------------------------------------
//
// Admin functions
//
// -----------------------------------------------------

// Custom Login
// -----------------------------------------------------
function fwbase_login_css() {
	wp_enqueue_style( 'fwbase_login_css', get_template_directory_uri() . '/css/login.css', false );
}

// changing the logo link from wordpress.org to your site
function fwbase_login_url() {  return home_url(); }

// changing the alt text on the logo to show your site name
function fwbase_login_title() { return get_option('blogname'); }

// calling it only on the login page
add_action('login_enqueue_scripts', 'fwbase_login_css', 10);
add_filter('login_headerurl', 'fwbase_login_url');
add_filter('login_headertitle', 'fwbase_login_title');


// Custom Backend Footer 
// -----------------------------------------------------
function fwbase_custom_admin_footer() {
	_e('<span id="footer-thankyou">Developed by <a href="http://falconwhite.de" target="_blank">falconwhite</a></span>.', 'fwbase');
}
add_filter('admin_footer_text', 'fwbase_custom_admin_footer');


// Custom Dashboard Itmes
// -----------------------------------------------------
add_action( 'admin_menu', 'fwbase_remove_menu_pages' );

function fwbase_remove_menu_pages() {
  remove_menu_page('link-manager.php');  
	//remove_menu_page('edit-comments.php');
}


// SVG Media Upload
// -----------------------------------------------------
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

//function fix_svg_thumb_display() {
//  echo 'td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail { width: 100% !important; height: auto !important; }';
//}
//add_action('admin_head', 'fix_svg_thumb_display');


// Clean up
// -----------------------------------------------------
// remove WP version from RSS
function fwbase_rss_version() { return ''; }

// remove WP version from scripts
function fwbase_remove_wp_ver_css_js( $src ) {
  if ( strpos( $src, 'ver=' ) )
    $src = esc_url(remove_query_arg( 'ver', $src ));
  return $src;
}

?>