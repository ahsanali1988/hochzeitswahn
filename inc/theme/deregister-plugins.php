<?php

//--------------------------------------------------------------------
// Disable Plugin CSS
//--------------------------------------------------------------------
	
//function fw_deregister_styles() {
//}
//add_action( 'wp_print_styles', 'fw_deregister_styles', 100 );
 

//--------------------------------------------------------------------
// Disable Plugin Scripts
//--------------------------------------------------------------------

function fw_deregister_javascript() {
	wp_deregister_script( 'picturefill' );
}	
add_action( 'wp_print_scripts', 'fw_deregister_javascript', 100 );

?>
