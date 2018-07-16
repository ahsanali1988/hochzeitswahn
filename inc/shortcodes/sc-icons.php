<?php

// Icons
function icon_code($atts, $content = null) { 
	extract (shortcode_atts(array(
		"name"  => "checkmark",
	), $atts));
	return '<span class="icon icon-'.$name.'"></span>';
}
add_shortcode('icon', 'icon_code');

?>
