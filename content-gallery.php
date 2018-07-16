<?php
/**
 * @package fwbase
 */
?>

<?php
  //Get all img info
  $image = wp_prepare_attachment_for_js($post->ID);       
?>


<?php /*<div class="ad-section ad-leaderboard medium-up">
  <img src="http://placehold.it/728x90" alt="Placeholder Leaderboard">
</div> */ ?>
			
<header class="page-header">
 
  <nav class="entry-nav">
    <a href="<?php echo get_permalink(132765); ?>" class="" title="<?php _e('Zur Galerie&uuml;bersicht', 'fwbase'); ?>"> <?php _e('Zur Galerie&uuml;bersicht', 'fwbase'); ?> </a>
    <a href="<?php echo get_permalink(132765).'?attached='.$image['uploadedTo'];?>" class="" title="<?php _e('Alle Bilder dieser Galerie', 'fwbase');?>"> <?php _e('Alle Bilder dieser Galerie', 'fwbase');?> </a>
    <a href="<?php echo get_permalink($image['uploadedTo']); ?>" class="" title="<?php _e('Zum Beitrag dieser Galerie', 'fwbase'); ?>"> <?php _e('Zum Beitrag dieser Galerie', 'fwbase'); ?> </a>
  </nav>		

  <div class="entry-meta">
    <?php 
      echo '<span class="entry-cats">';
        $cats = get_the_terms( $post->ID, 'bilderkategorie' ); 
        
        if( $cats != '') {        
          foreach( $cats as $cat ) {
            echo '<a href="'.get_permalink(132765).'?bilderkategorie='.$cat->slug.'&bilderfarben=&bildertags=" title="'.$cat->name.'" rel="nofollow">'.$cat->name.'</a>';
            if ($cat !== end($cats)) echo ', ';
          }
        } 
      echo '</span>';
    
      echo '<span class="entry-colors"> <strong>'.__('Farben', 'fwbase').'</strong>';
        $colors = get_the_terms( $post->ID, 'bilderfarben' ); 
        
        if( $colors != '' ) { 
          foreach( $colors as $color ) {
            echo '<a href="'.get_permalink(132765).'?bilderkategorie=&bilderfarben='.$color->slug.'&bildertags=" title="'.$color->name.'" rel="nofollow">'.$color->name.'</a>';
            if ($color !== end($colors)) echo ', ';          
          }
        } 
      echo '</span>';
    ?>			
  </div>
  
</header>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
  <div class="entry-content">
    <div class="entry-content-img">
      
      <div class="entry-meta">
  	    <div class="meta-wrapper">
  	      <div class="meta-content-output">
  	        <span class="sharing-options" data-modal-id="<?php echo $post->ID;?>">
              <?php 
                $url = get_permalink($post->ID);
                $title = get_the_title($post->ID);                
                $image_attr  = wp_get_attachment_image_src( get_the_ID(), 'full' );
                $shortcode_image = "";                
                
                if ($image_attr) {
                    $shortcode_image = $image_attr[0];
                }                
                
                echo do_shortcode('[easy-social-share buttons="facebook,twitter,pinterest,fave" counters=0 hide_names="force" template="light-retina" url="'.$url.'" text="'.$title.'" image="'.$shortcode_image.'"]');                 
              ?>
            </span>
          </div>
        </div>
      </div>

      <img src="<?php echo $image['sizes']['content-s']['url']; ?>"
        srcset="<?php echo $image['sizes']['content-m']['url'].' '.$image['sizes']['content-m']['width'].'w,'; ?>
                <?php echo $image['sizes']['full']['url'].' '.$image['sizes']['full']['width'].'w'; ?>" size="100vw" alt="<?php echo $image['alt']; ?>">         
      
      <a href="<?php echo custom_get_adjacent_image_link().'?details=gallery'; ?>" class="prev-img-link" title="<?php _e('Vorheriges Bild', 'fwbase'); ?>" aria-label="<?php _e('Vorheriges Bild', 'fwbase'); ?>">
        <span class="icon-links"></span> 
      </a> 
      <a href="<?php echo custom_get_adjacent_image_link(true).'?details=gallery'; ?>" class="next-img-link" title="<?php _e('N&auml;chstes Bild', 'fwbase'); ?>" aria-label="<?php _e('N&auml;chstes Bild', 'fwbase'); ?>">
        <span class="icon-rechts"></span> 
      </a> 
      
    </div>
    
    <?php if( $image['caption'] ) { ?>
      <div class="entry-content-text">
        <?php
          _e('Foto von:', 'fwbase'); 
          
          if( get_post_meta( $post->ID, 'opt_img_photograph', true) != '' ) {
            echo '<a href="http://'.get_post_meta( $post->ID, 'opt_img_photograph', true).'" title="" rel="nofollow" target="_blank"> <strong>'.$image['caption'].'</strong> </a>';
          } else {
            echo '<strong>'.$image['caption'].'</strong>';
          }
          
          echo $image['description'];
        ?>
      </div>
    <?php } ?>
    
  </div>	
</article>

<div class="remodal fav-modal-window" data-remodal-id="modal-<?php echo $post->ID;?>">
  <?php echo do_shortcode('[userpro_bookmark]'); ?>
</div>