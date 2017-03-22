<?php
class WPBakeryShortCode_gg_title_subtitle extends WPBakeryShortCode {

   public function __construct() {  
         add_shortcode('title_subtitle', array($this, 'gg_title_subtitle'));  
   }


   public function gg_title_subtitle( $atts, $content = null ) { 

         $output = $title = $style = $padding = $subtitle = $font_size = $t_font_weight = $t_font_color = $s_font_color ='';
         extract(shortcode_atts(array(
             'title'                => '',
             'title_type'           => 'h1',
             'subtitle'             => '',
             'custom_font_size'     => '',
             'custom_font_size_px'  => '',
             'title_font_color'     => '',
             'subtitle_font_color'  => '',
             'padding'              => '',
             'el_class'             => '',
             'css_animation'        => '',
             'align'                => 'left',
             'add_underline'        => '',
             'underline_color'      => '',
             'margin_bottom'        => '',
             'font_weight'          => 'normal',
         ), $atts));


         $css_class = $this->getCSSAnimation($css_animation);
         
         if( $padding != '' ) {
            $style .= ' padding: '.(preg_match('/(px|em|\%|pt|cm)$/', $padding) ? $padding : $padding.'px').';';
         }
         if( $margin_bottom != '' ) {
            $style .= ' margin-bottom:'.$margin_bottom.'px;';
         }

         if( $align != '' ) {
            $style .= ' text-align: '.$align.';';
         }

         if( $font_weight != '' ) {
            $t_font_weight = ' font-weight: '.$font_weight.';';
         }

         if ( $custom_font_size == 'use_custom_font_size' ) {
            $font_size = ' font-size:'.$custom_font_size_px.'px;';
         }

         if (!empty($title_font_color)) {
            $t_font_color = ' color:'.$title_font_color.'; ';
         }

         if (!empty($subtitle_font_color)) {
            $s_font_color = ' color:'.$subtitle_font_color.'; ';
         }

         $title_style_array = 'style="'.$font_size.$t_font_color.$t_font_weight.'"';
         $subtitle_style_array = 'style="'.$s_font_color.'"'; 
         
         $output  = "\n\t".'<div class="title-subtitle-box '.$css_class.'" style="'.$style.'">';
         
         if( $title != '' ) {
            $output .= "\n\t\t".'<'.$title_type.' '.$title_style_array.' >'.$title.'</'.$title_type.'>';
         }

         if( $subtitle != '' ) {
            $output .= "\n\t\t".'<p '.$subtitle_style_array.'>'.$subtitle.'</p>';
         }

         if ( $add_underline == 'use_underline' ) {
            $output .= "\n\t\t".'<hr class="has-underline" '.($underline_color !== '' ? 'style="background: '.$underline_color.'"' : '').' />';
         }

          $output .= "\n\t".'</div> ';

         return $output;
         
   }
}

$WPBakeryShortCode_gg_title_subtitle = new WPBakeryShortCode_gg_title_subtitle();  

vc_map( array(
   "name" => __("Title and Subtitle", "okthemes"),
   "description" => __('Display a title and a subtitle.', 'okthemes'),
   "base" => "title_subtitle",
   "class" => "clear_vc_style",
   "icon" => "icon-wpb-gg_vc_title_subtitle",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   'admin_enqueue_js' => array(get_template_directory_uri().'/lib/visualcomposer/custom-vc.js'),
   "category" => __('OKThemes', 'okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "heading" => __("Title", "okthemes"),
         "param_name" => "title",
         "admin_label" => true,
         "description" => __("Insert the title here", "okthemes")
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Title type", "okthemes"),
         "param_name" => "title_type",
         "value" => $headings_array,
         "description" => __("Choose the heading type", "okthemes"),
         "dependency" => Array('element' => "title", 'not_empty' => true)
      ),
      
      array(
         "type" => "dropdown",
         "heading" => __("Title font weight", "okthemes"),
         "param_name" => "font_weight",
         "value" => array(__("Normal", "okthemes") => "normal", __("Bold", "okthemes") => "bold"),
         "description" => __("Set the font weight", "okthemes"),
         "dependency" => Array('element' => "title", 'not_empty' => true)
     ),
      array(
         "type" => "colorpicker",
         "heading" => __('Title font color', 'okthemes'),
         "param_name" => "title_font_color",
         "description" => __("Select the title font color", "okthemes"),
         "dependency" => Array('element' => "title", 'not_empty' => true)
      ),
      array(
         "type" => "checkbox",
         "class" => "",
         "heading" => __("Title custom font size?", "okthemes"),
         "value" => array(__("Use a custom font size for your heading", "okthemes") => "use_custom_font_size" ),
         "param_name" => "custom_font_size",
         "dependency" => Array('element' => "title", 'not_empty' => true)
      ),
      array(
         "type" => "textfield",
         "heading" => __("Insert the title font size", "okthemes"),
         "param_name" => "custom_font_size_px",
         "description" => __("Insert the custom font size in px.", "okthemes"),
         "dependency" => Array('element' => "custom_font_size", 'value' => array('use_custom_font_size'))
      ),
      array(
         "type" => "textarea",
         "heading" => __("Subtitle", "okthemes"),
         "param_name" => "subtitle",
         "admin_label" => true,
         "description" => __("Insert the subtitle here", "okthemes")
      ),
      array(
         "type" => "colorpicker",
         "heading" => __('Subtitle font color', 'okthemes'),
         "param_name" => "subtitle_font_color",
         "description" => __("Select the subtitle font color", "okthemes"),
         "dependency" => Array('element' => "title", 'not_empty' => true)
      ),
      array(
         "type" => "checkbox",
         "class" => "",
         "heading" => __("Add underline?", "okthemes"),
         "value" => array(__("Use a underline for your heading", "okthemes") => "use_underline" ),
         "param_name" => "add_underline"
      ),
      array(
         "type" => "colorpicker",
         "heading" => __('Underline color', 'okthemes'),
         "param_name" => "underline_color",
         "description" => __("Select the underline color", "okthemes"),
         "dependency" => Array('element' => "add_underline", 'value' => array('use_underline'))
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Align", "okthemes"),
         "param_name" => "align",
         "value" => array(__("Align left", "okthemes") => "left", __("Align right", "okthemes") => "right", __("Align center", "okthemes") => "center"),
         "description" => __("Set the alignment", "okthemes")
     ),
      array(
         "type" => "textfield",
         "heading" => __('Padding', 'okthemes'),
         "param_name" => "padding",
         "description" => __("You can use px, em, %, etc. or enter just number and it will use pixels. ", "okthemes")
      ),
      array(
         "type" => "textfield",
         "heading" => __('Margin bottom', 'okthemes'),
         "param_name" => "margin_bottom",
         "description" => __("Insert the margin bottom in pixels. E.g.: 20", "okthemes")
      ),

      $add_css_animation,
   ),
  'js_view'  => 'vilanVcTitleSubtitleView',
) );

?>