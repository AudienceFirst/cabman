<?php
class WPBakeryShortCode_gg_featured_image extends WPBakeryShortCode {

   public function __construct() {  
         add_shortcode('featured_image', array($this, 'gg_featured_image'));  
   }

   public function gg_featured_image( $atts, $content = null ) { 

         $output = $img_style_octagon = $img_style_class = $img_style_wrapper_start = $img_style_wrapper_end = $featured_title = $image = '';
         extract(shortcode_atts(array(
             'featured_title'        => '',
             'featured_desc'  => '',
             'featured_link'  => '',
             'read_more_text'        => '',
             'read_more_link'        => '',
             'image' => $image,
             'img_size' => 'fullsize',
             'img_style' => 'default',
              'customsize_width' => '',
              'customsize_height' => '',
             'el_class'     => '',
             'css_animation' => ''
         ), $atts));

         switch ($img_style) {
            case 'rounded':
            case 'circle':
            case 'default':
                $img_style_class = $img_style;
                break;
            case 'octagon':
                if ($img_size !== 'fullsize') {
                    $img_style_octagon = 'style="width:'.$customsize_width.'px; height:'.$customsize_height.'px;"';
                } else {
                   $img_style_octagon = 'style="width:100%; height:100%;"'; 
                }
                $img_style_wrapper_start = '<span '.$img_style_octagon.' class="b-polygon b-polygon_octagon"><span class="b-polygon-part b-polygon-part_content">';
                $img_style_wrapper_end = '</span></span>';
                break;
        }


         $img_id = preg_replace('/[^\d]/', '', $image);
         //$img = wpb_getImageBySize(array( 'attach_id' => $img_id, 'thumb_size' => $img_size ));
         //if ( $img == NULL ) $img['thumbnail'] = '<img src="http://placekitten.com/g/400/300" /> <small>'.__('This is image placeholder, edit your page to replace it.', 'okthemes').'</small>';
         if ($img_id > 0) {
            $attachment_url = wp_get_attachment_url($img_id , 'full');
            $alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
            if ($img_size !== 'fullsize') {
                $thumbnail = $img_style_wrapper_start . ' <img class="wp-post-image '.$img_style_class.'" src="'.gg_aq_resize( $img_id, $customsize_width, $customsize_height, true, true ).'" alt="'.$alt_text.'" /> ' . $img_style_wrapper_end;
            } else {
                $thumbnail = $img_style_wrapper_start . ' <img class="wp-post-image '.$img_style_class.'" src="'.$attachment_url.'" /> ' . $img_style_wrapper_end;          
            }
        }

         $css_class = $this->getCSSAnimation($css_animation);

         if($featured_link != ""){
            $featured_title_html = '<a href="'.$featured_link.'">'.$featured_title.'</a>';
         } else {
            $featured_title_html = $featured_title;
         }
         
         $output = "\n\t".'<div class="featured-image-box '.$css_class.'">';
         $output .= "\n\t\t".'<figure>';
         $output .= "\n\t\t\t".$thumbnail;
         $output .= "\n\t\t".'</figure>';
         $output .= "\n\t\t".'<h4>'.$featured_title_html.'</h4>';
         $output .= "\n\t\t".'<p class="featured-desc">'.$featured_desc.'</p>';
         if ($read_more_link != '') {
          $output .= "\n\t\t\t\t".'<a class="btn" href="'.$read_more_link.'">'.$read_more_text.'</a>';
         }         
         $output .= "\n\t".'</div> ';

         return $output;
         
   }
}

$WPBakeryShortCode_gg_featured_image = new WPBakeryShortCode_gg_featured_image();  

vc_map( array(
   "name" => __("Featured image box","okthemes"),
   "description" => __('Image box with title and description.', 'okthemes'),
   "base" => "featured_image",
   "class" => "clear_vc_style",
   "icon" => "icon-wpb-gg_vc_featured_image_box",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   'admin_enqueue_js' => array(get_template_directory_uri().'/lib/visualcomposer/custom-vc.js'),
   "category" => __('OKThemes','okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "heading" => __("Title","okthemes"),
         "param_name" => "featured_title",
         "admin_label" => true,
         "description" => __("Insert title here","okthemes")
      ),
      array(
         "type" => "textarea",
         "heading" => __("Description","okthemes"),
         "param_name" => "featured_desc",
         "description" => __("Insert short description here","okthemes")
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title link","okthemes"),
         "param_name" => "featured_link",
         "value" => '',
         "description" => __("Insert title link here","okthemes")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Read more text","okthemes"),
         "value" => __("Read more","okthemes"),
         "param_name" => "read_more_text",
         "description" => __("Insert the read more text.","okthemes")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Read more link","okthemes"),
         "param_name" => "read_more_link",
         "description" => __("Insert read more link here","okthemes")
      ),
      array(
         "type" => "attach_image",
         "heading" => __("Featured image", "okthemes"),
         "param_name" => "image",
         "value" => "",
         "description" => __("Select image from media library.", "okthemes")
      ),
      //Image size
      array(
            "type" => "dropdown",
            "heading" => __("Image size", "js_composer"),
            "param_name" => "img_size",
            "value" => array(__("Full size", "js_composer") => "fullsize", __("Custom size", "js_composer") => "customsize"),
            "description" => __("Choose the image size", "js_composer")
      ),
      array(
          "type" => "dropdown",
          "heading" => __("Image style", "js_composer"),
          "param_name" => "img_style",
          "value" => $img_style_arr,
          "std" => "default",
          "description" => __("Choose the image style", "js_composer")
      ),
      array(
            "type" => "textfield",
            "heading" => __("Custom size - width", "js_composer"),
            "param_name" => "customsize_width",
            "description" => __("Insert the width of the image", "js_composer"),
            "dependency" => Array('element' => "img_size", 'value' => array('customsize'))
      ),
      array(
            "type" => "textfield",
            "heading" => __("Custom size - height", "js_composer"),
            "param_name" => "customsize_height",
            "description" => __("Insert the height of the image", "js_composer"),
            "dependency" => Array('element' => "img_size", 'value' => array('customsize'))
      ),
      $add_css_animation,
   ),
   'js_view'  => 'vilanVcFeaturedImageView',
) );

?>