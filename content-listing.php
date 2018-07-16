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
        $post_thumb_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
        $post_thumb_alt = ($post_thumb_alt == '' ? 'Inspiration auf Hochzeitswahn.de' : $post_thumb_alt);
    
        ?>
        <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>">
          <img src="<?php echo $post_thumb_s[0]; ?>" 
            srcset="<?php echo $post_thumb_m[0].' '.$post_thumb_m[1].'w'; ?>,
                    <?php echo $post_thumb_l[0].' '.$post_thumb_l[1].'w'; ?>" size="100vw" alt="<?php echo $post_thumb_alt; ?>">
        </a>        
        <?php
      } else { ?>
        <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>">
          <img src="<?php bloginfo('template_url'); ?>/img/lookbook_placeholder.jpg">
        </a>                        
      <?php    
      }
    ?>
  </div>
		
	<div class="entry-content">  

    <span class="entry-cats">
      <?php
        //Cats
        $post_terms      = get_the_terms( $post->ID, 'wahn_categorie' );
        if( count($post_terms) > 1) {

          $counter = 1;
          $term_output = '';
          
          foreach( $post_terms as $term) {
            if( $term->name != 'Alle Dienstleister') {
                           
              $term_output .= $term->name;
              
              if( $counter != count($post_terms) ) {
                $term_output .= ' / '; 
              }
            }
            
            $counter++;
          }
        } else {
          $post_terms_name = ($post_terms[0]->name != 'Alle Dienstleister') ? $post_terms[0]->name : __('Diverses', 'fwbase'); 
        }
                
        // Region       
        $post_region      = get_the_terms( $post->ID, 'wahn_region' );
        if( count($post_region) > 1) {

          $counter = 1;
          $post_region_name = '';
          
          foreach( $post_region as $term) {
                           
            $post_region_name .= $term->name;
              
            if( $counter != count($post_region) ) {
              $post_region_name .= ' / '; 
            }
            
            $counter++;
          }
        } else {
          $post_region_name = $post_region[0]->name; 
        }
              
        // Output
        echo '<em class="dl-entry-cat">'.$term_output.'</em> <em class="dl-entry-region">'.$post_region_name.'</em>'; 
      ?>
    </span>

    <?php                         
      if (strlen(get_the_title()) > 110) {
        echo '<h5 class="entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . substr(the_title($before = '', $after = '', FALSE), 0, 65) . '...' . '</a></h5>';
      } else { 
        the_title( sprintf( '<h5 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' ); 
      }
    ?>	
	</div>
	
</article>
