<?php
class WPBakeryShortCode_gg_portfolio extends WPBakeryShortCode {

   public function __construct() {  
         add_shortcode('portfolio', array($this, 'gg_portfolio'));  
   }

   public function gg_portfolio( $atts, $content = null ) { 

         $output = $link_html_start = $image = $el_class = $isotope_item = $is_carousel = $carousel_data = $is_unlimited = '';
         extract(shortcode_atts(array(
            'portfolio_col_select'        => 'three_columns',
            'portfolio_no_posts'  => '',
            'portfolio_terms' => '',
            'posts_in' => '',
            'posts_not_in' => '',
            'category_not_in' => '',
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
            'image_resize' => '',
            'css_animation'         => '',
         ), $atts));

         global $post, $portfolio_img_width, $portfolio_img_height, $disable_image_resize;

         //Enqueue magnific
         wp_enqueue_script( 'magnific' );
         wp_enqueue_style( 'magnific' );

         //Defaults
         $convert_ul = 'ul';
         $convert_li = 'li';
         $disable_image_resize = $image_resize;


         //Apply columns class based on column selection 
         switch ($portfolio_col_select) {
             case "four_columns":
                $portfolio_col_class = 'col-xs-6 col-sm-6 col-md-3';
                $portfolio_img_width = '263';
                $portfolio_img_height= '293';
                $carousel_column= '4';
                break;
            case "three_columns":
                $portfolio_col_class = 'col-xs-6 col-sm-4 col-md-4';
                $portfolio_img_width = '360';
                $portfolio_img_height= '390';
                $carousel_column= '3';
                break;
            case "two_columns":
                $portfolio_col_class = 'col-xs-6 col-sm-6 col-md-6';
                $portfolio_img_width = '555';
                $portfolio_img_height= '585';
                $carousel_column= '2';
                break;        
         }

         //Add 30px to the images for nogap mode 
         if ($grid_layout_style == 'nogap') {
          $is_unlimited = 'nogap-cols';
          $portfolio_img_width = $portfolio_img_width + 30;
         }

         //If masonry do not calculate height on images 
         if ($grid_layout_mode == 'masonry') {
          $portfolio_img_height = false;
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
            $portfolio_col_class ='';
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

         //Grid filter
         if (($category_filter == 'use_category_filter') && ($grid_layout_mode != 'carousel')) {
               
            $output .= "\n\t\t\t\t".'<ul class="categories_filter clearfix nav nav-pills">';
            $output .= "\n\t\t\t\t\t".'<li class="active"><a href="#" data-filter="*">'.__("All", "js_composer").'</a></li>';

            $cat_not_in = array();
            if ( $category_not_in != '' ) {
                $category_not_in = str_ireplace(" ", "", $category_not_in);
                $cat_not_in = explode(",", $category_not_in);
                $cat_args['exclude'] = $cat_not_in;
            }

            $terms = get_terms('portfolio_category', $cat_args);

            foreach ( $terms as $term ) {
            $output .= "\n\t\t\t\t\t".'<li><a data-filter=".grid-cat-'.$term->slug.'">' . $term->name . ' </a></li>';
            }

            $output .= "\n\t\t\t\t".'</ul>';
         }

         // WP_Query arguments
         $args = array (
            'post_type'              => 'portfolio_cpt',
            'taxonomy'               => 'portfolio_category',
            'posts_per_page'         => $portfolio_no_posts,
            'orderby'                => $orderby,
            'order'                  => $order,
            'ignore_sticky_posts'    => true,
         );

         //If portfolio terms are selected and carousel is not active - use terms
         if (($portfolio_terms != '') && ($category_filter != 'use_category_filter')) {
            $args['portfolio_category'] = $portfolio_terms;
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

         if ( $category_not_in != '' ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy'  => 'portfolio_category',
                    'terms'     => $cat_not_in,
                    'field'     => 'ID',
                    'operator'  => 'NOT IN',
                ),
            );
         }

         // The Query
         $portfolio_query = new WP_Query( $args );

         // The Loop
         if ( $portfolio_query->have_posts() ) {

         $output .= "\n\t".'<'.$convert_ul.' '.$carousel_data.' class="image-grid '.$is_carousel.' '.$is_unlimited.'" data-layout-mode="'.$grid_layout_mode.'" data-gap="'.$grid_layout_style.'">';

         while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post();

         $output .= "\n\t".'<'.$convert_li.' class=" '.$isotope_item.' '.$portfolio_col_class.' '.gg_tax_terms_slug('portfolio_category').' ">';
          
         ob_start();  
         get_template_part( 'parts/part', 'portfolio' );
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

$WPBakeryShortCode_gg_portfolio = new WPBakeryShortCode_gg_portfolio();


vc_map( array(
   "name" => __("Portfolio","okthemes"),
   "description" => __('Display portfolio posts.','okthemes'),
   "base" => "portfolio",
   "class" => "theme_icon_class",
   "icon" => "icon-wpb-gg_vc_portfolio",
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
      array(
         "type" => "dropdown",
         "heading" => __("Number of columns", "okthemes"),
         "param_name" => "portfolio_col_select",
         "value" => $portfolio_col_select_array,
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
         "param_name" => "portfolio_no_posts",
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
      //Image options
      array(
          "type" => 'checkbox',
          "heading" => __("Disable image resize", "okthemes"),
          "param_name" => "image_resize",
          "description" => __("If checked the portfolio images will not be resized, instead will be displayed at fullwidth. Usefull if you use full width section and you dont know the size of the viewport.", "okthemes"),
          "value" => Array(__("Yes, please", "okthemes") => 'yes')
      ),
      array(
         "type" => "gg_taxonomy",
         "taxonomy" => "portfolio_category",
         "heading" => __("Portfolio terms", "js_composer"),
         "param_name" => "portfolio_terms",
         "description" => __("Select portfolio terms to display. By default it displays posts from all terms.", "js_composer"),
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
         "type" => "textfield",
         "heading" => __("Exclude Category IDs", "js_composer"),
         "param_name" => "category_not_in",
         "description" => __('Fill this field with categories IDs separated by commas (,) to exclude them from query.', "js_composer")
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