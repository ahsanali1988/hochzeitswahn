<?php
/**
 * The template for displaying all single posts for fitterwochen.
 *
 * @package fwbase
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

		  <?php while ( have_posts() ) : the_post(); ?>

		  <?php
  		  // Display revision if post is awaiting approval
  		  if(get_post_status() == 'awaiting') {
          get_template_part( 'content', 'flitterwochen-revision');
        } else {
    		  get_template_part( 'content', 'flitterwochen' );
    		}
  		?>

      <?php // Featured

        // Check if any posts are available
        $show_flag = false;

        if( have_rows('hw_flitterwochen_admin') ):

          while ( have_rows('hw_flitterwochen_admin') ) : the_row();

            $post_object = get_sub_field('hw_flitterwochen_admin_post');

            if( get_post_status($post_object) == 'publish') {

              $show_flag = true;

            }

          endwhile;

          if( $show_flag == true ) :

      ?>

      <div class="post-navigation-wrapper">

        <section class="posts-to-like featured-section">

          <h3 class="section-headline"> <span><?php printf( __( '%s Features bei Hochzeitswahn', 'fwbase' ), get_field('flitter_profil_name') ); ?></span> </h3>

    	  	  <div class="posts-to-like-wrapper">

  		        <?php

                // Do the loop
                while ( have_rows('hw_flitterwochen_admin') ) : the_row();

                  $post_object = get_sub_field('hw_flitterwochen_admin_post');

                  if( get_post_status($post_object) == 'publish') :

              ?>

              <article>

                <a href="<?php echo get_permalink($post_object); ?>" title="<?php echo get_the_title($post_object); ?>">

                  <div class="entry-thumbnail">

                    <?php

                      if ( has_post_thumbnail($post_object) ) {
                        $post_thumbnail_id = get_post_thumbnail_id( $post_object );
                        $post_thumb_s   = wp_get_attachment_image_src( $post_thumbnail_id,'thumbnail' );
                        //$post_thumb_m   = wp_get_attachment_image_src( $post_thumbnail_id,'medium' );
                        $post_thumb_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true );
                        $post_thumb_alt = ($post_thumb_alt == '' ? 'Inspiration auf Hochzeitswahn.de' : $post_thumb_alt);

                        ?>
                          <img src="<?php echo $post_thumb_s[0]; ?>" alt="<?php echo $post_thumb_alt; ?>">
                        <?php
                      }

                    ?>

                  </div>

                  <h6 class="entry-title"><?php echo get_the_title($post_object); ?></h6>

                </a>

              </article>

              <?php
                  endif;

                endwhile;
              ?>

    	  	  </div>

  		  </section>

      </div>

  		<?php

    	  	endif;

        endif;

      ?>


      <?php // Andere Dienstleister ?>
  		<?php

        $regionen = get_the_terms( $post->ID, 'flitter_region' );
        $current_post = $post->ID;

        foreach( $regionen as $region ) {
          $query_reg = $region->slug;
        }

        $args = array(
          'post_type' => 'hw_flitterwochen',
          'posts_per_page'  => 8,
          'post__not_in' => array($current_post),
          'post_status' => 'publish',
          'orderby' => 'rand',
          'tax_query' => array(
            array(
            	'taxonomy' => 'flitter_region',
            	'field'    => 'slug',
            	'terms'    => $query_reg
            ),
          )
        );

        $service_Query = new WP_Query( $args );

        if ( $service_Query->have_posts() ) :

      ?>

  		  <div class="dienstleister-section">

    	  	<h3 class="section-headline"> <span><?php _e( 'Weitere Dienstleister aus dieser Region', 'fwbase' ); ?></span> </h3>

            <ul class="dienstleister-section-selection unstyled">

              <?php while ( $service_Query->have_posts() ) : $service_Query->the_post(); if($current_post != $post->ID) : ?>

              <?php if ( has_post_thumbnail() ) { ?>

              <li>
                <?php

                  $post_thumb_s   = wp_get_attachment_image_src( get_post_thumbnail_id(),'service-s' );
                  $post_thumb_m   = wp_get_attachment_image_src( get_post_thumbnail_id(),'service-m' );
                  $post_thumb_l   = wp_get_attachment_image_src( get_post_thumbnail_id(),'service-xl' );
                  $post_thumb_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
                  $post_thumb_alt = ($post_thumb_alt == '' ? 'Die besten Hochzeitsdienstleister bei Hochzeitswahn.de' : $post_thumb_alt);

                ?>

                <a href="<?php echo get_permalink(); ?>" title="<?php _e('Portfolio im Wahnb&uuml;chlein ansehen', 'fwbase'); ?>">

                  <img src="<?php echo $post_thumb_s[0]; ?>"
                    srcset="<?php echo $post_thumb_m[0].' '.$post_thumb_m[1].'w'; ?>,
                            <?php echo $post_thumb_l[0].' '.$post_thumb_l[1].'w'; ?>" size="100vw" alt="<?php echo $post_thumb_alt; ?>">

                  <div class="dienstleister-entry-content">

                    <span class="dl-entry-cat">
                      <?php
                        $categories = get_the_terms( $post->ID, 'flitter_categorie' );
                        foreach( $categories as $category ) {
                          if( $category->name != 'Alle Dienstleister') {
                            echo $category->name.' ';
                          }
                        }
                      ?>
                    </span>

                    <span class="dl-entry-region">
                      <?php
                        $regionen = get_the_terms( $post->ID, 'flitter_region' );
                        foreach( $regionen as $region ) {
                          echo $region->name.' ';
                        }
                      ?>
                    </span>

                    <h5><?php the_title(); ?></h5>

                  </div>

                </a>

              </li>

              <?php } //has thumb ?>

              <?php endif; endwhile; wp_reset_postdata(); ?>

            </ul>

  		  </div>

      <?php endif; ?>

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

      <div class="remodal fav-modal-window" data-remodal-id="modal-<?php echo $post->ID;?>">
        <?php echo do_shortcode('[userpro_bookmark]'); ?>
      </div>

		<?php endwhile; ?>

		</main>

	</div>

<?php get_footer(); ?>
