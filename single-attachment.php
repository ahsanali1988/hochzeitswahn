<?php
/**
 * The template for displaying all single attachments.
 *
 * @package fwbase
 */

get_header(); ?>

	<div id="primary" class="content-area">
		
		<main id="main" class="site-main" role="main">

		  <?php while ( have_posts() ) : the_post(); ?>
  		                            			
  			<?php get_template_part( 'content', 'gallery' ); ?>

        <div class="ad-section ad-2col">
      
          <div class="ad-2col-left ad-small-two">
          </div>
          
          <div class="ad-2col-right medium-up ad-small-two">
          </div>

        </div>
  		                
		  <?php endwhile; ?>

		</main>
		
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>


