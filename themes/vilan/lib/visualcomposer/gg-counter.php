<?php
class WPBakeryShortCode_gg_counter extends WPBakeryShortCode {

   public function __construct() {  
         add_shortcode('counter', array($this, 'gg_counter'));  
   }


   public function gg_counter( $atts, $content = null ) { 

         $output = $title = $subtitle = $is_box = $background_style = $padding_style = '';
         extract(shortcode_atts(array(
             'title'            => '',
             'subtitle'         => '',
             'align'            => 'left',
             'number'           => '',
             'font_size'        => '30',
             'font_color'       => '',
             'css_animation'    => '',
             'interval'         => '100',
             'speed'            => '1500',
             'icon'             => '',
             'add_icon'         => '',
             'add_box'          => '',
             'add_box'          => '',
             'title_color'      => '',
             'subtitle_color'   => '',
             'icon_color'       => '',
             'box_background'   => '',
             'padding'          => ''
         ), $atts));

         wp_enqueue_script('waypoints');
         wp_enqueue_script('countto');

        if($css_animation != ""){
          $clsss_css_animation =  " wpb_animate_when_almost_visible wpb_start_animation wpb_" . $css_animation;
        } else {
          $clsss_css_animation =  "";
        }

        $style = '';
        
        if ($font_size != '') {
          $style .= ' font-size:'.$font_size.'px;';
        }

        if ($font_color != '') {
          $style .= ' color:'.$font_color.';';
        }

        if ($title != '') {
          if ($title_color != "") {
            $title_color = 'style="color:'.$title_color.'"';  
          }
          $title = '<p '.$title_color.'>'.$title.'</p>';
        }

        if ($subtitle != '') {
          if ($subtitle_color != "") {
            $subtitle_color = 'style="color:'.$subtitle_color.'"';  
          }
          $subtitle = '<em '.$subtitle_color.'>'.$subtitle.'</em>';
        }

        if ($add_icon == 'use_icon') {
          if ($icon_color != "") {
            $icon_color = 'style="color:'.$icon_color.'"';  
          }
          $icon = '<i '.$icon_color.' class="'.$icon.' pull-'.$align.'"></i>';
        } else {
          $icon = '';
        }

        if ($add_box == 'use_box') {
          
          $is_box = 'is_box';

          if( $padding != '' ) {
            $padding_style = ' padding: '.(preg_match('/(px|em|\%|pt|cm)$/', $padding) ? $padding : $padding.'px').';';
          }

          if( $box_background != '' ) {
            $background_style = 'background:'.$box_background.';';
          }
        }
       

         $output  = "\n\t".'<div class="counter-holder media '.$clsss_css_animation.' '.$is_box.'" style="text-align:'.$align.'; '.$padding_style.' '.$background_style.' ">';
         $output .= "\n\t\t".$icon;
         $output .= "\n\t\t\t".'<div class="counter-content media-body">';
         $output .= "\n\t\t\t\t".'<span style="'.$style.'" class="counter" data-number="'.$number.'" data-interval="'.$interval.'" data-speed="'.$speed.'">'.$number.'</span>';
         $output .= "\n\t\t\t\t".$title;
         $output .= "\n\t\t\t\t".$subtitle;
         $output .= "\n\t\t\t".'</div>';
         $output .= "\n\t".'</div> ';

         return $output;
         
   }
}

$WPBakeryShortCode_gg_counter = new WPBakeryShortCode_gg_counter();  

vc_map( array(
   "name" => __("Counter","okthemes"),
   "description" => __('A counter from 0 to a specified number.', 'okthemes'),
   "base" => "counter",
   "class" => "theme_icon_class",
   "icon" => "icon-wpb-gg_vc_counter",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('OKThemes','okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "heading" => __("Title","okthemes"),
         "param_name" => "title",
         "admin_label" => true,
         "description" => __("Insert the title here","okthemes")
      ),
      array(
        "type" => "colorpicker",
        "holder" => "div",
        "class" => "",
        "heading" => __("Title color","okthemes"),
        "param_name" => "title_color",
        "dependency" => Array('element' => "title", 'not_empty' => true)
      ),
      array(
         "type" => "textfield",
         "heading" => __("Subtitle","okthemes"),
         "param_name" => "subtitle",
         "admin_label" => true,
         "description" => __("Insert the subtitle here","okthemes")
      ),
      array(
        "type" => "colorpicker",
        "holder" => "div",
        "class" => "",
        "heading" => __("Subtitle color","okthemes"),
        "param_name" => "subtitle_color",
        "dependency" => Array('element' => "subtitle", 'not_empty' => true)
      ),
      array(
         "type" => "checkbox",
         "heading" => __("Icon?","okthemes"),
         "value" => array(__("Use an icon for your counter.","okthemes") => "use_icon" ),
         "param_name" => "add_icon"
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Icon", "okthemes"),
         "param_name" => "icon",
         "value" => $gg_icons_array,
         "description" => __("Choose your icon.", "okthemes"),
         "dependency" => Array('element' => "add_icon", 'value' => array('use_icon'))
      ),
      array(
        "type" => "colorpicker",
        "heading" => __("Icon color","okthemes"),
        "param_name" => "icon_color",
        "dependency" => Array('element' => "add_icon", 'value' => array('use_icon'))
      ),
      array(
         "type" => "checkbox",
         "heading" => __("Box?","okthemes"),
         "value" => array(__("Display the counter in a box","okthemes") => "use_box" ),
         "param_name" => "add_box"
      ),
      array(
        "type" => "colorpicker",
        "heading" => __("Box background","okthemes"),
        "param_name" => "box_background",
        "description" => __("Choose your background color.", "okthemes"),
        "dependency" => Array('element' => "add_box", 'value' => array('use_box'))
      ),
      array(
          "type" => "textfield",
          "heading" => __('Box Padding', 'okthemes'),
          "param_name" => "padding",
          "description" => __("You can use px, em, %, etc. or enter just number and it will use pixels. ", "okthemes"),
          "dependency" => Array('element' => "add_box", 'value' => array('use_box'))
      ),
      array(
        "type" => "textfield",
        "heading" => __("Number", "okthemes"),
        "param_name" => "number"
      ),
      array(
        "type" => "textfield",
        "heading" => __("Refresh interval", "okthemes"),
        "param_name" => "interval",
        "value" => '100'
      ),
      array(
        "type" => "textfield",
        "heading" => __("Speed", "okthemes"),
        "param_name" => "speed",
        "value" => '1500'
      ),
      array(
        "type" => "textfield",
        "heading" => __("Font size (px)", "okthemes"),
        "param_name" => "font_size",
        "value" => '30'
      ),
      array(
        "type" => "colorpicker",
        "holder" => "div",
        "class" => "",
        "heading" => __("Number color", "okthemes"),
        "param_name" => "font_color"
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Align", "okthemes"),
         "param_name" => "align",
         "value" => array(__("Align left", "okthemes") => "left", __("Align right", "okthemes") => "right", __("Align center", "okthemes") => "center"),
         "description" => __("Set the alignment", "okthemes")
      ),

      $add_css_animation,

   )
) );

?>