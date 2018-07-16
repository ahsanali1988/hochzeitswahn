<?php
/**

 * @package fwbase

 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <div class="entry-thumbnail">
            <?php
            $featured_images = get_field('post_featured_images');



            if (!$featured_images) {
                ?>
                <span class="featured-image-block"> <img class="myc" src="<?php echo get_bloginfo('template_url') . '/img/placeholder-header.png' ?>" alt=""> </span>
                <?php
            } else {
                ?>
                <div class="featured-images <?php the_field('post_featured_images_layout'); ?>">
                    <?php
                    foreach ($featured_images as $featured_image) :



                        $size = ( $featured_image['height'] > $featured_image['width'] ) ? 'headersplit' : 'header';
                        ?>
                        <span class="featured-image-block <?php
                        if ($featured_image['height'] > $featured_image['width']) {
                            echo 'portrait';
                        }
                        ?>">
                            <div class="entry-meta"> <span class="sharing-options" data-modal-id="<?php echo $featured_image['ID']; ?>">
                                    <?php //echo do_shortcode('[easy-social-share buttons="pinterest,fave" counters=0 hide_names="force" template="light-retina"]');  ?>
                                    <?php echo do_shortcode('[share-image image="' . $featured_image['ID'] . '"]'); ?> </span> </div>
                            <img class="myc" src="<?php echo $featured_image['sizes'][$size . '-s'] ?>"

                                 srcset="<?php echo $featured_image['sizes'][$size . '-m'] . ' ' . $featured_image['sizes'][$size . '-m-width'] . 'w'; ?>,

                                 <?php echo $featured_image['sizes'][$size . '-l'] . ' ' . $featured_image['sizes'][$size . '-l-width'] . 'w'; ?>" size="100vw" alt="<?php echo $featured_image['alt'] ?>">
                            <div class="remodal fav-modal-window" data-remodal-id="modal-<?php echo $featured_image['ID']; ?>"> <?php echo do_shortcode('[userpro_bookmark_image bookmark_icon="show" post_id=' . $featured_image['ID'] . ' display="none" image_id="' . $featured_image['ID'] . '"]'); ?> </div>
                        </span>
                    <?php endforeach; ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="entry-meta">
            <?php fwbase_posted_on(); ?>
        </div>
    </header>
    <h1 class="entry-title">
        <?php the_title(); ?>
        <?php fwbase_entry_meta(); ?>
    </h1>
    <aside class="entry-details">
        <div class="entry-details-border">
            <div class="entry-details-author">
                <h5 class="entry-details-title">
                    <?php _e('Editorial Team ', 'fwbase'); ?>
                </h5>
                <?php
                $author = get_the_author_meta('ID');
                echo '<a href="' . esc_url(get_author_posts_url($author)) . '">' . esc_html(get_the_author()) . '</a>';
                ?>
                <ul class="unstyled entry-details-author-social">
                    <?php if (get_field('user_facebook', 'user_' . $author)): ?>
                        <li><a href="<?php the_field('user_facebook', 'user_' . $author); ?>" title="Facebook" rel="nofollow" target="_blank"><span class="icon-facebook"></span></a></li>
                    <?php endif; ?>
                    <?php if (get_field('user_twitter', 'user_' . $author)) : ?>
                        <li> <a href="<?php the_field('user_twitter', 'user_' . $author); ?>" title="Twitter" rel="nofollow" target="_blank"> <span class="icon-twitter"></span> </a> </li>
                    <?php endif; ?>
                    <?php if (get_field('user_pinterest', 'user_' . $author)) : ?>
                        <li> <a href="<?php the_field('user_pinterest', 'user_' . $author); ?>" title="Pinterest" rel="nofollow" target="_blank"> <span class="icon-pinterest"></span> </a> </li>
                    <?php endif; ?>
                    <?php if (get_field('user_instagram', 'user_' . $author)) : ?>
                        <li> <a href="<?php the_field('user_instagram', 'user_' . $author); ?>" title="Instagram" rel="nofollow" target="_blank"> <span class="icon-instagram"></span> </a> </li>
                    <?php endif; ?>
                    <?php if (get_field('user_google', 'user_' . $author)) : ?>
                        <li> <a href="<?php the_field('user_google', 'user_' . $author); ?>" title="Google Plus" rel="nofollow" target="_blank"> <span class="icon-google"></span> </a> </li>
                    <?php endif; ?>
                    <?php if (get_field('user_blog', 'user_' . $author)) : ?>
                        <li> <a href="<?php the_field('user_blog', 'user_' . $author); ?>" title="Blog" rel="nofollow" target="_blank"> <span class="icon-blog"></span> </a> </li>
                    <?php endif; ?>
                </ul>
            </div>
            <h5 class="entry-details-title details-trigger">
                <?php _e('Mitwirkende', 'fwbase'); ?>
            </h5>
            <ul class="entry-details-credits unstyled">
                <?php
                if (have_rows('post_fields_mentioned')) : while (have_rows('post_fields_mentioned')) : the_row();

                        if (get_sub_field('post_fields_mentioned_url')) {

                            echo '<li class="entry-details-credit"> <strong>' . get_sub_field('post_fields_mentioned_job') . '</strong> <a href="' . get_sub_field('post_fields_mentioned_url') . '" title="' . get_sub_field('post_fields_mentioned_name') . '" target="_blank">' . get_sub_field('post_fields_mentioned_name') . '</a> </li>';
                        } else {

                            echo '<li class="entry-details-credit"> <strong>' . get_sub_field('post_fields_mentioned_job') . '</strong> ' . get_sub_field('post_fields_mentioned_name') . ' </li>';
                        }

                    endwhile;
                endif;
                ?>
            </ul>
            <h5 class="entry-details-title social-title large-only">
                <?php _e('Social Love', 'fwbase'); ?>
            </h5>
            <div class="entry-details-social sharing-options large-only" data-modal-id="<?php echo $post->ID; ?>"> <?php echo do_shortcode('[easy-social-share buttons="facebook,twitter,pinterest,google" counters=1 counter_pos="bottom" total_counter_pos="none" hide_names="force" template="light-retina"]'); ?> </div>
        
        <?php
//        if ($_SERVER['REMOTE_ADDR'] == "182.190.14.219") {
            if (function_exists('oiopub_banner_zone')) {

                $zone_ids = 6;
                $options = array('align' => "left", 'empty' => "-1", 'raw_data' => true, 'rows' => 12);
                $zones = oiopub_banner_zone($zone_ids, $options);
//                echo '<pre>';
//                print_r($zones);
                ?>
                <?php
            }
//        }
        ?>
        <?php
//        if ($_SERVER['REMOTE_ADDR'] == "182.191.181.61") {
        if (function_exists('oiopub_banner_zone')) {

            $zone_ids_1 = 1;
            $zone_ids_2 = 2;

            $options_1 = array('align' => "left", 'empty' => "0", 'raw_data' => true, 'rows' => 8);
            $options_2 = array('align' => "left", 'empty' => "0", 'raw_data' => true, 'rows' => 4);

            $zones_1 = oiopub_banner_zone($zone_ids_1, $options_1);
            $zones_2 = oiopub_banner_zone($zone_ids_2, $options_2);
            $count = count($zones_1);
            foreach ($zones_2 as $value) {
                $zones_1[$count] = $value;
                $count++;
            }
            shuffle($zones_1);
//                echo '<pre>';
//                print_r($zones_1);
//            }
            if($_SERVER['REMOTE_ADDR'] == "119.152.97.53"){
//                echo '<pre>';
//                print_r($zones_1);
            }
            ?>
            <div class="ad-section hide">
                <ul style="list-style: none;padding: 0px;margin-top: 50px ">
                    <?php
                    $count1 = 0;
                    $fortime = 0;
                    foreach ($zones_1 as $value) {
                        $class = '';
                        if ($count1 % 2 == 0 && $fortime <= 3) {
                            $class = 'hide';
                            $fortime++;
                        }
                        ?>
                        <li class="<?php echo $class ?>"><a href="https://www.hochzeitswahn.de/wp-content/plugins/oiopub-direct/modules/tracker/go.php?id=<?php echo $value->item_id; ?>" target="_blank"><img width="300" height="250" src="<?php echo str_replace('http:', 'https:', $value->item_url); ?>"></a></li>   
                        <?php
                        $count1++;
                    }
                    ?>  
                </ul>
            </div>
            <?php
        }
        ?>
          </div>  
        <!--    <div class="ad-section ad-medium-one large-only"> 
              
              <div class="sponsoring">
             
                     <script type="text/javascript">
             
                       google_ad_client = "ca-pub-0598776326520536";
             
                       /* body hw */
             
                       google_ad_slot = "7650814193";
             
                       google_ad_width = 300;
             
                       google_ad_height = 250;
             
                       
             
                     </script>
             
                   </div> 
              
              <div class="sponsoring"> 
                
                 BEGINN des zanox-affiliate HTML-Code  
                
                 ( Der HTML-Code darf im Sinne der einwandfreien Funktionalitaet nicht veraendert werden! )  
                
                <a href="https://ad.zanox.com/ppc/?29425924C744390019T"><img  class="myc" src="https://ad.zanox.com/ppv/?29425924C744390019" align="bottom" width="300" height="250" border="0" hspace="1" alt="Entdecke Einzigartiges f&uuml;r deine Hochzeit auf Etsy.com"></a> 
                
                 ENDE des zanox-affiliate HTML-Code  
                
              </div>
            </div>-->
    </aside>
    <div class="entry-content">
        <?php the_content(); ?>
        <?php
        if (!post_password_required()):

            if (have_rows('flex_gallery')):



                echo '<div class="entry-gallery-wrapper">';



                $number = 0;



                while (have_rows('flex_gallery')) : the_row();

//                    break;


                    $number++;



                    if (get_row_layout() == 'flex_gallery_text'):



                        the_sub_field('flex_gallery_text_content');



                    elseif (get_row_layout() == 'flex_gallery_images'):



                        $gallery = get_sub_field('flex_gallery_images_content');



                        $flag = 0;



                        if (!get_sub_field('flex_gallery_only')) :
                            ?>
                            <div class="gallery-loader number<?php echo $number; ?>"></div>
                            <ul class="entry-gallery unstyled number<?php echo $number; ?> ">
                                <li class="masonry-helper"></li>
                                <?php foreach ($gallery as $image): ?>
                                    <li <?php
                                    if ($image['height'] > $image['width'] || get_post_meta($image['ID'], 'fw_media_class', true) == 'portrait') {

                                        if (get_post_meta($image['ID'], 'fw_media_class', true) != 'landscape') {
                                            echo 'class="portrait"';
                                            $orientation = 'portrait';
                                        }
                                    }
                                    ?>>
                                        <div class="entry-meta"> <span class="sharing-options" data-modal-id="<?php echo $image['ID']; ?>">
                                                <?php //echo do_shortcode('[easy-social-share buttons="pinterest,fave" counters=0 hide_names="force" template="light-retina"]');    ?>
                                                <?php echo do_shortcode('[share-image image="' . $image['ID'] . '"]'); ?> </span> </div>
                                        <img class="myc aabc" src="<?php echo $image['sizes']['content-s'] ?>" srcset="<?php echo $image['sizes']['content-m'] . ' ' . $image['sizes']['content-m-width'] . 'w'; ?>,

                                             <?php
                                             if ($orientation !== 'portrait') {
                                                 echo $image['sizes']['content-l'] . ' ' . $image['sizes']['content-l-width'] . 'w';
                                             };
                                             ?>"

                                             sizes="<?php
                                             if ($orientation == 'portrait') {
                                                 echo '(max-width: 1024px) 50vw,(min-width: 1024px) 40vw, (min-width: 1500px) 33vw, 30vw';
                                             } else {
                                                 echo '(max-width: 1024px) 100vw, 70vw';
                                             };
                                             ?>" alt="<?php echo $image['alt'] ?>">
                                        <div class="remodal fav-modal-window" data-remodal-id="modal-<?php echo $image['ID']; ?>"> <?php echo do_shortcode('[userpro_bookmark_image bookmark_icon="show" post_id=' . $image['ID'] . ' display="none" image_id="' . $image['ID'] . '"]'); ?> </div>
                                    </li>
                                    <?php
                                    $orientation = 'empty';
                                endforeach;
                                ?>
                            </ul>
                            <?php 
                               if ($number == 1 && get_field('post_ads') != 'No') {
                                        ?>
                                    <div class="" style="text-align: center">
                                            <ul style="list-style: none;padding: 0px;padding: 2px;">
                                                <li><a href="https://www.hochzeitswahn.de/wp-content/plugins/oiopub-direct/modules/tracker/go.php?id=<?php echo $zones[0]->item_id; ?>"><img  src="<?php echo str_replace('http:', 'https:',$zones[0]->item_url);?>"></a></li>
                                            </ul>
                                        </div>  
                                    <?php
                                    }
                            ?>
                            <?php
                        // View all Button
                        elseif (get_sub_field('flex_gallery_only') && $flag == 0) :



                            $img_counter = 1;
                            ?>
                        <!--    <script type="text/javascript" src="https://pagead2.googlesyndication.com/pagead/show_ads.js"></script> 
                            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> 
                            
                             blogpostads  
                            
                            <ins class="adsbygoogle"
                        
                                                         style="display:block"
                        
                                                         data-ad-client="ca-pub-0598776326520536"
                        
                                                         data-ad-slot="6544199396"
                        
                                                         data-ad-format="autorelaxed"></ins> 
                            <script>
                        
                                                        (adsbygoogle = window.adsbygoogle || []).push({});
                        
                                                    </script>-->
                            <?php //var_dump(get_field('post_ads')); ?>
                            <?php if(get_field('post_ads') != 'No') { ?>
                            <div class="" style="text-align: center;">
                                            <ul style="list-style: none;padding: 0px;margin-bottom: 0px;padding-left: 2px;padding-right: 2px;margin-bottom: -5px;">
                                                <li><a href="https://www.hochzeitswahn.de/wp-content/plugins/oiopub-direct/modules/tracker/go.php?id=<?php echo $zones[1]->item_id; ?>"><img src="<?php echo str_replace('http:', 'https:', $zones[1]->item_url);?>"></a></li>
                                            </ul>
                                        </div>
                            <?php } ?>
                            <div class="view-all-gallery"> <a href="<?php echo get_permalink(132765) . '?attached=' . get_the_ID(); ?>" class="view-all-link button" title="<?php _e('Alle Bilder in der Galerie', 'fwbase'); ?>">
                    <?php _e('Alle Bilder in der Galerie', 'fwbase'); ?>
                                </a>
                                <ul class="unstyled">
                                        <?php if (count($gallery) < 5) : ?>
                                        <li class="view-all-gallery-split">
                                            <?php foreach ($gallery as $image) : if ($img_counter < 3) : ?>
                                                    <img class="myc" src="<?php echo $image['sizes']['thumbnail'] ?>" alt="<?php echo $image['alt'] ?>">
                                                    <?php
                                                    $img_counter++;
                                                endif;
                                            endforeach;
                                            ?>
                                        </li>
                                    <?php else: ?>
                                        <?php foreach ($gallery as $image) : if ($img_counter < 6) : ?>
                                                    <?php if ($img_counter == 1) { ?>
                                                    <li> <img class="myc" src="<?php echo $image['sizes']['thumbnail'] ?>" alt="<?php echo $image['alt'] ?>">
                                                <?php } elseif ($img_counter == 2) { ?>
                                                        <img class="myc" src="<?php echo $image['sizes']['thumbnail'] ?>" alt="<?php echo $image['alt'] ?>"> </li>
                                                <?php } elseif ($img_counter == 3) { ?>
                                                    <li class="portrait"> <img class="myc"  src="<?php echo $image['sizes']['portrait-m'] ?>" alt="<?php echo $image['alt'] ?>"> </li>
                                                    <?php } elseif ($img_counter == 4) { ?>
                                                    <li> <img class="myc" src="<?php echo $image['sizes']['thumbnail'] ?>" alt="<?php echo $image['alt'] ?>">
                                                <?php } elseif ($img_counter == 5) { ?>
                                                        <img class="myc" src="<?php echo $image['sizes']['thumbnail'] ?>" alt="<?php echo $image['alt'] ?>"> </li>
                                                <?php } ?>
                                                <?php
                                                $img_counter++;
                                            endif;
                                        endforeach;
                                        ?>
                    <?php endif; ?>
                                </ul>
                            </div>
                            <?php
                            $flag++;



                        endif;



                    // View all END



                    endif;



                endwhile;



                echo '</div>';



            endif;

        endif;
        ?>
        <center>
            <h5 class="entry-details-title social-title large-only">
<?php _e('Social Love', 'fwbase'); ?>
            </h5>
        </center>
        <div class="entry-details-social sharing-options large-only" data-modal-id="<?php echo $post->ID; ?>"> <?php echo do_shortcode('[easy-social-share buttons="facebook,twitter,pinterest,google" counters=1 counter_pos="bottom" total_counter_pos="none" hide_names="force" template="light-retina"]'); ?> </div>

    </div>
    <footer class="entry-footer">
        <h5 class="entry-details-title social-title large-hidden">
<?php _e('Social Love', 'fwbase'); ?>
        </h5>
        <div class="entry-details-social sharing-options large-hidden" data-modal-id="<?php echo $post->ID; ?>"> <?php echo do_shortcode('[easy-social-share buttons="facebook,twitter,pinterest,google,fave" counters=1 counter_pos="bottom" total_counter_pos="none" hide_names="force" template="light-retina"]'); ?> </div>
    </footer>
    <div class="ad-section"  id="footAd" >
        <ul style="list-style: none;padding: 0px;margin-top: 50px ">
            <?php
            $count1 = 0;
            $fortime = 0;
            foreach ($zones_1 as $value) {
                $class = '';
                if ($count1 % 2 == 0 && $fortime <= 3) {
                    $class = 'hide';
                    $fortime++;
                }
                ?>
                <li class="<?php echo $class ?>"><a href="https://www.hochzeitswahn.de/wp-content/plugins/oiopub-direct/modules/tracker/go.php?id=<?php echo $value->item_id; ?>" target="_blank"><img width="300" height="250" src="<?php echo str_replace('http:', 'https:', $value->item_url); ?>"></a></li>   
                <?php
                $count1++;
            }
            ?>  
        </ul>
    </div>
</article>
