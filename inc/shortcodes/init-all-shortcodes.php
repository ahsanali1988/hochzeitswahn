<?php

//--------------------------------------------------------------------
//INCLUDE SHORTCODE FILES
//--------------------------------------------------------------------

// Basic Grid
require_once('sc-grids.php');

// Buttons
require_once('sc-buttons.php');

// Iconfont
require_once('sc-icons.php');

// Recent posts
require_once('sc-recentposts.php');

// Custom image share
require_once('sc-imageshare.php');

//--------------------------------------------------------------------
//TRY TO CLEAN UP SHORTCODE INCLUDES
//--------------------------------------------------------------------

remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 12);

?>
