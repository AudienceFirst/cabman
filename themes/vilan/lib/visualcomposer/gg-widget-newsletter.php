<?php
class WPBakeryShortCode_gg_Widget_Newsletter extends WPBakeryShortCode {

   public function __construct() {  
         add_shortcode('widget_newsletter', array($this, 'gg_widget_newsletter'));  
   }

   public function gg_widget_newsletter( $atts, $content = null ) { 

         $output = $title = $text = '';
         extract(shortcode_atts(array(
             'title'        => '',
             'text'         => ''
         ), $atts));

         $text =  rawurldecode(base64_decode(strip_tags($text)));
         $atts['text'] = $text;
         
         $output = '<div class="vc_widget vc_widget_newsletter">';
         $type = 'gg_Newsletter_Widget';
         $args = array();

         ob_start();
         the_widget( $type, $atts, $args );
         $output .= ob_get_clean();

         $output .= '</div>';

         return $output;
   }
}

$WPBakeryShortCode_gg_Widget_Newsletter = new WPBakeryShortCode_gg_Widget_Newsletter();


vc_map( array(
   "name" => __("Widget: Newsletter","okthemes"),
   "description" => __('Display a styled newsletter by MailChimp', 'okthemes'),
   "base" => "widget_newsletter",
   "class" => "theme_icon_class",
   "weight" => -50,
   "icon" => "icon-wpb-gg_vc_newsletter",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('OKThemes', 'okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "heading" => __("Title","okthemes"),
         "param_name" => "title",
         "description" => __("Insert title here","okthemes")
      ),
      array(
         "type" => "textarea_raw_html",
         "heading" => __("HTML form","okthemes"),
         "param_name" => "text",
         "description" => __("Insert the generated MailChimp form here","okthemes")
      )
   )
) );

?>