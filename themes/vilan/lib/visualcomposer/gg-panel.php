<?php
class WPBakeryShortCode_gg_panel extends WPBakeryShortCode {

   public function __construct() {  
         add_shortcode('panel', array($this, 'gg_panel'));  
   }

   public function gg_panel( $atts, $content = null ) { 

         $output = $header_style = $title = $subtitle = '';
         extract(shortcode_atts(array(
             'title'            => '',
             'panel_background' => '',
             'panel_text_color' => ''
         ), $atts));

         if ($panel_background != '') {
          $panel_background = ' background-color:'.$panel_background.';';
         }

         if ($panel_text_color != '') {
          $panel_text_color = ' color:'.$panel_text_color.';';
         }

         $header_style = 'style="'.$panel_background.$panel_text_color.'"';
         
         $output  = "\n\t".'<div class="panel">';
         $output .= "\n\t\t".'<div class="panel-heading" '.$header_style.'>'.$title.'</div>';
         $output .= "\n\t\t".'<div class="panel-body">'.wpb_js_remove_wpautop($content, true).'</div>';
         $output .= "\n\t".'</div> ';

         return $output;
         
   }
}

$WPBakeryShortCode_gg_panel = new WPBakeryShortCode_gg_panel();  

vc_map( array(
   "name" => __("Panel","okthemes"),
   "description" => __('A panel component with heading and body.', 'okthemes'),
   "base" => "panel",
   "class" => "theme_icon_class",
   "icon" => "icon-wpb-gg_vc_panel",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('OKThemes', 'okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "heading" => __("Title","okthemes"),
         "param_name" => "title",
         "admin_label" => true,
         "description" => __("Insert the title here","okthemes")
      ),
      array(
        "type" => "textarea_html",
        "holder" => "div",
        "heading" => __("Text", "okthemes"),
        "param_name" => "content",
        "value" => __("<p>I am text block. Click edit button to change this text.</p>", "okthemes")
      ),
      array(
         "type" => "colorpicker",
         "heading" => __('Panel header background color', 'okthemes'),
         "param_name" => "panel_background",
         "description" => __("Select the header background color", "okthemes")
      ),
      array(
         "type" => "colorpicker",
         "heading" => __('Panel header text color', 'okthemes'),
         "param_name" => "panel_text_color",
         "description" => __("Select the header text color", "okthemes")
      ),

      $add_css_animation,

   )
) );

?>