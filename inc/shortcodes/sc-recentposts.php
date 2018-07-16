<?php

// recent posts
function sc_recent_posts( $atts ) {
    extract( shortcode_atts( array(
      'title' => 'Recent Posts',
      'numbers' => '5',
    ), $atts ) );
    
    $rposts = new WP_Query( array( 'posts_per_page' => $numbers, 'orderby' => 'date' ) );
    
    if ( $rposts->have_posts() ) {
        $html = '<h3>'.$title.'</h3><ul class="recent-posts">';
        while( $rposts->have_posts() ) {
            $rposts->the_post();
            $html .= sprintf(
                '<li><a href="%s" title="%s">%s</a></li>',
                get_permalink($rposts->post->ID),
                get_the_title(),
                get_the_title()
            );
        }
        $html .= '</ul>';
    }
    wp_reset_query();
    return $html;
}
add_shortcode( 'recent-posts', 'sc_recent_posts' );

?>
