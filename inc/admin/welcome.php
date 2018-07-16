<?php

/************* DISPLAY WELCOME NOTICE IN ADMIN AREA *****************/

add_action('admin_notices', 'km_admin_notice');
function km_admin_notice() {
	global $current_user ;
  $user_id = $current_user->ID;
  /* Check that the user hasn't already clicked to ignore the message */
	if ( ! get_user_meta($user_id, 'km_ignore_notice') ) {
    echo '<div class="updated"><p>';
    printf(__('Willkommen zu Ihrer neuen Seite. | <a href="%1$s">Ausblenden</a>'), '?km_nag_ignore=0');
    echo "</p></div>";
	}
}

add_action('admin_init', 'km_nag_ignore');
function km_nag_ignore() {
	global $current_user;
  $user_id = $current_user->ID;
  /* If user clicks to ignore the notice, add that to their user meta */
  if ( isset($_GET['km_nag_ignore']) && '0' == $_GET['km_nag_ignore'] ) {
    add_user_meta($user_id, 'km_ignore_notice', 'true', true);
	}
}

//on theme deactivation remove the user meta
add_action('switch_theme', 'km_theme_deactivation_function');
function km_theme_deactivation_function() {
  global $current_user;
  $user_id = $current_user->ID;
  delete_user_meta( $user_id, 'km_ignore_notice' );
}

?>