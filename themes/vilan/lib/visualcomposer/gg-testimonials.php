<?php
class WPBakeryShortCode_gg_testimonials extends WPBakeryShortCode {

   public function __construct() {  
         add_shortcode('testimonials_module', array($this, 'gg_testimonials'));  
   }

   public function gg_testimonials( $atts, $content = null ) { 

         $output = $el_class = $isotope_item = $is_carousel = $carousel_data = $is_unlimited = '';
         extract(shortcode_atts(array(
            'testimonials_col_select'        => 'three_columns',
            'testimonials_no_posts'          => '',
            'posts_in'                       => '',
            'posts_not_in'                   => '',
            'orderby'                        => '',
            'order' => '',
            'grid_layout_mode'     => 'fitRows',
            'grid_layout_style'     => 'gap',
            'el_class'     => '',
            'css_animation' => '',
            'slides_per_view' => '1',
            'transition_style' => 'fade',
            'wrap' => '',
            'autoplay' => '',
            'hide_pagination_control' => '',
            'hide_prev_next_buttons' => '',
            'speed' => '200',
            'css_animation'         => '',
         ), $atts));

         global $post, $testimonials_img_width, $testimonials_img_height;

         //Enqueue magnific
         wp_enqueue_script( 'magnific' );
         wp_enqueue_style( 'magnific' );

         //Defaults
         $convert_ul = 'ul';
         $convert_li = 'li';


         //Apply columns class based on column selection 
         switch ($testimonials_col_select) {
             case "one_column":
                $testimonials_col_class = 'col-xs-12 col-md-12';
                $carousel_column= '1';
                break;
            case "two_columns":
                $testimonials_col_class = 'col-xs-6 col-md-6';
                $carousel_column= '2';
                break;
            case "three_columns":
                $testimonials_col_class = 'col-xs-6 col-md-4';
                $carousel_column= '3';
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

            //Enqueue OWL carousel
            wp_enqueue_script( 'owlcarousel' );
            wp_enqueue_style( 'owlcarouselbase' );
            wp_enqueue_style( 'owlcarouseltheme' );
            wp_enqueue_style( 'owlcarouseltransitions' );

            $isotope_item = '';
            $is_carousel = 'owl-carousel';
            $convert_ul = 'div';
            $convert_li = 'div';
            $testimonials_col_class ='item';
            $carousel_data .= "\n\t".' data-slides-per-view = "'.$carousel_column.'"';
            $carousel_data .= "\n\t".' data-transition-slide = "'.$transition_style.'"';
            $carousel_data .= "\n\t".' data-navigation-owl = "false"';
            $carousel_data .= "\n\t".' data-pagination-owl = "'.($hide_pagination_control !== 'yes' ? 'true' : 'false').'"';
            $carousel_data .= "\n\t".' data-autoplay = "'.($autoplay === 'yes' ? '3000' : 'false').'"';
            $carousel_data .= "\n\t".' data-rewind = "'.($wrap === 'yes' ? 'true' : 'false').'"';
            $carousel_data .= "\n\t".' data-speed = "'.$speed.'"';
         }

         //Animation
         $css_class = $this->getCSSAnimation($css_animation);

         //Start the insanity
         $output .= "\n\t".'<div class="gg_posts_grid '.$css_class.'">';

         // WP_Query arguments
         $args = array (
            'post_type'              => 'testimonials_cpt',
            'posts_per_page'         => $testimonials_no_posts,
            'orderby'                => $orderby,
            'order'                  => $order,
            'ignore_sticky_posts'    => true,
         );

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
         $testimonials_query = new WP_Query( $args );

         // The Loop
         if ( $testimonials_query->have_posts() ) {

         $output .= "\n\t".'<'.$convert_ul.' '.$carousel_data.' class="testimonials-grid row image-grid '.$is_carousel.' '.$is_unlimited.'" data-layout-mode="'.$grid_layout_mode.'" data-gap="'.$grid_layout_style.'">';

         while ( $testimonials_query->have_posts() ) : $testimonials_query->the_post();

         $output .= "\n\t".'<'.$convert_li.' class=" '.$isotope_item.' '.$testimonials_col_class.' ">';
          
         ob_start();  
         get_template_part( 'parts/part', 'testimonials' );
         $output .= "\n\t".ob_get_contents();  
         ob_end_clean(); 

         $output .= "\n\t".'</'.$convert_li.'>';

         endwhile;
         
         $output .= "\n\t".'</'.$convert_ul.'>';

         } else {
         
         $output .= "\n\t".'<p>No posts found</p>';
         
         }

         // Restore original Post Data    
         wp_reset_postdata();
         
         $output .= "\n\t".'</div>';

         return $output;
   }

}

$WPBakeryShortCode_gg_testimonials = new WPBakeryShortCode_gg_testimonials();  

vc_map( array(
   "name" => __("Testimonials","okthemes"),
   "description" => __('Display testimonials', 'okthemes'),
   "base" => "testimonials_module",
   "class" => "theme_icon_class",
   "icon" => "icon-wpb-gg_vc_testimonials_module",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   'admin_enqueue_js' => array(get_template_directory_uri().'/lib/visualcomposer/custom-vc.js'),
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
      array(
         "type" => "dropdown",
         "heading" => __("Number of columns", "okthemes"),
         "param_name" => "testimonials_col_select",
         "value" => $testimonials_col_select_array,
         "admin_label" => true,
         "description" => __("Select the number of columns to display", "okthemes")
      ),
      //Carousel options
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
         "type" => "textfield",
         "heading" => __("Number of posts","okthemes"),
         "param_name" => "testimonials_no_posts",
         "value" => '9',
         "description" => __("Insert the number of posts to display. Default: 9","okthemes")
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
   ),
) );

?>