<?php

/**
 * fwbase functions and definitions
 *
 * @package fwbase
 */
//--------------------------------------------------------------------
// Set the content width based on the theme's design and stylesheet.
//--------------------------------------------------------------------

if (!isset($content_width)) {
    $content_width = 640; /* pixels */
}


//--------------------------------------------------------------------
//Sets up theme defaults and registers support for various WordPress features.
//--------------------------------------------------------------------

if (!function_exists('fwbase_setup')) :

    function fwbase_setup() {

        // Make theme available for translation.
        load_theme_textdomain('fwbase', get_template_directory() . '/languages');

        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in this location.
        register_nav_menus(array(
            'primary' => __('Hautpmenu', 'fwbase'),
            'top-nav' => __('Top Navigation'),
            'off-meta' => __('Off Canvas Metalinks'),
            'footer-links-left' => __('Footer Menu Links'),
            'footer-links-center' => __('Footer Menu Werbung'),
            'footer-links-right' => __('Footer Menu Rechtliches'),
        ));

        // Switch default core markup for search form, comment form, and comments to output valid HTML5.
        add_theme_support('html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ));

        // Enable support for Post Formats.
        add_theme_support('post-formats', array(
            'aside', 'image', 'video', 'quote', 'link'
        ));
    }

endif; // fwbase_setup
add_action('after_setup_theme', 'fwbase_setup');

// Remove Comment Cookie
remove_action('set_comment_cookies', 'wp_set_comment_cookies');

//--------------------------------------------------------------------
//Register widget area.
//--------------------------------------------------------------------

function fwbase_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'fwbase'),
        'id' => 'sidebar-1',
        'description' => '',
        'before_widget' => '<imgside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>',
    ));
}

add_action('widgets_init', 'fwbase_widgets_init');

//--------------------------------------------------------------------
// Enqueue scripts, ajax and styles.
//--------------------------------------------------------------------

function fwbase_scripts() {

    wp_enqueue_script('fw-modernizr', get_template_directory_uri() . '/js/vendor/custom.modernizr.js', array(), '2.8.3', false);
    wp_enqueue_script('fw-picturefill', get_template_directory_uri() . '/inc/bower_components/picturefill/dist/picturefill.min.js', array(), '2.3.1', false);
    wp_enqueue_script('masonry', get_template_directory_uri() . '/js/vendor/masonry.pkgd.min.js', array('jquery'));
    wp_enqueue_script('infinite', get_template_directory_uri() . '/js/vendor/infinite-scroll.pkgd.min.js', array());
    wp_enqueue_script('slider', get_template_directory_uri() . '/js/vendor/jquery.slides.js', array('jquery'));

    wp_enqueue_script('fw-custom-js', get_template_directory_uri() . '/js/actions.min.js', array('jquery'), '', true);

    wp_enqueue_script('imagesLoaded', get_template_directory_uri() . '/js/vendor/imagesloaded.pkgd.min.js', array('jquery'));


    //Comments
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    //Google maps script
    if (is_singular('hw_wahnbuechlein')) {
        wp_enqueue_script('google-map', 'https://maps.googleapis.com/maps/api/js?v=3.exp', array(), '3', true);
        wp_enqueue_script('fw-maps-js', get_template_directory_uri() . '/js/vendor/maps.min.js', array('google-map', 'jquery'), '0.5', true);
    }

    wp_enqueue_style('fwbase-style', get_stylesheet_uri());
    wp_enqueue_style('homepage-slider-style', get_stylesheet_directory_uri() . '/homepage-slider.css');
}

add_action('wp_enqueue_scripts', 'fwbase_scripts');

//Replace jQuery with Google CDN jQuery
if (!is_admin())
    add_action("wp_enqueue_scripts", "fw_jquery_enqueue", 11);

function fw_jquery_enqueue() {
    wp_deregister_script('jquery');
    wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js", false, null);
    wp_enqueue_script('jquery');
}

// Ajax Data and Functions
require_once('inc/theme/ajax-functions.php');


//--------------------------------------------------------------------
// Templates and Tags
//--------------------------------------------------------------------
// Custom template tags for this theme.
require get_template_directory() . '/inc/theme/template-tags.php';

// Custom functions that act independently of the theme templates.
require get_template_directory() . '/inc/defaults/extras.php';

// Custom functions that act independently of the theme templates.
require get_template_directory() . '/inc/theme/custom-menus.php';

// Customizer additions.
//require get_template_directory() . '/inc/defaults/customizer.php';
//--------------------------------------------------------------------
// Backend Settings
//--------------------------------------------------------------------
// Load welcome message.
require('inc/admin/welcome.php');

// Admin clean up
require_once('inc/admin/admin.php');

// user roles
require_once('inc/admin/capabilities.php');

// Add styles and buttons to the visual editor
require_once('inc/admin/visualeditor.php');

// Custom post type registration
require_once('inc/theme/custom-post-type.php');

// This inits all shortcodes. Single shortcode files are called from this file.
require_once('inc/shortcodes/init-all-shortcodes.php');

// Sidebars & Widgetizes Areas
require_once('inc/theme/sidebars.php');

// Post image thumbs
add_image_size('thumbnail', 377, 270, array('center', 'top'));
add_image_size('medium', 730, 525, true);
add_image_size('large', 960, 640, true);
add_image_size('xlarge', 1460, 1050, true);

add_image_size('thumbsplit-s', 182, 262, true);
add_image_size('thumbsplit-m', 365, 524, true);
add_image_size('thumbsplit-l', 730, 1048, true);

// Post content images
add_image_size('header-s', 490, 9999);
add_image_size('header-m', 980, 9999);
add_image_size('header-l', 1960, 9999);

add_image_size('headersplit-s', 244, 9999);
add_image_size('headersplit-m', 488, 9999);
add_image_size('headersplit-l', 976, 9999);

add_image_size('content-s', 480, 9999);
add_image_size('content-m', 960, 9999);
add_image_size('content-l', 1440, 9999);

// Portrait
add_image_size('portrait-s', 200, 401, true);
add_image_size('portrait-m', 352, 707, true);
add_image_size('portrait-l', 704, 1414, true);

// Diensleister thumbs
add_image_size('service-xs', 125, 118, true);
add_image_size('service-s', 175, 175, true);
add_image_size('service-m', 250, 237, true);
add_image_size('service-l', 350, 350, true);
add_image_size('service-xl', 500, 474, true);
add_image_size('service-xxl', 525, 525, true);

// Lookboook
add_image_size('lookbook', 562, 703, true);

//--------------------------------------------------------------------
// Menus & Navigation
//--------------------------------------------------------------------
// Adds a class to parent menu items
function add_menu_parent_class($items) {
    $parents = array();
    foreach ($items as $item) {
        if ($item->menu_item_parent && $item->menu_item_parent > 0) {
            $parents[] = $item->menu_item_parent;
        }
    }
    foreach ($items as $item) {
        if (in_array($item->ID, $parents)) {
            $item->classes[] = 'menu-parent-item';
        }
    }
    return $items;
}

add_filter('wp_nav_menu_objects', 'add_menu_parent_class');

//--------------------------------------------------------------------
// Exclude Pw-Protected Posts from posts_where Filter
//--------------------------------------------------------------------
function wpb_password_post_filter($where = '') {
    if (!is_single() && !is_admin()) {
        $where .= " AND post_password = ''";
    }
    return $where;
}

add_filter('posts_where', 'wpb_password_post_filter');

//--------------------------------------------------------------------
// Additional Plugins
//--------------------------------------------------------------------
// Activate Soil Plugin
include_once('inc/plugins/soil-master/soil.php');

// Tidy up other plugin's mess
include_once('inc/plugins/others.php');

// Activate advanced custom fields and its options page
include_once('inc/plugins/acf-init.php');

add_action('wp_ajax_nopriv_infinite_custom_posts', 'infinite_custom_posts');
add_action('wp_ajax_infinite_custom_posts', 'infinite_custom_posts');

function infinite_custom_posts() {
    $html = "";
    $args = array('post_type' => 'hw_hochzeitpost', 'posts_per_page' => 1, 'orderby' => 'date', 'order' => 'ASC', 'paged' => $_REQUEST['page']);
    $res = new WP_Query($args);
    if ($res->have_posts()): while ($res->have_posts()): $res->the_post();
            global $post;
//         print_r($post);
            $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
            $html .= '<div class="split-text-block content-block ">';
            if (get_field('Image alignment') == 'left'):
                $html .= '<div class="split-text-left-col ">
          <p><img class="alignnone size-full" src="' . $src[0] . '" alt="Hochzeitswahn Einsendungen" width="980" height="736" ></p>
        </div>';
            endif;
            $html .= '<div class="split-text-left-col custom_content"><h2>' . ($post->post_title) . '</h2>';
            $html .= ($post->post_content);
            $title = get_post(get_post_thumbnail_id())->post_title;
            $html .= '<h3>mit freunden teilen</h3>';
            $html .= '<div class="social_icons">
            <ul>
              <li class="first"><a target="_blank"  href="http://www.facebook.com/sharer/sharer.php?u=' . get_permalink() . '" title="Facebook"><i class="-essbfc-icon-facebook"></i></a></li>
              <li><a target="_blank" href="https://twitter.com/intent/tweet?text=Hochzeitswahn Einsendungen&url=' . get_permalink() . '/attachment/' . $title . '&counturl=' . get_permalink() . '/attachment/' . $title . '" title="Twitter"><i class="-essbfc-icon-twitter "></i></a></li>
              <li><a data-pin-do="buttonPin" data-pin-count="above" data-pin-custom="true" data-pin-lang="en" target="_blank" href="https://www.pinterest.com/pin/create/button/?url=' . get_permalink() . '&media=' . $src[0] . '&description=' . $post->post_title . '"><i class="-essbfc-icon-pinterest"></i></a></li>    
            </ul>
          </div></div>';
            if (get_field('Image alignment') == 'right'):
                $html .= '<div class="split-text-right-col">
          <p><img class="alignnone size-full" src="' . $src[0] . '" alt="Hochzeitswahn Einsendungen" width="980" height="736" ></p>
        </div>';
            endif;
            $html .= '</div>';
        endwhile;
    endif;
//     $html .= '</div>';
    if (trim($html) != "") {
        echo json_encode(array('result' => 'success', 'html' => $html, 'pp' => $_REQUEST['page']));
    } else {
        $html .= '<div id="noPosts" style="text-align: center;font-size: 36px;color: green;">Ende</div>';
        echo json_encode(array('result' => 'empty', 'html' => $html));
    }
    exit;
}

add_action('wp_ajax_nopriv_infinite_scroll_posts', 'infinite_scroll_posts');
add_action('wp_ajax_infinite_scroll_posts', 'infinite_scroll_posts');

function infinite_scroll_posts() {
    if (isset($_REQUEST['page']) && $_REQUEST['page'] != "") {
        $filter = isset($_REQUEST['attachment']) && trim($_REQUEST['attachment']) != "" ? "date" : "rand";
        $args = array(
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'posts_per_page' => 12,
            'orderby' => $filter,
            'post_parent__in' => json_decode($_REQUEST['pIDs']),
            'meta_key' => 'fw_show_gallery',
            'paged' => $_REQUEST['page'],
        );
        $the_query = new WP_Query($args);
        $zones = json_decode(stripslashes_deep($_REQUEST['zoneArr1']));

        $post_count = $_REQUEST['postcount'];
        $Zone_loop_count = $_REQUEST['loopcount'];
        $zone_count = $_REQUEST['zonecount'];
        ob_start();

        while ($the_query->have_posts()) : $the_query->the_post();
            global $post;


            $image_s = wp_get_attachment_image_src($post->ID, 'content-s');

            if (!@getimagesize($image_s[0])) {
                continue;
            }
            if ($post_count >= 16) {
                $html .= '<li class="count-' . $Zone_loop_count . '"><a  href="https://www.hochzeitswahn.de/wp-content/plugins/oiopub-direct/modules/tracker/go.php?id=' . $zones[$Zone_loop_count]->item_id . '"><img src="' . $zones[$Zone_loop_count]->item_url . '"></a></li>';
?>
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



            if ($_REQUEST['attachment'] != '' && $_REQUEST['attachment'] != $image_caption['uploadedTo']) {

                continue;
            }
            $html .= "<li style='display:none' class='" . (($image_s[2] > $image_s[1]) || (isset($image_meta['fw_media_class']) && $image_meta['fw_media_class'][0] == 'portrait') ? "portrait" : "") . " " . " " . $_REQUEST['page'] . "'>";
            $html .= "<div class='img-hover abc'>";
            $html .= "<div class='open-hover' aria-label='Mehr Infos'><span class='icon-schliessen'></span> </div>";
            $html .= "<div class='img-hover-info'>";
            $html .= "<div>";
            $html .= "<span class='sharing-options' data-modal-id='" . $post->ID . "'>";
            $sharedImage = wp_prepare_attachment_for_js($image_caption['ID']);
            $sharedPost = get_permalink($sharedImage['uploadedTo']);
            $sharedDescr = ($sharedImage['caption'] != '' ? $sharedImage['caption'] : $sharedImage['alt']);
            $html .= '<div class="essb_links essb_counter_modern_bottom essb_displayed_shortcode essb_share essb_template_light-retina essb_1406883711 essb_links_center print-no">
  	  <ul class="essb_links_list essb_force_hide_name essb_force_hide">
    	  <li class="essb_item essb_link_pinterest nolightbox"> ';
            $onclick = "essb_window('http://pinterest.com/pin/create/bookmarklet/?media=" . $sharedImage['url'] . "&amp;url=" . $sharedPost . "&amp;title=" . $sharedImage['title'] . "&amp;description=" . $sharedDescr . "','pinterest','1406883711');";
//        $html .= '<a href="http://www.pinterest.com/pin/create/bookmarklet/?media='.$sharedImage['url'].'&amp;url='.$sharedPost.'&amp;title='.$sharedImage['title'].'&amp;description='.$sharedDescr.'" title="" onclick="essb_window("http://pinterest.com/pin/create/bookmarklet/?media='.$sharedImage['url'].'&amp;url='.$sharedPost.'&amp;title='.$sharedImage['title'].'&amp;description='.$sharedDescr.',"pinterest","1406883711"); return false;" target="_blank" rel="nofollow">   ';
            $html .= '<a href="http://www.pinterest.com/pin/create/bookmarklet/?media=' . $sharedImage['url'] . '&amp;url=' . $sharedPost . '&amp;title=' . $sharedImage['title'] . '&amp;description=' . $sharedDescr . '" title="" onclick="' . $onclick . ' return false;" target="_blank" rel="nofollow">   ';
            $html .= '<span class="essb_icon"></span>
      	    <span class="essb_network_name essb_noname"></span>
      	  </a>
        </li>
        
        <li class="essb_item essb_link_fave nolightbox"> 
          <a href="" title="" target="_blank" rel="nofollow" data-remodal-target="modal-' . $_REQUEST['firstPost'] . '">
            <span class="essb_icon"></span>
            <span class="essb_network_name essb_noname"></span>
          </a>
        </li>
      </ul>
    </div>';
//        $html .= "'".(do_shortcode('[share-image image="' . $image_caption['ID'] . '"]'))."'";
            $html .= "</span>";
            $html .= '<font style="vertical-align: inherit;">Photo by: </font>';
            if ($image_caption['caption']) {

//            _e('Foto von:', 'fwbase');

                if (get_post_meta($post->ID, 'opt_img_photograph', true) != '') {

                    $html .= '<a href="http://' . get_post_meta($post->ID, 'opt_img_photograph', true) . '" title="" rel="nofollow" target="_blank"> <strong>' . $image_caption['caption'] . '</strong> </a>';
                } else {

                    $html .= '<strong>' . $image_caption['caption'] . '</strong>';
                }
            }
            $html .= '<a class="img-link-post" href="' . get_permalink($image_caption['uploadedTo']) . '" title=""> Zum Beitrag </a>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= "<a href='" . get_permalink() . "?details=gallery' title=''>";
            $html .= "<img width='" . $image_s[1] . "' height='" . $image_s[2] . "' src='" . $image_s[0] . "' srcset='" . $image_m[0] . ' ' . $image_m[1] . 'w,' . $image_l[0] . ' ' . $image_l[1] . 'w' . "' size='100vw' alt='" . $image_alt . "' >";
            $html .= "</a>";
            $html .= "<div class='remodal fav-modal-window' data-remodal-id='modal-" . $post->ID . "' style='display:none'>";
            $html .= "'" . (do_shortcode('[userpro_bookmark_image bookmark_icon="show" post_id=' . $post->ID . ' display="none" image_id=' . $post->ID . ']')) . "'";
            $html .= "</div>";
            $html .= "</li>";

        endwhile;
//    $html .= "</ul>";
//    $html =  ob_get_contents();
        ob_end_clean();
        if (trim($html) != "") {
            echo json_encode(array('result' => 'success', 'html' => $html, 'zonecount' => $zone_count, 'postcount' => $post_count, 'loopcount' => $Zone_loop_count, 'pp' => $_REQUEST['page']));
            exit;
        } else {
            $html .= '<div id="noPosts" style="text-align: center;font-size: 36px;color: green;">Ende</div>';
            echo json_encode(array('result' => 'empty'));
            exit;
        }
    }
}

add_action('wp_ajax_nopriv_infinite_scroll_custom_posts', 'infinite_scroll_custom_posts');
add_action('wp_ajax_infinite_scroll_custom_posts', 'infinite_scroll_custom_posts');

function infinite_scroll_custom_posts() {
    if (isset($_REQUEST['page']) && $_REQUEST['page'] != "") {
        $filter = isset($_REQUEST['attachment']) && trim($_REQUEST['attachment']) != "" ? "date" : "rand";
        $args = array(
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'posts_per_page' => 15,
            'orderby' => 'rand',
            'post_parent__in' => json_decode($_REQUEST['pIDs']),
//            'meta_key' => 'fw_show_gallery',
            'paged' => $_REQUEST['page'],
        );

        $the_query = new WP_Query($args);
        $html = "";
//    $html .= "   <li class='sizer'></li>";
//        ob_start();
        $postIDS = json_decode($_REQUEST['postIDS']);
//      echo '<pre>';
//      print_r($postIDS);
        while ($the_query->have_posts()) : $the_query->the_post();
            global $post;
//            echo '1 ';

            $image_s = wp_get_attachment_image_src($post->ID, 'content-s');
            if ($_REQUEST['logoURL'] == $image_s[0]) {
                continue;
            }
//            if (!@getimagesize($image_s[0])) {
//                continue;
//            }
            if (!in_array($post->ID, $postIDS)) {
                $html.= ' <li style="display:none" class="' . $_REQUEST['page'] . '"><a href="' . get_permalink() . '?details=gallery" ><img src="' . $image_s[0] . '"></a></li>';
            }
        endwhile;
        if (trim($html) != "") {
            echo json_encode(array('result' => 'success', 'html' => $html, 'pp' => $_REQUEST['page']));
            exit;
        } else {
            $html .= '<div id="noPosts" style="text-align: center;font-size: 36px;color: green;">Ende</div>';
            echo json_encode(array('result' => 'empty'));
            exit;
        }
    }
}
function posttype_admin_css() {
    global $post_type;
    $post_types = array(
                        /* set post types */
                        'hw_wahnbuechlein',
                  );
    if(in_array($post_type, $post_types))
    echo '<style type="text/css">#post-preview, #view-post-btn{display: none;}</style>';
}
add_action( 'admin_head-post-new.php', 'posttype_admin_css' );
add_action( 'admin_head-post.php', 'posttype_admin_css' );
                ?>