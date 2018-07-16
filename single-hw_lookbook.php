<?php
/**
 * The template for displaying all single posts for lookbook.
 *
 * @package fwbase
 */

get_header(); ?>

	<div id="primary" class="content-area">
		
		<main id="main" class="site-main" role="main">

		  <?php while ( have_posts() ) : the_post(); ?>

  		<?php 
    		    		
    		$parent = ($post->post_parent > 0) ? get_post($post->post_parent) : '';
        $parent_title = get_the_title($parent);
        
        if( $parent != '' ) {        
      		$grandparent = ($parent->post_parent > 0) ? $parent->post_parent : '';
          $grandparent_title = get_the_title($grandparent);
    		}
    		
        // muss ein produkt sein
        // ------------------------------------------------------------------        
        if( $parent && $grandparent) :
        
          include(locate_template('content-lookbook_produkt.php'));


        // muss kollektion sein
        // ------------------------------------------------------------------
        elseif( $parent && !$grandparent) :
          
          include(locate_template('content-lookbook_designer.php'));


        // muss designer sein
        // ------------------------------------------------------------------        
        else:

          include(locate_template('content-lookbook_designer.php'));

        endif;
    		
  		?>

      <div class="ad-section ad-leaderboard">
        <script type="text/javascript"><!--
          google_ad_client = "ca-pub-0598776326520536";
          if (window.innerWidth < 740) {                
            /* body hw */
            google_ad_slot = "7650814193";
            google_ad_width = 300;
            google_ad_height = 250;                
            
          } else if (window.innerWidth >= 740) {
            /* hw footer */
            google_ad_slot = "1654652993";
            google_ad_width = 728;
            google_ad_height = 90;
          }
        //--></script>
        <script type="text/javascript" src="//pagead2.googlesyndication.com/pagead/show_ads.js"></script>    
      </div> 

		<?php endwhile; ?>

		</main>
		
	</div>

<?php get_footer(); ?>