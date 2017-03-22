<?php
class WPBakeryShortCode_gg_posts_grid extends WPBakeryShortCode {

   public function __construct() {  
         add_shortcode('posts_grid', array($this, 'gg_posts_grid'));  
   }

   public function gg_posts_grid( $atts, $content = null ) { 

         $output = $link_html = $image = $el_class = $isotope_item = $is_carousel = $carousel_data = $is_unlimited = '';
         extract(shortcode_atts(array(
            'posts_grid_col_select'        => '',
            'posts_grid_no_posts'  => '',
            'posts_grid_terms' => '',
            'posts_in' => '',
            'posts_not_in' => '',
            'orderby' => '',
            'order' => '',
            'grid_layout_mode'     => 'fitRows',
            'grid_layout_style'     => 'gap',
            'el_class'     => '',
            'css_animation' => '',
            'category_filter' => '',
            'slides_per_view' => '1',
            'transition_style' => 'fade',
            'wrap' => '',
            'autoplay' => '',
            'hide_pagination_control' => '',
            'hide_prev_next_buttons' => '',
            'speed' => '200',
            'css_animation'         => '',
         ), $atts));

         //Enqueue magnific
         wp_enqueue_script( 'magnific' );
         wp_enqueue_style( 'magnific' );

         //Defaults
         global $gg_is_vc;
         $convert_ul = 'ul';
         $convert_li = 'li';
         

         //Apply columns class based on column selection 
         switch ($posts_grid_col_select) {
            case "3":
               $posts_grid_col_class = 'col-xs-12 col-sm-6 col-md-4';
            break;
            case "2":
               $posts_grid_col_class = 'col-xs-12 col-sm-6 col-md-6';
            break;
         }

         //Add 30px to the images for nogap mode 
         if ($grid_layout_style == 'nogap') {
          $is_unlimited = 'nogap-cols';
         }

         if ( $grid_layout_mode == 'fitRows' || $grid_layout_mode == 'masonry') {
            //Enqueue isotope
            wp_enqueue_style('theme-isotope');
            wp_enqueue_script( 'theme-isotope' );
            $isotope_item = 'isotope-item ';
         } else if ( $grid_layout_mode == 'carousel' ) {
            //Enqueue owl carousel
            wp_enqueue_script( 'owlcarousel' );
            wp_enqueue_style( 'owlcarouselbase' );
            wp_enqueue_style( 'owlcarouseltheme' );
            wp_enqueue_style( 'owlcarouseltransitions' );

            $isotope_item = '';
            $is_carousel = 'owl-carousel';
            $convert_ul = 'div';
            $convert_li = 'div';
            $posts_grid_col_class ='';
            $carousel_data .= "\n\t".' data-slides-per-view = "'.$slides_per_view.'"';
            $carousel_data .= "\n\t".' data-transition-slide = "'.$transition_style.'"';
            $carousel_data .= "\n\t".' data-navigation-owl = "false"';
            $carousel_data .= "\n\t".' data-pagination-owl = "'.($hide_pagination_control !== 'yes' ? 'true' : 'false').'"';
            $carousel_data .= "\n\t".' data-autoplay = "'.($autoplay === 'yes' ? '3000' : 'false').'"';
            $carousel_data .= "\n\t".' data-rewind = "'.($wrap === 'yes' ? 'true' : 'false').'"';
            $carousel_data .= "\n\t".' data-speed = "'.$speed.'"';
            $carousel_data .= "\n\t".' data-height = "false"';
         }

         //Animation
         $css_class = $this->getCSSAnimation($css_animation);

         //Start the insanity
         $output .= "\n\t".'<div class="'.$css_class.'">';
         $output .= "\n\t".'<div class="gg_posts_grid">';

         //Grid filter
         if (($category_filter == 'use_category_filter') && ($grid_layout_mode != 'carousel')) {
               
            $output .= "\n\t\t\t\t".'<ul class="categories_filter clearfix nav nav-pills">';
            $output .= "\n\t\t\t\t\t".'<li class="active"><a href="#" data-filter="*">'.__("All", "js_composer").'</a></li>';

            $terms = get_terms('category');
            foreach ( $terms as $term ) {
            $output .= "\n\t\t\t\t\t".'<li><a data-filter=".grid-cat-'.$term->slug.'">' . $term->name . ' </a></li>';
            }

            $output .= "\n\t\t\t\t".'</ul>';
         }

         // WP_Query arguments
         $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
         $args = array (
            'taxonomy'               => 'category',
            'posts_per_page'         => $posts_grid_no_posts,
            'orderby'                => $orderby,
            'order'                  => $order,
            'ignore_sticky_posts'    => true,
            'paged' => $paged
         );

         //If posts_grid terms are selected and carousel is not active - use terms
         if (($posts_grid_terms != '') && ($category_filter != 'use_category_filter')) {
            $args['category'] = $posts_grid_terms;
         }

         $not_in = array();
         if ( $posts_not_in != '' ) {
            $posts_not_in = str_ireplace(" ", "", $posts_not_in);
            $not_in = explode(",", $posts_not_in);
         }

         //exclude current post from query
         if ( $posts_in == '' ) {
            global $post;
            array_push($not_in, $post->ID);
         }
         else if ( $posts_in != '' ) {
            $posts_in = str_ireplace(" ", "", $posts_in);
            $args['post__in'] = explode(",", $posts_in);
         }
         if ( $posts_in == '' || $posts_not_in != '' ) {
            $args['post__not_in'] = $not_in;
         }

         // The Query
         $posts_grid_query = new WP_Query( $args );

         // The Loop
         if ( $posts_grid_query->have_posts() ) {

         $output .= "\n\t".'<'.$convert_ul.' '.$carousel_data.' class="image-grid '.$is_carousel.' '.$is_unlimited.'" data-layout-mode="'.$grid_layout_mode.'">';

         while ( $posts_grid_query->have_posts() ) : $posts_grid_query->the_post();

         //Retrieve variables from the metabox
         global $post; 

         $output .= "\n\t".'<'.$convert_li.' class=" '.$isotope_item.' '.$posts_grid_col_class.' '.gg_tax_terms_slug('category').' ">';
         
          ob_start();  
          get_template_part( 'parts/part', get_post_format() );
          $output .= "\n\t".ob_get_contents();  
          ob_end_clean();  

         $output .= "\n\t".'</'.$convert_li.'>';

         endwhile;
         
         $output .= "\n\t".'</'.$convert_ul.'>';

         if (function_exists("pagination")) {
         ob_start(); 
         pagination($posts_grid_query->max_num_pages);
         $output .= "\n\t".ob_get_contents(); 
         ob_end_clean();
        }

         } else {
         
         $output .= "\n\t".'<p>No posts found</p>';
         
         }

         wp_reset_postdata();

         
         $output .= "\n\t".'</div>';
         $output .= "\n\t".'</div>';

         return $output;
   }
}

$WPBakeryShortCode_gg_posts_grid = new WPBakeryShortCode_gg_posts_grid();


vc_map( array(
   "name" => __("Posts grid","okthemes"),
   "description" => __('Display grid posts.','okthemes'),
   "base" => "posts_grid",
   "class" => "theme_icon_class",
   "icon" => "icon-wpb-gg_vc_posts_grid",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('OKThemes','okthemes'),
   "params" => array(
      array(
         "type" => "dropdown",
         "heading" => __("Layout mode", "js_composer"),
         "param_name" => "grid_layout_mode",
         "value" => array(__("Grid Fit rows", "js_composer") => "fitRows", __('Grid Masonry', "js_composer") => 'masonry', __('Carousel', "js_composer") => 'carousel'),
         "description" => __("Layout template.", "js_composer")
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Layout style", "js_composer"),
         "param_name" => "grid_layout_style",
         "value" => array(__("Gap", "js_composer") => "gap", __('No gap', "js_composer") => 'nogap'),
         "description" => __("Layout style.", "js_composer"),
         "dependency" => Array('element' => 'grid_layout_mode', 'value' => array('fitRows','masonry'))
      ),
      //Carousel options
      array(
          "type" => "dropdown",
          "heading" => __("Slides per view", "okthemes"),
          "param_name" => "slides_per_view",
          "value" => array(2, 3),
          "description" => __("Set numbers of slides you want to display at the same time on slider's container for carousel mode.", "okthemes"),
          "dependency" => Array('element' => 'grid_layout_mode', 'value' => array('carousel'))
      ),
      array(
          "type" => 'checkbox',
          "heading" => __("Hide pagination control", "okthemes"),
          "param_name" => "hide_pagination_control",
          "description" => __("If YES pagination control will be removed .", "okthemes"),
          "value" => Array(__("Yes, please", "okthemes") => 'yes'),
          "dependency" => Array('element' => 'grid_layout_mode', 'value' => array('carousel'))
      ),
      array(
          "type" => 'checkbox',
          "heading" => __("Autoplay", "okthemes"),
          "param_name" => "autoplay",
          "description" => __("Enables autoplay mode.", "okthemes"),
          "value" => Array(__("Yes, please", "okthemes") => 'yes'),
          "dependency" => Array('element' => 'grid_layout_mode', 'value' => array('carousel'))
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Columns count", "js_composer"),
         "param_name" => "posts_grid_col_select",
         "value" => array(2, 3),
         "admin_label" => true,
         "description" => __("Select columns count.", "js_composer"),
         "dependency" => Array('element' => 'grid_layout_mode', 'value' => array('fitRows','masonry'))
      ),
      array(
         "type" => "textfield",
         "heading" => __("Number of posts","okthemes"),
         "param_name" => "posts_grid_no_posts",
         "value" => '9',
         "description" => __("Insert the number of posts to display. Default: 9","okthemes")
      ),
      array(
           "type" => "checkbox",
           "heading" => __("Display category filter?","okthemes"),
           "value" => array(__("Display category filter","okthemes") => "use_category_filter" ),
           "param_name" => "category_filter",
           "dependency" => Array('element' => 'grid_layout_mode', 'value' => array('fitRows','masonry'))
      ),
      array(
         "type" => "gg_taxonomy",
         "taxonomy" => "category",
         "heading" => __("Posts grid terms", "js_composer"),
         "param_name" => "posts_grid_terms",
         "description" => __("Select posts_grid terms to display. By default it displays posts from all terms.", "js_composer"),
         "dependency" => Array('element' => "category_filter", 'is_empty' => true)
      ),
      array(
         "type" => "textfield",
         "heading" => __("Post IDs", "js_composer"),
         "param_name" => "posts_in",
         "description" => __('Fill this field with posts IDs separated by commas (,) to retrieve only them.', "js_composer")
      ),
       array(
         "type" => "textfield",
         "heading" => __("Exclude Post IDs", "js_composer"),
         "param_name" => "posts_not_in",
         "description" => __('Fill this field with posts IDs separated by commas (,) to exclude them from query.', "js_composer")
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Order by", "okthemes"),
         "param_name" => "orderby",
         "value" => array(
            "Date" => "date",
            "Author" => "author",
            "Title" => "title",
            "Slug" => "name",
            "Date modified" => "modified",
            "ID" => "id"
         ),
         "description" => __("Select how to sort retrieved posts.", "okthemes")
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Order way", "okthemes"),
         "param_name" => "order",
         "value" => array(
            "Descending" => "desc",
            "Ascending" => "asc"
         ),
         "description" => __("Designates the ascending or descending order.", "okthemes")
      ),
      $add_css_animation
   )
) );

?>