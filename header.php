<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package fwbase
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
      <style>
          /*.ad-1col{display: none !important}*/
          /*.myc{display: none !important}*/
/*          .home .internal-ad .entry-thumbnail img{display: block !important}
          .home .site-main img{display: none}*/
          /*#slides{display: none !important}*/
/*          .default-row-layout .entry-thumbnail img{display: none !important}
          .ad-2col{display: none !important}
          .module-c-aside{display: none !important}*/
/*          .ad-medium-one{display: none !important}
          #oio-banner-3{display: none !important}
          .ad-small-three{display: none !important}
          .dienstleister-section{display: none !important}*/
      </style>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <meta name="sitelock-site-verification" content="8989" />

    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <link rel="apple-touch-icon" sizes="57x57" href="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/touch/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/touch/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/touch/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/touch/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/touch/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/touch/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/touch/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/touch/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/touch/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/touch/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/touch/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/touch/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/touch/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/touch/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/touch/mstile-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <?php wp_head(); ?>
    <script> jQuery(document).ready(function ($) { document.cookie = "used_ads=; expires=Thu, 01 Jan 1970 00:00:00 UTC"; }); </script>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '1750970218471174');
fbq('track', "PageView");</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1750970218471174&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
  </head>

  <body <?php $loged = ''; if( is_user_logged_in() && current_user_can( 'subscriber' ) ) { $loged = 'subscriber'; } body_class($loged); ?>>

    <div class="hfeed site">

    	<header class="site-header" role="banner" id="site-header">

    		<nav class="top-navigation" aria-hidden="true">
          <?php wp_nav_menu( array( 'theme_location' => 'top-nav', 'menu_class' => 'unstyled menu', 'container' => false ) ); ?>
        </nav>

    		<div class="site-branding">
    			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
    			  <?php if( is_post_type_archive('hw_wahnbuechlein') || is_tax('wahn_categorie') || is_tax('wahn_region') || is_singular('hw_wahnbuechlein') ) { ?>
              <img src="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/hochzeitswahn-wahnbuechlein.jpg" alt="<?php bloginfo('description'); ?>" nopin="nopin">
            <?php } elseif( is_post_type_archive('hw_lookbook') || is_tax('look_filter') || is_tax('look_categorie') || is_singular('hw_lookbook') ) { ?>
    			    <img src="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/hochzeitswahn-kollektion.jpg" alt="<?php bloginfo('description'); ?>" nopin="nopin">
            <?php } elseif( is_post_type_archive('hw_flitterwochen') || is_tax('flitter_categorie') || is_tax('flitter_region') || is_singular('hw_flitterwochen') ) { ?>
      			  <img src="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/hochzeitswahn-kollektion.jpg" alt="<?php bloginfo('description'); ?>" nopin="nopin">
            <?php } else { ?>
      			  <img src="https://www.hochzeitswahn.de/wp-content/themes/hochzeitswahn_v3/img/hochzeitswahn-inspiriert.jpg" alt="<?php bloginfo('description'); ?>" nopin="nopin">
            <?php } ?>
    			</a>
    		</div>

    		<nav class="main-navigation" role="navigation">

    			<button class="off-canvas-toggle small-only" aria-label="<?php _e('Men&uuml; &ouml;ffnen'); ?>">
    			  <span class="icon-menue"></span>
    		  </button>

    			<div class="off-canvas-wrapper">

    			  <a href="#" class="off-canvas-close small-only" title="<?php _e('Men&uuml; schlie&szlig;en', 'fwbase'); ?>"> <span class="icon-schliessen"></span> </a>

            <div class="top-navigation small-only">
              <?php wp_nav_menu( array( 'theme_location' => 'top-nav', 'menu_class' => 'unstyled menu', 'container' => false ) ); ?>
            </div>

            <div class="off-canvas-menu">
    			    <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'unstyled menu', 'container' => false, 'walker' => new FWMegaMenu ) ); ?>
            </div>

            <div class="off-canvas-meta small-only">
    			    <?php wp_nav_menu( array( 'theme_location' => 'off-meta', 'menu_class' => 'unstyled menu', 'container' => false ) ); ?>
            </div>

            <div class="off-canvas-social small-only">
              <ul class="unstyled social-network-list">
                <li> <?php _e('@hochzeitswahn', 'fwbase'); ?> </li>
                <?php if(get_field('social_networks', 'option')): while(has_sub_field('social_networks', 'option')): ?>
                <li>
                  <a href="<?php the_sub_field('social_networks_url'); ?>" title="<?php _e('Folge Hochzeitswahn', 'fwbase'); ?>" target="_blank" rel="nofollow">
                    <i class="icon-<?php the_sub_field('social_networks_icon'); ?>"></i>
                  </a>
                </li>
                <?php endwhile; endif; ?>
              </ul>
            </div>

    		    <div class="off-canvas-newsletter small-only">
      		    <h6><?php _e('Newsletter Anmeldung:','fwbase'); ?></h6>
      		    <?php include('newsletterform.php'); ?>
    		    </div>

    			</div> <!-- /off-canvas -->

    			<div class="main-navigation-meta">

            <div class="main-navigation-search">
              <a href="#" class="searchform-toggle" title="<?php _e('Suche ein-/ausblenden', 'fwbase'); ?>"> <span class="search-term"><?php _e('Suche', 'fwbase'); ?></span> <span class="icon-lupe"></span> </a>
            </div>

            <div class="main-navigation-social large-only" aria-hidden="true">
              <ul class="unstyled social-network-list">
                <li> <?php _e('@hochzeitswahn', 'fwbase'); ?> </li>
                <?php if(get_field('social_networks', 'option')): while(has_sub_field('social_networks', 'option')): ?>
                <li>
                  <a href="<?php the_sub_field('social_networks_url'); ?>" title="<?php _e('Folge Hochzeitswahn', 'fwbase'); ?>" target="_blank" rel="nofollow">
                    <i class="icon-<?php the_sub_field('social_networks_icon'); ?>"></i>
                  </a>
                </li>
                <?php endwhile; endif; ?>
              </ul>
            </div>

    			</div>

          <div class="main-navigation-login small-only" aria-hidden="true">
            <a href="<?php echo get_permalink(19786); ?>" title="<?php _e('Login', 'fwbase'); ?>"> <span class="icon-benutzer"></span> </a>
          </div>

    		</nav><!-- /navigation -->

        <?php get_search_form(true); ?>
    	</header>

      <?php
      if ( is_home() ) {
           include_once 'inc/theme/homepage-slider.php';
       }; ?>

    	<div id="content" class="site-content">
