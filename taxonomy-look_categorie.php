<?php
/**
 * The template for displaying the lookbook tax pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package fwbase
 */

get_header(); ?>
  
  <header class="entry-header">  
    <h1 class="entry-title section-headline"> 
      <span>
      <?php 
        $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
        echo $term->name;
      ?>      
      </span> 
    </h1>
  </header><!-- .entry-header -->
							
  <main id="main" class="site-main" role="main">

    <?php 
            
      // Get all Lookbook posts to filter for grandchilds
      // ------------------------------------------------
      $args = array(
        'post_type' => 'hw_lookbook',
        'post_parent' => 0,
        'posts_per_page' => -1,
        'post_status' => 'publish'
      );
      
      $the_query = new WP_Query( $args );
      
		  if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
		  
        $grandparent_id = $post->ID;               
        $grandchildren_ids[] = $wpdb->get_col( $wpdb->prepare( "SELECT p1.ID FROM {$wpdb->posts} AS p1 INNER JOIN {$wpdb->posts} AS p2 ON p1.post_parent = p2.ID WHERE p2.post_parent = %d", $grandparent_id ) );
		  		  
		  endwhile; endif;
            
      $grandchildren_ids = call_user_func_array('array_merge', $grandchildren_ids);
  
      // Got all grandchilds. lets prepare the real query
      // ------------------------------------------------ 
      $look_category = $wp->query_vars['look_categorie']; 

      $args = array(
        'post__in' => $grandchildren_ids,
        'post_type' => 'hw_lookbook',
        'post_status' => 'publish',
        'posts_per_page' => -1, //16
        'paged' => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
        'orderby' => 'rand',
        'tax_query' => array(
          array(
            'taxonomy' => 'look_categorie',
            'field'    => 'slug',
            'terms'    => $look_category,
          ),
        ),
      );
      
      // Add filter queries if there are any
      // ------------------------------------------------
      $look_filter = ( isset($wp->query_vars['look_filter']) ) ? $wp->query_vars['look_filter'] : '';
      
      if( $look_filter != '') {    
        
        $look_filter = explode(',', $look_filter);
        $sorted_filters = array();
        
        foreach($look_filter as $filter) {
          $term = get_term_by('slug', $filter, 'look_filter'); 
          $sorted_filters[$term->parent][] = $term->slug;
        } 
        
        if( count($sorted_filters) >= 2) {
          $args['tax_query'] = array(
            'relation' => 'AND',
             array(
              'taxonomy' => 'look_categorie',
              'field'    => 'slug',
              'terms'    => $look_category,
            ),
          );
          foreach($sorted_filters as $filter) {
            $args['tax_query'][] = array(
           	  'taxonomy' => 'look_filter',
           	  'field'    => 'slug',
           	  'terms'    => $filter,
           	  'operator' => 'IN'               
            );
          }
        } else {
          $args['tax_query'] = array(
            'relation' => 'AND',
            array(
              'taxonomy' => 'look_categorie',
              'field'    => 'slug',
              'terms'    => $look_category,
            ),
            array(
              'taxonomy' => 'look_filter',
              'field'    => 'slug',
              'terms'    => $look_filter,
            ),
          );
        }
      }
            
      $gc_query = new WP_Query( $args );
      
      // Add some parameters for lazy load
      // ------------------------------------------------      
      $maxPages = $gc_query->max_num_pages;
      $paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
       
      wp_localize_script('fw-custom-js', 'fw_lazy_load', array(
      	'startPage' => $paged,
      	'maxPages' => $maxPages,
      	'nextLink' => next_posts($maxPages, false)
      	)
      );       
    ?>
    
    
		<?php 
  	  // Enough chitchat, lets query:
      // ------------------------------------------------
  		if ( $gc_query->have_posts() ) : 
    ?>		
    
      <nav class="sub-category-nav lookbook-filter">
              
        <ul class="sub-cat-nav-catlist unstyled">
          <?php 
            $args = array(
            	'hide_empty'    => 1,
            	'hierarchical'  => 0,
            	'parent'        => 0,
            	'taxonomy'      => 'look_filter'
            ); 

            $categories = get_categories( $args );

            foreach ($categories as $category) {

              $subargs = array(
              	'hide_empty'    => 1,
              	'hierarchical'  => 0,
              	'parent'        => $category->cat_ID,
              	'taxonomy'      => 'look_filter'
              ); 
              
              $subcategories = get_categories( $subargs );
              
              echo '<li class="filter-title" data-filter-parent="'.$category->slug.'">'.$category->name.' <ul class="children">';
              
              foreach ($subcategories as $subcategory ) {
                if( is_array($look_filter) && in_array($subcategory->slug, $look_filter) ) {
                  echo '<li data-filter="'.$subcategory->slug.'" class="active">'.$subcategory->name.'</li>';
                } else {
                  echo '<li data-filter="'.$subcategory->slug.'">'.$subcategory->name.'</li>';
                } 
              }
              
              echo '</ul> </li>';
            }    
          ?>
        </ul>
        
        <a class="button submit" href="<?php echo esc_url(home_url(add_query_arg(array(),$wp->request))); ?>" title="<?php _e('Filter die Produkte', 'fwbase'); ?>"><?php _e('Filtern', 'fwbase'); ?></a>
            
      </nav>			
			
			<?php if( is_array($look_filter) && count($look_filter) > 0 ) : ?>
			<div class="delete-filters">
  		  <a class="filter-to-delte" href="<?php echo esc_url(home_url('/lookbook/')); ?>" title="<?php _e('Alle Filter l&ouml;schen', 'fwbase'); ?>"><?php _e('Alle Filter l&ouml;schen', 'fwbase'); ?></a>
  		  
  		  <?php foreach( $look_filter as $delete_filter ) : if( $delete_filter != '' ) : $cleanURL = str_replace($delete_filter.',', '', $_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']); ?>		  
    		  <a class="filter-to-delete" href="<?php echo esc_url($cleanURL); ?>" title="<?php _e('Filter l&ouml;schen', 'fwbase'); ?>"> <?php echo $delete_filter; ?> </a>
    		<?php endif; endforeach; ?>
  		</div>
			<?php endif; ?>			
			
			<section class="lookbook-listing">
			
			  <ul class="unstyled">
          
          <?php 
            
            $counter = 1;
            
            while ( $gc_query->have_posts() ) : $gc_query->the_post(); ?>
              
              <li <?php if( $counter == 1 ) echo 'class="first-img"'; ?>>
                
                <div class="entry-thumbnail">
                   <?php 
                     if ( has_post_thumbnail() ) {
                       
                       $post_thumb_s   = wp_get_attachment_image_src( get_post_thumbnail_id(),'lookbook' );
                       $post_thumb_m   = wp_get_attachment_image_src( get_post_thumbnail_id(),'lookbook' );
                       $post_thumb_l   = wp_get_attachment_image_src( get_post_thumbnail_id(),'lookbook' );
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
                   
                   <div class="entry-content">
                     <?php
                        
                      $parent = ($post->post_parent > 0) ? get_post($post->post_parent) : '';
                      $grandparent = ($parent->post_parent > 0) ? $parent->post_parent : '';
                      $grandparent_title = get_the_title($grandparent);
                       
                      echo '<a href="'.get_permalink($grandparent).'" title="'.__('Zum Designer', 'fwbase').'">'.$grandparent_title.'</a>';

                       if (strlen(get_the_title()) > 110) {
                         echo '<h6 class="entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . substr(the_title($before = '', $after = '', FALSE), 0, 65) . '...' . '</a></h6>';
                       } else { 
                         the_title( sprintf( '<h6 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' ); 
                       }
                     ?>	
                   </div>                
                   
                 </div>
              </li>
                 
            <?php                 
              
            $counter++; endwhile;

          ?>
          
			  </ul>
			  			
			</section>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

  </main>

  <?php //fwbase_paging_nav(); ?>

<?php get_footer(); ?>