<?php
/**

 * Template Name: Custom Post Page
 */
get_header();
?>
<style type="text/css">
.social_icons {
	clear: both;
}
.social_icons ul {
	margin: 0;
	padding: 0;
}
.social_icons ul li {
	text-align: center;
	float: none;
	display:inline-block;
	vertical-align:middle;
	list-style: none;
	margin-right:-3px;
}
.social_icons ul li a {
	font-size: 26px;
	color: #676767;
	text-decoration: none;
	margin-right: 7px;
	cursor:pointer;
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
    background: url(<?php bloginfo('template_url');?>/img/ajax-loader.gif) no-repeat center center;
    -webkit-transition: all .1s ease;
    transition: all .1s ease;
	z-index:250;
	clear:both;
	position:relative;
	background-color:#fff;
	overflow:hidden;
    }
.custom_content {
	padding: 100px 50px;
	text-align: center !important;
}
.custom_content h3 {
	background-color: #fbc1ad;
	color: #fff;
	padding: 8px 20px;
	font-family: Bryant Condensed;
	font-weight: 300;
	    font-size: 22px;
	border: none;
	text-decoration: none;
	text-transform: uppercase;
	display: inline-block;
	vertical-align: middle;
	position: relative;
	-webkit-transition: all ease .35s;
	transition: all ease .35s;
	margin-bottom: 15px;
	
}

	@media (max-width: 767px) {
		
		.custom_content {
			padding: 0px 0px;
			text-align: center !important;
		}
		
	}

</style>
<main id="main" class="site-main" role="main">

<article class="content-page post-165 page type-page status-publish hentry">
  <header class="entry-header">
    <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <h1 class="entry-title section-headline"> <span>
      <?php the_title(); ?>
      </span> </h1>
  </header>
  <?php endwhile;
        endif;
        ?>
  <div class="entry-content">
    <?php query_posts(array('post_type' => 'hw_hochzeitpost', 'posts_per_page' => 1, 'paged' => 1, 'orderby' => 'date', 'order' => 'ASC')); ?>
    <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <?php $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
    <div class="split-text-block content-block ">
      <?php if (get_field('Image alignment') == 'left'): ?>
      <div class="split-text-left-col">
        <p><img class="alignnone size-full" src="<?php echo $src[0]; ?>" alt="Hochzeitswahn Einsendungen" width="980" height="736" ></p>
      </div>
      <?php endif; ?>
      <div class="split-text-left-col custom_content">
        <h2>
          <?php the_title(); ?>
        </h2>
        <?php the_content(); ?>
        <?php $title = get_post(get_post_thumbnail_id())->post_title;?>
        <h3>mit freunden teilen</h3>
        <div class="social_icons">
        
     	<meta property="og:url"           content="<?php echo get_permalink() ?>" />
        <meta property="og:type"          content="article">
        <meta property="og:title"         content="<?php the_title();?>" />
        <meta property="og:description"   content="Die schönsten und lustigsten Hochzeitssprüche - Hochzeitswahn - Sei inspiriert!" />
        <meta property="og:image"         content="<?php echo $src[0];?>" />
        <meta property="og:image:width"   content="450"/>
        <meta property="og:image:height"  content="298"/>

          
          <ul>
            <li class="first"><a target="_blank"  href="http://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink() ?>" title="Facebook"><i class="-essbfc-icon-facebook"></i></a></li>
            <li><a target="_blank" href="https://twitter.com/intent/tweet?text=Hochzeitswahn Einsendungen&url=<?php echo get_permalink()?>/attachment/<?php echo $title?>&counturl=<?php echo get_permalink()?>/attachment/<?php echo $title?>" title="Twitter"><i class="-essbfc-icon-twitter "></i></a></li>
            <li><a data-pin-do="buttonPin" data-pin-count="above" data-pin-custom="true" target="_blank" data-pin-lang="en" href="https://www.pinterest.com/pin/create/button/?url=<?php echo get_permalink()?>&media=<?php echo $src[0];?>&description=<?php the_title();?>"><i class="-essbfc-icon-pinterest"></i></a></li>
          </ul>
        </div>
      </div>
      <?php if (get_field('Image alignment') == 'right'): ?>
      <div class="split-text-right-col">
        <p><img class="alignnone size-full" src="<?php echo $src[0]; ?>" alt="Hochzeitswahn Einsendungen" width="980" height="736" ></p>
      </div>
      <?php endif; ?>
    </div>
    <?php endwhile;
            endif;
            ?>
  </div>
  <div class="loader-ellips infinite-scroll-request loader_custom" style="display: none;"> 
    <!--        <span class="loader-ellips__dot"></span>
        <span class="loader-ellips__dot"></span>
        <span class="loader-ellips__dot"></span>
        <span class="loader-ellips__dot"></span>--> 
  </div>
</article>
</main>
<input type="hidden" name="pageQ" id="pageQ" value="2">
<input type="hidden" name="ajaxcheck" id="ajaxcheck" value="1">
<!-- #main --> 
<script>

    jQuery(window).scroll(function () {
        if (jQuery(window).scrollTop() + jQuery(window).height() >= jQuery(document).height() / 2) {
            var page = jQuery('#pageQ').val();
			
			


            var dataString = {action: 'infinite_custom_posts', page: page};
            if (jQuery('#ajaxcheck').val() == "1") {
                jQuery('#ajaxcheck').val('2');
				jQuery('.loader_custom').show();
                $.ajax({
                    url: "/wp-admin/admin-ajax.php",
                    type: 'POST',
                    data: dataString,
                    dataType: 'json',
                    success: function (response) {
                        var page2 = ++page;
                        jQuery('#pageQ').val(page2);
                        jQuery('.entry-content').append(response.html);

                        if (response.result != 'empty')
                        {
                            jQuery('#ajaxcheck').val('1');
                        }
						jQuery('.loader_custom').hide();

                    }
                });
            }
        }
    });
</script>

<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
<?php get_footer(); ?>
