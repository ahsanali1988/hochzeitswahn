<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package fwbase
 */
?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title section-headline"> <span><?php _e( 'Leider konnten wir nichts finden', 'fwbase' ); ?></span> </h1>
	</header><!-- .page-header -->

	<div class="page-content">
		
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Bereit deinen ersten Beitrag zu ver&ouml;ffentlichen? <a href="%1$s">Dann leg los!</a>', 'fwbase' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Es tut uns leid, aber wir haben nichts dazu gefunden. Probiere es doch einfach nochmal mit einem anderen Suchbegriff.', 'fwbase' ); ?></p>
			<?php get_search_form(); ?>

		<?php elseif ( is_post_type_archive('hw_wahnbuechlein') || is_tax('wahn_categorie') || is_tax('wahn_region') ) : ?>

			<p class="aligncenter"><?php _e( 'Leider haben wir keinen Dienstleister in dieser Kategorie gefunden. Bitte gehe zur&uuml;ck zur &Uuml;bersicht und probiere eine andere Region oder Kategorie', 'fwbase' ); ?></p>

			<p class="aligncenter">
  		  <a href="<?php echo esc_url( home_url( '/wahnbuechlein/' ) ); ?>" class="back-to-overview" title="<?php _e('Zur&uuml;ck zu allen Kategorien','fwbase'); ?>"> 
    		  <span class="icon-pfeil-links"><?php _e('Zur&uuml;ck zu allen Kategorien','fwbase'); ?></span>
    		</a>
      </p>
      
		<?php elseif ( is_post_type_archive('hw_lookbook') || is_tax('look_categorie') || is_tax('look_filter') ) : ?>

			<p class="aligncenter"><?php _e( 'Leider haben wir keine passenden Produkte gefunden. Bitte gehe zur&uuml;ck zur &Uuml;bersicht und probiere andere Filter aus.', 'fwbase' ); ?></p>

			<p class="aligncenter">
  		  <a href="<?php echo esc_url( home_url( '/lookbook/' ) ); ?>" class="back-to-overview" title="<?php _e('Zur &Uuml;bersicht', 'fwbase'); ?>">	
    		  <span class="icon-pfeil-links"><?php _e('Zur &Uuml;bersicht', 'fwbase'); ?></span>
    		</a>
      </p>  
      
		<?php elseif ( is_page(11152) ) : ?>

			<p class="aligncenter"><?php _e( 'Leider haben wir keine passenden Bilder gefunden. Bitte gehe zur&uuml;ck zur &Uuml;bersicht und probiere andere Filter aus.', 'fwbase' ); ?></p>

			<p class="aligncenter">
  		  <a href="<?php echo get_permalink(11152); ?>" class="back-to-overview" title="<?php _e('Zur &Uuml;bersicht', 'fwbase'); ?>">	
    		  <span class="icon-pfeil-links"></span> <?php _e('Zur &Uuml;bersicht', 'fwbase'); ?>
    		</a>
      </p>           
		
		<?php else : ?>

			<p><?php _e( 'Es scheint fast so als w&auml;re das, was du suchst, nicht gefunden worden. Probiere es doch einmal mit der Suche.', 'fwbase' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
		
	</div><!-- .page-content -->
</section><!-- .no-results -->