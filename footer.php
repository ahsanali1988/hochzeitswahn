<?php
/**

 * The template for displaying the footer.

 *

 * Contains the closing of the #content div and all content after

 *

 * @package fwbase

 */
?>



</div> <?php //content   ?>



<a href="#site-header" class="to-top-btn" title="<?php _e('Nach oben', 'fwbase'); ?>"> <span class="icon-back-to-top"></span> <?php _e('Nach oben', 'fwbase'); ?> </a>



<footer class="site-footer" role="contentinfo">



    <div class="site-footer-wrapper">



        <div class="footer-row nav">



            <div class="footer-newsletter">

                <span class="icon-mail"></span>

                <strong>Newsletter</strong>

                <p> <?php _e('Erfahre immer als erster was es bei Hochzeitswahn als n&auml;chstes passiert.', 'fwbase'); ?> </p>

                <?php include('newsletterform.php'); ?>

            </div>



            <nav class="footer-navigation">

                <?php wp_nav_menu(array('theme_location' => 'footer-links-left', 'menu_class' => 'unstyled menu', 'container' => false)); ?>

                <?php wp_nav_menu(array('theme_location' => 'footer-links-center', 'menu_class' => 'unstyled menu', 'container' => false)); ?>

                <?php wp_nav_menu(array('theme_location' => 'footer-links-right', 'menu_class' => 'unstyled menu', 'container' => false)); ?>

            </nav>



            <div class="footer-badge">

                <a href="<?php echo get_permalink(19549); ?>" title="<?php _e('W&auml;hle deinen Hochzeitswahn-Badge aus!', 'fwbase'); ?>"> <img width="400" height="400" src="<?php echo get_bloginfo('template_url') . '/img/hzw-badge.jpg'; ?>" alt="<?php _e('W&auml;hle deinen Hochzeitswahn-Badge aus!', 'fwbase'); ?>"> </a>

            </div>



        </div>



        <div class="footer-row ad-section ad-leaderboard medium-up">

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



        <div class="footer-row footer-social">

            <p class="social-name"> <?php _e('@hochzeitswahn', 'fwbase'); ?> 

                <?php echo do_shortcode('[essb-fans style="mutted" width="75"]'); ?></p>



            <p class="copyright-info"> &copy; <?php echo date("Y ");
                _e('Hochzeitswahn. Alle Rechte vorbehalten', 'fwbase');
                ?> </p>

        </div>



    </div>

</footer>

<div style="text-align:center;"><h3 style="color:#ffc1ac"><a href="https://www.instagram.com/hochzeitswahn/" target="_blank">@hochzeitswahn bei Instagram</a></h3></div>

<script>
                setTimeout(function () {
                    console.log('he')
//                    jQuery('.ad-1col').attr('style','display: block !important');
                    jQuery('#hid').show();
//                    jQuery('.home .site-main img').attr('style','display: block !important');
//                    jQuery('.home .internal-ad .entry-thumbnail img').attr('style','display: block !important');
//                    jQuery('.myc').attr('style','display: block !important');
//                    jQuery('.default-row-layout .entry-thumbnail img').attr('style','display: block !important');
//                    jQuery('.ad-2col').attr('style','display: block !important');
//                    jQuery('.module-c-aside').attr('style','display: block !important');
//                    jQuery('.ad-medium-one').attr('style','display: block !important');
//                    jQuery('.ad-small-three').attr('style','display: block !important');
//                    jQuery('.dienstleister-section').attr('style','display: block !important');
//                    jQuery('#slides').attr('style','display: block !important');
//                    jQuery('#oio-banner-3').attr('style','display: block !important');
                }, 5000);
</script>
<?php echo '<div id="hid" style="display:none">'.do_shortcode('[instagram-journal mode="user" user_id="2304997" gallery_mode="classic" gallery_size="auto" photo_size="12.5%" classic_hover_photo_background="#ffc1ac" classic_hover_video_background="#ffc1ac" limit="8" classic_hover_heading_color="#fff" classic_hover_subheading_color="#fff" classic_active_username_color="#333" classic_active_content_color="#333" classic_active_link_color="#ffc1ac" is_full_width="true" enable_links="true" enable_fancybox="false"]').'</div>'; ?>

<a href="#" class="off-canvas-deactivate" title="<?php _e('Men&uuml; schlie&szlig;en', 'fwbase'); ?>"></a>



</div> <?php //site   ?>







<?php wp_footer(); ?>

<script>

    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {

            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)

    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');



    ga('create', 'UA-7711327-12', 'auto');

    ga('require', 'displayfeatures');

    ga('send', 'pageview');

</script>



<?php if (is_home() && false) { ?>

    <script type="text/javascript" src="//s3.amazonaws.com/downloads.mailchimp.com/js/signup-forms/popup/embed.js" data-dojo-config="usePlainJson: true, isDebug: false"></script><script type="text/javascript">require(["mojo/signup-forms/Loader"], function (L) {
            L.start({"baseUrl": "mc.us10.list-manage.com", "uuid": "fe48696e72335b61384722510", "lid": "af1b25bd25"})
        })</script>

<?php }; ?>





<style>

    #oio-banner-3 .oio-slot {

        width: 100% !important;

        padding-bottom: 0 !important;

    }

</style>



</body>

</html>