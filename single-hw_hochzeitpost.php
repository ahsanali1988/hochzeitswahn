<?php

get_header(); ?>


	<div id="primary" class="content-area">


		<div class="entry-content">
    <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <?php $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
         	<meta property="og:url"           content="<?php echo get_permalink() ?>" />
        <meta property="og:type"          content="article">
        <meta property="og:title"         content="<?php the_title();?>" />
        <meta property="og:description"   content="Die schönsten und lustigsten Hochzeitssprüche - Hochzeitswahn - Sei inspiriert!" />
        <meta property="og:image"         content="<?php echo $src[0];?>" />
        <meta property="og:image:width"   content="450"/>
        <meta property="og:image:height"  content="298"/>
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



	</div>



<?php get_sidebar(); ?>



<?php get_footer(); ?>