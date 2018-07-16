<?php
/**
 * @package fwbase
 */
?>

<article>
  
  <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

    <div class="entry-thumbnail">
      
      <?php 
        
        if ( has_post_thumbnail() ) {
          
          $post_thumb_s   = wp_get_attachment_image_src( get_post_thumbnail_id(),'thumbnail' );
          //$post_thumb_m   = wp_get_attachment_image_src( get_post_thumbnail_id(),'medium' );
          $post_thumb_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
          $post_thumb_alt = ($post_thumb_alt == '' ? 'Inspiration auf Hochzeitswahn.de' : $post_thumb_alt);

              //<img src="<?php echo $post_thumb_s[0]; ? >" 
              //  srcset="<?php echo $post_thumb_m[0].' '.$post_thumb_m[1].'w'; ? >" size="100vw" alt="<?php echo $post_thumb_alt; ? >">
 
          ?>
          <img src="<?php echo $post_thumb_s[0]; ?>" alt="<?php echo $post_thumb_alt; ?>">
          <?php
        } 
      
      ?>
      
    </div>
    
    <?php the_title( '<h6 class="entry-title">', '</h6>' ); ?>

  </a>
  
</article>