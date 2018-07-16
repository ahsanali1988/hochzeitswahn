<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package fwbase
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

  <div class="comments-wrapper">
    
	  <?php if ( have_comments() ) : ?>
	  	<strong class="comments-title">
	  		<?php
	  			printf( _nx( '1 Kommentar', '%1$s Kommentare', get_comments_number(), 'comments title', 'fwbase' ),
	  				number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
	  		?>
	  	</strong>
    
	  	<a class="commentform-anchor" href="#reply-title" rel="nofollow" title="<?php _e('Hinterlasse eine Antwort', 'fwbase'); ?>">
	  		<?php _e('Hinterlasse eine Antwort', 'fwbase'); ?>
	  	</a>
	  	    
	  	<ol class="comment-list">
	  		<?php
	  			wp_list_comments( array(
	  				'style'      => 'ol',
	  				'short_ping' => true,
	  			) );
	  		?>
	  	</ol><!-- .comment-list -->
    
	  	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
	  	<nav id="comment-nav-below" class="comment-navigation" role="navigation">
	  		<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'fwbase' ); ?></h1>
	  		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'fwbase' ) ); ?></div>
	  		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'fwbase' ) ); ?></div>
	  	</nav><!-- #comment-nav-below -->
	  	<?php endif; // check for comment navigation ?>
    
	  <?php endif; // have_comments() ?>
        
	  <?php	if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :	?>
	  	<p class="no-comments"><?php _e( 'Leider sind die Kommentare geschlossen.', 'fwbase' ); ?></p>
	  <?php endif; ?>
        
    <?
      $aria_req = ( $req ? " aria-required='true'" : '' );
      $comments_args = array(
        'comment_notes_after' => '',
        'class_submit' => 'submit button',
    	  'fields' => apply_filters( 'comment_form_default_fields', array(
    	   'author' =>
    	   	'<div class="left"><p class="comment-form-author ">' .
    	   	'<input id="author" placeholder="' . __( 'Name', 'domainreference' ) . '*" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .'" size="30" ' . $aria_req . ' /></p>',
          
    	   'email' =>
    	   	'<p class="comment-form-email">' .
    	   	'<input placeholder="' . __( 'Email', 'domainreference' ) . '*" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
    	   	'" size="30"' . $aria_req . ' /></p>',
          
    	   'url' =>
    	   	'<p class="comment-form-url">' .
    	   	'<input id="url" placeholder="' .__( 'Website', 'domainreference' ) . '" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
    	   	'" size="30" /></p></div>'
    	   )
    	  )
      );
    
      comment_form($comments_args);
            
      if (function_exists('subscribe_reloaded_show')) {
        echo '<div class="comment-form-subscriptions-wrapper">';
        subscribe_reloaded_show(); 
        echo '</div>';
      }
    ?>
    
  </div>
  
  <div class="ad-section">
    <h6 class="section-headline"> <span> <?php _e('Unsere Sponsoren', 'fwbase')?> </span> </h6>
    <div class="ad-medium-two">
      <img src="https://placehold.it/300x250" alt="Placeholder Medium Rectangle">
      <img src="https://placehold.it/300x250" alt="Placeholder Medium Rectangle">
    </div>
  </div>     

</div>

<div class="ad-section ad-2col below-comments">
  <div class="ad-2col-left ad-small-two">
  </div>
  
  <div class="ad-2col-right medium-up ad-small-two">
  </div>
</div>   