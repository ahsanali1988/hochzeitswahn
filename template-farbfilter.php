<?php
/**
 * Template Name: Farbfilter Page
 * Description: Template zur Darstellung von Posts nach Farbe gefiltert
 *
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package fwbase
 */

get_header(); 

// Add some parameters for lazy load
$maxPages = $wp_query->max_num_pages;
$paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
 
wp_localize_script('fw-custom-js', 'fw_lazy_load', array(
		'startPage' => $paged,
		'maxPages' => $maxPages,
		'nextLink' => next_posts($maxPages, false)
	)
);

// Get all custom ad rows
$adrows = get_field('opt_ads_repeater', 'option');
  
?>

  <main id="main" class="site-main" role="main">

  <?php 
    $filterfarbe = $wp->query_vars['farbfilter'];        

    $args = array(
      'post_type' => 'post',
      'posts_per_page'  => 16,
      'orderby' => 'date',
      'meta_key' => 'post_fields_farbfilter',        
      'meta_key'    => 'post_fields_farbfilter', 
      'meta_value'  => $filterfarbe,
      'meta_compare' => 'LIKE',        
    );
          
    $the_query = new WP_Query( $args );
      
    // Add some parameters for lazy load
    $maxPages = $the_query->max_num_pages;
    $paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
     
    wp_localize_script('fw-custom-js', 'fw_lazy_load', array(
    		'startPage' => $paged,
    		'maxPages' => $maxPages,
    		'nextLink' => next_posts($maxPages, false)
    	)
    );
  ?>

  <header class="page-header">
    <h1 class="page-title section-headline"> 
    	<span>
    	  <?php echo __('Farbfilter:', 'fwbase').' '.$filterfarbe; ?> 
    	</span> 
    </h1>
  </header>

  <main id="main" class="site-main" role="main">

	<?php if ( $the_query->have_posts() ) : $post_counter = 1; $current_paged = get_query_var('paged'); ?>			
			
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

      <?php 
        
        // Check if at least 14 posts are available, if not we need to alter the layout       
        if( $the_query->post_count < 14 ) {
                    
          //odd 
          if ( ($post_counter%2) != 0 && $post_counter != $the_query->post_count ) {
            
            echo '<section class="article-row default-row-layout">';
      	    get_template_part( 'content', get_post_format() ) ;
          
          }
          
          //even
          if ( ($post_counter%2) == 0) {
      	    get_template_part( 'content', get_post_format() ) ;
      	    
            echo '</section>';
      	    
            //Ad section ?>
            <div class="ad-section ad-2col">
              
              <div class="ad-2col-left ad-small-four">
                <img src="http://placehold.it/300x250" alt="Placeholder Medium">
                <img src="http://placehold.it/300x250" alt="Placeholder Medium">
              </div>
              
              <div class="ad-2col-right ad-small-four">
                <img src="http://placehold.it/300x100" alt="Placeholder Rectangle">
                <img src="http://placehold.it/300x100" alt="Placeholder Rectangle" class="medium-up">
                <img src="http://placehold.it/300x100" alt="Placeholder Rectangle" class="medium-up">
                <img src="http://placehold.it/300x100" alt="Placeholder Rectangle" class="medium-up">
              </div>
            
            </div> <?php
          
          }     
          
          //if odd and last one!
          if ( ($post_counter%2) != 0 && $post_counter == $the_query->post_count ) {
            
            echo '<section class="article-row default-row-layout">';
      	    get_template_part( 'content', get_post_format() ) ;
            echo '</section>';
          }
        
        // Ok, seems like we have more than 14 posts available, start the complex layout       
        } else {
                    
          if ( $post_counter == 1 ) :
            
          echo '<section class="article-row default-row-layout">';
      		  
      		  get_template_part( 'content', get_post_format() ) ;
          
          elseif ( $post_counter == 2) :
          
      		  get_template_part( 'content', get_post_format() ) ;
      		  
      		echo '</section>';
      		  
          //Ad section ?>
          <div class="ad-section ad-2col">
            
            <div class="ad-2col-left ad-medium-two">
              <img src="http://placehold.it/300x250" alt="Placeholder Medium">
              <img src="http://placehold.it/300x250" alt="Placeholder Medium">
            </div>
            
            <div class="ad-2col-right ad-small-four">
              <img src="http://placehold.it/300x100" alt="Placeholder Rectangle">
              <img src="http://placehold.it/300x100" alt="Placeholder Rectangle" class="medium-up">
              <img src="http://placehold.it/300x100" alt="Placeholder Rectangle" class="medium-up">
              <img src="http://placehold.it/300x100" alt="Placeholder Rectangle" class="medium-up">
            </div>
          
          </div>
          
          <?php
            
          elseif ( $post_counter == 3 ): 
            
            echo '<section class="article-row default-row-layout">';
            
      		  get_template_part( 'content', get_post_format() );
          
          elseif ( $post_counter == 4 ) :
          
      		  get_template_part( 'content', get_post_format() );
      		  
      		  echo '</section>';
      	  
          elseif ( $post_counter == 5 ): 
            
            echo '<section class="article-row default-row-layout">';
            
      		  get_template_part( 'content', get_post_format() );      
      		      
          elseif ( $post_counter == 6 ) :
          
      		  get_template_part( 'content', get_post_format() );
      		  
      		  echo '</section>';
      	  
          elseif ( $post_counter == 7 ) :
          
      		  //get_template_part( 'content', 'module-a' );

	          include(locate_template('content-module-a.php'));

            //Service section ?>
              
            <div class="dienstleister-section medium-up">
            
              <h3 class="section-headline"> <span> <?php _e('Plant eure Hochzeit mit Anbietern, die wir empfehlen!', 'fwbase'); ?> </span> </h3>
              
              <div class="dienstleister-section-intro">
                <div>
                  <h2> <?php _e('Die besten Hochzeits&shy;dienstleister in einer &Uuml;bersicht', 'fwbase'); ?> </h2>
                  <a href="" class="button"> <?php _e('Finde alle Hochzeitsanbieter hier', 'fwbase'); ?> </a>
                </div>
              </div>
              
              <?php 
                
                $sub_Query = new WP_Query( array(
                  'post_type' => 'hw_wahnbuechlein',
                  'posts_per_page'  => 3,
                  'orderby' => 'rand',
                  'date_query' => array(
                    'after' => date('Y-m-d', strtotime('-360 days')) 
                  )
                ));
            
                if ( $sub_Query->have_posts() ) : 
              
              ?>
                            
              <ul class="dienstleister-section-selection unstyled">
              
                <?php while ( $sub_Query->have_posts() ) : $sub_Query->the_post(); ?>
                
                <li> 
                  <div class="dienstleister-entry-content">
                    <?php the_title(); ?>
                  </div>
          
                  <?php 
                    if ( has_post_thumbnail() ) {
                      
                      $post_thumb_s   = wp_get_attachment_image_src( get_post_thumbnail_id(),'service-s' );
                      $post_thumb_m   = wp_get_attachment_image_src( get_post_thumbnail_id(),'service-m' );
                      $post_thumb_l   = wp_get_attachment_image_src( get_post_thumbnail_id(),'service-xl' );
                      $post_thumb_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
                      $post_thumb_alt = ($post_thumb_alt == '' ? 'Die besten Hochzeitsdienstleister bei Hochzeitswahn.de' : $post_thumb_alt);
                  
                      ?>
                      <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>">
                        <img src="<?php echo $post_thumb_s[0]; ?>" 
                          srcset="<?php echo $post_thumb_m[0].' '.$post_thumb_m[1].'w'; ?>,
                                  <?php echo $post_thumb_l[0].' '.$post_thumb_l[1].'w'; ?>" size="100vw" alt="<?php echo $post_thumb_alt; ?>">
                      </a>
                      <?php
                    } 
                  ?>                  
                  
                                   
                </li>
                
                <?php endwhile; wp_reset_postdata(); ?>
                
              </ul>
              
              <?php endif; ?>  
                             
            </div>        	
      	  
          <?php
      	    
          elseif ( $post_counter == 8 ) :
            
      		  get_template_part( 'content', 'module-c' );
      	  
          elseif ( $post_counter == 9 ): 
            
            echo '<section class="article-row default-row-layout">';
            
      		  get_template_part( 'content', get_post_format() ); 
      		           
          elseif ( $post_counter == 10 ) :
          
            get_template_part( 'content', get_post_format() );
            
      		  echo '</section>'; 
      		  
      		  // Ad section ?>
      		  <div class="ad-section ad-2col">
              
              <div class="ad-2col-left ad-small-two">
              </div>
              
              <div class="ad-2col-right medium-up ad-small-two">
              </div>
            
            </div>    
      		  <?php
        	 
          elseif ( $post_counter == 11 ) :
          
      		  //get_template_part( 'content', 'module-a' );

	          include(locate_template('content-module-a.php'));
	                	  
          elseif ( $post_counter == 12 ) :
            
            echo '<section class="article-row default-row-layout">';
            
      		  get_template_part( 'content', get_post_format() );
      		           
          elseif ( $post_counter == 13 ) :
          
      		  get_template_part( 'content', get_post_format() );
          
      		  echo '</section>'; 
          
          elseif ( $post_counter == 14 ) :
          
      		  get_template_part( 'content', 'module-c' );
      	  
          elseif ( $post_counter > 14 ) :
              
            if( $post_counter-1 == 14 ) echo '<section class="article-row default-row-layout last-final-row">';

              get_template_part( 'content' );      
            
            if( $post_counter == $the_query->post_count ) echo '</section>';
                		
      		endif;
      		
        }
      		
      ?>     
      	
    <?php $post_counter++; endwhile; ?>
          
    <div class="ad-section ad-2col">
      
      <div class="ad-2col-left ad-small-two">
      </div>
      
      <div class="ad-2col-right medium-up ad-small-two">
      </div>
    
    </div>    
      
    <?php else : ?>
    
      <?php get_template_part( 'content', 'none' ); ?>
    
    <?php endif; ?>
        
  </main>

  <?php fwbase_paging_nav(); ?>  

<?php get_footer(); ?>
