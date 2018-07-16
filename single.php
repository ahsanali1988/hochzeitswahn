<?php
/**
 * The template for displaying all single posts.
 *
 * @package fwbase
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

		  <?php while ( have_posts() ) : the_post(); ?>

      <?php if ( (isset($wp->query_vars['details']) && $wp->query_vars['details']=='galerie') || (isset($wp->query_vars['details']) && $wp->query_vars['details']=='gallery') ) : ?>
          			
  			<?php get_template_part( 'content', 'gallery' ); ?>

        <div class="ad-section ad-2col">

          <div class="ad-2col-left">
            <img src="http://placehold.it/300x100" alt="Placeholder Rectangle">
            <img src="http://placehold.it/300x100" alt="Placeholder Rectangle">
          </div>

          <div class="ad-2col-right medium-up">
            <img src="http://placehold.it/300x100" alt="Placeholder Rectangle">
            <img src="http://placehold.it/300x100" alt="Placeholder Rectangle">
          </div>

        </div>

  		<?php else : ?>

  		  <?php get_template_part( 'content', 'single' ); ?>

        <?php // Dienstleister
          if( have_rows('wahnbuch_repeater') ):

            $show_flag = false;

            while ( have_rows('wahnbuch_repeater') ) : the_row();
              $post_object = get_sub_field('wahnbuch_repeater_id');
              if( get_post_status($post_object->ID) == 'publish') {
                $show_flag = true;
              }
            endwhile;

            if( $show_flag == true ) :
        ?>

  		  <div class="dienstleister-section">

    	  	<h3><?php _e('Unsere Dienstleister&shyempfehlungen', 'fwbase'); ?></h3>

    	  	<div class="dl-slider-wrapper">

  		      <?php
            while ( have_rows('wahnbuch_repeater') ) : the_row();

              $post_object       = get_sub_field('wahnbuch_repeater_id');
              $post_thumbnail_id = get_post_thumbnail_id( $post_object->ID );
              $post_thumb_small  = wp_get_attachment_image_src( $post_thumbnail_id, 'service-s');
              $post_thumb_medium = wp_get_attachment_image_src( $post_thumbnail_id, 'service-m');
              $post_thumb_large  = wp_get_attachment_image_src( $post_thumbnail_id, 'service-l');
              $post_btn_label    = ( get_post_type($post_object->ID) == 'hw_lookbook' ) ? __('Zur Kollektion', 'fwbase') : __('Zum Portfolio', 'fwbase');

              if( get_post_status($post_object->ID) == 'publish') :

            ?>

  		      <div class="dl-recommend-entry">
              <div class="dl-recommend-entry-thumb">
                <a href="<?php echo get_permalink($post_object->ID); ?>" title="<?php echo get_the_title($post_object->ID); ?>">
                  <span> <?php echo $post_btn_label; ?> </span>
                  <img src="<?php echo $post_thumb_small[0]; ?>"
                    srcset="<?php echo $post_thumb_medium[0]; ?> 250w,
                            <?php echo $post_thumb_large[0]; ?> 350w" size="100vw" alt="<?php echo get_the_title($post_object->ID); ?>">
                </a>
              </div>

              <div class="dl-recommend-entry-content">
                <span>
                  <?php
                    if( get_post_type($post_object->ID) == 'hw_lookbook' ) {
                      $post_terms      = get_the_terms( $post_object->ID, 'look_categorie' );
                      $post_terms_name = $post_terms[0]->name;

                      echo '<em class="dl-entry-cat">'.$post_terms_name.'</em>';

                    } else {
                      $post_terms      = get_the_terms( $post_object->ID, 'wahn_categorie' );
                      $post_terms_name = ($post_terms[1]->name != 'Alle Dienstleister') ? $post_terms[1]->name : $post_terms[0]->name;

                      $post_region      = get_the_terms( $post_object->ID, 'wahn_region' );
                      $post_region_name = $post_region[0]->name;

                      echo '<em class="dl-entry-cat">'.$post_terms_name.'</em> <em class="dl-entry-region">'.$post_region_name.'</em>';
                    }
                  ?>
                </span>

                <a href="<?php echo get_permalink($post_object->ID); ?>" title="<?php echo get_the_title($post_object->ID); ?>">
                  <?php echo get_the_title($post_object->ID); ?>
                </a>
              </div>
            </div>

            <?php
              endif;

            endwhile;
            ?>

          </div>
  		  </div>

  		  <?php
    		    endif;

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

        <div class="post-navigation-wrapper">
          <?php fwbase_posts_you_like('parent', $post->ID); ?>
          <?php fwbase_post_nav(); ?>
        </div>

			  <?php
			  	if ( comments_open() || '0' != get_comments_number() ) :
			  		comments_template();
			  	endif;
			  ?>

        <div class="remodal fav-modal-window" data-remodal-id="modal-<?php echo $post->ID;?>">
          <?php echo do_shortcode('[userpro_bookmark]'); ?>
        </div>

  		<?php endif; ?>

		<?php endwhile; ?>

		</main>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>