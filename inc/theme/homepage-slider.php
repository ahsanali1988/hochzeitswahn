 <section class="content-100" id="slider-section">
               <div style="width:100%;text-align:center;background-color:#fbfbfb;margin:0;padding:25px;">
                <div>
                  <h2 style="padding-bottom:5px; margin-bottom:0;"> <?php _e('Hochzeitsplanung leicht gemacht!', 'fwbase'); ?> </h2>
                                                            <p style="text-transform: uppercase;">Mit unserem exklusiven Hochzeitsanbieterverzeichnis wird jede Hochzeit und Planung zu einem sorgenfreien Ereignis!</p>
                                     <nav class="sub-category-nav" style="margin:15px 0;padding:0;">
        <ul class="sub-cat-nav-catlist unstyled">
          <?php             
            $terms = get_terms('wahn_region');

            echo '<li class="wahn_region"> <span>'. __( 'Suche in Region:', 'fwbase' ) .'</span>';
            echo '<ul>';
              if( !empty($reg_query) && !empty($cat_query) ) { echo '<li class="tags_overview"> <a href="'.$current_url.'?wahn_categorie='.$cat_query.'&wahn_region=" title="Alle Regionen" rel="nofollow">Alle Regionen</a> </li>'; }
              foreach( $terms as $term ) {
                if( $term->slug === $reg_query ) {
                  echo '<li class="active"> <a href="'.$current_url.'?wahn_categorie='.$cat_query.'&wahn_region='.$term->slug.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';
                } else {                
                  echo '<li> <a href="'.$current_url.'?wahn_categorie='.$cat_query.'&wahn_region='.$term->slug.'" title="'.$term->name.'" rel="nofollow">'.$term->name.'</a> </li>';
                }
              }
            echo '</ul> </li>';
          ?>
        </ul>                               
      </nav>  	
                  <a href="<?php echo get_bloginfo('url').'/wahnbuechlein/'; /*get_term_link(3129, 'wahn_categorie');*/ ?>" class="button" style="font-size:130%;"> <?php _e('Finde Deine Hochzeitsanbieter in einer &Uuml;bersicht', 'fwbase'); ?> </a>              
                </div>
              </div>
  <div id="slides">
<?php

  $WORD_COUNT_TITLES=8;
  $WORD_COUNT_TEXT=15;
  $FALLBACK_IMAGE_URL='/wp-content/themes/hochzeitswahn_v3/img/homepage-slider-fallback.jpg';
  $FALLBACK_IMAGE_DIY_URL='/wp-content/themes/hochzeitswahn_v3/img/homepage-slider-fallback_diy.jpg';

  // Aktuellster Beitrag
  $sub_Query = new WP_Query( array(
    'post_type' => 'post',
    'posts_per_page'  => 1,
  ));
  $LATEST_POST_ID = $sub_Query->posts[0]->ID;
  wp_reset_postdata();

  // Zufälliger Beitrag aus Echte Hochzeiten / Inspirationen
  $sub_Query = new WP_Query( array(
    'post_type' => 'post',
    'post__not_in' => array($LATEST_POST_ID),
    'posts_per_page'  => 1,
    'category_name' => 'inspirationen',
    'orderby' => 'rand',
    'date_query' => array(
      'after' => date('Y-m-d', strtotime('-365 days'))
    )
  ));

  if ( $sub_Query->have_posts() ) :
    $sub_Query->the_post();
    $imageUrl=$FALLBACK_IMAGE_URL;
    if ( has_post_thumbnail() ) {
       $image=wp_get_attachment_image_src( get_post_thumbnail_id(),'large' );
       $imageUrl=$image[0];
    }
  ?>
  <div class="slide-element">
    <a href="<?=get_permalink(); ?>" title="<?=get_the_title(); ?>" class="slide-img-link disabled"><div class="slide-image" style="background-image: url('<?=$imageUrl; ?>');"></div></a>

    <div class="slide-text">
      <div class="col-12">
        <p class="slide-category">Echte Hochzeiten</p>
      </div>

      <div class="col-6">
        <h2><?=wp_trim_words(get_the_title(),$WORD_COUNT_TITLES); ?></h2>
      </div>

      <div class="col-6 abstract fadeIn">
        <p><?=wp_trim_words(get_the_excerpt(),$WORD_COUNT_TEXT); ?></p>
        <a href="<?=get_permalink(); ?>" class="button-slider">Zum Beitrag</a>
      </div>
    </div>

  </div>
<?php
  wp_reset_postdata();
  endif;
 ?>

<?php

  // Zufälliger Beitrag aus Hochzeitstrends / Inspirationsideen
  $sub_Query = new WP_Query( array(
    'post_type' => 'post',
    'post__not_in' => array($LATEST_POST_ID),
    'posts_per_page'  => 1,
    'category_name' => 'inspirationsideen',
    'orderby' => 'rand',
    'date_query' => array(
      'after' => date('Y-m-d', strtotime('-365 days'))
    )
  ));

  if ( $sub_Query->have_posts() ) :
    $sub_Query->the_post();
    $imageUrl=$FALLBACK_IMAGE_URL;
    if ( has_post_thumbnail() ) {
       $image=wp_get_attachment_image_src( get_post_thumbnail_id(),'large' );
       $imageUrl=$image[0];
    }
  ?>
  <div class="slide-element">
  <a href="<?=get_permalink(); ?>" title="<?=get_the_title(); ?>" class="slide-img-link disabled">  <div class="slide-image" style="background-image: url('<?=$imageUrl; ?>');"></div></a>

    <div class="slide-text">
      <div class="col-12">
        <p class="slide-category">Hochzeitstrends</p>
      </div>

      <div class="col-6">
        <h2><?=wp_trim_words(get_the_title(),$WORD_COUNT_TITLES); ?></h2>
      </div>

      <div class="col-6 abstract fadeIn">
        <p><?=wp_trim_words(get_the_excerpt(),$WORD_COUNT_TEXT); ?></p>
        <a href="<?=get_permalink(); ?>" class="button-slider">Zum Beitrag</a>
      </div>
    </div>

  </div>
<?php
  wp_reset_postdata();
  endif;
 ?>

<?php

  // Aktuellster Beitrag
  $sub_Query = new WP_Query( array(
    'p' => $LATEST_POST_ID,
    'posts_per_page'  => 1,
  ));

  if ( $sub_Query->have_posts() ) :
    $sub_Query->the_post();
    $imageUrl=$FALLBACK_IMAGE_URL;
    if ( has_post_thumbnail() ) {
       $image=wp_get_attachment_image_src( get_post_thumbnail_id(),'large' );
       $imageUrl=$image[0];
    }
  ?>
  <div class="slide-element active-slide">
    <a href="<?=get_permalink(); ?>" title="<?=get_the_title(); ?>" class="slide-img-link"><div class="slide-image" style="background-image: url('<?=$imageUrl; ?>');"></div></a>

    <div class="slide-text">
      <div class="col-12">
        <p class="slide-category">Aktuell</p>
      </div>

      <div class="col-6">
        <h2><?=wp_trim_words(get_the_title(),$WORD_COUNT_TITLES); ?></h2>
      </div>

      <div class="col-6 abstract fadeIn">
        <p><?=wp_trim_words(get_the_excerpt(),$WORD_COUNT_TEXT); ?></p>
        <a href="<?=get_permalink(); ?>" class="button-slider">Zum Beitrag</a>
      </div>
    </div>

  </div>
<?php
  wp_reset_postdata();
  endif;
 ?>

<?php

  // Zufälliger Beitrag aus Lookbook
  $sub_Query = new WP_Query( array(
    'post_type' => 'hw_lookbook',
    'post__not_in' => array($LATEST_POST_ID),
    'posts_per_page'  => 1,
    'orderby' => 'rand',
    'date_query' => array(
      'after' => date('Y-m-d', strtotime('-365 days'))
    )
  ));

  if ( $sub_Query->have_posts() ) :
    $sub_Query->the_post();
    $imageUrl=$FALLBACK_IMAGE_URL;
    if ( has_post_thumbnail() ) {
       $image=wp_get_attachment_image_src( get_post_thumbnail_id(),'large' );
       $imageUrl=$image[0];
    }
  ?>
  <div class="slide-element">
    <a href="<?=get_permalink(); ?>" title="<?=get_the_title(); ?>" class="slide-img-link disabled"><div class="slide-image" style="background-image: url('<?=$imageUrl; ?>');"></div></a>

    <div class="slide-text">
      <div class="col-12">
        <p class="slide-category">Hochzeitskollektionen</p>
      </div>

      <div class="col-6">
        <h2><?=wp_trim_words(get_the_title(),$WORD_COUNT_TITLES); ?></h2>
        <?=get_the_title($post->post_parent); ?>
      </div>

      <div class="col-6 abstract fadeIn">
        <p>Aktuelle Brautkleider &amp; Accessoires entdecken</p>
        <a href="<?=get_permalink(); ?>" class="button-slider">Zum Beitrag</a>
      </div>
    </div>

  </div>
<?php
  wp_reset_postdata();
  endif;
 ?>

<?php

  // Zufälliger Beitrag aus Wahnbuechlein Kategorie Allgemein
  $sub_Query = new WP_Query( array(
    'post_type' => 'post',
    'post__not_in' => array($LATEST_POST_ID),
    'posts_per_page'  => 1,
    'category_name' => 'selbstgemacht',
    'orderby' => 'rand',
    'date_query' => array(
      'after' => date('Y-m-d', strtotime('-365 days'))
    )
  ));

  if ( $sub_Query->have_posts() ) :
    $sub_Query->the_post();
    $imageUrl=$FALLBACK_IMAGE_DIY_URL;
    if ( has_post_thumbnail() ) {
       $image=wp_get_attachment_image_src( get_post_thumbnail_id(),'large' );
       $imageUrl=$image[0];
    }
  ?>
  <div class="slide-element">
    <a href="<?=get_permalink(); ?>" title="<?=get_the_title(); ?>" class="slide-img-link disabled"><div class="slide-image" style="background-image: url('<?=$imageUrl; ?>');"></div></a>

    <div class="slide-text">
      <div class="col-12">
        <p class="slide-category">DIY</p>
      </div>

      <div class="col-6">
        <h2><?=wp_trim_words(get_the_title(),$WORD_COUNT_TITLES); ?></h2>
      </div>

      <div class="col-6 abstract fadeIn">
        <p><?=wp_trim_words(get_the_excerpt(),$WORD_COUNT_TEXT); ?></p>
        <a href="<?=get_permalink(); ?>" class="button-slider">Zum Beitrag</a>
      </div>
    </div>

  </div>
<?php
  wp_reset_postdata();
  endif;
 ?>
</div>
</section>