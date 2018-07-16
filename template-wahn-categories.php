<?php
/**
 * Template Name: Wahnbuechlein Kategorie Uebersicht
 * Description: Template zur Darstellung aller Kategorien des Wahnbuechleins
 *
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package fwbase
 */

get_header(); ?>
  
  <header class="wahnbuch-header">
							
		<img src="<?php bloginfo('template_url'); ?>/img/elements/wahnbuch-header.jpg" alt="<?php _e('Die besten Hochzeits-Dienstleister im Wahnb&uuml;chlein', 'fwbase'); ?>" class="wahnbuch-header-img large-only">
				
    <div class="wahnbuch-header-info">
      <h1> <?php _e('Finde die <strong>Cr&egrave;me de la Cr&egrave;me</strong> der Hochzeitsdienstleister', 'fwbase'); ?> </h1>
      <p> 
        <?php _e('Das Hochzeitswahn Wahnb&uuml;chlein ist nicht einfach nur ein Branchenbuch aller Hochzeitsdienstleister, denn wir haben uns hier nur auf die cr&egrave;me de la cr&egrave;me von erstklassigen und megatalentierten Dienstleister beschr&auml;nkt, mit denen jede Hochzeit und Planung zu einem sorgenfreien Ereignis wird.', 'fwbase'); ?>
      </p>
    </div>
    
    <div class="wahnbuch-header-bewerben">
      <h5><?php _e('Bewirb dich jetzt', 'fwbase'); ?></h5>
      <p><?php _e('Wir sind immer auf der Suche nach neuen, Talentierten Dienstleistern. Wenn du meinst, Dass dein Auftritt hier fehlt, dann stell dich uns vor.', 'fwbase'); ?></p>
      <a href="<?php echo get_permalink(19547); ?>" class="button" title=""> <?php _e('Zum Bewerbungsformular', 'fwbase'); ?> </a>
    </div>
				
  </header>

  <main id="main" class="site-main" role="main">

    <nav class="sub-category-nav">
            
      <ul class="sub-cat-nav-catlist unstyled">
        <?php 
          $args = array(
        	  'style'              => 'list',
        	  'use_desc_for_title' => 0,
        	  'hierarchical'       => 0,
        	  'echo'               => 1,
        	  'taxonomy'           => 'wahn_categorie',
        	  'title_li'           => '<span>'.__( 'W&auml;hle eine Kategorie', 'fwbase' ).'</span>'          	  
          );
          wp_list_categories( $args );
        ?>
      </ul>
      
      <ul class="sub-cat-nav-catlist unstyled">
        <?php 
          $args = array(
        	  'style'              => 'list',
        	  'use_desc_for_title' => 0,
        	  'hierarchical'       => 0,
        	  'echo'               => 1,
        	  'taxonomy'           => 'wahn_region',
            'title_li'           => '<span>'.__( 'Suche in deiner Region:', 'fwbase' ).'</span>'
          );
          wp_list_categories( $args );
        ?>
      </ul>        
             
    </nav>  


		<section class="post-entry-listing">
			
		  <ul class="unstyled">
        
        <?php $wahn_categories = get_terms('wahn_categorie'); foreach($wahn_categories as $category) : ?>

          <li>  
          
            <article class="default-article-layout">

              <div class="entry-thumbnail">
                
                <a href="<?php echo get_term_link( $category ); ?>" title="<?php echo $category->name; ?>">
                
                  <div class="entry-description">
                    <?php echo $category->description; ?>                
                  </div>
                                  
                  <?php                     
                    $taxonomy = $category->taxonomy;
                    $term_id  = $category->term_id;  
                    $image = get_field('wahn_cat_img', $taxonomy . '_' . $term_id);
                    
                    if (! empty($image) ) {
                  
                    ?>
                      <img src="<?php echo $image['sizes']['thumbnail'] ?>"
                        srcset="<?php echo $image['sizes']['medium'].' '.$image['sizes']['medium-width'].'w'; ?>,
                                <?php echo $image['sizes']['large'].' '.$image['sizes']['large-width'].'w'; ?>" size="100vw" alt="<?php echo $image['alt']?>">
              
                  <?php } ?>
                </a>    
              </div>
            		
            	<div class="entry-content">  
                
                <h5 class="entry-title"> <a href="<?php echo get_term_link( $category ); ?>" title="<?php echo $category->name; ?>"> <?php echo $category->name; ?> </a> </h5>

            	</div>
            	
            </article>
          
          </li>
          
        <?php endforeach; ?> 
          
		  </ul>
			  			
		</section>

  </main>
  
  <div class="wahnbuch-footer-bewerben">
    <h2> <?php _e('Werde Dienstleister bei Hochzeitswahn', 'fwbase'); ?></h2>
    <p> <?php _e('Wir sind immer auf der Suche nach neuen, Talentierten Dienstleistern. Wenn du meinst, Dass dein Auftritt hier fehlt, dann stell dich uns vor.', 'fwbase'); ?> </p>
    <a class="button" href="<?php get_permalink(19547); ?>" title=" <?php _e('Zum Bewerbungsformular', 'fwbase'); ?>"> <?php _e('Zum Bewerbungsformular', 'fwbase'); ?> </a>
  </div>  
  
<?php get_footer(); ?>