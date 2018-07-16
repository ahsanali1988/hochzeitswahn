<?php
/**
 * The template for displaying the wahnbuch archiv pages.
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

$cat_query = ( get_query_var( 'flitter_categorie' ) != '' ) ? get_query_var( 'flitter_categorie' ) : '';
$reg_query = ( get_query_var( 'flitter_region' ) != '' ) ? get_query_var( 'flitter_region' ) : '';
$current_url = esc_url(home_url(add_query_arg(array(),$wp->request)));


?>

  <header class="flitter-header">

		<img src="<?php bloginfo('template_url'); ?>/img/elements/wahnbuch-header.jpg" alt="<?php _e('Die besten Hochzeits-Dienstleister im Wahnb&uuml;chlein', 'fwbase'); ?>" class="flitterwochen-header-img large-only">

    <div class="flitterwochen-header-info">
      <?php
        if( empty($cat_query) && empty($reg_query) ) {
          echo '<h1>'.__('Finde die <strong>Cr&egrave;me de la Cr&egrave;me</strong> der Hochzeitsdienstleister', 'fwbase').'</h1>';
        } elseif( empty($cat_query) && !empty($reg_query) ) {
          echo '<h1>'.__('Finde tolle <strong>Dienstleister</strong> aus deiner Region.', 'fwbase').'</h1>';
        } elseif( !empty($cat_query) ) { ?>
          <h1> <?php
            if ($cat_query == 'allgemein') {
              _e('Finde die besten Dienstleister f&uuml;r <strong>deine Traumhochzeit</strong>', 'fwbase');
            } else {
              printf( __('Finde die besten Dienstleister f&uuml;r <strong>%s</strong>', 'fwbase'), $cat_query );
            }
            ?>
          </h1> <?php
        }
      ?>

      <p>
        <?php
          if( !empty($cat_query) ) {
            $termID = get_term_by('slug', $cat_query, 'flitter_categorie');
            $term_descr = get_field('flitter_cat_description', $termID);
          }

          if(!empty($term_descr) ) {
            echo $term_descr;
          } else {
            _e('Das Hochzeitswahn Wahnb&uuml;chlein ist nicht einfach nur ein Branchenbuch aller Hochzeitsdienstleister, denn wir haben uns hier nur auf die cr&egrave;me de la cr&egrave;me von erstklassigen und megatalentierten Dienstleister beschr&auml;nkt, mit denen jede Hochzeit und Planung zu einem sorgenfreien Ereignis wird.', 'fwbase');
          }
        ?>
      </p>

    </div>

    <div class="flitterwochen-header-bewerben">
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
            $terms = get_terms('flitter_categorie', array('hide_empty' => false));

            echo '<li class="flitter_category"> <span>'. __( 'W&auml;hle eine Kategorie:', 'fwbase' ) .'</span>';
            echo '<ul>';
              echo '<li class="tags_overview"> <a href="'.$current_url.'" title="'.__('Alle Kategorien ansehen', 'fwbase').'">'.__('Zum Kategorie-&Uuml;berblick', 'fwbase').'</a> </li>';
              foreach( $terms as $term ) {
                if( $term->slug === $cat_query ) {
                  echo '<li class="active"> <a href="'.$current_url.'?flitter_categorie='.$term->slug.'&flitter_region='.$reg_query.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';
                } else {
                  echo '<li> <a href="'.$current_url.'?flitter_categorie='.$term->slug.'&flitter_region='.$reg_query.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';
                }
              }
            echo '</ul> </li>';
          ?>
        </ul>

        <ul class="sub-cat-nav-catlist unstyled">
          <?php
            $terms = get_terms('flitter_region');

            echo '<li class="flitter_region"> <span>'. __( 'Suche in deiner Region:', 'fwbase' ) .'</span>';
            echo '<ul>';
              if( !empty($reg_query) && !empty($cat_query) ) { echo '<li class="tags_overview"> <a href="'.$current_url.'?flitter_categorie='.$cat_query.'&flitter_region=" title="Alle Regionen" rel="nofollow">Alle Regionen</a> </li>'; }
              foreach( $terms as $term ) {
                if( $term->slug === $reg_query ) {
                  echo '<li class="active"> <a href="'.$current_url.'?flitter_categorie='.$cat_query.'&flitter_region='.$term->slug.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';
                } else {
                  echo '<li> <a href="'.$current_url.'?flitter_categorie='.$cat_query.'&flitter_region='.$term->slug.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';
                }
              }
            echo '</ul> </li>';
          ?>
        </ul>

      </nav>


      <?php if( $cat_query != '' || $reg_query != '' ) : ?>
		  <div class="delete-filters">
  	    <a class="filter-to-delte" href="<?php echo esc_url($current_url); ?>" title="<?php _e('Alles l&ouml;schen', 'fwbase'); ?>"><?php _e('Alles l&ouml;schen', 'fwbase'); ?></a>
  	    <?php
          if($cat_query != ''){echo '<a class="filter-to-delete" href="'.$current_url.'?flitter_categorie=&flitter_region='.$reg_query.'" title="'.__('Kategorie l&ouml;schen', 'fwbase').'">'.__('Kategorie l&oumlschen', 'fwbase').'</a>';}
          if($reg_query != ''){echo '<a class="filter-to-delete" href="'.$current_url.'?flitter_categorie='.$cat_query.'&flitter_region=" title="'.__('Region l&ouml;schen', 'fwbase').'">'.__('Region l&oumlschen', 'fwbase').'</a>';}
        ?>
  	  </div>
      <?php endif; ?>


			<section class="post-entry-listing">

			  <ul class="unstyled">

          <?php if( empty($cat_query) && empty($reg_query) ) : ?>

            <?php $flitter_categories = get_terms('flitter_categorie', array('hide_empty' => false)); foreach($flitter_categories as $category) : ?>

            <li class="flitter-cat">

              <article class="default-article-layout">

                <div class="entry-thumbnail">

                  <a href="<?php echo $current_url.'?flitter_categorie='.$category->slug; ?>" title="<?php echo $category->name; ?>">

                    <div class="entry-description">
                      <?php echo $category->description; ?>
                    </div>

                    <?php
                      $taxonomy = $category->taxonomy;
                      $term_id  = $category->term_id;
                      $image = get_field('field_5549d7197f898', $taxonomy . '_' . $term_id);

                      if (! empty($image) ) {

                      ?>
                      <img src="<?php echo $image['sizes']['thumbnail'] ?>"
                        srcset="<?php echo $image['sizes']['medium'].' '.$image['sizes']['medium-width'].'w'; ?>,
                                <?php echo $image['sizes']['large'].' '.$image['sizes']['large-width'].'w'; ?>" size="100vw" alt="<?php echo $image['alt']?>">

                    <?php } ?>
                  </a>
                </div>

              	<div class="entry-content">

                  <h5 class="entry-title"> <a href="<?php echo $current_url.'?flitter_categorie='.$category->slug; ?>" title="<?php echo $category->name; ?>"> <?php echo $category->name; ?> </a> </h5>

              	</div>

              </article>

            </li>

            <?php endforeach; ?>

  			  <?php else: ?>

            <?php while ( have_posts() ) : the_post(); ?>

              <li> <?php get_template_part( 'content', 'listing' ); ?> </li>

            <?php endwhile; ?>

          <?php endif; ?>

			  </ul>

			</section>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

  </main>

  <?php if( !empty($cat_query) || !empty($reg_query) ) { fwbase_paging_nav(); } ?>

  <div class="flitter-footer-bewerben">
    <h2> <?php _e('Werde Dienstleister bei Hochzeitswahn', 'fwbase'); ?></h2>
    <p> <?php _e('Wir sind immer auf der Suche nach neuen, Talentierten Dienstleistern. Wenn du meinst, Dass dein Auftritt hier fehlt, dann stell dich uns vor.', 'fwbase'); ?> </p>
    <a class="button" href="<?php echo get_permalink(19547); ?>" title=" <?php _e('Zum Bewerbungsformular', 'fwbase'); ?>"> <?php _e('Zum Bewerbungsformular', 'fwbase'); ?> </a>
  </div>

<?php get_footer(); ?>
