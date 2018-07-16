<?php
/**
 * The main template file.
 *
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

// Get all custom ad rows
$adrows = get_field('opt_ads_repeater', 'option');

?>



  <main class="site-main" role="main">

    <?php if ( have_posts() ) : $post_counter = 1; $current_paged = get_query_var('paged'); ?>

      <?php while ( have_posts() ) : the_post(); ?>

        <?php

          // Check if at least 14 posts are available, if not we need to alter the layout
          if( $wp_query->post_count < 14 ) {

            //odd
            if ( ($post_counter%2) != 0 && $post_counter != $wp_query->post_count ) {

              echo '<section class="article-row default-row-layout">';
      		    get_template_part( 'content', get_post_format() ) ;

            }

            //even
            if ( ($post_counter%2) == 0) {
      		    get_template_part( 'content', get_post_format() ) ;

              echo '</section>';

              //Ad section ?>
              <div class="ad-section ad-2col">
                <h6 class="section-headline"> <span> <?php _e('Unsere Sponsoren', 'fwbase')?> </span> </h6>
                <div class="ad-2col-left ad-medium-two">
                </div>

                <div class="ad-2col-right ad-small-four">
                </div>

              </div> <?php

            }

            //if odd and last one!
            if ( ($post_counter%2) != 0 && $post_counter == $wp_query->post_count ) {
              echo '<section class="article-row default-row-layout">';
      		    get_template_part( 'content', get_post_format() ) ;
              echo '</section>';
            }

          // Ok, seems like we have more than 14 posts available, start the complex layout
          } else {

            if ( $post_counter == 1 && $current_paged == 0) :

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

          <nav class="sub-category-nav">
            <h3 class="section-headline"><span><?php _e('Weitere Beitr&auml;ge', 'fwbase'); ?></span> </h3>

            <ul class="sub-cat-nav-catlist unstyled">
              <?php
                $args = array(
              	  'style'              => 'list',
              	  'use_desc_for_title' => 0,
              	  'hierarchical'       => 1,
              	  'echo'               => 1,
              	  'taxonomy'           => 'category',
              	  'title_li'           => '<span>'.__( 'Kategorien', 'fwbase' ).'</span>'
                );
                wp_list_categories( $args );
              ?>
            </ul>

            <ul class="sub-cat-nav-archive unstyled large-only">
              <li class="archive"> <span><?php _e('Archiv', 'fwbase'); ?></span>
                <ul><?php wp_get_archives(); ?></ul>
              </li>
            </ul>

            <ul class="sub-cat-nav-taglist unstyled large-only">
              <li class="tags"> <span><?php _e('Schlagw&ouml;rter', 'fwbase'); ?></span>
                <?php

                  $args = array(
                    'smallest'                  => 0.875,
                    'largest'                   => 0.875,
                    'unit'                      => 'rem',
                    'number'                    => 25,
                    'format'                    => 'array',
                    'orderby'                   => 'name',
                    'order'                     => 'ASC',
                    'echo'                      => false,
                  );

                  $pop_tags = wp_tag_cloud($args);

                  echo '<ul>';
                  echo '<li class="tags_overview"> <a href="'.get_permalink(11383).'" title="'.__('Alle Schlagw&ouml;rter', 'fwbase').'" rel="nofollow">'.__('Alle Schlagw&ouml;rter', 'fwbase').'</a> </li>';
                    foreach ( $pop_tags as $tag ) {
                      echo '<li class="tag">'.$tag.'</li>';
                    }
                  echo '</ul>';

                ?>
              </li>
            </ul>
          </nav>

        <?php
          elseif ( $post_counter == 1  && $current_paged > 0 ) :

            echo '<section class="article-row default-row-layout">';

      		  get_template_part( 'content', get_post_format() ) ;

          elseif ( $post_counter == 2 && $current_paged > 0 ) :

      		  get_template_part( 'content', get_post_format() ) ;

      		  echo '</section>';

				//Ad section ?>


							<?php if(function_exists('oiopub_banner_zone')) oiopub_banner_zone(3, 'center'); ?>

            <div class="ad-section ad-2col">

            <h6 class="section-headline"> <span> <?php _e('Unsere Sponsoren', 'fwbase')?> </span> </h6>
              <div class="ad-2col-left ad-medium-two">
                <img src="https://placehold.it/300x250" alt="Placeholder Medium">
                <img src="https://placehold.it/300x250" alt="Placeholder Medium">
              </div>

              <div class="ad-2col-right ad-small-four">
                <img src="https://placehold.it/300x100" alt="Placeholder Rectangle">
                <img src="https://placehold.it/300x100" alt="Placeholder Rectangle">
                <img src="https://placehold.it/300x100" alt="Placeholder Rectangle">
                <img src="https://placehold.it/300x100" alt="Placeholder Rectangle">
              </div>

            </div>
          <?php

          elseif ( $post_counter == 2 && $current_paged == 0 ) :

      		  //get_template_part( 'content', 'module-a' );

	          include(locate_template('content-module-a.php'));

          elseif ( $post_counter == 3 ):

            echo '<section class="article-row default-row-layout">';

      		  get_template_part( 'content', get_post_format() );

          elseif ( $post_counter == 4 ) :

      		  get_template_part( 'content', get_post_format() );

      		  echo '</section>';

          elseif ( $post_counter == 5 ):

            //Ad section
            if ( $current_paged == 0 ) : ?>



            <div class="ad-section ad-2col">

							<?php if(function_exists('oiopub_banner_zone')) oiopub_banner_zone(3, 'center'); ?>

              <h6 class="section-headline"> <span> <?php _e('Unsere Sponsoren', 'fwbase')?> </span> </h6>
              <div class="ad-2col-left">
				<div class="ad-medium-one"></div>
				<div class="ad-medium-one"></div>
              </div>

			  <div class="ad-2col-right">
				<div class="ad-medium-one"></div>
				<div class="ad-medium-one"></div>
              </div>

            <style>


            .ad-2col-left .ad-medium-one, .ad-2col-right .ad-medium-one {
              float: left;
              width: 50%;
            }

            @media screen and (max-width: 46.195em) {

                .ad-2col-left .ad-medium-one, .ad-2col-right .ad-medium-one {
                    float: none;
                    width: 100%;
                }

            }

            .ad-2col-left .ad-medium-one .oio-banner-zone .oio-slot, .ad-2col-right .ad-medium-one .oio-banner-zone .oio-slot {
              width: 100% !important;
            }

            .ad-2col-right {
                margin-right: 0 !important;
            }
            /*@media only screen and (max-width: 46.195em) {*/
                /*.ad-2col {*/
                    /*display: none;*/
                /*}*/
            /*}*/
            </style>
             <!-- <div class="ad-2col-right ad-small-four">
                <img src="https://placehold.it/300x100" alt="Placeholder Rectangle">
                <img src="https://placehold.it/300x100" alt="Placeholder Rectangle">
                <img src="https://placehold.it/300x100" alt="Placeholder Rectangle">
                <img src="https://placehold.it/300x100" alt="Placeholder Rectangle">
              </div> -->

            </div>
            <?php endif;

            echo '<section class="article-row default-row-layout">';

      		  get_template_part( 'content', get_post_format() );

          elseif ( $post_counter == 6 ) :

      		  get_template_part( 'content', get_post_format() );

      		  echo '</section>';

          elseif ( $post_counter == 7 ) :

      		  //get_template_part( 'content', 'module-a' );

	          include(locate_template('content-module-a.php'));

            //Service section ?>

            <div class="dienstleister-section medium-up">

              <h3 class="section-headline"> <span> <?php _e('Plant eure Hochzeit mit Anbietern, die wir empfehlen!', 'fwbase'); ?> </span> </h3>
              
              <div class="dienstleister-section-intro">
                <div>
                  <h2> <?php _e('Die besten Hochzeits&shy;dienstleister in einer &Uuml;bersicht', 'fwbase'); ?> </h2>
                  <a href="<?php echo get_bloginfo('url').'/wahnbuechlein/'; /*get_term_link(3129, 'wahn_categorie');*/ ?>" class="button"> <?php _e('Finde alle Hochzeitsanbieter hier', 'fwbase'); ?> </a>
                </div>
              </div>

              <?php

                $sub_Query = new WP_Query( array(
                  'post_type' => 'hw_wahnbuechlein',
                  'posts_per_page'  => 3,
                  'orderby' => 'rand',
                  'date_query' => array(
                    'after' => date('Y-m-d', strtotime('-360 days'))
                  )
                ));

                if ( $sub_Query->have_posts() ) :

              ?>

              <ul class="dienstleister-section-selection unstyled">

                <?php while ( $sub_Query->have_posts() ) : $sub_Query->the_post(); ?>

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

                    <div class="dienstleister-entry-content">

                      <span class="dl-entry-cat">
                        <?php
                          $categories = get_the_terms( $post->ID, 'wahn_categorie' );
                          foreach( $categories as $category ) {
                            if( $category->name != 'Alle Dienstleister') {
                              echo $category->name;
                            }
                          }
                        ?>
                      </span>

                      <h5><?php the_title(); ?></h5>

                      <span class="dl-entry-region">
                        <?php
                          $regionen = get_the_terms( $post->ID, 'wahn_region' );
                          foreach( $regionen as $region ) {
                            echo $region->name;
                          }
                        ?>
                      </span>

                      <span class="dl-entry-link">Zum Portfolio</span>

                    </div>

                    <img src="<?php echo $post_thumb_s[0]; ?>"
                      srcset="<?php echo $post_thumb_m[0].' '.$post_thumb_m[1].'w'; ?>,
                              <?php echo $post_thumb_l[0].' '.$post_thumb_l[1].'w'; ?>" size="100vw" alt="<?php echo $post_thumb_alt; ?>">
                  </a>
                </li>

                <?php } ?>

                <?php endwhile; wp_reset_postdata(); ?>

              </ul>

              <?php endif; ?>

            </div>


          <?php

          elseif ( $post_counter == 8 ) :

      		  get_template_part( 'content', 'module-c' );

          elseif ( $post_counter == 9 ):

            echo '<section class="article-row default-row-layout">';

      		  get_template_part( 'content', get_post_format() );

          elseif ( $post_counter == 10 ) :

            get_template_part( 'content', get_post_format() );

      		  echo '</section>';

	// Ad section ?>


       <div class="ad-section ad-2col">
              <h6 class="section-headline"> <span> <?php _e('Unsere Sponsoren', 'fwbase')?> </span> </h6>
            <!--   <div class="ad-2col-left ad-small-two">
              </div>

              <div class="ad-2col-right ad-small-two">
              </div> -->
  <div class="ad-2col-left">
				<div class="ad-medium-one"></div>
				<div class="ad-medium-one"></div>
              </div>

			  <div class="ad-2col-right">
				<div class="ad-medium-one"></div>
				<div class="ad-medium-one"></div>
              </div>

            </div>
      		  <?php

          elseif ( $post_counter == 11 ) :

      		  //get_template_part( 'content', 'module-a' );

            include(locate_template('content-module-a.php'));

          elseif ( $post_counter == 12 ) :

            echo '<section class="article-row default-row-layout">';

      		  get_template_part( 'content', get_post_format() );

          elseif ( $post_counter == 13 ) :

      		  get_template_part( 'content', get_post_format() );

      		  echo '</section>';

          elseif ( $post_counter == 14 ) :

			get_template_part( 'content', 'module-c' );

      	  elseif ( $post_counter > 14 ) :

      		  get_template_part( 'content' );

      		endif;

        }

      	?>

      <?php $post_counter++; endwhile; ?>

 <div class="ad-section ad-2col">
              <h6 class="section-headline"> <span> <?php _e('Unsere Sponsoren', 'fwbase')?> </span> </h6>
              <div class="ad-2col-left">
				<div class="ad-medium-one"></div>
				<div class="ad-medium-one"></div>
              </div>

			  <div class="ad-2col-right">
				<div class="ad-medium-one"></div>
				<div class="ad-medium-one"></div>
              </div>

           
     </div>
			<div class="ad-section ad-2col">
			<h6 class="section-headline"> <span> <?php _e('Locations & Flitterwochen', 'fwbase')?> </span> </h6>
<?php
$catPost = get_posts('cat=5841&posts_per_page=-4&orderby=rand');
   foreach ($catPost as $post) : setup_postdata($post); ?>
  <div style="width:22.5%;display:inline;text-align:center"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
    <?php the_post_thumbnail('name of your thumbnail'); ?>
  </a>

<h6 style="text-transform: uppercase">
  <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
    <?php the_title(); ?>
  </a>
</h6></div>
<?php  endforeach;?>

			    <!-- <div class="ad-2col-left">
			      <div class="ad-medium-one"></div>
						<div class="ad-medium-one"></div>
			    </div>

					<div class="ad-2col-right">
						<div class="ad-medium-one"></div>
						<div class="ad-medium-one"></div>
			    </div>

			    <div class="ad-2col-right ad-small-four">
			      <img src="https://placehold.it/300x100" alt="Placeholder Rectangle">
			      <img src="https://placehold.it/300x100" alt="Placeholder Rectangle">
			      <img src="https://placehold.it/300x100" alt="Placeholder Rectangle">
			      <img src="https://placehold.it/300x100" alt="Placeholder Rectangle">
			    </div> -->

			</div>

    <?php else : ?>

      <?php get_template_part( 'content', 'none' ); ?>

    <?php endif; ?>
  </main>
  <?php fwbase_paging_nav(); ?>

<?php get_footer(); ?>
