<?php
/**
 * @package fwbase
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('default-article-layout'); ?>>

  <div class="entry-thumbnail">
    <?php 
      if ( has_post_thumbnail() ) {
        
        $post_thumb_s   = wp_get_attachment_image_src( get_post_thumbnail_id(),'thumbnail' );
        $post_thumb_m   = wp_get_attachment_image_src( get_post_thumbnail_id(),'medium' );
        $post_thumb_l   = wp_get_attachment_image_src( get_post_thumbnail_id(),'large' );
        $post_thumb_xl  = wp_get_attachment_image_src( get_post_thumbnail_id(),'xlarge' );        
        $post_thumb_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
        $post_thumb_alt = ($post_thumb_alt == '' ? 'Inspiration auf Hochzeitswahn.de' : $post_thumb_alt);
    
        ?>
        <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>">
          <img src="<?php echo $post_thumb_s[0]; ?>" 
            srcset="<?php echo $post_thumb_m[0].' '.$post_thumb_m[1].'w'; ?>,
                    <?php echo $post_thumb_l[0].' '.$post_thumb_l[1].'w'; ?>,
                    <?php echo $post_thumb_xl[0].' '.$post_thumb_xl[1].'w'; ?>" size="100vw" alt="<?php echo $post_thumb_alt; ?>">
        </a>        
        <?php
      } 
    ?>
  </div>
		
	<div class="entry-content">  
    <div class="entry-meta">
	    <?php fwbase_posted_on(); ?>
	    <?php fwbase_entry_meta(); ?>
    </div>
    
    <?php                         
      if (strlen(get_the_title()) > 110) {
        echo '<h5 class="entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . substr(the_title($before = '', $after = '', FALSE), 0, 65) . '...' . '</a></h5>';
      } else { 
        the_title( sprintf( '<h5 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' ); 
      }
    ?>	
	</div>
  
  <div class="remodal fav-modal-window" data-remodal-id="modal-<?php echo $post->ID;?>">
    <?php echo do_shortcode('[userpro_bookmark]'); ?>
  </div> 
  
</article>