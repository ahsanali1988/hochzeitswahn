<?php

/**

 * Template Name: Gallery Page

 * Description: Template zur Darstellung der Galerien

 *

 * Please note that this is the WordPress construct of pages

 * and that other 'pages' on your WordPress site will use a

 * different template.

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



?>
<?php /*<div class="ad-section ad-leaderboard medium-up"> <img src="http://placehold.it/728x90" alt="Placeholder Leaderboard"> </div>*/ ?>

<div class="ad-section ad-2col nomargin">
  <?php if ( current_user_can( 'administrator' ) ) { ?>
  <?php if(function_exists('oiopub_banner_zone')) oiopub_banner_zone(3, 'center'); ?>
  <?php	}; ?>
</div>
<header class="page-header">
  <h1 class="page-title section-headline"> <span>
    <?php _e('Galerie', 'fwbase'); ?>
    </span> </h1>
</header>
<main id="main" class="site-main" role="main">
  <?php



      $attachment = ( get_query_var( 'attached' ) ) ? get_query_var( 'attached' ) : '';



      // Create wildcard to meta_query for flexible content

      function my_posts_where( $where ) {

      	$where = str_replace("meta_key = 'flex_gallery_%", "meta_key LIKE 'flex_gallery_%", $where);

      	return $where;

      }

      add_filter('posts_where', 'my_posts_where');



      // args with flexible content query

      $args = array(

        'posts_per_page'  => -1, /* get only the first 50 entries */

      	'post_type'		=> 'post',
      	'post_status'		=> 'publish',

      	'oderby'      => 'date',

//      	'meta_query' => array(
//
//          array(
//
//          	'key'     => 'flex_gallery_%_flex_gallery_only',
//
//          	'value'   => 1,
//
//          ),
//
//        ),

      );



      if( isset($attachment) ) {

        $args['p'] = $attachment;

      }



      $pre_query  = new WP_Query( $args );



      $parentIDs = array();



      if( $pre_query->have_posts() ): while ( $pre_query->have_posts() ) : $pre_query->the_post();

//  if ($_SERVER['REMOTE_ADDR'] == "182.190.76.94") {
// echo '<pre>';
// print_r($post->ID);
//    }
        $parentIDs[] = $post->ID;



      endwhile; endif;

// echo '<pre>';
// print_r($pre_query);

      $args = array(

        'post_type' => 'attachment',

        'post_status'=>'inherit',

        'posts_per_page'  => 30,

        'orderby' => 'date',

        'post_parent__in' => $parentIDs,

        'meta_key' => 'fw_show_gallery',

      );



      $args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

      $the_query  = new WP_Query( $args );



    ?>
  <nav class="sub-category-nav">
    <ul class="sub-cat-nav-catlist unstyled">
      <?php

          // Collects all query vars

          $cat_query = ( get_query_var( 'bilderkategorie' ) != '' ) ? get_query_var( 'bilderkategorie' ) : '';

          $col_query = ( get_query_var( 'bilderfarben' ) != '' ) ? get_query_var( 'bilderfarben' ) : '';

          $tag_query = ( get_query_var( 'bildertags' ) != '' ) ? get_query_var( 'bildertags' ) : '';



          //$current_url = esc_url(home_url(add_query_arg(array(),$wp->request)));

          $current_url = esc_url(home_url('/hochzeitswahn-galerien/'));



        ?>
      <?php

          $terms = get_terms('bilderkategorie');

          echo '<li> <span>'. __( 'Kategorien:', 'fwbase' ) .'</span>';

          echo '<ul>';

            echo '<li class="tags_overview"> <a href="'.$current_url.'?bilderkategorie=&bilderfarben='.$col_query.'&bildertags='.$tag_query.'" title="Alle Kategorien" rel="nofollow">Alle Kategorien</a> </li>';

            foreach( $terms as $term ) {

              if( $term->slug === $cat_query ) {

                echo '<li class="active"> <a href="'.$current_url.'?bilderkategorie='.$term->slug.'&bilderfarben='.$col_query.'&bildertags='.$tag_query.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';

              } else {

                echo '<li> <a href="'.$current_url.'?bilderkategorie='.$term->slug.'&bilderfarben='.$col_query.'&bildertags='.$tag_query.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';

              }

            }

          echo '</ul> </li>';

        ?>
    </ul>
    <ul class="sub-cat-nav-catlist unstyled">
      <?php

          $terms = get_terms('bilderfarben');

          echo '<li> <span>'. __( 'Farben:', 'fwbase' ) .'</span>';

          echo '<ul>';

            echo '<li class="tags_overview"> <a href="'.$current_url.'?bilderkategorie='.$cat_query.'&bilderfarben=&bildertags='.$tag_query.'" title="Alle Farben" rel="nofollow">Alle Farben</a> </li>';

            foreach( $terms as $term ) {

              if( $term->slug === $col_query ) {

                echo '<li class="active"> <a href="'.$current_url.'?bilderkategorie='.$cat_query.'&bilderfarben='.$term->slug.'&bildertags='.$tag_query.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';

              } else {

                echo '<li> <a href="'.$current_url.'?bilderkategorie='.$cat_query.'&bilderfarben='.$term->slug.'&bildertags='.$tag_query.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';

              }

            }

          echo '</ul> </li>';

        ?>
    </ul>
    <ul class="sub-cat-nav-catlist unstyled">
      <?php

          $terms = get_terms('bildertags');

          echo '<li> <span>'. __( 'Schlagw&ouml;rter:', 'fwbase' ) .'</span>';

          echo '<ul>';

            echo '<li class="tags_overview"> <a href="'.$current_url.'?bilderkategorie='.$cat_query.'&bilderfarben='.$col_query.'&bildertags=" title="'.$term->name.'" title="Alle Schlagw&ouml;rter" rel="nofollow">Alle Schlagw&ouml;rter</a> </li>';

            foreach( $terms as $term ) {

              if( $term->slug === $tag_query ) {

                echo '<li class="active"> <a href="'.$current_url.'?bilderkategorie='.$cat_query.'&bilderfarben='.$col_query.'&bildertags='.$term->slug.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';

              } else {

                echo '<li> <a href="'.$current_url.'?bilderkategorie='.$cat_query.'&bilderfarben='.$col_query.'&bildertags='.$term->slug.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';

              }

            }

          echo '</ul> </li>';



        ?>
    </ul>
  </nav>
  <?php if( $cat_query != '' || $col_query != '' || $tag_query != '' ) : ?>
  <div class="delete-filters"> <a class="filter-to-delte" href="<?php echo get_permalink(11152); ?>" title="<?php _e('Alle Filter l&ouml;schen', 'fwbase'); ?>">
    <?php _e('Alle Filter l&ouml;schen', 'fwbase'); ?>
    </a>
    <?php

          if( $cat_query != '' ) { echo '<a class="filter-to-delete" href="'.$current_url.'?bilderkategorie=&bilderfarben='.$col_query.'&bildertags='.$tag_query.'" title="'.__('Filter l&ouml;schen', 'fwbase').'">'.__('Kategorie l&oumlschen', 'fwbase').'</a>'; }

          if( $col_query != '' ) { echo '<a class="filter-to-delete" href="'.$current_url.'?bilderkategorie='.$cat_query.'&bilderfarben=&bildertags='.$tag_query.'" title="'.__('Filter l&ouml;schen', 'fwbase').'">'.__('Farbe l&oumlschen', 'fwbase').'</a>'; }

          if( $tag_query != '' ) { echo '<a class="filter-to-delete" href="'.$current_url.'?bilderkategorie='.$cat_query.'&bilderfarben='.$col_query.'&bildertags=" title="'.__('Filter l&ouml;schen', 'fwbase').'">'.__('Schlagwort l&oumlschen', 'fwbase').'</a>'; }

        ?>
  </div>
  <?php endif; ?>
  <?php if( $the_query->have_posts() ): ?>
  <div class="gallery-loader"></div>
  <ul class="entry-gallery unstyled" ontouchstart="">
    <li class="sizer"></li>
    <?php if ( !post_password_required() ): ?>
    <?php



        while ( $the_query->have_posts() ) : $the_query->the_post();



          $image_s = wp_get_attachment_image_src( $post->ID, 'content-s' );

          $image_m = wp_get_attachment_image_src( $post->ID, 'content-m' );

          $image_l = wp_get_attachment_image_src( $post->ID, 'content-l' );

          $image_caption = wp_prepare_attachment_for_js($post->ID);

          $image_meta = get_post_meta($post->ID);

          $image_alt = get_post_meta($post->ID, '_wp_attachment_image_alt', true);

          $attachment = ( get_query_var( 'attached' ) ) ? get_query_var( 'attached' ) : '';



          if( $attachment != '' && $attachment != $image_caption['uploadedTo'] ) {

            continue;

          }



        ?>
    <li <?php if ( $image_s[2] > $image_s[1]  || (isset($image_meta['fw_media_class']) && $image_meta['fw_media_class'][0] == 'portrait') ) { echo 'class="portrait"'; } ?>>
      <div class="img-hover abc">
        <div class="open-hover" aria-label="<?php _e('Mehr Infos', 'fwbase')?>"> <span class="icon-schliessen"></span> </div>
        <div class="img-hover-info">
          <div> <span class="sharing-options" data-modal-id="<?php echo $post->ID; ?>">
            <?php //echo do_shortcode('[easy-social-share buttons="pinterest,fave" counters=0 hide_names="force" template="light-retina url="'.$image_m[0].'"]'); ?>
            <?php echo do_shortcode('[share-image image="'.$image_caption['ID'].'"]'); ?> </span>
            <?php

                    if( $image_caption['caption'] ) {

                      _e('Foto von:', 'fwbase');

                      if( get_post_meta( $post->ID, 'opt_img_photograph', true) != '' ) {

                        echo '<a href="http://'.get_post_meta( $post->ID, 'opt_img_photograph', true).'" title="" rel="nofollow" target="_blank"> <strong>'.$image_caption['caption'].'</strong> </a>';

                      } else {

                      echo '<strong>'.$image_caption['caption'].'</strong>';

                      }

                    }

                  ?>
            <?php echo '<a class="img-link-post" href="'.get_permalink($image_caption['uploadedTo']).'" title=""> Zum Beitrag </a>'; ?> </div>
        </div>
      </div>
      <a href="<?php echo get_permalink().'?details=gallery'; ?>" title=""> <img width="<?php echo $image_s[1]; ?>" height="<?php echo $image_s[2]; ?>" src="<?php echo $image_s[0]; ?>"

                srcset="<?php echo $image_m[0].' '.$image_m[1].'w,'; ?>

                        <?php echo $image_l[0].' '.$image_l[1].'w'; ?>" size="100vw" alt="<?php echo $image_alt; ?>"> </a>
      <div class="remodal fav-modal-window" data-remodal-id="modal-<?php echo $post->ID;?>"> <?php echo do_shortcode('[userpro_bookmark_image bookmark_icon="show" post_id='.$post->ID.' display="none" image_id="'.$post->ID.'"]'); ?> </div>
    </li>
    <?php



        endwhile;



      ?>
    <?php endif; ?>
  </ul>
  <?php else:  ?>
  <?php endif; ?>
  <?php wp_reset_postdata();



      // Pagination fixes for Custom Queries

      // http://wordpress.stackexchange.com/questions/120407/how-to-fix-pagination-for-custom-loops

      $big = 999999999;



      echo '<div class="pagination-links">'.paginate_links( array(

      	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),

      	'format' => '?paged=%#%',

      	'current' => max( 1, get_query_var('paged') ),

      	'total' => $the_query->max_num_pages,

        'prev_text' => __('&#x2190;'),

        'next_text' => __('&#x2192;'),

      ) ).'</div>';



    ?>
  <div class="ad-section ad-2col">
    <div class="ad-2col-left ad-small-two"> </div>
    <div class="ad-2col-right medium-up ad-small-two"> </div>
  </div>
</main>
<!-- #main -->

<?php get_footer(); ?>
