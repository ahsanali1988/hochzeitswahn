<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package fwbase
 */
?>

<?php 
  
  //  Lets see it ACF is enabled and used
  // ---------------------------------------
  if ( function_exists( 'get_field' ) && have_rows('pages_flex') ) :

?>

  <article id="post-<?php the_ID(); ?>" <?php post_class('content-page'); ?>>
  
    <header class="entry-header">

		  <h1 class="entry-title section-headline"> <span><?php the_title(); ?></span> </h1>

  	</header>
	
  	<div class="entry-content">

  	<?php 
    	
      while ( have_rows('pages_flex') ) : the_row();
              
        // One column Text
        if( get_row_layout() == 'flex_centered' ):    
        
      ?>
            
        <div class="centered-text-block content-block <?php if( get_sub_field('flex_centered_bg') ) { echo ' include-bg'; } ?>">
        
          <div class="content-output">
            <?php the_sub_field('flex_centered_content'); ?>
          </div>
        
        </div>
        
      <?php 
                        
        // Two column Text
        elseif( get_row_layout() == 'flex_split' ): 
  
      ?>
        
        <div class="split-text-block content-block <?php if( get_sub_field('flex_split_bg') ) { echo ' include-bg'; } ?>">
          
          <div class="split-text-left-col">
            <?php the_sub_field('flex_split_left'); ?>
          </div>
          
          <div class="split-text-right-col">
            <?php the_sub_field('flex_split_right'); ?>
          </div>
          
        </div>

  	  <?php 
    	  endif; 
    	endwhile; 
    ?>
    
  	</div>
  	
    <?php if(!is_page('17197')) : ?> <footer class="entry-footer"></footer>	<?php endif; ?>
  
  </article>

<?php 
  
  //  Else we output the editor content as usual
  // ---------------------------------------
  else :
  
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('content-page'); ?>>
	
	<header class="entry-header">

		<h1 class="entry-title section-headline"> <span><?php the_title(); ?></span> </h1>

	</header>
	
	<div class="entry-content no-acf">   

		<?php the_content(); ?>

	</div>
	
  <?php if(is_page('19549') || is_page_template( 'template-badges.php' ) ) : ?> <footer class="entry-footer"></footer>	<?php endif; ?>

</article><!-- #post-## -->

<?php endif; ?>


<?php 
  //Badges on press site
  if(is_page('19549') || is_page_template( 'template-badges.php' ) ) :   
?>

  <section class="press-badges">
    
    <?php if( have_rows('badges_repeater') ) : while ( have_rows('badges_repeater') ) : the_row(); ?>
      
      <h2 class="section-headline"> <span> <?php the_sub_field('badge_headline'); ?> </span> </h2>
      
      <ul class="badges-wrapper">
        <?php if( have_rows('badge_single') ) : while ( have_rows('badge_single') ) : the_row(); $badge = get_sub_field('badge_img'); ?>
          <li>  
            <img src="<?php echo $badge['url']; ?>" alt="<?php echo $badge['alt']; ?>">
            <pre><code><?php echo htmlspecialchars(get_sub_field('badge_code')); ?></code></pre>
          </li>      
        <?php endwhile; endif; ?>
      </ul>
    
    <?php endwhile; endif; ?>
        
  </section>

<?php endif; ?>
