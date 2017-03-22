<div class="logo-wrapper">
<?php 
    // Displays H1 or DIV based on whether we are on the home page or not (SEO)
    $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div';
    
    if ( 1 == get_theme_mod( 'logo_check') ) {    
        $class="graphic";
        $logo_url = get_theme_mod('main_logo');
        $logo_width = get_theme_mod('logo_width');
        $logo_height = get_theme_mod('logo_height');
        echo '<a class="brand" href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo('name','display')).'" rel="home">'. "\n";
        echo '<img style="margin-top: '.get_theme_mod('logo_margin_top').'px; " class="brand" src="'.$logo_url.'" width="'.$logo_width.'" height="'.$logo_height.'" alt="'.esc_attr( get_bloginfo('name','display')).'" />'. "\n";
        echo '</a>'. "\n";
    } else {
        $class="text"; 
        echo '<'.$heading_tag.' id="site-title" class="'.$class.'">';
        echo '<a class="brand" href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo('name','display')).'" rel="home">'.get_bloginfo('name').'</a>';
        if ( 1 == get_theme_mod( 'tagline_check', 1) ) {
            echo '<small class="visible-desktop visible-tablet '.$class.'">'.get_bloginfo('description').'</small>'. "\n";
        }
        echo '</'.$heading_tag.'>'. "\n";     
    } 
        
    
?>
</div>