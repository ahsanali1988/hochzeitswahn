<?php

/**

 * The template for displaying archive pages.

 *

 * Learn more: https://codex.wordpress.org/Template_Hierarchy

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



  <header class="page-header">

    <h1 class="page-title section-headline">

    	<span>

    	<?php

    	  if ( is_category() ) :

    	  	single_cat_title();



    	  elseif ( is_tag() ) :

    	  	single_tag_title();



    	  elseif ( is_author() ) :

    	  	printf( __( 'Autor: %s', 'fwbase' ), '<span class="vcard">'.get_the_author().'</span>' );



    	  elseif ( is_day() ) :

    	  	printf( __( 'Tag: %s', 'fwbase' ), '<span>'.get_the_date().'</span>' );



    	  elseif ( is_month() ) :

    	  	printf( __( 'Monat: %s', 'fwbase' ), '<span>'.get_the_date( _x( 'F Y', 'monthly archives date format', 'fwbase' ) ).'</span>' );



    	  elseif ( is_year() ) :

    	  	printf( __( 'Jahr: %s', 'fwbase' ), '<span>'.get_the_date( _x( 'Y', 'yearly archives date format', 'fwbase' ) ).'</span>' );



    	  elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :

    	  	_e( 'Asides', 'fwbase' );



    	  elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :

    	  	_e( 'Galerien', 'fwbase' );



    	  elseif ( is_tax( 'post_format', 'post-format-image' ) ) :

    	  	_e( 'Bilder', 'fwbase' );



    	  elseif ( is_tax( 'post_format', 'post-format-video' ) ) :

    	  	_e( 'Videos', 'fwbase' );



    	  elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :

    	  	_e( 'Zitate', 'fwbase' );



    	  elseif ( is_tax( 'post_format', 'post-format-link' ) ) :

    	  	_e( 'Links', 'fwbase' );



    	  elseif ( is_tax( 'post_format', 'post-format-status' ) ) :

    	  	_e( 'Status', 'fwbase' );



    	  elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :

    	  	_e( 'Audios', 'fwbase' );



    	  elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :

    	  	_e( 'Chats', 'fwbase' );



    	  else :

    	  	_e( 'Archiv', 'fwbase' );



    	  endif;

    	?>

    	</span>

    </h1>



    <?php

      if ( is_author() ) :

        echo '<p class="author-bio">'.get_the_author_meta('description').'</p>';

      endif;

    ?>



  </header>



  <main id="main" class="site-main" role="main">



	<?php if ( have_posts() ) : $post_counter = 1; $current_paged = get_query_var('paged'); ?>



    <nav class="sub-category-nav">



      <ul class="sub-cat-nav-catlist unstyled">

        <?php

          $args = array(

        	  'style'              => 'list',

        	  'use_desc_for_title' => 0,

        	  'hierarchical'       => 1,

      	  	'child_of'           => get_query_var('cat'),

      	  	'show_option_none'   => __('Keine weiteren Unterkategorien verf&uuml;gbar', 'fwbase'),

        	  'echo'               => 1,

        	  'taxonomy'           => 'category',

        	  'title_li'           => '<span>'.__( 'Weitere Kategorien', 'fwbase' ).'</span>'

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



            <!--  <?php if ( current_user_can( 'administrator' ) ) { ?>

                    <?php if(function_exists('oiopub_banner_zone')) oiopub_banner_zone(3, 'center'); ?>

              <?php	}; ?> -->



              <h6 class="section-headline"> <span> <?php _e('Unsere Sponsoren', 'fwbase')?> </span> </h6>

              <div class="ad-2col-left ad-medium-two">

                <img src="https://placehold.it/300x250" alt="Placeholder Medium">

                <img src="https://placehold.it/300x250" alt="Placeholder Medium">

              </div>



              <div class="ad-2col-right ad-small-four">

                <img src="https://placehold.it/300x100" alt="Placeholder Rectangle">

                <img src="https://placehold.it/300x100" alt="Placeholder Rectangle" class="medium-up">

                <img src="https://placehold.it/300x100" alt="Placeholder Rectangle" class="medium-up">

                <img src="https://placehold.it/300x100" alt="Placeholder Rectangle" class="medium-up">

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



          if ( $post_counter == 1 ) :



          echo '<section class="article-row default-row-layout">';



      		  get_template_part( 'content', get_post_format() ) ;



          elseif ( $post_counter == 2) :



      		  get_template_part( 'content', get_post_format() ) ;



      		echo '</section>';



          //Ad section ?>



          <div class="ad-section ad-2col">



						<?php if(function_exists('oiopub_banner_zone')) oiopub_banner_zone(3, 'center'); ?>

						

            <h6 class="section-headline"> <span> <?php _e('Unsere Sponsoren', 'fwbase')?> </span> </h6>

            <div class="ad-2col-left ad-medium-two">

              <img src="https://placehold.it/300x250" alt="Placeholder Medium">

              <img src="https://placehold.it/300x250" alt="Placeholder Medium">

            </div>



            <div class="ad-2col-right ad-small-four">

              <img src="https://placehold.it/300x100" alt="Placeholder Rectangle">

              <img src="https://placehold.it/300x100" alt="Placeholder Rectangle" class="medium-up">

              <img src="https://placehold.it/300x100" alt="Placeholder Rectangle" class="medium-up">

              <img src="https://placehold.it/300x100" alt="Placeholder Rectangle" class="medium-up">

            </div>



          </div>



          <?php



          elseif ( $post_counter == 3 ):



            echo '<section class="article-row default-row-layout">';



      		  get_template_part( 'content', get_post_format() );



          elseif ( $post_counter == 4 ) :



      		  get_template_part( 'content', get_post_format() );



      		  echo '</section>';



          elseif ( $post_counter == 5 ):



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



                <li>

                  <?php

                    if ( has_post_thumbnail() ) {



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

                      <?php

                    }

                  ?>

                </li>



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

              <div class="ad-2col-left ad-small-two">

              </div>



              <div class="ad-2col-right medium-up ad-small-two">

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



            if( $post_counter-1 == 14 ) echo '<section class="article-row default-row-layout last-final-row">';



              get_template_part( 'content' );



            if( $post_counter == $the_query->post_count ) echo '</section>';



      		endif;



        }



      ?>



    <?php $post_counter++; endwhile; ?>





<?php

if (in_category(5841)) { 

 _e('<div style="text-align:center;"><h3 style="color:#ffc1ac"><a href="https://www.instagram.com/hellobeautifulplaces/" target="_blank">@hellobeautifulplaces bei Instagram</a></h3></div>', 'fwbase');

echo do_shortcode('[instagram-journal mode="user" user_id="1634410463" limit="12" gallery_mode="classic" gallery_size="auto" photo_size="24%" gutter_size="2px" classic_hover_photo_background="#ffc1ac" classic_hover_video_background="#ffc1ac" classic_hover_heading_color="#fff" classic_hover_subheading_color="#fff" classic_active_username_color="#333" classic_active_content_color="#333" classic_active_link_color="#ffc1ac" is_full_width="true" enable_links="true" enable_fancybox="false"]');

}

?>



    <div class="ad-section ad-2col">&nbsp;

      <h6 class="section-headline"> <span> <?php _e('Unsere Sponsoren', 'fwbase')?> </span> </h6>

<?php if(function_exists('oiopub_banner_zone')) oiopub_banner_zone(3, 'center'); ?>

     

 <!-- <div class="ad-2col-left ad-small-two">

      </div>

      <div class="ad-2col-right medium-up ad-small-two">

      </div> -->



    </div>



    <?php else : ?>



      <?php get_template_part( 'content', 'none' ); ?>



    <?php endif; ?>



  </main>



  <?php fwbase_paging_nav(); ?>



<?php get_footer(); ?>

