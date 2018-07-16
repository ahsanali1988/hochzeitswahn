<?php

function row_start($atts, $content = null) { 
  extract (shortcode_atts(array(
	  "class"  => "",
  ), $atts));
	return '<div class="row '.$class.'">';
}
add_shortcode('neuezeile', 'row_start');	
	
function row_end($content = null) { 
	return '</div>';
}
add_shortcode('zeilenende', 'row_end');	
	
// Grid System with included Shortcodes -> Start
function grid_start($atts, $content = null) { 
	extract (shortcode_atts(array(
		"span"   => "12",
		"offset" => "0",
		"class"  => "",
	), $atts));
	return '<div class="span'.$span.' offset'.$offset.' '.$class.'">';
}
add_shortcode('spalte', 'grid_start');	
	
// Grid System with included Shortcodes -> End
function grid_end($atts, $content = null) { 
	return '</div>';
}
add_shortcode('spaltenende', 'grid_end');	

?>
