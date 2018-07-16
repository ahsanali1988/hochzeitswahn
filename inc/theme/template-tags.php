<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package fwbase
 */

//--------------------------------------------------------------------
// Display navigation to next/previous set of posts when applicable.
//--------------------------------------------------------------------

if ( ! function_exists( 'fwbase_paging_nav' ) ) :

function fwbase_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
  <div class="post-navigation paging-nav">
	  <nav class="posts-navigation page-navigation" role="navigation">
	  	<div class="nav-links">
	  		<?php if ( get_next_posts_link() ) : ?>
	  		<div class="nav-previous"><?php next_posts_link( __( '&Auml;ltere Beitr&auml;ge', 'fwbase' ) ); ?></div>
	  		<?php endif; ?>

	  		<?php if ( get_previous_posts_link() ) : ?>
	  		<div class="nav-next"><?php previous_posts_link( __( 'Neuere Beitr&auml;ge', 'fwbase' ) ); ?></div>
	  		<?php endif; ?>
	  	</div>
	  </nav>
  </div>

  <a href="#" class="load-more-button" title="<?php _e('Weitere Beitr&auml;ge laden', 'fwbase'); ?>"> <span class="icon-neu-laden"></span> <?php _e('Weitere Beitr&auml;ge laden', 'fwbase'); ?> </a>

	<?php
}
endif;


//--------------------------------------------------------------------
// Display navigation to next/previous post when applicable.
//--------------------------------------------------------------------

if ( ! function_exists( 'fwbase_post_nav' ) ) :

function fwbase_post_nav() {
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
  $prevThumbnail = ($previous != '') ? get_the_post_thumbnail( $previous->ID, 'service-s' ) : '';
  $nextThumbnail = ($next != '') ? get_the_post_thumbnail( $next->ID, 'service-s' ) : '';

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="post-navigation" role="navigation">
		<div class="nav-links">
			<?php
  			$prev_text = _x('Zum vorherigen Beitrag', 'fwbase');
  			$next_text = _x('Zum n&auml;chsten Beitrag', 'fwbase');

				previous_post_link( '<div class="nav-previous">%link</div>', $prevThumbnail.'<span>'.$prev_text.'</span> <span class="prev-title">%title</span>' );
				next_post_link( '<div class="nav-next">%link</div>', $nextThumbnail.'<span>'.$next_text.'</span> <span class="next-title">%title</span>' );
			?>
		</div>
	</nav>
	<?php
}
endif;


//--------------------------------------------------------------------
// Prints HTML with meta information for the current post-date/time and author.
//--------------------------------------------------------------------

if ( ! function_exists( 'fwbase_posted_on' ) ) :
  function fwbase_posted_on() {
  	if( is_single() ) {
  	  $html_output  = '<div class="meta-wrapper">';
  	  $html_output .=  '<div class="meta-content-output">';
  	  $html_output .=   '<span class="posted-on">' . get_the_date( 'M' ) . ' <strong> ' . get_the_date( 'd' ) . '</strong> </span>';
  	  $html_output .=   '<span class="sharing-options" data-modal-id="'.get_the_ID().'">';
      $html_output .=     '<div class="essb_links essb_template_light-retina">';
      $html_output .=       '<ul class="essb_links_list">';
      $html_output .=         '<li class="essb_item essb_link_comment">';
      $html_output .=           '<a href="#comments" rel="nofollow" title="">';
      $html_output .=             '<span class="icon-kommentare"></span>';
      $html_output .=             '<span class="comment-count">'.get_comments_number(get_the_ID()).'</span>';
      $html_output .=           '</a>';
      $html_output .=         '</li>';
      $html_output .=         '<li class="essb_item essb_link_fave">';
      $html_output .=           '<a href="" rel="nofollow" title="" data-remodal-target="modal-16632">';
      $html_output .=             '<span class="essb_icon"></span>';
      $html_output .=           '</a>';
      $html_output .=         '</li>';
      $html_output .=       '</ul>';
	    $html_output .=     '</div>';
      $html_output .=   '</span>';
      $html_output .=  '</div>';
      $html_output .= '</div>';
      echo $html_output;
  	} else {
  	  $html_output  = '<div class="meta-wrapper">';
  	  $html_output .=  '<div class="meta-content-output">';
  	  $html_output .=   '<span class="posted-on">' . get_the_date( 'M' ) . ' <strong> ' . get_the_date( 'd' ) . '</strong> </span>';
  	  $html_output .=   '<span class="sharing-options" data-modal-id="'.get_the_ID().'">';
  	  $html_output .=     do_shortcode('[easy-social-share buttons="facebook,twitter,pinterest,fave" counters=0 hide_names="force" template="light-retina"]');
      $html_output .=   '</span>';
      $html_output .=  '</div>';
      $html_output .= '</div>';
      echo $html_output;
    }
  }
endif;


//--------------------------------------------------------------------
// Prints HTML with meta information for the categories, tags and comments.
//--------------------------------------------------------------------

if ( ! function_exists( 'fwbase_entry_meta' ) ) :
  function fwbase_entry_meta() {
  	if ( 'post' == get_post_type() ) {
  		$categories_list = get_the_category_list( __( ', ', 'fwbase' ) );
  		if ( is_single() && function_exists('get_field') && get_field('post_fields_farbfilter') ) {
  		  $color_filter = get_field('post_fields_farbfilter');
        $html_output = $categories_list;
        $html_output .= '<span class="entry-colors"> <strong>'.__('Farben', 'fwbase').'</strong>';
        foreach( $color_filter as $color ) {
    		  $html_output .= '<a href="'.get_permalink(19554).'?farbfilter='.$color.'" class="colorfilter-'.$color.'" title="'.__('Alle Beitr&auml;ge mit der Farbe '.$color.' anzeigen', 'fwbase').'" aria-label="'.$color.'"></a>';
        }
        $html_output .= '</span>';
  			printf( '<span class="cat-links">' . __( '%1$s', 'fwbase' ) . '</span>', $html_output );
  		}
  		elseif ( $categories_list && fwbase_categorized_blog() ) {
  			printf( '<span class="cat-links">' . __( '%1$s', 'fwbase' ) . '</span>', $categories_list );
  		}
  	} elseif ( 'hw_lookbook' == get_post_type() ) {
    	global $post;
      printf( '<span class="cat-links">' . __( '%1$s', 'fwbase' ) . '</span>', get_the_term_list( $post->ID, 'look_categorie' ) );
  	} elseif ( 'hw_wahnbuechlein' == get_post_type() ) {
    	global $post;
      printf( '<span class="cat-links">' . __( '%1$s', 'fwbase' ) . '</span>', get_the_term_list( $post->ID, 'wahn_categorie' ) );
		} elseif ( 'hw_flitterwochen' == get_post_type() ) {
				global $post;
				printf( '<span class="cat-links">' . __( '%1$s', 'fwbase' ) . '</span>', get_the_term_list( $post->ID, 'flitter_categorie' ) );
			}
  }
endif;


//--------------------------------------------------------------------
// Display the archive title based on the queried object.
//--------------------------------------------------------------------

if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( __( 'Category: %s', 'fwbase' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( __( 'Tag: %s', 'fwbase' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( __( 'Author: %s', 'fwbase' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( __( 'Year: %s', 'fwbase' ), get_the_date( _x( 'Y', 'yearly archives date format', 'fwbase' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( __( 'Month: %s', 'fwbase' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'fwbase' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( __( 'Day: %s', 'fwbase' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'fwbase' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = _x( 'Asides', 'post format archive title', 'fwbase' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = _x( 'Galleries', 'post format archive title', 'fwbase' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = _x( 'Images', 'post format archive title', 'fwbase' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = _x( 'Videos', 'post format archive title', 'fwbase' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = _x( 'Quotes', 'post format archive title', 'fwbase' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = _x( 'Links', 'post format archive title', 'fwbase' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = _x( 'Statuses', 'post format archive title', 'fwbase' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = _x( 'Audio', 'post format archive title', 'fwbase' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = _x( 'Chats', 'post format archive title', 'fwbase' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( __( 'Archives: %s', 'fwbase' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( __( '%1$s: %2$s', 'fwbase' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = __( 'Archives', 'fwbase' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;
	}
}
endif;


//--------------------------------------------------------------------
// Display posts from same or parent category
//--------------------------------------------------------------------
if ( ! function_exists( 'fwbase_posts_you_like' ) ) :
  function fwbase_posts_you_like( $level, $currentID ) {

    $category = get_the_category();

    // $level can be 'parent' or 'same'
    if ( $level == 'parent' ) {
      $queryCat = $category[0]->term_id;
    } else {
      $queryCat = ( $category[1] != '' ) ? $category[1]->term_id : $category[0]->term_id;
    }

    // query ausfuehren
    $new_Query = new WP_Query( array(
      'cat' => $queryCat,
      'posts_per_page'  => 4,
      'post__not_in' => array($currentID),
      'orderby' => 'rand',
      'date_query' => array(
        'after' => date('Y-m-d', strtotime('-420 days'))
      )
    ));

    // while have posts - get_template preview
    if ( $new_Query->have_posts() ) :
      echo '<section class="posts-to-like">';
      echo   '<h3 class="section-headline"> <span>'._x('Das k&ouml;nnte dir auch gefallen', 'fwbase').'</span> </h3>';
      echo   '<div class="posts-to-like-wrapper">';
      while ( $new_Query->have_posts() ) : $new_Query->the_post();
        if( get_the_ID() != $currentID) {
      		get_template_part( 'content', 'preview' );
        }
      endwhile; wp_reset_postdata();
      echo   '</div>';
      echo '</section>';
      echo '<a class="button" title="'._x('Weitere Beitr&auml;ge', 'fwbase').'" href="'.get_category_link( $queryCat ).'">'._x('Noch mehr Beitr&auml;ge', 'fwbase').'</a>';
    endif;
  }
endif;


//--------------------------------------------------------------------
// Display category, tag, or term description.
//--------------------------------------------------------------------

if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function fwbase_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'fwbase_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'fwbase_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so fwbase_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so fwbase_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in fwbase_categorized_blog.
 */
function fwbase_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'fwbase_categories' );
}
add_action( 'edit_category', 'fwbase_category_transient_flusher' );
add_action( 'save_post',     'fwbase_category_transient_flusher' );
