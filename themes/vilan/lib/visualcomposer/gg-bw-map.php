<?php
class WPBakeryShortCode_gg_bw_map extends WPBakeryShortCode {

   public function __construct() {  
         add_shortcode('bw_map', array($this, 'gg_bw_map'));  
   }

   public function gg_bw_map( $atts, $content = null ) { 

         $output = $latitude = $longitude = $zoom = '';
         extract(shortcode_atts(array(
             'latitude'        => '',
             'longitude'  => '',
             'zoom' => '14',
             'height' => '500',
             'infow' => '',
             'infowtitle' => '',
             'infowcontent' => '',
         ), $atts));

         wp_enqueue_script('google-map');

         $output .= "\n\t".'<div data-infow="'.$infow.'" data-infowtitle="'.$infowtitle.'" data-infowcontent="'.$infowcontent.'" data-height="'.$height.'" data-latitude="'.$latitude.'" data-longitude="'.$longitude.'" data-zoom="'.$zoom.'" id="bwmap"></div>';

         return $output;
   }
}

$WPBakeryShortCode_gg_bw_map = new WPBakeryShortCode_gg_bw_map();


vc_map( array(
   "name" => __("BW map", "okthemes"),
   "description" => __('Display a black and white map.', 'okthemes'),
   "base" => "bw_map",
   "class" => "theme_icon_class",
   "icon" => "icon-wpb-gg_vc_bw_map",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   'admin_enqueue_js' => array(get_template_directory_uri().'/lib/visualcomposer/custom-vc.js'),
   "category" => __('OKThemes', 'okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "heading" => __("Latitude", "okthemes"),
         "param_name" => "latitude",
         "value" => '',
         "admin_label" => true,
         "description" => __("Insert the latitude here", "okthemes")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Longitude", "okthemes"),
         "param_name" => "longitude",
         "value" => '',
         "admin_label" => true,
         "description" => __("Insert the longitude here", "okthemes")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Zoom", "okthemes"),
         "param_name" => "zoom",
         "value" => '14',
         "admin_label" => true,
         "description" => __("Zoom level", "okthemes")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Map Height", "okthemes"),
         "param_name" => "height",
         "value" => '500',
         "description" => __("Insert map height in pixels", "okthemes")
      ),
      array(
         "type" => "checkbox",
         "heading" => __("Info window","okthemes"),
         "value" => array(__("Display an info window on marker click?","okthemes") => "use_infow" ),
         "param_name" => "infow"
      ),
      array(
         "type" => "textfield",
         "heading" => __("Info window title", "okthemes"),
         "param_name" => "infowtitle",
         "value" => '',
         "description" => __("Put the info window title here", "okthemes"),
         "dependency" => Array('element' => "infow", 'value' => array('use_infow'))
      ),
      array(
         "type" => "textarea",
         "heading" => __("Info window content", "okthemes"),
         "param_name" => "infowcontent",
         "value" => '',
         "description" => __("Put the info window content here", "okthemes"),
         "dependency" => Array('element' => "infow", 'value' => array('use_infow'))
      ),
   ),
) );

?>