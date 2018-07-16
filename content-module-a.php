<?php

/**

 * @package fwbase

 */

?>



<section class="article-row module-a-layout">



  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>



    <div class="entry-thumbnail">

      <?php

        if ( has_post_thumbnail() ) {



          $post_thumb_s   = wp_get_attachment_image_src( get_post_thumbnail_id(),'thumbnail' );

          $post_thumb_m   = wp_get_attachment_image_src( get_post_thumbnail_id(),'medium' );

          $post_thumb_l   = wp_get_attachment_image_src( get_post_thumbnail_id(),'large' );

          $post_thumb_xl  = wp_get_attachment_image_src( get_post_thumbnail_id(),'xlarge' );

          $post_thumb_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );

          $post_thumb_alt = ($post_thumb_alt == '' ? 'Inspiration auf Hochzeitswahn.de' : $post_thumb_alt);



          ?>



          <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>">

            <img class="myc" src="<?php echo $post_thumb_s[0]; ?>"

              srcset="<?php echo $post_thumb_m[0].' '.$post_thumb_m[1].'w'; ?>,

                      <?php echo $post_thumb_l[0].' '.$post_thumb_l[1].'w'; ?>,

                      <?php echo $post_thumb_xl[0].' '.$post_thumb_xl[1].'w'; ?>" size="100vw" alt="<?php echo $post_thumb_alt; ?>">

          </a>



          <?php

        }

      ?>

    </div>



	  <div class="entry-content">

  	  <div class="entry-meta">

        <?php fwbase_posted_on(); ?>

	      <?php fwbase_entry_meta(); ?>

      </div>



      <?php

        if (strlen(get_the_title()) > 110) {

          echo '<h5 class="entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . substr(the_title($before = '', $after = '', FALSE), 0, 65) . '...' . '</a></h5>';

        } else {

          the_title( sprintf( '<h5 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' );

        }

      ?>

	  </div>



    <div class="remodal fav-modal-window" data-remodal-id="modal-<?php echo $post->ID; ?>">

      <?php echo do_shortcode('[userpro_bookmark]'); ?>

    </div>



  </article>





  <aside class="module-a-aside">



    <div class="module-a-aside-post">



      <?php



        if( !empty($adrows) ) :



          $rand_row = array_shift($adrows); // get first row



          $rand_row_img      = $rand_row['opt_ads_repeater_link_img'];

          $rand_row_intro    = $rand_row['opt_ads_repeater_intro'];

          $rand_row_text     = $rand_row['opt_ads_repeater_text'];

          $rand_row_url      = $rand_row['opt_ads_repeater_link'];

          $rand_row_linktext = $rand_row['opt_ads_repeater_link_text'];



        ?>



        <article class="internal-ad">



            <div class="entry-thumbnail">



              <?php

                $post_thumb_s   = wp_get_attachment_image_src( $rand_row_img, 'portrait-s' );

                $post_thumb_m   = wp_get_attachment_image_src( $rand_row_img, 'portrait-m' );

                $post_thumb_l   = wp_get_attachment_image_src( $rand_row_img, 'portrait-l' );

                $post_thumb_xl  = wp_get_attachment_image_src( $rand_row_img, 'xlarge' );

                $post_thumb_alt = get_post_meta( $rand_row_img, '_wp_attachment_image_alt', true );

                $post_thumb_alt = ($post_thumb_alt == '' ? 'Inspiration auf Hochzeitswahn.de' : $post_thumb_alt);



              ?>



              <a href="<?php echo $rand_row_url; ?>" title="<?php $rand_row_intro; ?>">

                  <img style="display: block !important" src="<?php echo $post_thumb_s[0]; ?>"

                  srcset="<?php echo $post_thumb_m[0].' '.$post_thumb_m[1].'w'; ?>,

                          <?php echo $post_thumb_l[0].' '.$post_thumb_l[1].'w'; ?>,

                          <?php echo $post_thumb_xl[0].' '.$post_thumb_xl[1].'w'; ?>" alt="<?php echo $post_thumb_alt; ?>">

              </a>



            </div>



  	        <div class="entry-content">

    	        <div>

                <span class="cat-links"> <a href="<?php echo $rand_row_url; ?>"> <?php echo $rand_row_intro; ?> </a></span>

                <h2 class="entry-title"> <a href="<?php echo $rand_row_url; ?>" rel="bookmark"> <?php echo $rand_row_text; ?> </a></h2>

                <a href="<?php echo $rand_row_url; ?>" title="<?php _e('Jetzt ansehen', 'fwbase'); ?>"> <?php echo $rand_row_linktext; ?> </a>

    	        </div>

	          </div>



          </article>



        <?php



        else:



          $sub_Query = new WP_Query( array(

            'post_type' => array('hw_lookbook'),

            'meta_key' => 'lookbook_prod_price',

            'posts_per_page'  => 1,

            'orderby' => 'rand',

            'date_query' => array(

              'after' => date('Y-m-d', strtotime('-360 days'))

            )

          ));



          if ( $sub_Query->have_posts() ) : while ( $sub_Query->have_posts() ) : $sub_Query->the_post(); ?>



            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>



              <div class="entry-thumbnail">



                <?php

                  if ( has_post_thumbnail() ) {



                    $post_thumb_s   = wp_get_attachment_image_src( get_post_thumbnail_id(),'portrait-s' );

                    $post_thumb_m   = wp_get_attachment_image_src( get_post_thumbnail_id(),'portrait-m' );

                    $post_thumb_l   = wp_get_attachment_image_src( get_post_thumbnail_id(),'portrait-l' );

                    $post_thumb_xl  = wp_get_attachment_image_src( get_post_thumbnail_id(),'xlarge' );

                    $post_thumb_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );

                    $post_thumb_alt = ($post_thumb_alt == '' ? 'Inspiration auf Hochzeitswahn.de' : $post_thumb_alt);



                    ?>

                    <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>">

                      <img class="myc" src="<?php echo $post_thumb_s[0]; ?>"

                        srcset="<?php echo $post_thumb_m[0].' '.$post_thumb_m[1].'w'; ?>,

                                <?php echo $post_thumb_l[0].' '.$post_thumb_l[1].'w'; ?>,

                                <?php echo $post_thumb_xl[0].' '.$post_thumb_xl[1].'w'; ?>" alt="<?php echo $post_thumb_alt; ?>">

                    </a>

                    <?php

                  }

                ?>



              </div>



  	          <div class="entry-content">

    	          <div>

  	              <?php fwbase_entry_meta(); ?>

                  <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

                  <a href="<?php echo get_permalink(); ?>" title="<?php _e('Jetzt ansehen', 'fwbase'); ?>"> <?php _e('Jetzt ansehen', 'fwbase'); ?> </a>

    	          </div>

	            </div>



            </article>



          <?php endwhile; wp_reset_postdata(); endif; ?>



      <?php endif; ?>



    </div>



    <div class="ad-section ad-1col">



<h6 class="section-headline"> <span> <?php _e('Unsere Sponsoren', 'fwbase')?> </span> </h6>

	<div class="ad-medium-one">

		<div>

			<ul class="oio-banner-zone" id="oio-banner-1">

				<li class="oio-slot oio-last-col oio-last-row"><img class="myc" src="https://placehold.it/300x250" alt="Placeholder Rectangle"></li>

				<li><br /></li>

			</ul>



		</div>

	</div>



      <div class="ad-small-three">

        <img class="myc" src="https://placehold.it/300x100" alt="Placeholder Rectangle">

        <img class="myc" src="https://placehold.it/300x100" alt="Placeholder Rectangle">

        <img class="myc" src="https://placehold.it/300x100" alt="Placeholder Rectangle">

      </div>



    </div>



  </aside>



</section>

