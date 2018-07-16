<?php

// Buttons
function btn_code($atts, $content = null) { 
	extract (shortcode_atts(array(
		"stil" => "",
		"link" => "",
		"label" => "Download",
	), $atts));
	return '<a class="btn '.$stil.'" href="'.$link.'">'.$label.'</a>';
}
add_shortcode('button', 'btn_code');
			
?>
