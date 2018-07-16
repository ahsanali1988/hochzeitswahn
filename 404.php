<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package fwbase
 */

get_header(); ?>

	<div id="primary" class="content-area">
  	
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				
				<header class="entry-header page-header">
          <h1 class="entry-title section-headline"> <span><?php _e( 'Nichts gefunden.', 'fwbase' ); ?></span> </h1>
  	    </header>

				<div class="page-content">
					<p><?php _e( 'Entschuldige bitte, aber die Seite konnte nicht gefunden werden. Vielleicht hilft die Suchfunktion ein Ergebnis zu finden.', 'fwbase' ); ?></p>

					<?php get_search_form(); ?>

					<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

				</div>
				
			</section>
			
		</main>
		
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
