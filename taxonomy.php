<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : $post_counter = 1; ?>

			<header class="page-header">
				<h1 class="page-title section-headline"> <span>
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides', 'fwbase' );

						elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
							_e( 'Galleries', 'fwbase' );

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'fwbase' );

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'fwbase' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes', 'fwbase' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links', 'fwbase' );

						elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
							_e( 'Statuses', 'fwbase' );

						elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
							_e( 'Audios', 'fwbase' );

						elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
							_e( 'Chats', 'fwbase' );

						else :
							_e( 'Archives', 'fwbase' );

						endif;
					?>
				</span> </h1>
			</header>
			
      <nav class="sub-category-nav">
              
        <ul class="sub-cat-nav-catlist unstyled">
          <?php 
            $args = array(
          	  'style'              => 'list',
          	  'use_desc_for_title' => 0,
          	  'hierarchical'       => 1,
          	  'echo'               => 1,
          	  'taxonomy'           => 'category',
            );
            wp_list_categories( $args );
          ?>
        </ul>
               
      </nav>  			
			
			<?php while ( have_posts() ) : the_post(); ?>

        <?php 
          
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
                  'cat' => 9,
                  //'post_type' => 'hw_wahnbuechlein',
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
                                  <?php echo $post_thumb_l[0].' '.$post_thumb_l[1].'w'; ?>" alt="<?php echo $post_thumb_alt; ?>">
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
          
      		  get_template_part( 'content' );
      		
      		endif;
      	?>     
      	
      <?php $post_counter++; endwhile; ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main>

  	<?php fwbase_paging_nav(); ?>

	</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>





