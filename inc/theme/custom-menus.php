<?php
  
// -----------------------------------------------------
//
// Custom Menu Items
//
// -----------------------------------------------------


// Category Posts in Menu
// -----------------------------------------------------
class FWMegaMenu extends Walker_Nav_Menu
{
  
  function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"sub-menu\">\n";
  } 
  
  function end_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent</ul>\n";
  }

  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    global $wp_query;
    
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    
    $classes[] = 'menu-item-' . $item->ID;

    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
    $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<li' . $id . $class_names .'>';

    $atts = array();
    $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
    $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
    $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
    $atts['href']   = ! empty( $item->url )        ? $item->url        : '';     
         
    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

    $attributes = '';
    foreach ( $atts as $attr => $value ) {
      if ( ! empty( $value ) ) {
        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
        $attributes .= ' ' . $attr . '="' . $value . '"';
      }
    }

    $item_output = '';

    // Recent posts in Menu
    if ( strpos($class_names,'recent-posts') !== false ) { 

      $query_ID = $item->description;
      
      if( $query_ID == 'hw_lookbook' ) {
        $recent_args = array(
          'post_type'      => $query_ID,
          'posts_per_page' => 3,
          'orderby'        => 'rand',
          'order'          => 'DESC'
        );
      } else {
        $recent_args = array(
          'cat'            => $query_ID,
          'posts_per_page' => 3,
          'orderby'        => 'date',
          'order'          => 'DESC'
        );
      }
          
      $recent_query = new WP_Query( $recent_args );
      
      if ( $recent_query->have_posts() ) : 
                
        $item_output = $args->before;
        $item_output .= '<div class="featured-post-menu-wrapper">';
        
        while ( $recent_query->have_posts() ) : $recent_query->the_post();
          
          global $post;
                  
          $post_thumbnail_id = get_post_thumbnail_id( $post->ID );     
          $the_thumbnail     = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' );
          $the_title         = ( strlen(get_the_title()) > 65 ? substr(the_title($before = '', $after = '', FALSE), 0, 65) . '...' : get_the_title() );
          
          $item_output .= '<div class="featured-post-menu-content">';
          $item_output .=   '<a href="' . get_permalink() . '" title="' . get_the_title() . '">';
          $item_output .=     '<img src="' . $the_thumbnail[0] . '" alt="' . get_the_title() . '">';
          $item_output .=     '<div class="features-post-menu-title"> <span>' . $the_title . '</span> </div>';
          $item_output .=   '</a>';          
          $item_output .= '</div>';
                       
        endwhile;
      
        wp_reset_postdata();
        
        $item_output .= '</div>';
        $item_output .= $args->after;

      endif;          
    
    // View all with selected categories
    } elseif ( strpos($class_names,'view-all') !== false ) { 
      
      $item_output = $args->before;
      $item_output .= '<a href="'.get_bloginfo('url').'/'.$item->description.'" class="view-all-link">';
      // $item_output .= ($item->description == 'lookbook') ? '<a href="'.get_bloginfo('url').'/'.$item->description.'" class="view-all-link">' : '<a href="'.get_bloginfo('url').'/?cat='.$item->description.'" class="view-all-link">';
      $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
      $item_output .= '</a>';
      $item_output .= $args->after;    
    
    // normal output
    } else {
      
      $item_output = $args->before;
      $item_output .= '<a'. $attributes .'>';
      $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
      $item_output .= '</a>';
      $item_output .= $args->after;
      
    }

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    
  }
}

?>