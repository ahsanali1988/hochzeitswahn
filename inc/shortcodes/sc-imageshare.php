<?php

// Image share for individual pinterest images
function fw_image_share($atts, $content = null) { 
	extract (shortcode_atts(array(
		"image"  => "",
	), $atts));
		
	$sharedImage = wp_prepare_attachment_for_js( $image );
  $sharedPost  = get_permalink($sharedImage['uploadedTo']);
  $sharedDescr = ($sharedImage['caption'] != '' ? $sharedImage['caption'] : $sharedImage['alt']);  
  
	?>
	
	  <div class="essb_links essb_counter_modern_bottom essb_displayed_shortcode essb_share essb_template_light-retina essb_1406883711 essb_links_center print-no">
  	  <ul class="essb_links_list essb_force_hide_name essb_force_hide">
    	  <li class="essb_item essb_link_pinterest nolightbox"> 
    	    <a href="http://pinterest.com/pin/create/bookmarklet/?media=<?php echo $sharedImage['url']; ?>&amp;url=<?php echo $sharedPost; ?>&amp;title=<?php echo $sharedImage['title']; ?>&amp;description=<?php echo $sharedDescr; ?>" title="" onclick="essb_window('http://pinterest.com/pin/create/bookmarklet/?media=<?php echo $sharedImage['url']; ?>&amp;url=<?php echo $sharedPost; ?>&amp;title=<?php echo $sharedImage['title']; ?>&amp;description=<?php echo $sharedDescr; ?>','pinterest','1406883711'); return false;" target="_blank" rel="nofollow">   
      	    <span class="essb_icon"></span>
      	    <span class="essb_network_name essb_noname"></span>
      	  </a>
        </li>
        
        <li class="essb_item essb_link_fave nolightbox"> 
          <a href="" title="" target="_blank" rel="nofollow" data-remodal-target="modal-20203">
            <span class="essb_icon"></span>
            <span class="essb_network_name essb_noname"></span>
          </a>
        </li>
      </ul>
    </div>
	
	<?php

}

add_shortcode('share-image', 'fw_image_share');

?>
