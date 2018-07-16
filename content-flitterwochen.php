<?php
/**
 * @package fwbase
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
  <?php
    echo '<a href="'.get_bloginfo('url').'/flitterwochen/" class="back-to-overview" title="'.__('Zur&uuml;ck zu allen Kategorien','fwbase').'"> <span class="icon-pfeil-links"></span>'.__('Alle Kategorien', 'fwbase').'</a>';

    echo '<div class="post-categories">';
      $categories = get_the_terms( $post->ID, 'flitter_categorie' );
      foreach( $categories as $category ) {
        if( $category->name != 'Alle Dienstleister') {
          echo '<a href="'.get_term_link( $category->slug, 'flitter_categorie' ).'" title="'.$category->name.'">'.$category->name.'</a>';
        }
      }

      $regionen = get_the_terms( $post->ID, 'flitter_region' );
      foreach( $regionen as $region ) {
        echo '<a href="'.get_term_link( $region->slug, 'flitter_region' ).'" title="'.$region->name.'">'.$region->name.'</a>';
      }
    echo '</div>';
  ?>
	</header>

  <aside class="entry-details">

    <div class="entry-details-top">

      <div class="details-top-img">
        <?php
          if( get_field('flitter_profil_logo') ) {
            $logo = get_field('flitter_profil_logo');
            echo '<img src="'.$logo['url'].'" alt="'.$logo['alt'].'">';
          } else {
            echo '<img alt="Profil" src="'.get_bloginfo('template_url').'/img/placeholder.jpg">';
          }
        ?>
        <span class="sharing-options" data-modal-id="<?php echo $post->ID;?>">
          <a class="button link-fave" href="#" title="<?php _e('Als Favorit speichern','fwbase');?>"><span class="icon-hertz"></span><?php _e('Als Favorit speichern','fwbase');?></a>
        </span>
      </div>

      <div class="details-top-content">
        <h1> <?php the_field('flitter_profil_name'); ?> </h1>

        <ul class="unstyled details-top-content-basics">
          <?php if( get_field('flitter_profil_website') ) : ?> <li> <span><?php _e('Webseite:', 'fwbase'); ?></span> <a href="<?php the_field('flitter_profil_website'); ?>" title="Website" rel="nofollow" target="_blank"><?php echo str_replace(array('http://', '/'), '', get_field('flitter_profil_website')); ?></a> </li> <?php endif; ?>
          <?php if( get_field('flitter_profil_email') ) : ?> <li> <span><?php _e('E-Mail:', 'fwbase'); ?></span> <a href="#modal-contact_DL" title=""> <?php the_field('flitter_profil_email'); ?></a> </li> <?php endif; ?>
          <?php if( get_field('flitter_profil_telefon') ) : ?> <li> <span><?php _e('Telefon:', 'fwbase'); ?></span> <?php the_field('flitter_profil_telefon'); ?> </li> <?php endif; ?>
          <li>
            <span><?php _e('Kategorie: ', 'fwbase'); ?></span>
            <?php
              //$categories = get_the_terms( $post->ID, 'flitter_categorie' );
              $counter = 2;
              foreach( $categories as $category ) {
                if( $category->name != 'Alle Dienstleister') {
                  echo $category->name;
                  if( $counter != count($categories) ) echo ', '; $counter++;
                }
              }
            ?>
          </li>
          <li>
            <span><?php _e('Region: ', 'fwbase');    ?></span>
            <?php
              $counter = 1;
              foreach( $regionen as $region ) {
                echo $region->name;
                if( $counter != count($regionen) ) echo ', '; $counter++;
              }
            ?>
          </li>
          <?php if( get_field('flitter_profil_standort') ) : ?> <li>
            <span><?php _e('Standorte:', 'fwbase'); ?></span>

            <?php

              if( have_rows('flitter_profil_standort') ) : $counter = 1; while ( have_rows('flitter_profil_standort') ) : the_row();

                if( !get_sub_field('flitter_profil_standort_maps') ) {

                  echo '<a href="'.get_sub_field('flitter_profil_standort_url').'" rel="nofollow" title="Google Maps Link" target="_blank">'.get_sub_field('flitter_profil_standort_ort').'</a>';

                } else {

                  $location = get_sub_field('flitter_profil_standort_maps');

                  echo '<a href="#modal-map" title="Google Maps Link" class="acf-maps-modal" rel="nofollow">'.get_sub_field('flitter_profil_standort_ort').'</a>';
                  echo '<div class="remodal" data-remodal-id="modal-map"> <div class="acf-map"> <div class="marker" data-lat="'.$location['lat'].'" data-lng="'.$location['lng'].'"></div> </div> </div>';

                }

                if( $counter != count(get_field('flitter_profil_standort')) ) echo ', '; $counter++;

              endwhile; endif;

            ?>

          </li> <?php endif; ?>
          <?php if(get_field('flitter_profil_mobilitaet')) { ?> <li> <span><?php _e('Bereit zu Reisen:', 'fwbase'); ?></span> <?php _e('Ja', 'fwbase'); ?> </li> <?php } ?>
        </ul>

        <ul class="unstyled details-top-content-social">
          <?php if( get_field('flitter_facebook') ) :   ?> <li> <a href="<?php the_field('flitter_facebook');   ?>" target="_blank" title="Facebook" rel="nofollow"> <span class="icon-facebook"></span> </a> </li> <?php endif; ?>
          <?php if( get_field('flitter_twitter') ) :    ?> <li> <a href="<?php the_field('flitter_twitter');    ?>" target="_blank" title="Twitter" rel="nofollow"> <span class="icon-twitter"></span> </a> </li> <?php endif; ?>
          <?php if( get_field('flitter_pinterest') ) :  ?> <li> <a href="<?php the_field('flitter_pinterest');  ?>" target="_blank" title="Pinterest" rel="nofollow"> <span class="icon-pinterest"></span> </a> </li> <?php endif; ?>
          <?php if( get_field('flitter_instagram') ) :  ?> <li> <a href="<?php the_field('flitter_instagram');  ?>" target="_blank" title="Instagram" rel="nofollow"> <span class="icon-instagram"></span> </a> </li> <?php endif; ?>
          <?php if( get_field('flitter_googleplus') ) : ?> <li> <a href="<?php the_field('flitter_googleplus'); ?>" target="_blank" title="Google Plus" rel="nofollow"> <span class="icon-google"></span> </a> </li> <?php endif; ?>
          <?php if( get_field('flitter_blog') ) :       ?> <li> <a href="<?php the_field('flitter_blog');       ?>" target="_blank" title="Blog" rel="nofollow"> <span class="icon-blog"></span> </a> </li> <?php endif; ?>
        </ul>

      </div>

    </div>

    <div class="entry-details-descr">
      <?php the_field('flitter_profil_description'); ?>
    </div>

    <?php if( get_field('flitter_profil_email') ) : ?>
      <a class="entry-details-contact button" href="#modal-contact_DL" title="<?php _e('Kontaktiere diesen Dienstleister','fwbase'); ?>"> <?php _e('Kontaktiere diesen Dienstleister','fwbase'); ?> </a>
    <?php endif; ?>
  </aside>


	<div class="entry-content">

    <div class="entry-slider-wrapper">

		  <?php

      $gallery = get_field('flitter_gallery');

      ?>

      <ul class="entry-slider-wrapper-slider unstyled">

        <?php foreach( $gallery as $image ): ?>

        <li <?php if ( $image['height'] > $image['width'] || get_post_meta($image['ID'], 'fw_media_class', true) == 'portrait') { echo 'class="portrait"'; } ?>>

          <img src="<?php echo $image['sizes']['content-s'] ?>"
            srcset="<?php echo $image['sizes']['content-m'].' '.$image['sizes']['content-m-width'].'w'; ?>,
                    <?php echo $image['sizes']['content-l'].' '.$image['sizes']['content-l-width'].'w'; ?>" size="100vw" alt="<?php echo $image['alt']?>">

        </li>

        <?php endforeach; ?>

        <?php

        if( have_rows('flitter_video') ) : while ( have_rows('flitter_video') ) : the_row();

//          echo '<li class="flex-video"> <div>'.wp_oembed_get( get_sub_field( 'flitter_video_embed' ) ).'</div> </li>';
// deprecated since 02.02.16 iframe error becaus of plugin conflict

			$flittervid = get_sub_field( 'flitter_video_embed');

			if (stripos($flittervid, 'www.') !== false) { // make this if it is a link with a url
				echo '<li class="flex-video"> <div>'.wp_oembed_get( get_sub_field( 'flitter_video_embed') ).'</div> </li>';
			}

			elseif (stripos($flittervid, '[vimeo') !== false) { // make this when it's a shortcode [vimeo id="45454545"]
	            echo '<li class="flex-video"> <div>'.do_shortcode(get_sub_field( 'flitter_video_embed')).'</div> </li>';
			}

			else { // make this if it's just an ID
				echo '<li class="flex-video"> <div>'.do_shortcode('[vimeo id="'.get_sub_field('flitter_video_embed').'"]').'</div> </li>';
			}

        endwhile; endif;

      ?>

      </ul>

      <ul class="entry-slider-nav unstyled">

        <?php $nav_counter = 1; foreach( $gallery as $image ): ?>

        <li class="prod-thumbnail <?php if ( $image['height'] > $image['width'] || get_post_meta($image['ID'], 'fw_media_class', true) == 'portrait') { echo 'portrait'; } ?>">

          <img src="<?php echo $image['sizes']['content-s'] ?>" alt="Thumbnail" data-slick-index="<?php echo $nav_counter; ?>">

        </li>

        <?php $nav_counter++; endforeach; ?>

        <?php if( have_rows('flitter_video') ) : while ( have_rows('flitter_video') ) : the_row(); ?>

          <li class="prod-thumbnail video-thumb"> <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/video-thumb.jpg" alt="Thumbnail" data-slick-index="<?php echo $nav_counter; ?>"> </li>

        <?php $nav_counter++; endwhile; endif; ?>

      </ul>


    </div>

	</div>

	<footer class="entry-footer">
  </footer>

</article>

<?php if( get_field('flitter_profil_email') ) : ?>
  <div class="remodal fav-modal-window" data-remodal-id="modal-contact_DL">
    <strong><?php _e('Sende dem Dienstleister eine Nachricht', 'fwbase'); ?></strong>
    <p><?php _e('Nutze das Formular, um den Dienstleister direkt zu kontaktieren.', 'fwbase'); ?></p>
    <?php gravity_form(8, false, false, false, '', true, 100); ?>
  </div>
<?php endif; ?>
