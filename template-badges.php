<?php
/**
 * Template Name: Badge Page
 * Description: Template zur Darstellung von Badges
 *
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package fwbase
 */

get_header(); ?>

	<div id="primary" class="content-area">
  	
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
        
				<?php get_template_part( 'content', 'page' ); ?>
                 
			  <?php
			  	if ( comments_open() || '0' != get_comments_number() ) :
			  		comments_template();
			  	endif;
			  ?>
 
			<?php endwhile; // end of the loop. ?>

		</main>
		
	</div>
<?php get_sidebar(); ?>

<?php get_footer(); ?>
