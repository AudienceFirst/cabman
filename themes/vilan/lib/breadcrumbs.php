<?php
if ( ! function_exists( 'gg_breadcrumbs' ) ) :
  function gg_breadcrumbs() {

      GLOBAL $post;

      $stack           = '';
      $delimiter       = '<span class="delimiter"><i class="arrow_carrot-right"></i></span>';                   // 1
      $home            = '<span class="home"><i class="icon_house_alt"></i> ' . __( 'Home', 'okthemes' ) . '</span>'; // 2
      $home_link       = home_url();                                                                            // 3
      $show_current    = 1;                                                                                     // 4
      $before          = '<span class="current">';                                                              // 5
      $after           = '</span>';                                                                             // 6
      $page_title      = get_the_title();                                                                       // 7
      $blog_title      = get_the_title( get_option( 'page_for_posts', true ) );                                 // 8
      $shop_page_title = get_theme_mod( 'gg_' . $stack . '_shop_title' );

      $text['search']   = 'Search Results for "%s" Query'; // text for a search results page
      $text['tag']      = 'Posts Tagged "%s"'; // text for a tag page
      $text['author']   = 'Articles Posted by %s'; // text for an author page
      $text['404']      = 'Error 404'; // text for the 404 page

      $link_before  = '<span typeof="v:Breadcrumb">';
      $link_after   = '</span>';
      $link_attr    = ' rel="v:url" property="v:title"';
      $link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after; 
                                             // 9
      if ( function_exists( 'woocommerce_get_page_id' ) ) {
        $shop_page_url   = get_permalink( woocommerce_get_page_id( 'shop' ) );
      }
     
      if ( is_front_page() ) {
        echo '<div class="gg-breadcrumbs">' . $before . $home . $after . '</div>';
      } elseif ( is_home() ) {
        echo '<div class="gg-breadcrumbs"><a href="' . $home_link . '">' . $home . '</a> ' . $delimiter . ' ' . $before . $blog_title . $after . '</div>';
      //Load bbPress breadcrumbs
      } elseif ( function_exists('bbp_body_class') && count( bbp_body_class( array() ) ) > 1 ) {
        remove_filter('bbp_get_breadcrumb','__return_false');
        echo '<div class="gg-breadcrumbs"><a href="' . $home_link . '">' . $home . '</a> ' . $delimiter . ' '.bbp_get_breadcrumb( ' '.$delimiter.' ' ).'</div>';
        add_filter('bbp_get_breadcrumb','__return_false');
      //Load WC breadcrumbs  
      } elseif (is_woocommerce_activated() && is_woocommerce()) {
        echo woocommerce_breadcrumb();
      } else {
        echo '<div class="gg-breadcrumbs"><a href="' . $home_link . '">' . $home . '</a> ' . $delimiter . ' ';
        if ( is_category() ) {
          $the_cat = get_category( get_query_var( 'cat' ), false );
          if ($the_cat->parent != 0) echo get_category_parents( $the_cat->parent, TRUE, ' ' . $delimiter . ' ' );
          echo $before . __( 'Posts Categorized as ', 'okthemes' ) . '&#8220;' . single_cat_title( '', false ) . '&#8221;' . $after;
        
        } elseif ( is_tax('portfolio_category') ) {

        $current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
        $ancestors = array_reverse( get_ancestors( $current_term->term_id, get_query_var( 'taxonomy' ) ) );
        foreach ( $ancestors as $ancestor ) {
            $ancestor = get_term( $ancestor, get_query_var( 'taxonomy' ) );
            echo $before .  '<a href="' . get_term_link( $ancestor->slug, get_query_var( 'taxonomy' ) ) . '">' . esc_html( $ancestor->name ) . '</a>' . $after . $delimiter;
        }
        echo $before . esc_html( $current_term->name ) . $after;    

        } elseif ( is_search() ) {
      echo $before . sprintf($text['search'], get_search_query()) . $after;
 
    } elseif ( is_day() ) {
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
      echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
      echo $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
      echo $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
          if ( get_post_type() == 'portfolio_cpt' ) {

            if ( $terms = wp_get_post_terms( $post->ID, 'portfolio_category', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ) {

                $post_type = get_post_type_object(get_post_type());
    
                $main_term = $terms[0];

                $ancestors = array_reverse( get_ancestors( $main_term->term_id, 'portfolio_category' ) );

                $ancestors = array_reverse( $ancestors );

                foreach ( $ancestors as $ancestor ) {
                    $ancestor = get_term( $ancestor, 'portfolio_category' );

                    echo $before . '<a href="' . get_term_link( $ancestor->slug, 'portfolio_category' ) . '">' . $ancestor->name . '</a>' . $after . $delimiter;
                }

                echo $before . '<a href="' . get_term_link( $main_term->slug, 'portfolio_category' ) . '">' . $main_term->name . '</a>' . $after . $delimiter;

            }
            echo $before . get_the_title() . $after;

        } elseif ( get_post_type() != 'post' ) {
          
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
        if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
        
        } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, $delimiter);
        if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
        $cats = str_replace('<a', $before . '<a', $cats);
        $cats = str_replace('</a>', '</a>' . $after, $cats);
        echo $cats;
        if ($show_current == 1) echo $before . get_the_title() . $after;
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      $cats = get_category_parents($cat, TRUE, $delimiter);
      $cats = str_replace('<a', $before . '<a', $cats);
      $cats = str_replace('</a>', '</a>' . $after, $cats);
      echo $cats;
      printf($link, get_permalink($parent), $parent->post_title);
      if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
      
        } elseif ( is_page() && ! $post->post_parent ) {
          if ( $show_current == 1 ) echo $before . $page_title . $after;
        } elseif ( is_page() && $post->post_parent ) {
          $parent_id   = $post->post_parent;
          $breadcrumbs = array();
          while ( $parent_id ) {
            $page          = get_page( $parent_id );
            $breadcrumbs[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
            $parent_id     = $page->post_parent;
          }
          $breadcrumbs = array_reverse( $breadcrumbs );
          for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
            echo $breadcrumbs[$i];
            if ( $i != count( $breadcrumbs ) -1 ) echo ' ' . $delimiter . ' ';
          }
          if ( $show_current == 1 ) echo ' ' . $delimiter . ' ' . $before . $page_title . $after;
        } elseif ( is_tag() ) {
          echo $before . __( 'Posts Tagged as ', 'okthemes') . '&#8220;' . single_tag_title( '', false ) . '&#8221;' . $after;
        } elseif ( is_author() ) {
          GLOBAL $author;
          $userdata = get_userdata( $author );
          echo $before . __( 'Posts by ', 'okthemes' ) . '&#8220;' . $userdata->display_name . $after . '&#8221;';
        } elseif ( is_404() ) {
          echo $before . __( '404 (Page Not Found)', 'okthemes' ) . $after;
        } elseif ( is_archive() ) {
          if ( is_post_type_archive( 'portfolio_cpt' ) ) {
            echo $before . get_theme_mod( 'gg_portfolio_title' ) . $after;
          //} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
            //echo $before . $shop_page_title . $after;
          } else {
            echo $before . __( 'Archives ', 'okthemes' ) . $after;
          }
        }
        if ( get_query_var( 'paged' ) ) {
          if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
          echo '<span class="current" style="white-space: nowrap;">' . __( 'Page', 'okthemes' ) . ' ' . get_query_var( 'paged' ) . '</span>';
          if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
        }
        echo '</div>';
      }

    }
endif;