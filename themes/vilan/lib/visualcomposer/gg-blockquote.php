<?php
class WPBakeryShortCode_gg_blockquote extends WPBakeryShortCode {

   public function __construct() {  
         add_shortcode('blockquote', array($this, 'gg_blockquote'));  
   }

   public function gg_blockquote( $atts, $content = null ) { 

         $output = $quote = $cite = $cite_html = $quote_background_color_html = $quote_text_color_html = $style = '';
         extract(shortcode_atts(array(
             'quote'        => '',
             'cite'  => '',
             'quote_background_color' => '',
             'quote_text_color' => '',
             'css_animation' => ''
         ), $atts));

         $css_class = $this->getCSSAnimation($css_animation);

         if ($cite != '') {
            $cite_html = '<cite>'.$cite.'</cite>';
         }
         
         if ($quote_background_color != '') {
            $quote_background_color_html = ' background:'.$quote_background_color.';';
         }

         if ($quote_text_color != '') {
            $quote_text_color_html = ' color:'.$quote_text_color.';';
         }

         $style = 'style ="'.$quote_background_color_html.$quote_text_color_html.'"';

         $output .= "\n\t".'<blockquote class="'.$css_class.'" '.$style.'>';
         $output .= "\n\t".$quote;
         $output .= "\n\t".$cite_html;
         $output .= "\n\t".'</blockquote>';

         return $output;
   }
}

$WPBakeryShortCode_gg_blockquote = new WPBakeryShortCode_gg_blockquote();


vc_map( array(
   "name" => __("Blockquote", "okthemes"),
   "description" => __('Display a blockquote.', 'okthemes'),
   "base" => "blockquote",
   "class" => "clear_vc_style",
   "icon" => "icon-wpb-gg_vc_blockquote",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   'admin_enqueue_js' => array(get_template_directory_uri().'/lib/visualcomposer/custom-vc.js'),
   "category" => __('OKThemes', 'okthemes'),
   "params" => array(
      array(
         "type" => "textarea",
         "heading" => __("Quote", "okthemes"),
         "param_name" => "quote",
         "value" => '',
         "description" => __("Insert quote content here", "okthemes")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Cite", "okthemes"),
         "param_name" => "cite",
         "value" => '',
         "admin_label" => true,
         "description" => __("Insert cite here. Like author name, position, website.", "okthemes")
      ),
      array(
        "type" => "colorpicker",
        "heading" => __("Blockquote background color", "okthemes"),
        "param_name" => "quote_background_color",
        "value" => ''
      ),
      array(
        "type" => "colorpicker",
        "heading" => __("Blockquote text color", "okthemes"),
        "param_name" => "quote_text_color",
        "value" => ''
      ),

      $add_css_animation,
   ),
   'js_view'  => 'vilanVcBlockquoteView',
) );

?>