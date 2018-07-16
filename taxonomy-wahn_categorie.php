<?php
/**
 * The template for displaying the wahnbuch cat pages.
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

$term_name = get_term_by( 'id', $wp_query->get_queried_object_id(), 'wahn_categorie' );

?>
  
  <header class="wahnbuch-header">
							
		<img src="<?php bloginfo('template_url'); ?>/img/elements/wahnbuch-header.jpg" alt="<?php _e('Die besten Hochzeits-Dienstleister im Wahnb&uuml;chlein', 'fwbase'); ?>" class="wahnbuch-header-img large-only">
				
    <div class="wahnbuch-header-info">
      <h1> 
        <?php 
          if ($term_name->slug == 'allgemein') { $term_name->name = 'deine Traumhochzeit'; }
          printf( __( 'Finde die besten Dienstleister f&uuml;r <strong>%s</strong>', 'fwbase' ), $term_name->name ); 
        ?> 
      </h1>
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

		<?php if ( have_posts() ) : ?>
			
      <nav class="sub-category-nav">

        <ul class="sub-cat-nav-catlist unstyled">
          <?php             
            $terms = get_terms('wahn_categorie');
            $add_query = ( get_query_var( 'wahn_region' ) != '' ) ? '?wahn_region='.get_query_var( 'wahn_region' ) : '';
                            
            echo '<li class="wahn_category"> <span>'. __( 'W&auml;hle eine Kategorie:', 'fwbase' ) .'</span>';
            echo '<ul>';
              echo '<li class="tags_overview"> <a href="'.get_permalink(3192).'" title="'.__('Alle Kategorien ansehen', 'fwbase').'">'.__('Kategorie-&Uuml;berblick', 'fwbase').'</a> </li>';            
              foreach( $terms as $term ) {
                if( $term_name->slug === $term->slug ) {
                  echo '<li class="active"> <a href="'.get_term_link( $term->slug, 'wahn_categorie' ).$add_query.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';
                } else {                
                  echo '<li> <a href="'.get_term_link( $term->slug, 'wahn_categorie' ).$add_query.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';
                }
              }
            echo '</ul> </li>';            
            
          ?>
        </ul>

        <ul class="sub-cat-nav-catlist unstyled">
          <?php             
            $current_url = esc_url(home_url(add_query_arg(array(),$wp->request)));          
            $reg_query = ( get_query_var( 'wahn_region' ) != '' ) ? get_query_var( 'wahn_region' ) : '';
            $terms = get_terms('wahn_region');

            echo '<li class="wahn_region"> <span>'. __( 'Suche in deiner Region:', 'fwbase' ) .'</span>';
            echo '<ul>';
              echo '<li class="tags_overview"> <a href="'.esc_url(remove_query_arg( 'wahn_region',  $current_url)).'" title="Alle Regionen" rel="nofollow">Alle Regionen</a> </li>';
              foreach( $terms as $term ) {
                if( $term->slug === $reg_query ) {
                  echo '<li class="active"> <a href="'.$current_url.'/?wahn_region='.$term->slug.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';
                } else {
                  echo '<li> <a href="'.$current_url.'/?wahn_region='.$term->slug.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>'; 
                }
              }
            echo '</ul> </li>';
          ?>
        </ul>        

      </nav>  			
			
			<section class="post-entry-listing">
			
			  <ul class="unstyled">
  			  
          <?php while ( have_posts() ) : the_post(); ?>

            <li> <?php get_template_part( 'content', 'listing' ); ?> </li>
      	
          <?php endwhile; ?>
          
			  </ul>
			  			
			</section>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>
    
  </main>
  
  <?php fwbase_paging_nav(); ?>
  
  <div class="wahnbuch-footer-bewerben">
    <h2> <?php _e('Werde Dienstleister bei Hochzeitswahn', 'fwbase'); ?></h2>
    <p> <?php _e('Wir sind immer auf der Suche nach neuen, Talentierten Dienstleistern. Wenn du meinst, Dass dein Auftritt hier fehlt, dann stell dich uns vor.', 'fwbase'); ?> </p>
    <a class="button" href="<?php get_permalink(19547); ?>" title=" <?php _e('Zum Bewerbungsformular', 'fwbase'); ?>"> <?php _e('Zum Bewerbungsformular', 'fwbase'); ?> </a>
  </div>  

<?php get_footer(); ?>