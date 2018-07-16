<?php
/**
 * The template for displaying search results pages.
 *
 * @package fwbase
 */

get_header();

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

<div class="ad-section ad-2col nomargin">
  <?php if(function_exists('oiopub_banner_zone')) oiopub_banner_zone(3, 'center'); ?>
</div>


  <header class="page-header">
    <h1 class="page-title section-headline">
      <span> <?php printf( __( 'Deine Suchergebnisse f&uuml;r "%s"', 'fwbase' ), get_search_query() ); ?> </span>
    </h1>
  </header>

  <main id="main" class="site-main" role="main">

    <?php
      $wp_query->query_vars["posts_per_page"] = 16;
      $wp_query->get_posts();
    ?>

	  <?php if ( have_posts() ) : ?>

			<section class="post-entry-listing">

			  <ul class="unstyled">

          <?php while ( have_posts() ) : the_post(); ?>

            <li> <?php get_template_part( 'content', 'listing' ); ?> </li>

          <?php endwhile; ?>

			  </ul>

			</section>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

  </main>

  <?php fwbase_paging_nav(); ?>

<?php get_footer(); ?>
