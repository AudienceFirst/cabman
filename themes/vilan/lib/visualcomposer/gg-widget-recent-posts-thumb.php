<?php
class WPBakeryShortCode_gg_Widget_Recent_Posts_Thumb extends WPBakeryShortCode {

   public function __construct() {  
         add_shortcode('widget_recent_posts_thumb', array($this, 'gg_widget_Recent_Posts_Thumb'));  
   }

   public function gg_widget_Recent_Posts_Thumb( $atts, $content = null ) { 

        $output = $title = $number = $el_class = '';
		extract( shortcode_atts( array(
		    'title' => __('Recent posts with thumbnails','okthemes'),
		    'number' => 5,
		    'el_class' => ''
		), $atts ) );

         
         $output = '<div class="vc_widget vc_widget_recent_posts_thumb">';
         $type = 'gg_Recent_Posts_Widget';
         $args = array();

         ob_start();
         the_widget( $type, $atts, $args );
         $output .= ob_get_clean();

         $output .= '</div>';

         return $output;
   }
}

$WPBakeryShortCode_gg_Widget_Recent_Posts_Thumb = new WPBakeryShortCode_gg_Widget_Recent_Posts_Thumb();


vc_map( array(
   "name" => __("Widget: Recent posts with thumbnail","okthemes"),
   "description" => __('Display posts.', 'okthemes'),
   "base" => "widget_recent_posts_thumb",
   "class" => "theme_icon_class",
   "weight" => -50,
   "icon" => "icon-wpb-gg_vc_recent_post_thumb",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('OKThemes', 'okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "heading" => __("Title","okthemes"),
         "param_name" => "title",
         "admin_label" => true,
         "description" => __("Insert title here","okthemes")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Number of posts to show","okthemes"),
         "param_name" => "number",
         "admin_label" => true,
         "value" => '5',
         "description" => __("Insert the number of posts to show","okthemes")
      ),
   )
) );

?>