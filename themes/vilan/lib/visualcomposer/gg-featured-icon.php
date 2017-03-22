<?php
class WPBakeryShortCode_gg_featured_icon extends WPBakeryShortCode {

   public function __construct() {  
         add_shortcode('featured_icon', array($this, 'gg_featured_icon'));  
   }


   public function gg_featured_icon( $atts, $content = null ) { 

         $output = $margin_style = $style = $icon_box_style_start = $icon_box_style_end = $icon_size_css = $icon_color_css = $featured_title = $image = $align_center = $icon_box_css = $icon_box_back = $icon_border_style = $read_more_text_name = '';
         extract(shortcode_atts(array(
             'featured_title'        => '',
             'featured_desc'         => '',
             'featured_link'         => '',
             'featured_icon'         => '',
             'read_more_text_name'        => '',
             'read_more_link'        => '',
             'read_more_but'         => '',
             'align'                 => 'pull-left',
             'icon_box'              => '',
             'icon_box_color'        => '',
             'el_class'              => '',
             'css_animation'         => '',
             'icon_size'             => 'normal',
             'icon_box_style'        => '',
             'icon_color'            => '',
             'icon_border'           => ''
         ), $atts));

         $css_class = $this->getCSSAnimation($css_animation);

         if($align == "pull-center"){
            $align_center = 'style="text-align:center;"';
         } 

         if($icon_color != ""){
            $icon_color_css = ' color: '.$icon_color.';';
         }

         if($icon_border == "use_icon_border"){
            $icon_border_style = 'style= "border-color: '.$icon_color.';"';
            $css_class .= ' icn_has_border';
         }

        //parse featured link
        if($featured_link !=='||'){
            $featured_link = vc_build_link($featured_link);
            $featured_link['target'] = ( $featured_link['target'] == '' ) ? '_self' : $featured_link['target'];
            $featured_title_html = '<a target="'.$featured_link['target'].'" title="'.esc_attr($featured_link['title']).'" href="'.$featured_link['url'].'">'.$featured_title.'</a>';
        } else {
            $featured_title_html = $featured_title;
        }

         $style = 'style="'.$icon_box_back.$icon_color_css.'"';

         if($icon_box == "use_icon_box"){
            $icon_box_css = 'icon-box';
            $icon_box_back = ' background-color: '.$icon_box_color.';';
            switch ($icon_box_style) {
              case 'circle_style':
                  $icon_box_style_start = '<span class="b-circle '.$align.' '.$icon_size.'" style="'.$icon_box_back.$icon_color_css.$margin_style.'">';
                  $icon_box_style_end = '</span>';
                  break;
              case 'rounded_style':
                  $icon_box_style_start = '<span class="b-rounded '.$align.' '.$icon_size.'" style="'.$icon_box_back.$icon_color_css.$margin_style.'">';
                  $icon_box_style_end = '</span>';
                  break;
            }
            
         }

         $output = "\n\t".'<div class="featured-icon-box '.$css_class.'" '.$align_center.'>';
         $output .= "\n\t\t".'<div class="media">';
         $output .= "\n\t\t".'<div class="icn-holder '.$align.' '.$icon_box_css.'" '.$icon_border_style.'>'.$icon_box_style_start.'<i style="'.$icon_color_css.'" class="'.$featured_icon.' '.$icon_size.'"></i>'.$icon_box_style_end.'</div>';
         $output .= "\n\t\t\t".'<div class="media-body">';
         $output .= "\n\t\t\t\t".'<h3 class="media-heading">'.$featured_title_html.'</h3>';
         $output .= "\n\t\t\t\t".'<p class="featured-desc">'.$featured_desc.'</p>';
        
         if ($read_more_but == 'use_read_more_button' && $read_more_link !=='||') {
          
          $read_more_link = vc_build_link($read_more_link);
          $read_more_link['target'] = ( $read_more_link['target'] == '' ) ? '_self' : $read_more_link['target'];
          $output .= "\n\t\t\t\t".'<a class="" target="'.$read_more_link['target'].'" title="'.esc_attr($read_more_link['title']).'" href="'.$read_more_link['url'].'">'.$read_more_text_name.'</a>';
         }
         $output .= "\n\t\t\t".'</div>';
         $output .= "\n\t\t".'</div>';        
         $output .= "\n\t".'</div> ';

         return $output;
         
   }
}

$WPBakeryShortCode_gg_featured_icon = new WPBakeryShortCode_gg_featured_icon();  

vc_map( array(
   "name" => __("Featured icon box","okthemes"),
   "description" => __('Display an featured icon with title and description.', 'okthemes'),
   "base" => "featured_icon",
   "class" => "clear_vc_style",
   "icon" => "icon-wpb-gg_vc_featured_icon_box",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   'admin_enqueue_js' => array(get_template_directory_uri().'/lib/visualcomposer/custom-vc.js'),
   "category" => __('OKThemes', 'okthemes'),

   "params" => array(
      array(
         "type" => "textfield",
         "heading" => __("Title","okthemes"),
         "param_name" => "featured_title",
         "admin_label" => true,
         "description" => __("Insert title here","okthemes")
      ),
      array(
        "type" => "vc_link",
        "heading" => __("Title URL (Link)", "okthemes"),
        "param_name" => "featured_link",
        "description" => __("Title link.", "okthemes")
      ),
      array(
         "type" => "textarea",
         "heading" => __("Description","okthemes"),
         "param_name" => "featured_desc",
         "description" => __("Insert short description here","okthemes")
      ),

      array(
         "type" => "checkbox",
         "heading" => __("Read more link","okthemes"),
         "value" => array(__("Use a read more link?","okthemes") => "use_read_more_button" ),
         "param_name" => "read_more_but"
      ),
      array(
         "type" => "textfield",
         "heading" => __("Read more text","okthemes"),
         "value" => __("Read more","okthemes"),
         "param_name" => "read_more_text_name",
         "description" => __("Insert the read more text.","okthemes"),
         "dependency" => Array('element' => "read_more_but", 'value' => array('use_read_more_button'))
      ),
      array(
         "type" => "vc_link",
         "heading" => __("Read more URL","okthemes"),
         "param_name" => "read_more_link",
         "description" => __("Insert read more URL here","okthemes"),
         "dependency" => Array('element' => "read_more_but", 'value' => array('use_read_more_button'))
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Featured icon", "okthemes"),
         "param_name" => "featured_icon",
         "value" => $gg_icons_array,
         "description" => __("Choose your featured icon.", "okthemes")
      ),
      array(
         "type" => "checkbox",
         "heading" => __("Icon border","okthemes"),
         "value" => array(__("Apply a border around the icons?","okthemes") => "use_icon_border" ),
         "param_name" => "icon_border"
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Featured icon size", "okthemes"),
         "param_name" => "icon_size",
         "value" => array(__("Normal", "okthemes") => "normal", __("Small", "okthemes") => "small", __("Large", "okthemes") => "large"),
         "description" => __("Select the featured icon size", "okthemes")
      ),
      array(
         "type" => "colorpicker",
         "heading" => __('Featured icon color', 'okthemes'),
         "param_name" => "icon_color",
         "description" => __("Select the icon color", "okthemes")
      ),
      array(
         "type" => "checkbox",
         "heading" => __("Icon box","okthemes"),
         "value" => array(__("Wrap the icon in a box?","okthemes") => "use_icon_box" ),
         "param_name" => "icon_box"
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Icon box style", "okthemes"),
         "param_name" => "icon_box_style",
         "value" => array(__("Circle", "okthemes") => "circle_style", __("Rounded", "okthemes") => "rounded_style"),
         "description" => __("Select the icon style", "okthemes"),
         "dependency" => Array('element' => "icon_box", 'value' => array('use_icon_box')),
         "admin_label" => true
      ),
      array(
         "type" => "colorpicker",
         "heading" => __('Icon box background color', 'okthemes'),
         "param_name" => "icon_box_color",
         "description" => __("Select the icon box background color", "okthemes"),
         "dependency" => Array('element' => "icon_box", 'value' => array('use_icon_box'))
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Align the icon", "okthemes"),
         "param_name" => "align",
         "value" => array(__("Align left", "okthemes") => "pull-left", __("Align right", "okthemes") => "pull-right", __("Align center", "okthemes") => "pull-center"),
         "description" => __("Set the alignment of the icon.", "okthemes")
      ),

      $add_css_animation,


   ),
  'js_view'  => 'vilanVcFeaturedIconView',
) );

?>