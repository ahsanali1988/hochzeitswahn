<?php
  
// -----------------------------------------------------
//
// Register Template parts for AJAX
//
// -----------------------------------------------------


// Jquery Data for frontend
// -----------------------------------------------------
function fw_frontend_data() {
  wp_localize_script( 'fw-custom-js', 'URLData', array(
    'siteurl' => get_option('siteurl'),
    'ajaxurl' => admin_url('admin-ajax.php') 
  ));  
}
add_action('wp_enqueue_scripts', 'fw_frontend_data');


// Instagram in Footer
// -----------------------------------------------------
function fw_ajax_instagram() {
  $response  = '<strong class="instagram-link">';
  $response .=   '<a href="http://instagram.com/hochzeitswahn/" target="_blank" title="Hochzeitswahn at Instagram"> Instagram <small>@hochzeitswahn</small> </a>'; 
  $response .= '</strong>';
  $response .= '<div class="footer-instagram-wrapper">';
  $response .=   do_shortcode('[alpine-phototile-for-instagram id=571 user="hochzeitswahn" src="user_recent" imgl="instagram" style="wall" row="8" size="M" num="8" highlight="1" align="center" max="100"]');
  $response .= '</div>';

  echo $response;
  
  exit;
}
add_action('wp_ajax_fw_ajax_instagram', 'fw_ajax_instagram');
add_action('wp_ajax_nopriv_fw_ajax_instagram', 'fw_ajax_instagram');

?>