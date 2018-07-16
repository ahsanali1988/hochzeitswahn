<?php
/**
 * Template Name: Tag Page
 * Description: Template zur Darstellung aller Tags
 *
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package fwbase
 */

get_header(); ?>

  <main id="main" class="site-main" role="main">
		
		<?php while ( have_posts() ) : the_post(); ?>
    
    <article <?php post_class('content-page'); ?>>
  
      <header class="entry-header">

		    <h1 class="entry-title section-headline"> <span><?php the_title(); ?></span> </h1>

      </header>

    	<div class="entry-content">

      	<ul class="unstyled tag-list-nav">
	      	<li><a href="#tag-nav-a">A</a></li>
	      	<li><a href="#tag-nav-b">B</a></li>
	      	<li><a href="#tag-nav-c">C</a></li>
	      	<li><a href="#tag-nav-d">D</a></li>
	      	<li><a href="#tag-nav-e">E</a></li>
	      	<li><a href="#tag-nav-f">F</a></li>
	      	<li><a href="#tag-nav-g">G</a></li>
	      	<li><a href="#tag-nav-h">H</a></li>
	      	<li><a href="#tag-nav-i">I</a></li>
	      	<li><a href="#tag-nav-j">J</a></li>
	      	<li><a href="#tag-nav-k">K</a></li>
	      	<li><a href="#tag-nav-l">L</a></li>
	      	<li><a href="#tag-nav-m">M</a></li>
	      	<li><a href="#tag-nav-n">N</a></li>
	      	<li><a href="#tag-nav-o">O</a></li>
	      	<li><a href="#tag-nav-p">P</a></li>
	      	<li><a href="#tag-nav-q">Q</a></li>
	      	<li><a href="#tag-nav-r">R</a></li>
	      	<li><a href="#tag-nav-s">S</a></li>
	      	<li><a href="#tag-nav-t">T</a></li>
	      	<li><a href="#tag-nav-u">U</a></li>
	      	<li><a href="#tag-nav-v">V</a></li>
	      	<li><a href="#tag-nav-w">W</a></li>
	      	<li><a href="#tag-nav-x">X</a></li>
	      	<li><a href="#tag-nav-y">Y</a></li>
	      	<li><a href="#tag-nav-z">Z</a></li>
	      	<li><a href="#tag-nav-1">1</a></li>
	      	<li><a href="#tag-nav-2">2</a></li>
	      	<li><a href="#tag-nav-3">3</a></li>
	      	<li><a href="#tag-nav-4">4</a></li>
	      	<li><a href="#tag-nav-5">5</a></li>
	      	<li><a href="#tag-nav-6">6</a></li>
	      	<li><a href="#tag-nav-7">7</a></li>
	      	<li><a href="#tag-nav-8">8</a></li>
	      	<li><a href="#tag-nav-9">9</a></li>
	      	<li><a href="#tag-nav-0">0</a></li>
	      	<li><a href="#tag-nav-#">#</a></li>
	      </ul>

        <?php
          $args = array(
            'orderby'      => 'name', 
            'order'        => 'ASC',
            'hierarchical' => false,
          );
        
          $all_tags = get_tags($args);
          $tag_letter_pre = '';                            

          echo '<ul class="unstyled tag-list">';

            foreach ( $all_tags as $tag ) {              
              $tag_letter     = substr($tag->slug, 0, 1);
              $tag_link       = get_tag_link( $tag->term_id );               
              
              if( $tag_letter == $tag_letter_pre ) {           
                echo '<li class="tag"> <a href="'.$tag_link.'" title="'.$tag->name.'">'.$tag->name.'</a> </li>';
              } else {
                echo '<li class="tag" id="tag-nav-'.$tag_letter.'"> <a href="'.$tag_link.'" title="'.$tag->name.'">'.$tag->name.'</a> </li>';
                $tag_letter_pre = $tag_letter;
              }
            }
          echo '</ul>';  
        ?>
                
    	</div>
      
    </article>

		<?php endwhile; // end of the loop. ?>

  </main>

<?php get_footer(); ?>