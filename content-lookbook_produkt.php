<?php
/**
 * @package fwbase
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header class="entry-header">

    <span> 
      <a href="<?php echo esc_url( home_url( '/lookbook/' ) ); ?>" title="<?php _e('Zur &Uuml;bersicht', 'fwbase'); ?>" class=""><?php _e('Zur &Uuml;bersicht', 'fwbase'); ?></a> | 
      <a href="<?php echo get_permalink($grandparent); ?>" title="<?php _e('Zum Designer', 'fwbase'); ?>" class=""><?php _e('Zum Designer', 'fwbase'); ?></a> | 
      <a href="<?php echo get_permalink($parent); ?>" title="<?php _e('Zur Kollektion', 'fwbase'); ?>" class=""><?php _e('Zur Kollektion', 'fwbase'); ?></a> 
    </span>

	</header>


	<div class="entry-content">
        
    <div class="entry-slider-lookbook">
      
		  <?php
      
      $gallery = get_field('lookbook_prod_galery');
                                    
      ?>

      <ul class="lookbook-slider unstyled">
                          
        <?php foreach( $gallery as $image ): ?>
                                 
        <li <?php if ( $image['height'] > $image['width'] || get_post_meta($image['ID'], 'fw_media_class', true) == 'portrait') { echo 'class="portrait"'; } ?>> 
             
          <img src="<?php echo $image['sizes']['content-s'] ?>"
            srcset="<?php echo $image['sizes']['content-m'].' '.$image['sizes']['content-m-width'].'w'; ?>,
                    <?php echo $image['sizes']['content-l'].' '.$image['sizes']['content-l-width'].'w'; ?>" size="100vw" alt="<?php echo $image['alt']?>">                  
          
        </li>
  
        <?php endforeach; ?>

      </ul>
      
      <ul class="lookbook-slider-nav unstyled">
        
        <?php $nav_counter = 1; foreach( $gallery as $image ): ?>
                                 
        <li class="prod-thumbnail <?php if ( $image['height'] > $image['width'] || get_post_meta($image['ID'], 'fw_media_class', true) == 'portrait') { echo 'portrait'; } ?>"> 
             
          <img src="<?php echo $image['sizes']['content-s'] ?>" alt="Thumbnail" data-slick-index="<?php echo $nav_counter; ?>"> 
                                  
        </li>
  
        <?php $nav_counter++; endforeach; ?>
                
      </ul>  
      
    </div>
    
    
    <div class="entry-prod-info">
      
      <h3> <?php the_title(); ?> <small> <?php echo '<a href="'.get_permalink($grandparent).'">'.$grandparent_title.'</a>'; ?> </small> </h3>
      
      <span class="prod-info-price"> <?php the_field('lookbook_prod_price'); ?> </span>
      
      <?php the_field('lookbook_prod_descr'); ?>
     
      <div class="entry-prod-meta">
        <?php _e('Kollektion: ', 'fwbase'); ?> <a href="<?php echo get_permalink($parent); ?>" title="<?php _e('Komplette Kollektionen', 'fwbase');?>"> <?php echo $parent_title; ?> </a>         
        <?php $children = get_children( array('post_parent' => $grandparent,'post_type' => 'hw_lookbook ') ); if( count( $children ) > 1 ) : ?>        
          | <a href="<?php echo get_permalink($grandparent); ?>" title="<?php _e('Andere Kollektionen', 'fwbase');?>"> <?php _e('Weitere Kollektionen', 'fwbase');?> </a>
        <?php endif; ?>
        
        <span>
          <?php 
            $colors = get_the_terms( $post->ID, 'look_filter' );

            function removeNonColors($var) {              
              if( $var->parent == 5682 ) {
                return($var);
              }
            }
            
            $colors = array_filter($colors, 'removeNonColors');
                        
            if( $colors ) :
              _e('Farbe: ', 'fwbase');  
  
              foreach( $colors as $color ) {
                echo '<i>'.$color->name.'</i>';
                if ($color !== end($colors)) echo ', ';
              }
              
            endif; 
          ?> 
        </span>
         
      </div>
  
      <?php if( get_field('lookbook_prod_buy') ) : ?>
        <a class="button" href="<?php the_field('lookbook_prod_buy'); ?>" title="<?php _e('Zum Produkt', 'fwbase'); ?>" rel="nofollow" target="_blank"> <?php _e('Zum Produkt', 'fwbase'); ?> </a>
      <?php endif; ?>  
        
      <div class="sharing-options" data-modal-id="<?php echo get_the_ID(); ?>">
        <?php echo do_shortcode('[easy-social-share buttons="facebook,twitter,pinterest,fave" counters=0 hide_names="force" template="light-retina"]'); ?>
      </div>  
      
    </div>
	
	</div>

	<footer class="entry-footer"></footer>

  <div class="remodal fav-modal-window" data-remodal-id="modal-<?php echo $post->ID; ?>">
    <?php echo do_shortcode('[userpro_bookmark]'); ?>
  </div>   

</article>

  		
<?php
    
  $currentPost = $post->ID;
    
  $args = array(
    'post_type' => 'hw_lookbook',
    'post_parent' => $parent->ID,
    'post__not_in' => array($currentPost),
    'posts_per_page'  => -1,
    'orderby' => 'DESC',
  );
    
  $collection_Query = new WP_Query( $args );
  if ( $collection_Query->have_posts() ) : 

 ?>
  
  <div class="dienstleister-section">
  
    <h3 class="section-headline"> <span><?php _e( 'Weitere Produkte dieser Kollektion', 'fwbase' ); ?></span> </h3>
                      
    <ul class="dienstleister-section-selection unstyled">
        
      <?php while ( $collection_Query->have_posts() ) : $collection_Query->the_post(); if( $currentPost != $post->ID ) : ?>
          
      <li> 
        <?php 
          if ( has_post_thumbnail() ) {
            
            $post_thumb_s   = wp_get_attachment_image_src( get_post_thumbnail_id(),'thumbsplit-s' );
            $post_thumb_m   = wp_get_attachment_image_src( get_post_thumbnail_id(),'thumbsplit-m' );
            $post_thumb_l   = wp_get_attachment_image_src( get_post_thumbnail_id(),'thumbsplit-l' );
            $post_thumb_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
            $post_thumb_alt = ($post_thumb_alt == '' ? 'Die besten Hochzeitsdienstleister bei Hochzeitswahn.de' : $post_thumb_alt);
        
            ?>
            <a href="<?php echo get_permalink(); ?>" title="<?php _e('Produkt ansehen', 'fwbase'); ?>">
                                  
              <img src="<?php echo $post_thumb_s[0]; ?>" 
                srcset="<?php echo $post_thumb_m[0].' '.$post_thumb_m[1].'w'; ?>,
                        <?php echo $post_thumb_l[0].' '.$post_thumb_l[1].'w'; ?>" size="100vw" alt="<?php echo $post_thumb_alt; ?>">
                                                  
            </a>
          <?php
          } 
        ?>                   
      </li>
          
      <?php endif; endwhile; wp_reset_postdata(); ?>
          
    </ul>

  </div>

<?php endif; ?>
