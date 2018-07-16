<?php
/**
 * @package fwbase
 */
 
  // Check if we need the designer or collection ID
  $detailsID = ($parent && !$grandparent) ? $parent : $post->ID;
 
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('lookbook-designer'); ?>>

  <?php if($parent && !$grandparent) : ?>
	<header class="entry-header collection-header">
    <span> 
      <a href="<?php echo esc_url( home_url( '/lookbook/' ) ); ?>" title="<?php _e('Zur &Uuml;bersicht', 'fwbase'); ?>" class=""><?php _e('Zur &Uuml;bersicht', 'fwbase'); ?></a> | 
      <a href="<?php echo get_permalink($parent); ?>" title="<?php _e('Zum Designer', 'fwbase'); ?>" class=""><?php _e('Zum Designer', 'fwbase'); ?></a>
    </span>
	</header>
	<?php endif; ?>
	
  <?php if(!$parent && !$grandparent) : ?>
	<header class="entry-header collection-header">
    <span> 
      <a href="<?php echo esc_url( home_url( '/lookbook/' ) ); ?>" title="<?php _e('Zur &Uuml;bersicht', 'fwbase'); ?>" class=""><?php _e('Zur &Uuml;bersicht', 'fwbase'); ?></a>
    </span>
	</header>
	<?php endif; ?>


  <aside class="entry-details">
    
    <div class="entry-details-top">
      
      <div class="details-top-img">
        <?php          
          if( get_field('look_profil_logo', $detailsID) ) {            
            $logo = get_field('look_profil_logo', $detailsID);
            echo '<img src="'.$logo['url'].'" alt="'.$logo['alt'].'">';
          } else {
            echo '<img alt="Profil" src="'.get_bloginfo('template_url').'/img/placeholder.jpg">';
          }
        ?>  
        <span class="sharing-options" data-modal-id="<?php echo $detailsID->ID;?>">              
          <a class="button link-fave" href="#" title="<?php _e('Als Favorit speichern','fwbase');?>"><span class="icon-hertz"></span><?php _e('Als Favorit speichern','fwbase');?></a>
        </span>
      </div>
      
      <div class="details-top-content">
        <h1> <?php the_field('look_profil_name', $detailsID); ?> </h1>
        
        <ul class="unstyled details-top-content-basics">
          <?php if( get_field('look_profil_website', $detailsID) ) : ?> <li> <a href="<?php the_field('look_profil_website', $detailsID); ?>" title="Website" target="_blank">Zur Webseite</a> </li> <?php endif; ?>
          <?php if( get_field('look_profil_email', $detailsID) ) : ?> <li> <a href="#modal-contact_DL" title=""> Unverbindlich anfragen </a> </li> <?php endif; ?>
          <?php if( get_field('look_profil_telefon', $detailsID) ) : ?> <li> <span><?php _e('Telefon:', 'fwbase'); ?></span> <?php the_field('look_profil_telefon', $detailsID); ?> </li> <?php endif; ?>                      
        </ul>
       
        <ul class="unstyled details-top-content-social">
          <?php if( get_field('look_facebook', $detailsID) ) :   ?> <li> <a href="<?php the_field('look_facebook', $detailsID);   ?>" target="_blank" title="Facebook" rel="nofollow"> <span class="icon-facebook"></span> </a> </li> <?php endif; ?>
          <?php if( get_field('look_twitter', $detailsID) ) :    ?> <li> <a href="<?php the_field('look_twitter', $detailsID);    ?>" target="_blank" title="Twitter" rel="nofollow"> <span class="icon-twitter"></span> </a> </li> <?php endif; ?>
          <?php if( get_field('look_pinterest', $detailsID) ) :  ?> <li> <a href="<?php the_field('look_pinterest', $detailsID);  ?>" target="_blank" title="Pinterest" rel="nofollow"> <span class="icon-pinterest"></span> </a> </li> <?php endif; ?>
          <?php if( get_field('look_instagram', $detailsID) ) :  ?> <li> <a href="<?php the_field('look_instagram', $detailsID);  ?>" target="_blank" title="Instagram" rel="nofollow"> <span class="icon-instagram"></span> </a> </li> <?php endif; ?>
          <?php if( get_field('look_googleplus', $detailsID) ) : ?> <li> <a href="<?php the_field('look_googleplus', $detailsID); ?>" target="_blank" title="Google Plus" rel="nofollow"> <span class="icon-google"></span> </a> </li> <?php endif; ?>
          <?php if( get_field('look_blog', $detailsID) ) :       ?> <li> <a href="<?php the_field('look_blog', $detailsID);       ?>" target="_blank" title="Blog" rel="nofollow"> <span class="icon-blog"></span> </a> </li> <?php endif; ?>
        </ul>
        
      </div>
      
    </div>
    
    <div class="entry-details-descr">
      <?php the_field('look_profil_description', $detailsID); ?>
    </div> 
    
    <?php if( get_field('look_profil_email') ) : ?>
      <a class="entry-details-contact button" href="#modal-contact_DL" title="<?php _e('Kontaktiere diesen Designer','fwbase'); ?>"> <?php _e('Kontaktiere diesen Designer','fwbase'); ?> </a>
    <?php endif;?>      
  </aside>


	<div class="entry-content">
  	
  	<h3 class="section-headline"> <span> 
    	<?php 
      	if( $parent && !$grandparent ) { the_title(); } else { _e('Kollektionen', 'fwbase'); }
      ?> 
    </span> </h3>
  	
    <?php 
      $args = array( 
        'posts_per_page' => -1, 
        'post_type' => 'hw_lookbook',
        'orderby' => 'title',
        'post_parent' => $post->ID
      );
      
      $collections = get_posts( $args );

      if( $collections ) :

    ?>
    
     <ul class="unstyled">

  		<?php        
        foreach ( $collections as $post ) : setup_postdata( $post );
      ?>  			  
  			  
      <li>
            
        <div class="collection-entry">

          <div class="entry-thumbnail">
            <?php 
              if ( has_post_thumbnail() ) {
                
                $post_thumb_s   = wp_get_attachment_image_src( get_post_thumbnail_id(),'thumbsplit-s' );
                $post_thumb_m   = wp_get_attachment_image_src( get_post_thumbnail_id(),'thumbsplit-m' );
                $post_thumb_l   = wp_get_attachment_image_src( get_post_thumbnail_id(),'thumbsplit-l' );
                $post_thumb_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
                $post_thumb_alt = ($post_thumb_alt == '' ? 'Inspiration auf Hochzeitswahn.de' : $post_thumb_alt);
            
                ?>
                <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>">
                  <img src="<?php echo $post_thumb_s[0]; ?>" 
                    srcset="<?php echo $post_thumb_m[0].' '.$post_thumb_m[1].'w'; ?>,
                            <?php echo $post_thumb_l[0].' '.$post_thumb_l[1].'w'; ?>" size="100vw" alt="<?php echo $post_thumb_alt; ?>">
                </a>        
                <?php
              } 
            ?>
          </div>
		
          <div class="entry-content">  
            <?php                         
              if (strlen(get_the_title()) > 110) {
                echo '<h5 class="entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . substr(the_title($before = '', $after = '', FALSE), 0, 65) . '...' . '</a></h5>';
              } else { 
                the_title( sprintf( '<h5 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' ); 
              }
            ?>	
          </div>
	
        </div>
      
      </li>
      
      <?php
        endforeach; wp_reset_postdata();	  
      ?>
      	
    </ul>
    
    <?php endif; ?>
    
	</div>

	<footer class="entry-footer"></footer>

</article>

<?php if( get_field('look_profil_email') ) : ?>
  <div class="remodal fav-modal-window" data-remodal-id="modal-contact_DL">
    <strong><?php _e('Sende dem Designer eine Nachricht', 'fwbase'); ?></strong>
    <p><?php _e('Nutze das Formular, um den Designer direkt zu kontaktieren.', 'fwbase'); ?></p>
    <?php gravity_form(8, false, false, false, '', true, 100); ?>
  </div>
<?php endif; ?>  

<div class="remodal fav-modal-window" data-remodal-id="modal-<?php echo $detailsID->ID;?>">
  <?php echo do_shortcode('[userpro_bookmark]'); ?>
</div>