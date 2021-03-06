<?php
/**
 * The template for displaying the flitterwochen regio pages.
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

$term_name = get_term_by( 'id', $wp_query->get_queried_object_id(), 'flitter_region' );

?>

  <header class="flitterwochen-header">

		<img src="<?php bloginfo('template_url'); ?>/img/elements/wahnbuch-header.jpg" alt="<?php _e('Die besten Hochzeits-Dienstleister im Wahnb&uuml;chlein', 'fwbase'); ?>" class="flitterwochen-header-img large-only">

    <div class="flitterwochen-header-info">
      <h1> <?php _e('Finde tolle <strong>Dienstleister</strong> aus deiner Region.', 'fwbase'); ?> </h1>
      <p>
        <?php _e('Das Hochzeitswahn Wahnb&uuml;chlein ist nicht einfach nur ein Branchenbuch aller Hochzeitsdienstleister, denn wir haben uns hier nur auf die cr&egrave;me de la cr&egrave;me von erstklassigen und megatalentierten Dienstleister beschr&auml;nkt, mit denen jede Hochzeit und Planung zu einem sorgenfreien Ereignis wird.', 'fwbase'); ?>
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
            $current_url = esc_url(home_url(add_query_arg(array(),$wp->request)));
            $cat_query = ( get_query_var( 'flitter_categorie' ) != '' ) ? get_query_var( 'flitter_categorie' ) : '';
            $terms = get_terms('flitter_categorie');

            echo '<li class="flitter_category"> <span>'. __( 'W&auml;hle eine Kategorie:', 'fwbase' ) .'</span>';
            echo '<ul>';
            echo '<li class="tags_overview"> <a href="'.esc_url(remove_query_arg( 'flitter_categorie',  $current_url)).'" title="'.__('Alle Kategorien anzeigen', 'fwbase').'" rel="nofollow">'.__('Alle Kategorien anzeigen', 'fwbase').'</a> </li>';
            foreach( $terms as $term ) {
              if( $term->slug === $cat_query ) {
                echo '<li class="active"> <a href="'.$current_url.'/?flitter_categorie='.$term->slug.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';
              } else {
                echo '<li> <a href="'.$current_url.'/?flitter_categorie='.$term->slug.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';
              }
            }
            echo '</ul> </li>';
          ?>
        </ul>

        <ul class="sub-cat-nav-catlist unstyled">
          <?php
            $terms = get_terms('flitter_region');
            $add_query = ( get_query_var( 'flitter_categorie' ) != '' ) ? '?flitter_categorie='.get_query_var( 'flitter_categorie' ) : '';

            echo '<li class="flitter_region"> <span>'. __( 'Suche in deiner Region:', 'fwbase' ) .'</span>';
            echo '<ul>';
            foreach( $terms as $term ) {
              if( $term_name->slug === $term->slug ) {
                echo '<li class="active"> <a href="'.get_term_link( $term->slug, 'flitter_region' ).$add_query.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';
              } else {
                echo '<li> <a href="'.get_term_link( $term->slug, 'flitter_region' ).$add_query.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';
              }
            }
            echo '</ul> </li>';
          ?>
        </ul>

      </nav>

			<section class="post-entry-listing">

			  <ul class="unstyled">

          <?php while ( have_posts() ) : the_post(); ?>

            <li> <?php get_template_part( 'content', 'flitterlisting' ); ?> </li>

          <?php endwhile; ?>

			  </ul>

			</section>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

  </main>

  <?php fwbase_paging_nav(); ?>

  <div class="flitterwochen-footer-bewerben">
    <h2> <?php _e('Werde Dienstleister bei Hochzeitswahn', 'fwbase'); ?></h2>
    <p> <?php _e('Wir sind immer auf der Suche nach neuen, Talentierten Dienstleistern. Wenn du meinst, Dass dein Auftritt hier fehlt, dann stell dich uns vor.', 'fwbase'); ?> </p>
    <a class="button" href="<?php get_permalink(19547); ?>" title=" <?php _e('Zum Bewerbungsformular', 'fwbase'); ?>"> <?php _e('Zum Bewerbungsformular', 'fwbase'); ?> </a>
  </div>

<?php get_footer(); ?>
