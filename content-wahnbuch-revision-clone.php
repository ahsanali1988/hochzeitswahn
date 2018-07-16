<?php
/**
 * Displays an older revision in case of a pending post
 * 
 * @package fwbase
 */
//   Post for authers//
?>
<style>
    .loader-ellips {
        /*        font-size: 20px;
                position: relative;
                width: 4em;
                height: 1em;
                margin: 10px auto;
                text-align: center;*/


        display: none;
        width: 100%;
        padding: 50px;
        margin: 0 0 20px;
        background: #fff;
        border: 2px dashed #ccc;
        background: url(<?php bloginfo('template_url');
?>/img/ajax-loader.gif) no-repeat center center;
        -webkit-transition: all .1s ease;
        transition: all .1s ease;
        z-index: 250;
        clear: both;
        overflow: hidden;
        position: relative;
        background-color: #fff;
    }
</style>
<?php
$author = get_the_author_meta('ID');
$auther_args = array(
    'posts_per_page' => -1, /* get only the first 50 entries */
    'author' => $author,
    'post_type' => 'hw_wahnbuechlein',
    'post_status' => 'publish',
    'oderby' => 'date',
);
$pre_query = new WP_Query($auther_args);

$parentIDs = array();

if ($pre_query->have_posts()): while ($pre_query->have_posts()) : $pre_query->the_post();
        $parentIDs[] = $post->ID;

    endwhile;
endif;
wp_reset_postdata();
$attach_args = array(
    'post_type' => 'attachment',
    'post_status' => 'inherit',
    'posts_per_page' => 9,
    'orderby' => 'rand',
    'post_parent__in' => $parentIDs,
//        'meta_key' => 'wahn_gallery',
);
$the_query = new WP_Query($attach_args);
//     $images = the_field('wahn_gallery',$post->ID);

$parentID = $post->ID;
//the_ID();
$is_feautred = get_field('featured');
$subquery = new WP_Query(array(
    'post_type' => 'revision',
    'post_parent' => $parentID,
    'post_status' => 'inherit',
    'offset' => 1,
    'posts_per_page' => 1)
);




$cat_query = ( get_query_var('wahn_categorie') != '' ) ? get_query_var('wahn_categorie') : '';
$reg_query = ( get_query_var('wahn_region') != '' ) ? get_query_var('wahn_region') : '';
$current_url = 'https://www.hochzeitswahn.de/wahnbuechlein/';
?>

<div class="archive">
    <nav class="sub-category-nav">
        <ul class="sub-cat-nav-catlist unstyled">
            <?php
            $terms = get_terms('wahn_categorie', array('hide_empty' => false));

            echo '<li class="wahn_category"> <span>' . __('W&auml;hle eine Kategorie:', 'fwbase') . '</span>';
            echo '<ul>';
            echo '<li class="tags_overview"> <a href="' . $current_url . '" title="' . __('Alle Kategorien ansehen', 'fwbase') . '">' . __('Zum Kategorie-&Uuml;berblick', 'fwbase') . '</a> </li>';
            foreach ($terms as $term) {
                if ($term->slug === $cat_query) {
                    echo '<li class="active"> <a href="' . $current_url . '?wahn_categorie=' . $term->slug . '&wahn_region=' . $reg_query . '" title="' . $term->name . '" rel="nofollow">' . $term->name . '</a> </li>';
                } else {
                    echo '<li> <a href="' . $current_url . '?wahn_categorie=' . $term->slug . '&wahn_region=' . $reg_query . '" title="' . $term->name . '" rel="nofollow">' . $term->name . '</a> </li>';
                }
            }
            echo '</ul> </li>';
            ?>
        </ul>
        <ul class="sub-cat-nav-catlist unstyled">
            <?php
            $terms = get_terms('wahn_region');

            echo '<li class="wahn_region"> <span>' . __('Suche in deiner Region:', 'fwbase') . '</span>';
            echo '<ul>';
            if (!empty($reg_query) && !empty($cat_query)) {
                echo '<li class="tags_overview"> <a href="' . $current_url . '?wahn_categorie=' . $cat_query . '&wahn_region=" title="Alle Regionen" rel="nofollow">Alle Regionen</a> </li>';
            }
            foreach ($terms as $term) {
                if ($term->slug === $reg_query) {
                    echo '<li class="active"> <a href="' . $current_url . '?wahn_categorie=' . $cat_query . '&wahn_region=' . $term->slug . '" title="' . $term->name . '" rel="nofollow">' . $term->name . '</a> </li>';
                } else {
                    echo '<li> <a href="' . $current_url . '?wahn_categorie=' . $cat_query . '&wahn_region=' . $term->slug . '" title="' . $term->name . '" rel="nofollow">' . $term->name . '</a> </li>';
                }
            }
            echo '</ul> </li>';
            ?>
        </ul>
    </nav>
</div>
<?php
if ($subquery->have_posts()) : while ($subquery->have_posts()) : $subquery->the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('hw_wahnbuechlein type-hw_wahnbuechlein'); ?>>
            <header class="entry-header">
                <?php
                echo '<a href="' . get_bloginfo('url') . '/wahnbuechlein/" class="back-to-overview" title="' . __('Zur&uuml;ck zu allen Kategorien', 'fwbase') . '"> <span class="icon-pfeil-links"></span>' . __('Alle Kategorien', 'fwbase') . '</a>';

                echo '<div class="post-categories">';
                $categories = get_the_terms($parentID, 'wahn_categorie');
                foreach ($categories as $category) {
                    if ($category->name != 'Alle Dienstleister') {
                        echo '<a href="' . get_term_link($category->slug, 'wahn_categorie') . '" title="' . $category->name . '">' . $category->name . '</a>';
                    }
                }

                $regionen = get_the_terms($parentID, 'wahn_region');
                foreach ($regionen as $region) {
                    echo '<a href="' . get_term_link($region->slug, 'wahn_region') . '" title="' . $region->name . '">' . $region->name . '</a>';
                }
                echo '</div>';
                ?>
            </header>
            <?php wp_reset_postdata(); ?>
            <?php
            $src = wp_get_attachment_image_src(get_post_thumbnail_id($parentID), 'full');
            ?>
            <div class="vendor_banner" style="background: url(<?php echo $src[0]; ?>) no-repeat center center #fbfafa; "> 
                <div class="inner_vendor">
                    <img src="<?php echo $src[0]; ?>"  class="img-responsive show_on_mobile">
                    <div class="fav-sec" data-modal-id="<?php echo $parentID; ?>"> <a  href="#" class="link-fave favourite_profile"  data-remodal-target="modal-<?php echo $parentID; ?>" favid="<?php echo $parentID; ?>" title="<?php _e('Als Favorit speichern', 'fwbase'); ?>"><i class="fa fa-heart-o"></i> <span>
                                <?php _e('Als Favorit speichern', 'fwbase'); ?>
                            </span></a></div>
                    <?php if ($is_feautred == 'Yes') { ?>
                        <div class="featured_logo">
                            <img src="<?php bloginfo('template_url'); ?>/img/badge.png" class="badge_f">
                        </div>
                    <?php } ?>
                    <div class="vendor_cat_name">
                        <?php
                        $counter = 2;
                        foreach ($categories as $category) {
                            $category_link = get_term_link($category, 'category');
                            if ($category->name != 'Alle Dienstleister') {
                                echo '<a href="' . $category_link . '">' . $category->name . '</a>';

                                if ($counter != count($categories))
                                    echo ', ';
                                $counter++;
                            }
                        }
                        ?>

                    </div>
                </div>
                <div class="caption">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="vendor_name">
                                <h1>
                                    <?php the_field('wahn_profil_name'); ?>
                                </h1>
                                <p><i class="fa fa-calendar"></i>Wahnbüchlein-Mitglied seit <?php echo get_the_date('Y'); ?></p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="vendor_social_icons">
                                <ul>
                                    <?php if (get_field('wahn_facebook')) : ?>
                                        <li> <a href="<?php the_field('wahn_facebook'); ?>" target="_blank" title="Facebook" rel="nofollow"> <span class="icon-facebook"></span> </a> </li>
                                    <?php endif; ?>
                                    <?php if (get_field('wahn_twitter')) : ?>
                                        <li> <a href="<?php the_field('wahn_twitter'); ?>" target="_blank" title="Twitter" rel="nofollow"> <span class="icon-twitter"></span> </a> </li>
                                    <?php endif; ?>
                                    <?php if (get_field('wahn_pinterest')) : ?>
                                        <li> <a href="<?php the_field('wahn_pinterest'); ?>" target="_blank" title="Pinterest" rel="nofollow"> <span class="icon-pinterest"></span> </a> </li>
                                    <?php endif; ?>
                                    <?php if (get_field('wahn_instagram')) : ?>
                                        <li> <a href="<?php the_field('wahn_instagram'); ?>" target="_blank" title="Instagram" rel="nofollow"> <span class="icon-instagram"></span> </a> </li>
                                    <?php endif; ?>
                                    <?php if (get_field('wahn_googleplus')) : ?>
                                        <li> <a href="<?php the_field('wahn_googleplus'); ?>" target="_blank" title="Google Plus" rel="nofollow"> <span class="icon-google"></span> </a> </li>
                                    <?php endif; ?>
                                    <?php if (get_field('wahn_blog')) : ?>
                                        <li> <a href="<?php the_field('wahn_blog'); ?>" target="_blank" title="Blog" rel="nofollow"> <span class="icon-blog"></span> </a> </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div class="banner_rating">
                                <?php echo do_shortcode("[show-average-rating taxonomy='{current_page_id}' orderby='menu_order' order='ASC' theme='simple_box' stars='on' half_stars='on' stars_label='Bewertungen&nbsp;' total_label_after='&nbsp;Ratings' total_label_after_singular='&nbsp;Rating' empty='<span>' ]"); ?>
                                <?php //echo do_shortcode("[show-average-rating taxonomy='{current_page_id}' orderby='menu_order' order='ASC' theme='simple_box' stars='on' half_stars='on' stars_label='Bewertungen&nbsp;' average_label='&nbsp;Average of ' ]");   ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="vendor_top_section">
                <aside class="entry-details">
                    <div class="vendor_all_info_wrap">
                        <div class="entry-details-top">
                            <div class="details-top-img">
                                <?php
                                if (get_field('wahn_profil_logo')) {
                                    $logo = get_field('wahn_profil_logo');
                                    echo '<img src="' . $logo['url'] . '" alt="' . $logo['alt'] . '">';
                                } else {
                                    echo '<img alt="Profil" src="' . get_bloginfo('template_url') . '/img/placeholder.jpg">';
                                }
                                ?>
                            </div>
                            <input type="hidden" name="phn" id="phn" value="1">
                            <div class="details-top-content">
                                <ul class="unstyled details-top-content-basics">
                                    <?php if (get_field('wahn_profil_website')) : ?>
                                        <li class="web"><a href="<?php the_field('wahn_profil_website'); ?>" title="" rel="nofollow" target="_blank"><i class='fa fa-globe'></i> Webseite</a></li>
                                    <?php endif; ?>
                                    <?php if (get_field('wahn_profil_telefon')) : ?>
                                        <li class="phone_no"><i class='fa fa-phone'></i> Anrufen</li>
                                        <script>
                                            jQuery(document).ready(function () {
                                                jQuery('.web').click(function () {
                                                    window.open('<?php the_field('wahn_profil_website'); ?>', '_blank');
                                                });
                                                jQuery('.phone_no').click(function () {
                                                    if (jQuery('#phn').val() == "2")
                                                    {
                                                        window.location.href = 'tel:<?php the_field('wahn_profil_telefon'); ?>';
                                                    }
                                                    var phone_no = '<?php the_field('wahn_profil_telefon'); ?>'
                                                    jQuery(this).html("<a href='tel:" + phone_no + "'><i class='fa fa-phone'></i>" + phone_no + "</a>");
                                                    jQuery('#phn').val('2');
                                                });
                                            });


                                        </script>
                                    <?php endif; ?>
                                    <li>
                                        <div class="vendor_social_links">
                                            <ul class="unstyled details-top-content-social">
                                                <?php if (get_field('wahn_facebook')) : ?>
                                                    <li> <a href="<?php the_field('wahn_facebook'); ?>" target="_blank" title="Facebook" rel="nofollow"> <span class="icon-facebook"></span> </a> </li>
                                                <?php endif; ?>
                                                <?php if (get_field('wahn_twitter')) : ?>
                                                    <li> <a href="<?php the_field('wahn_twitter'); ?>" target="_blank" title="Twitter" rel="nofollow"> <span class="icon-twitter"></span> </a> </li>
                                                <?php endif; ?>
                                                <?php if (get_field('wahn_pinterest')) : ?>
                                                    <li> <a href="<?php the_field('wahn_pinterest'); ?>" target="_blank" title="Pinterest" rel="nofollow"> <span class="icon-pinterest"></span> </a> </li>
                                                <?php endif; ?>
                                                <?php if (get_field('wahn_instagram')) : ?>
                                                    <li> <a href="<?php the_field('wahn_instagram'); ?>" target="_blank" title="Instagram" rel="nofollow"> <span class="icon-instagram"></span> </a> </li>
                                                <?php endif; ?>
                                                <?php if (get_field('wahn_googleplus')) : ?>
                                                    <li> <a href="<?php the_field('wahn_googleplus'); ?>" target="_blank" title="Google Plus" rel="nofollow"> <span class="icon-google"></span> </a> </li>
                                                <?php endif; ?>
                                                <?php if (get_field('wahn_blog')) : ?>
                                                    <li> <a href="<?php the_field('wahn_blog'); ?>" target="_blank" title="Blog" rel="nofollow"> <span class="icon-blog"></span> </a> </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </li>
                                    <li style="display:none;"> <span>
                                            <?php _e('Kategorie: ', 'fwbase'); ?>
                                        </span>
                                        <?php
                                        //$categories = get_the_terms( $post->ID, 'wahn_categorie' );
                                        $counter = 2;
                                        foreach ($categories as $category) {
                                            if ($category->name != 'Alle Dienstleister') {
                                                echo $category->name;
                                                if ($counter != count($categories))
                                                    echo ', ';
                                                $counter++;
                                            }
                                        }
                                        ?>
                                    </li>
                                    <li style="display:none;"> <span>
                                            <?php _e('Region: ', 'fwbase'); ?>
                                        </span>
                                        <?php
                                        $counter = 1;
                                        foreach ($regionen as $region) {
                                            echo $region->name;
                                            if ($counter != count($regionen))
                                                echo ', ';
                                            $counter++;
                                        }
                                        ?>
                                    </li>

                                    <?php if (get_field('wahn_profil_mobilitaet')) { ?>
                                        <li style="display:none;"> <span>
                                                <?php _e('Bereit zu Reisen:', 'fwbase'); ?>
                                            </span>
                                            <?php _e('Ja', 'fwbase'); ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <script>
                            jQuery(document).ready(function () {

                            })
                            jQuery('.details-top-content-social li').click(function () {
                                var href = jQuery(this).find('a').attr('href');
                                //                console.log();
                                window.open(href, '_blank');
                            })
                        </script>

                        <div class="bio_description">
                            <p>
                                <?php $bio = the_field('profile_biography'); ?>
                                <?php echo(str_word_count("'.$category_link.'", 25)); ?>	
                            </p>
                        </div>
                        <div class="text-center" style="margin-top: 30px;">
                            <?php if (get_field('wahn_profil_email')) : ?>
                                <a class="entry-details-contact button"  href="#modal-contact_DL" title="<?php _e('Kontaktiere', 'fwbase'); ?> <?php the_field('wahn_profil_name'); ?>">
                                    <?php _e('Kontaktiere', 'fwbase'); ?> <?php the_field('wahn_profil_name'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </aside>
                <div class="entry-content">
                    <div class="vendor_long_desc">
                        <!--      <h1>
                        <?php //the_field('wahn_profil_name');  ?>
                              </h1>-->
                        <div class="entry-details-descr">
                            <?php the_field('wahn_profil_description'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="entry-footer" style="display:none;"> </footer>
        </article>


        <div class="gallery horizontal-long">
            <div class="gallery-images">

                <ul class="slider with-arrows">



                <!--<li class="relative video_emb"> <img class="lazy" width="1350" height="900" data-width="1350" data-height="900" src="https://www.hochzeitswahn.de/wp-content/uploads/2018/01/video_thumb.jpg" size="100vw" alt="">
                <div class="zoom-image"> <a href="https://vimeo.com/162199984" class="fancy_video" rel="vendor_gallery" title="">&nbsp;</a> </div>
                </li>-->


                    <?php
                    $gallery = get_field('wahn_gallery');
                    ?>
                    <?php foreach ($gallery as $image): ?>
                        <li class="item"> <img class="" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" data-width="<?php echo $image['width']; ?>" data-height="<?php echo $image['height']; ?>" src="<?php echo $image['sizes']['content-s'] ?>"
                                               srcset="<?php echo $image['sizes']['content-m'] . ' ' . $image['sizes']['content-m-width'] . 'w'; ?>,
                                               <?php echo $image['sizes']['content-l'] . ' ' . $image['sizes']['content-l-width'] . 'w'; ?>" size="100vw" alt="<?php echo $image['alt'] ?>">

                        <!--<div class="zoom-image"> <a href="<?php echo $image['sizes']['content-l'] ?>" class="fancy_photo" rel="vendor_gallery" title="">&nbsp;</a> </div> </li>-->
                        <?php endforeach; ?>
                        <?php
                        if (have_rows('wahn_video')) : while (have_rows('wahn_video')) : the_row();
                                $video_url = get_sub_field('video_thumb');
//                                if ($_SERVER['REMOTE_ADDR'] == "182.190.74.218") {
//                                    print_r($video_url['url']);
//                                }
                                $url = "/wp-content/uploads/videoplay-default.jpg";
                                if (isset($video_url['url']) && trim($video_url['url']) != "") {
                                  $url = $video_url['url'];  
                                }
                                echo '<li class="item video_emb"> <img src="'.$url.'" class="lazy" width="1350" height="900" data-width="1350" data-height="900" size="100vw" alt=""><div class="zoom-image"><a href="' . get_sub_field('featured_video_embed') . '" class="fancy_video" rel="vendor_gallery" title="">&nbsp;</a></div> </li>';
                            endwhile;
                        endif;
                        ?>

                        <?php wp_reset_postdata(); ?>  

                </ul>

            </div>


        </div>











        <div class="new_vendor_section" style="clear:both;">
            <aside class="entry-details">
                <div class="vendor_all_info_wrap clone">
                    <div class="entry-details-top">
                        <div class="details-top-content">
                            <?php wp_reset_postdata(); ?>
                            <h3>Übersicht & Leistungen</h3>
                            <ul class="unstyled details-top-content-basics">
                                <?php if (get_field('wahn_profil_standort')) : ?>
                                    <li> <i class="fa fa-map-marker"></i> <span>
                                            <?php _e('Standort:', 'fwbase'); ?>
                                        </span>
                                        <?php
                                        if (have_rows('wahn_profil_standort')) : $counter = 1;
                                            while (have_rows('wahn_profil_standort')) : the_row();
                                                $map_id = get_the_ID();
                                                if (!get_sub_field('wahn_profil_standort_maps')) {

                                                    echo '<a  href="' . get_sub_field('wahn_profil_standort_url') . '" rel="nofollow" title="Google Maps Link" target="_blank">' . get_sub_field('wahn_profil_standort_ort') . '</a>';
                                                } else {

                                                    $location = get_sub_field('wahn_profil_standort_maps');

                                                    if ($_SERVER['REMOTE_ADDR'] == "182.191.181.61") {
//                                                        echo '<pre>';
//                                                        print_r($location);
                                                    }


                                                    echo '<a class = "1" href="#modal-map-' . get_sub_field('wahn_profil_standort_ort') . '" title="Google Maps Link" class="acf-maps-modal" rel="nofollow">' . get_sub_field('wahn_profil_standort_ort') . '</a>';
                                                    echo '<div class="remodal" data-remodal-id="modal-map-' . get_sub_field('wahn_profil_standort_ort') . '"> <div class="acf-map"> <div class="marker" data-lat="' . $location['lat'] . '" data-lng="' . $location['lng'] . '"></div> </div> </div>';
                                                }

                                                if ($counter != count(get_field('wahn_profil_standort')))
                                                    echo ', ';
                                                $counter++;

                                            endwhile;
                                        endif;
                                        ?>
                                    </li>
                                <?php endif; ?>
                                <li> <span>
                                        <?php _e('Einsatzgebiet: ', 'fwbase'); ?>
                                    </span>
                                    <?php
                                    $counter = 1;
                                    foreach ($regionen as $region) {
                                        echo $region->name;
                                        if ($counter != count($regionen))
                                            echo ', ';
                                        $counter++;
                                    }
                                    ?>
                                </li>
                                <?php if (get_field('einsatzgebiet')) : ?>
                                    <li style="display:none;"><span>Einsatzgebiet</span>
                                        <?php the_field('einsatzgebiet'); ?>
                                    </li>
                                <?php endif; ?>
                                <?php if (get_field('bereit_zu_reisen')) : ?>
                                    <li><span>Bereit zu reisen? </span>
                                        <?php the_field('bereit_zu_reisen'); ?>
                                    </li>
                                <?php endif; ?>
                                <?php if (get_field('preiskategorie')) : ?>
                                    <li><span>Preiskategorie </span>
                                        <?php the_field('preiskategorie'); ?>
                                    </li>
                                <?php endif; ?>
                                <?php if (get_field('zusatzleistungen')) : ?>
                                    <li><span>Zusatzleistungen: </span>
                                        <?php the_field('zusatzleistungen'); ?>
                                    </li>
                                <?php endif; ?>

                                <?php if (get_field('wahn_profil_mobilitaet')) { ?>
                                    <li style="display:none;"> <span>
                                            <?php _e('Bereit zu Reisen:', 'fwbase'); ?>
                                        </span>
                                        <?php _e('Ja', 'fwbase'); ?>
                                    </li>
                                <?php } ?>
                            </ul>

                            <div class="rating_wrap" style="margin-top: 30px">
                                <?php // echo do_shortcode('[WPCR_SHOW POSTID="27596" NUM="3" SHOWFORM="1" PERPAGE="10"]');  ?>
                                <?php echo do_shortcode("[show-average-rating taxonomy='{current_page_id}' orderby='menu_order' order='ASC' theme='simple_box' stars='on' half_stars='on' stars_label='Bewertungen&nbsp;' total_label_after='&nbsp;Ratings' total_label_after_singular='&nbsp;Rating' empty='<span>' ]"); ?>
                                <?php echo do_shortcode("[show-testimonials taxonomy='{current_page_id}' orderby='menu_order' order='ASC' limit='5' pagination='short' layout='grid' options='theme:quotes,info-position:info-left,text-alignment:left,columns:1,filter:none,review_title:on,date:on,quote-content:short,charlimitextra: (...),display-image:on,image-size:ttshowcase_small,image-shape:circle,image-effect:none,image-link:on']"); ?>
                                <div class="rating_form_btn tex-center">

                                    <a class="entry-details-contact button" href="javascript:void(0)" id="showForm" title="Hinterlasse eine Bewertung f�r diesen Dienstleister">
                                        Hinterlasse eine Bewertung f&uuml;r diesen Dienstleister      </a>

                                </div>


                                <div class="formR" style="display: none">   
                                    <?php echo do_shortcode("[show-testimonials-form image='on' review_title='on' taxonomy='{current_page_id}' rating='hover' email='on' logged='on' logged_only='on' style='tt_simple' ]"); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
            <div class="entry-content" style="text-align:center;">
                <div class="long_desc_2">
                    <div class="text-center">
                        <div class="f_video_sec">
<?php


  $vimeoUrl = get_field('f_video_vendor');
    $fetchVimeoIdArr = explode('/', $vimeoUrl);
    $idCounter = count($fetchVimeoIdArr) - 1;
    $vimeoId = $fetchVimeoIdArr[$idCounter];

 if (get_field('f_video_vendor')) { ?>
     <iframe src="https://player.vimeo.com/video/<?php echo $vimeoId; ?>" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
             
       <?php } ?>       
             
 
                        </div>
                        <div class="faqs_wrap">

                            <?php wp_reset_postdata(); ?>
                            <?php
                            if (have_rows('faqs')):
                                echo '<h3>Oft gestellte Fragen</h3>';
                                // loop through the rows of data
                                while (have_rows('faqs')) : the_row();
                                    // display a sub field value
                                    echo'<div id="faq_container"> 
					
                    <div class="faq">
                        <div class="faq_question"> <span class="fa fa-question-circle"></span><span class="question">' . get_sub_field('faq_question') . '</span></div>
                            <div class="faq_answer_container">
                                <div class="faq_answer"><span class="fa fa-check-circle"></span><span>' . get_sub_field('faq_answer') . '</span></div>
                            </div>
                    </div>
                     </div>';
                                endwhile;
                            else :
                            // no rows found
                            endif;
                            ?>
                        </div>
                    </div>
                    <?php if (get_field('wahn_profil_email')) : ?>
                        <a class="entry-details-contact button" href="#modal-contact_DL" title="<?php _e('Kontaktiere', 'fwbase'); ?> <?php the_field('wahn_profil_name'); ?>">
                            <?php _e('Kontaktiere', 'fwbase'); ?> <?php the_field('wahn_profil_name'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if (get_field('wahn_profil_email')) : ?>
            <div class="remodal fav-modal-window" data-remodal-id="modal-contact_DL"> <strong>
                    <?php _e('Sende dem Dienstleister eine Nachricht', 'fwbase'); ?>
                </strong>
                <p>
                    <?php _e('Nutze das Formular, um den Dienstleister direkt zu kontaktieren.', 'fwbase'); ?>
                </p>
                <?php gravity_form(8, false, false, false, '', true, 100); ?>
            </div>
        <?php endif; ?>
        <!--<div class="dienstleister-section" style="clear:both;">
          <ul class="vendory_post_gallery entry-gallery unstyled">
            <li class="sizer"></li>
        <?php
        $postIDS = array();
        while ($the_query->have_posts()) : $the_query->the_post();
            $image_s = wp_get_attachment_image_src($post->ID, 'content-s');
            if ($logo['url'] == $image_s[0]) {
                continue;
            }
            $postIDS[] = $post->ID;
            ?>
                    <li> <a href="<?php echo get_permalink() . '?details=gallery'; ?>"> <img src="<?php echo $image_s[0]; ?>"> </a> </li>
        <?php endwhile; ?>
          </ul>
          
        <?php wp_reset_postdata(); ?>
          <div class="text-center"> <a style="text-transform:uppercase;" class="entry-details-contact button long" target="_blank" id="ajaxFecth" href="https://www.hochzeitswahn.de/hochzeitswahn-galerien/?custom=<?php echo $author ?>" title=""> PORTFOLIO GALERIE VON <?php the_field('wahn_profil_name'); ?> </a> </div>
           
          <div class="loader-ellips infinite-scroll-request loader_custom" style="display: none;margin-bottom: 20px;margin-top: 20px"> 
                    <span class="loader-ellips__dot"></span>
                          <span class="loader-ellips__dot"></span>
                          <span class="loader-ellips__dot"></span>
                          <span class="loader-ellips__dot"></span> 
          </div>
          <div id="empty" style="display: none;text-align: center;font-size: 36px;color: green;">Ende</div>
        </div>-->
        <?php
    endwhile;
endif;

wp_reset_postdata();
?>
<input type="hidden" name="pageQ" id="pageQ" value="2">
<input type="hidden" name="ajaxcheck" id="ajaxcheck" value="2">
<input type="hidden" name="ajaxcheck" id="pageClass" value="2">
<script>
    $(document).ready(function () {
//        $('.tt_average_rating_box').removeByContent('Ratings empty');
    })
    $('#showForm').on('click', function () {
        $('.formR').show();
    })
    function ajaxfetch() {
        var page = jQuery('#pageQ').val();


        var dataString = {action: 'infinite_scroll_custom_posts', postIDS: '<?php echo json_encode($postIDS) ?>', logoURL: '<?php echo $logo['url'] ?>', page: page, pIDs: '<?php echo json_encode($parentIDs) ?>'};
        if (jQuery('#ajaxcheck').val() == "1") {
            jQuery('#ajaxcheck').val('2');
            $('.loader_custom').show();
            /*					var theight = $('.custom_gallery_ajax').height();
             $('.custom_gallery_ajax').css('min-height', theight);*/
//                    $('.ad-section').hide();
            $.ajax({
                url: "/wp-admin/admin-ajax.php",
                type: 'POST',
                data: dataString,
                dataType: 'json',
                success: function (response) {
//               console.log(response.result)
//               console.log(response.html)
                    var $g_container = $('.vendory_post_gallery');
//                            jQuery('.entry-gallery').append(response.html);
//                            $g_container.masonry( 'appended', response.html );
                    var pageclass = $('#pageClass').val();
                    $g_container.masonry("reloadItems").masonry("reloadItems");
                    imagesLoaded($("." + pageclass), function () {
                        $($g_container).append(response.html);

                        setTimeout(function () {
                            $("." + pageclass).show();
                            $g_container.masonry("reloadItems").masonry("layout");
                            $g_container.masonry("reloadItems").masonry("layout");
                            $g_container.masonry("reloadItems").masonry("layout");
                            console.log("." + pageclass)
                            jQuery('#ajaxcheck').val('1');
                            if (response.result == 'empty')
                            {
                                jQuery('#empty').show();
                                jQuery('#ajaxcheck').val('2');
                            }
                            $('.loader_custom').hide();
//                                    $('.ad-section').show();
//                                    $('.ad-section').masonry("reloadItems").masonry("layout");
                            pageclass = ++pageclass;
                            $('#pageClass').val(pageclass);
                            page = ++page;
                            jQuery('#pageQ').val(page);
                        }, 2000)
                    });







                }
            });
        }
    }
    $('#ajaxFecth').on('click', function () {
        /*        $('#ajaxFecth').hide();
         jQuery('#ajaxcheck').val('1');
         ajaxfetch();*/

    })
    var lastScrollTop = 0;
    $(window).scroll(function (event) {

        var st = $(this).scrollTop();
        if (st > lastScrollTop) {
            if (jQuery('#ajaxcheck').val() == "1") {
                ajaxfetch();
            }
        } else {
            // upscroll code
        }
        lastScrollTop = st;
    });
</script>


<script type='text/javascript' src='<?php bloginfo('template_url'); ?>/js/vendor_gallery/slick.min.js'></script> 
<script type='text/javascript' src='<?php bloginfo('template_url'); ?>/js/vendor_gallery/fancy_box.js'></script>
<script>
    jQuery(document).ready(function () {
        $('#_aditional_info_review_title').attr('placeholder', 'Gib deiner Bewertung einen Titel');
    });

</script>


<script type='text/javascript'>
    jQuery(document).ready(function () {
        $('.gallery.horizontal-long .slider').slick({
            variableWidth: !0,
            infinite: !0,
            slidesToShow: 1,
            lazyLoad: "progressive",
            centerMode: !0,
            autoplay: false,
            prevArrow: "<button class='slick-prev button' aria-label='Previous'><i class='fa fa-chevron-left'></i></button>",
            nextArrow: "<button class='slick-next button' aria-label='Next'><i class='fa fa-chevron-right'></i></button>",
            responsive: [{
                    breakpoint: 1080,
                    settings: {
                        variableWidth: !1,
                        centerMode: !1,
                        infinite: false,
                        adaptiveHeight: !0

                    }}]
        });






    });
    $('.fancy_video').fancybox({
        'padding': 0,
        'autoScale': false,
        'transitionIn': 'none',
        'transitionOut': 'none',
        'width': 900,
        'height': 506,
        helpers: {
            media: {}
        }
    });


    $('.fancy_photo').fancybox({
        'titleShow': false,
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'easingIn': 'easeOutBack',
        'easingOut': 'easeInBack'
    });
</script>