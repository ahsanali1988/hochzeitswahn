<?php
/**

 * Template Name: Gallery Scroll Page

 * Description: Template zur Darstellung der Galerien

 *

 * Please note that this is the WordPress construct of pages

 * and that other 'pages' on your WordPress site will use a

 * different template.

 *

 * @package fwbase

 */
get_header();
?>
<style type="text/css">
    .social_icons ul {
        margin: 0;
        padding: 0;
    }
    .social_icons ul li {
        text-align: center;
        float: left;
        list-style: none;
    }
    .social_icons ul li a {
        font-size: 22px;
        color: #676767;
        text-decoration: none;
        margin-right: 7px;
    }
    .social_icons ul li a:hover {
        color: #e6ac92;
        text-decoration: none;
    }

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
        background: url(<?php bloginfo('template_url'); ?>/img/ajax-loader.gif) no-repeat center center;
        -webkit-transition: all .1s ease;
        transition: all .1s ease;
        z-index:250;
        clear:both;
        overflow:hidden;
        position:relative;
        background-color:#fff;
    }

    .custom_gallery_ajax{



    }



    /*    .loader-ellips__dot {
            display: block;
            width: 1em;
            height: 1em;
            border-radius: 0.5em;
            background: #555;
            position: absolute;
            animation-duration: 0.5s;
            animation-timing-function: ease;
            animation-iteration-count: infinite;
        }
    
        .loader-ellips__dot:nth-child(1),
        .loader-ellips__dot:nth-child(2) {
            left: 0;
        }
        .loader-ellips__dot:nth-child(3) { left: 1.5em; }
        .loader-ellips__dot:nth-child(4) { left: 3em; }
    
        @keyframes reveal {
            from { transform: scale(0.001); }
            to { transform: scale(1); }
        }
    
        @keyframes slide {
            to { transform: translateX(1.5em) }
        }
    
        .loader-ellips__dot:nth-child(1) {
            animation-name: reveal;
        }
    
        .loader-ellips__dot:nth-child(2),
        .loader-ellips__dot:nth-child(3) {
            animation-name: slide;
        }
    
        .loader-ellips__dot:nth-child(4) {
            animation-name: reveal;
            animation-direction: reverse;
        }
    */


    .ad-section, .site-footer, .to-top-btn{

        position:relative;
        z-index:250;
        background-color:#fff;

    }

    .entry-gallery{

        float:none;	

    }

</style>

<?php
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

<?php /* <div class="ad-section ad-leaderboard medium-up"> <img src="http://placehold.it/728x90" alt="Placeholder Leaderboard"> </div> */ ?>



<div class="ad-section ad-2col nomargin">

    <?php if (current_user_can('administrator')) { ?>

        <?php if (function_exists('oiopub_banner_zone')) oiopub_banner_zone(3, 'center'); ?>

    <?php }; ?>

</div>





<header class="page-header">

    <h1 class="page-title section-headline">

        <span>

            <?php _e('Galerie', 'fwbase'); ?>

        </span>

    </h1>

</header>



<main id="main" class="site-main" role="main">



    <?php
    $attachment = ( get_query_var('attached') ) ? get_query_var('attached') : '';
    $attachCustom = $_REQUEST['custom'] ? $_REQUEST['custom'] : '';

// Create wildcard to meta_query for flexible content

    function my_posts_where($where) {

        $where = str_replace("meta_key = 'flex_gallery_%", "meta_key LIKE 'flex_gallery_%", $where);

        return $where;
    }

    add_filter('posts_where', 'my_posts_where');



// args with flexible content query

    $args = array(
        'posts_per_page' => -1, /* get only the first 50 entries */
        'post_type' => 'post',
        'post_status' => 'publish',
        'oderby' => 'date',
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



    if (trim($attachment) != "") {

        $args['p'] = $attachment;
    }
    if (trim($attachCustom) != "") {

        $args['author'] = $attachCustom;
    }
    $parentIDs = array();

    if (trim($attachCustom) != "") {

        while (have_rows('hw_wahnbuch_admin', $attachCustom)) : the_row();
            $post_object = get_sub_field('hw_wahnbuch_admin_post');

            $parentIDs[] = $post_object;

        endwhile;
    }else {
        $pre_query = new WP_Query($args);


//  if($_SERVER['REMOTE_ADDR'] == "182.184.89.216")
//    {
//        echo '<pre>';
//    print_r($args);
//    print_r($pre_query);
//    }







        if ($pre_query->have_posts()): while ($pre_query->have_posts()) : $pre_query->the_post();

//  if ($_SERVER['REMOTE_ADDR'] == "182.190.76.94") {
// echo '<pre>';
// print_r($post->ID);
//    } 
                if (trim($attachCustom) != "") {
                    $logo = get_field('wahn_profil_logo');
                }
//           print_r($logo);
                $parentIDs[] = $post->ID;



            endwhile;
        endif;
    }

// echo '<pre>';
// print_r($pre_query);
//shuffle($parentIDs);
    $filter = "";
    if (trim($attachment) != "") {
        $filter = 'date';
    } else {
        $filter = 'rand';
    }
//    $filter = isset($attachment) && trim($attachment) != "" ? "date" : "rand";
    $args = array(
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'posts_per_page' => 20,
        'orderby' => $filter,
        'post_parent__in' => $parentIDs,
        'meta_key' => 'fw_show_gallery',
    );
//    echo '<pre>';
//    print_r($args);



    $args['paged'] = get_query_var('paged') ? get_query_var('paged') : 1;

    $the_query = new WP_Query($args);
    ?>

    <input type="hidden" name="attachment" id="attachment" value="<?php echo $attachment ?>">
    <input type="hidden" name="pageQ" id="pageQ" value="2">

    <nav class="sub-category-nav">



        <ul class="sub-cat-nav-catlist unstyled">

            <?php
// Collects all query vars

            $cat_query = ( get_query_var('bilderkategorie') != '' ) ? get_query_var('bilderkategorie') : '';

            $col_query = ( get_query_var('bilderfarben') != '' ) ? get_query_var('bilderfarben') : '';

            $tag_query = ( get_query_var('bildertags') != '' ) ? get_query_var('bildertags') : '';



//$current_url = esc_url(home_url(add_query_arg(array(),$wp->request)));

            $current_url = esc_url(home_url('/hochzeitswahn-galerien/'));
            ?>



            <?php
            $terms = get_terms('bilderkategorie');

            echo '<li> <span>' . __('Kategorien:', 'fwbase') . '</span>';

            echo '<ul>';

            echo '<li class="tags_overview"> <a href="' . $current_url . '?bilderkategorie=&bilderfarben=' . $col_query . '&bildertags=' . $tag_query . '" title="Alle Kategorien" rel="nofollow">Alle Kategorien</a> </li>';

            foreach ($terms as $term) {

                if ($term->slug === $cat_query) {

                    echo '<li class="active"> <a href="' . $current_url . '?bilderkategorie=' . $term->slug . '&bilderfarben=' . $col_query . '&bildertags=' . $tag_query . '" title="' . $term->name . '" rel="nofollow">' . $term->name . '</a> </li>';
                } else {

                    echo '<li> <a href="' . $current_url . '?bilderkategorie=' . $term->slug . '&bilderfarben=' . $col_query . '&bildertags=' . $tag_query . '" title="' . $term->name . '" rel="nofollow">' . $term->name . '</a> </li>';
                }
            }

            echo '</ul> </li>';
            ?>

        </ul>



        <ul class="sub-cat-nav-catlist unstyled">

            <?php
            $terms = get_terms('bilderfarben');

            echo '<li> <span>' . __('Farben:', 'fwbase') . '</span>';

            echo '<ul>';

            echo '<li class="tags_overview"> <a href="' . $current_url . '?bilderkategorie=' . $cat_query . '&bilderfarben=&bildertags=' . $tag_query . '" title="Alle Farben" rel="nofollow">Alle Farben</a> </li>';

            foreach ($terms as $term) {

                if ($term->slug === $col_query) {

                    echo '<li class="active"> <a href="' . $current_url . '?bilderkategorie=' . $cat_query . '&bilderfarben=' . $term->slug . '&bildertags=' . $tag_query . '" title="' . $term->name . '" rel="nofollow">' . $term->name . '</a> </li>';
                } else {

                    echo '<li> <a href="' . $current_url . '?bilderkategorie=' . $cat_query . '&bilderfarben=' . $term->slug . '&bildertags=' . $tag_query . '" title="' . $term->name . '" rel="nofollow">' . $term->name . '</a> </li>';
                }
            }

            echo '</ul> </li>';
            ?>

        </ul>



        <ul class="sub-cat-nav-catlist unstyled">

            <?php
            $terms = get_terms('bildertags');

            echo '<li> <span>' . __('Schlagw&ouml;rter:', 'fwbase') . '</span>';

            echo '<ul>';

            echo '<li class="tags_overview"> <a href="' . $current_url . '?bilderkategorie=' . $cat_query . '&bilderfarben=' . $col_query . '&bildertags=" title="' . $term->name . '" title="Alle Schlagw&ouml;rter" rel="nofollow">Alle Schlagw&ouml;rter</a> </li>';

            foreach ($terms as $term) {

                if ($term->slug === $tag_query) {

                    echo '<li class="active"> <a href="' . $current_url . '?bilderkategorie=' . $cat_query . '&bilderfarben=' . $col_query . '&bildertags=' . $term->slug . '" title="' . $term->name . '" rel="nofollow">' . $term->name . '</a> </li>';
                } else {

                    echo '<li> <a href="' . $current_url . '?bilderkategorie=' . $cat_query . '&bilderfarben=' . $col_query . '&bildertags=' . $term->slug . '" title="' . $term->name . '" rel="nofollow">' . $term->name . '</a> </li>';
                }
            }

            echo '</ul> </li>';
            ?>

        </ul>



    </nav>



    <?php if ($cat_query != '' || $col_query != '' || $tag_query != '') : ?>

        <div class="delete-filters">

            <a class="filter-to-delte" href="<?php echo get_permalink(132765); ?>" title="<?php _e('Alle Filter l&ouml;schen', 'fwbase'); ?>"><?php _e('Alle Filter l&ouml;schen', 'fwbase'); ?></a>



            <?php
            if ($cat_query != '') {
                echo '<a class="filter-to-delete" href="' . $current_url . '?bilderkategorie=&bilderfarben=' . $col_query . '&bildertags=' . $tag_query . '" title="' . __('Filter l&ouml;schen', 'fwbase') . '">' . __('Kategorie l&oumlschen', 'fwbase') . '</a>';
            }

            if ($col_query != '') {
                echo '<a class="filter-to-delete" href="' . $current_url . '?bilderkategorie=' . $cat_query . '&bilderfarben=&bildertags=' . $tag_query . '" title="' . __('Filter l&ouml;schen', 'fwbase') . '">' . __('Farbe l&oumlschen', 'fwbase') . '</a>';
            }

            if ($tag_query != '') {
                echo '<a class="filter-to-delete" href="' . $current_url . '?bilderkategorie=' . $cat_query . '&bilderfarben=' . $col_query . '&bildertags=" title="' . __('Filter l&ouml;schen', 'fwbase') . '">' . __('Schlagwort l&oumlschen', 'fwbase') . '</a>';
            }
            ?>

        </div>

    <?php endif; ?>



    <?php
//    if ($_SERVER['REMOTE_ADDR'] == "182.191.234.253") {
        if (function_exists('oiopub_banner_zone')) {

            $zone_ids = 4;
            $options = array('align' => "left", 'empty' => "0", 'raw_data' => true, 'rows' => 100);
            $zones = oiopub_banner_zone($zone_ids, $options);
            ?>
            <?php
            $zone_count = count($zones);
        }
//    }
    ?>

    <?php if ($the_query->have_posts()): ?>



        <div class="gallery-loader"></div>


        <div id="scroll"  class="custom_gallery_ajax clearfix">
            <ul class="entry-gallery unstyled" ontouchstart="">;



                <li class="sizer"></li>

                <?php if (!post_password_required()): ?>

                    <?php
                    $count = 1;
                    $post_count = 1;
                    $Zone_loop_count = 0;
                    while ($the_query->have_posts()) : $the_query->the_post();



                        $image_s = wp_get_attachment_image_src($post->ID, 'content-s');
                        if (trim($attachCustom) != "") {
                            if ($logo['url'] == $image_s[0]) {
                                continue;
                            }
                        }
                        if (!@getimagesize($image_s[0])) {
                            continue;
                        }
                        if ($post_count >= 16) {
//                            var_dump($zones);
                            ?>
                            <li class="count-<?php echo $Zone_loop_count ?>"><a  href="https://www.hochzeitswahn.de/wp-content/plugins/oiopub-direct/modules/tracker/go.php?id=<?php echo $zones[$Zone_loop_count]->item_id ?>"><img src="<?php echo $zones[$Zone_loop_count]->item_url ?>"></a></li>   
                            <?php
                            $zone_count--;
                            if ($zone_count == 0) {
                                $Zone_loop_count = 0;
                                $zone_count = count($zones);
                            } else {
                                $Zone_loop_count++;
                            }
                            $post_count = 1;
                        }
                        $post_count++;
                        $image_m = wp_get_attachment_image_src($post->ID, 'content-m');

                        $image_l = wp_get_attachment_image_src($post->ID, 'content-l');

                        $image_caption = wp_prepare_attachment_for_js($post->ID);

                        $image_meta = get_post_meta($post->ID);

                        $image_alt = get_post_meta($post->ID, '_wp_attachment_image_alt', true);

                        $attachment = ( get_query_var('attached') ) ? get_query_var('attached') : '';



                        if ($attachment != '' && $attachment != $image_caption['uploadedTo']) {

                            continue;
                        }
                        ?>



                        <li <?php
                        if ($image_s[2] > $image_s[1] || (isset($image_meta['fw_media_class']) && $image_meta['fw_media_class'][0] == 'portrait')) {
                            echo 'class="portrait"';
                        }
                        ?>>



                            <div class="img-hover abc">

                                <div class="open-hover" aria-label="<?php _e('Mehr Infos', 'fwbase') ?>"> <span class="icon-schliessen"></span> </div>



                                <div class="img-hover-info">

                                    <div>

                                        <span class="sharing-options" data-modal-id="<?php echo $post->ID; ?>">

                                            <?php //echo do_shortcode('[easy-social-share buttons="pinterest,fave" counters=0 hide_names="force" template="light-retina url="'.$image_m[0].'"]');      ?>

                                            <?php echo do_shortcode('[share-image image="' . $image_caption['ID'] . '"]'); ?>

                                        </span>



                                        <?php
                                        if ($image_caption['caption']) {

                                            _e('Foto von:', 'fwbase');

                                            if (get_post_meta($post->ID, 'opt_img_photograph', true) != '') {

                                                echo '<a href="http://' . get_post_meta($post->ID, 'opt_img_photograph', true) . '" title="" rel="nofollow" target="_blank"> <strong>' . $image_caption['caption'] . '</strong> </a>';
                                            } else {

                                                echo '<strong>' . $image_caption['caption'] . '</strong>';
                                            }
                                        }
                                        ?>



                                        <?php echo '<a class="img-link-post" href="' . get_permalink($image_caption['uploadedTo']) . '" title=""> Zum Beitrag </a>'; ?>



                                    </div>

                                </div>

                            </div>



                            <a href="<?php echo get_permalink() . '?details=gallery'; ?>" title="">

                                <img width="<?php echo $image_s[1]; ?>" height="<?php echo $image_s[2]; ?>" src="<?php echo $image_s[0]; ?>"

                                     srcset="<?php echo $image_m[0] . ' ' . $image_m[1] . 'w,'; ?>

                                     <?php echo $image_l[0] . ' ' . $image_l[1] . 'w'; ?>" size="100vw" alt="<?php echo $image_alt; ?>">

                            </a>



                            <div class="remodal fav-modal-window" data-remodal-id="modal-<?php echo $post->ID; ?>" >

                                <?php echo do_shortcode('[userpro_bookmark_image bookmark_icon="show" post_id=' . $post->ID . ' display="none" image_id="' . $post->ID . '"]'); ?>

                            </div>

                        </li>



                        <?php
                        if ($count == 1) {
                            echo '<input type="hidden" id="firstPost" value="' . $post->ID . '">';
                        }
                        $count++;

                    endwhile;
                    ?>
                    <input type="hidden" id="zonecount" value="<?php echo $zone_count ?>">
                    <input type="hidden" id="postcount" value="<?php echo $post_count ?>">
                    <input type="hidden" id="loopcount" value="<?php echo $Zone_loop_count ?>">


                <?php endif; ?>



            </ul>
        </div>


    <?php else: ?>





    <?php endif; ?>



    <?php
    wp_reset_postdata();



// Pagination fixes for Custom Queries
// http://wordpress.stackexchange.com/questions/120407/how-to-fix-pagination-for-custom-loops

    $big = 999999999;



//    echo '<div class="pagination-links">' . paginate_links(array(
//        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
//        'format' => '?paged=%#%',
//        'current' => max(1, get_query_var('paged')),
//        'total' => $the_query->max_num_pages,
//        'prev_text' => __('&#x2190;'),
//        'next_text' => __('&#x2192;'),
//    )) . '</div>';
    ?>




    <div class="loader-ellips infinite-scroll-request loader_custom" style="display: none;margin-bottom: 20px;margin-top: 20px">
<!--        <span class="loader-ellips__dot"></span>
        <span class="loader-ellips__dot"></span>
        <span class="loader-ellips__dot"></span>
        <span class="loader-ellips__dot"></span>-->
    </div>
    <div id="empty" style="display: none;text-align: center;font-size: 36px;color: green;">Ende</div>
    <div class="ad-section ad-2col">



        <div class="ad-2col-left ad-small-two">

        </div>



        <div class="ad-2col-right medium-up ad-small-two">

        </div>

    </div>
    <?php
//if (trim($attachCustom) != "") {
//    $attachment = $attachCustom;
//}
//if (trim($attachment) != "") {
//    $attachment = $attachment;
//}
    ?>
    <input type="hidden" name="ajaxcheck" id="ajaxcheck" value="2">
    <input type="hidden" name="ajaxcheck" id="pageClass" value="2">
    <script src="https://unpkg.com/infinite-scroll@3/dist/infinite-scroll.pkgd.min.js"></script>
    <script>

        $(window).load(function () {
            jQuery('#ajaxcheck').val('1');
        })
        var lastScrollTop = 0;
        $(window).scroll(function (event) {

            var st = $(this).scrollTop();
            if (st > lastScrollTop) {
                var page = jQuery('#pageQ').val();
                var firstPost = jQuery('#firstPost').val();


                var dataString = {action: 'infinite_scroll_posts', zoneArr1 :'<?php echo json_encode($zones)?>' ,loopcount : jQuery('#loopcount').val() ,zonecount : jQuery('#zonecount').val() ,postcount : jQuery('#postcount').val() ,firstPost: firstPost, attachment: '<?php echo $attachment ?>', page: page, pIDs: '<?php echo json_encode($parentIDs) ?>'};
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
                            var $g_container = $('.entry-gallery');
//                            jQuery('.entry-gallery').append(response.html);
//                            $g_container.masonry( 'appended', response.html );
                            var pageclass = $('#pageClass').val();
                            $g_container.masonry("reloadItems").masonry("reloadItems");
                            imagesLoaded($("." + pageclass), function () {
                                $($g_container).append(response.html);
                                       jQuery('#zonecount').val(response.zonecount);
                                       jQuery('#postcount').val(response.postcount);
                                       jQuery('#loopcount').val(response.loopcount);
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
            } else {
                // upscroll code
            }
            lastScrollTop = st;
        });
//        jQuery(window).scroll(function () {
//            if (jQuery(window).scrollTop() + jQuery(window).height() >= jQuery(document).height() / 2) {
//                var page = jQuery('#pageQ').val();
//
//
//                var dataString = {action: 'infinite_scroll_posts', attachment: '<?php echo ( get_query_var('attached') ) ? get_query_var('attached') : '' ?>', page: page, pIDs: '<?php echo json_encode($parentIDs) ?>'};
//                if (jQuery('#ajaxcheck').val() == "1") {
//                    jQuery('#ajaxcheck').val('2');
//                    $('.loader_custom').show();
//                    $.ajax({
//                        url: "/wp-admin/admin-ajax.php",
//                        type: 'POST',
//                        data: dataString,
//                        dataType: 'json',
//                        success: function (response) {
////               console.log(response.result)
////               console.log(response.html)
//                            var $g_container = $('.entry-gallery');
////                            jQuery('.entry-gallery').append(response.html);
////                            $g_container.masonry( 'appended', response.html );
//
//                            $($g_container).append(response.html).masonry("reloadItems").masonry("layout");
//                            setTimeout(function () {
//                                $g_container.masonry("reloadItems").masonry("layout");
////                               alert('1')
//                            }, 2000)
//                            setTimeout(function () {
//                                $g_container.masonry("reloadItems").masonry("layout");
////                               alert('1')
//                            }, 3000)
//                            setTimeout(function () {
//                                $g_container.masonry("reloadItems").masonry("layout");
////                               alert('1')
//                            }, 4000)
//                            setTimeout(function () {
//                                $g_container.masonry("reloadItems").masonry("layout");
////                               alert('1')
//                            }, 5000)
//                            $('.loader_custom').hide();
//
//                            page = ++page;
//                            jQuery('#pageQ').val(page);
//
//                            jQuery('#ajaxcheck').val('1');
//
//                        }
//                    });
//                }
//            }
//        });
    </script>

</main><!-- #main -->



<?php get_footer(); ?>