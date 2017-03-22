<?php

$output = $overlay_figcaption_custom_link = $overlay_figcaption_video = $overlay_figcaption_large_image = $el_class = $img_style_octagon = $img_style_class = $img_style_wrapper_start = $img_style_wrapper_end = $has_magnific = $image = $img_size = $img_link = $img_link_target = $img_link_large = $title = $alignment = $css_animation = '';

extract(shortcode_atts(array(
    'title' => '',
    'image' => $image,
    'img_size' => 'fullsize',
    'customsize_width' => '',
    'customsize_height' => '',
    'img_link_large' => false,
    'img_link' => '',
    'link' => '',
    'img_link_target' => '_self',
    'alignment' => 'left',
    'el_class' => '',
    'css_animation' => '',
    'overlay' => '',
    'lightbox_large_image' => '',
    'lightbox_video' => '',
    'lightbox_custom_link' => '',
    'lightbox_title' => '',
    'lightbox_subtitle' => '',
    'style' => '',
    'img_style' => 'default',
    'border_color' => ''
), $atts));

$a_class = '';

$style = ($style!='') ? $style : '';
$border_color = ($border_color!='') ? ' vc_box_border_' . $border_color : '';

$img_style_class = $img_style;

$img_id = preg_replace('/[^\d]/', '', $image);

if ($img_id > 0) {
    $attachment_url = wp_get_attachment_url($img_id , 'full');
    $alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
    if ($img_size !== 'fullsize') {
        $thumbnail = $img_style_wrapper_start . ' <img class="wp-post-image '.$img_style_class.'" src="'.gg_aq_resize( $img_id, $customsize_width, $customsize_height, true, true ).'" alt="'.$alt_text.'" /> ' . $img_style_wrapper_end;
    } else {
        $thumbnail = $img_style_wrapper_start . ' <img class="wp-post-image '.$img_style_class.'" src="'.$attachment_url.'" /> ' . $img_style_wrapper_end;          
    }
}

$el_class = $this->getExtraClass($el_class);

$has_magnific = '';

if ( $el_class != '' ) {
  $has_magnific = ' has_magnific';  
  $tmp_class = explode(" ", strtolower($el_class));
  $tmp_class = str_replace(".", "", $tmp_class);
  if ( in_array("lightbox-el", $tmp_class) ) {
      wp_enqueue_script( 'magnific' );
      wp_enqueue_style( 'magnific' );  
      $a_class = ' class="lightbox-el"';
      $el_class = str_ireplace("lightbox-el", "", $el_class);
  }
}

$link_to = '';
$link_to_icn = '';
if ( $img_link_large == true ) {
    $has_magnific = ' has_magnific';
    wp_enqueue_script( 'magnific' );
    wp_enqueue_style( 'magnific' );

    $link_to = wp_get_attachment_image_src( $img_id, 'large' );
    $link_to = $link_to[0];
    $a_class = ' class="lightbox-el"';
    $link_to_icn = '<span class="portfolio-hover-icn"><i class="icon_zoom-in_alt"></i></span>';
} else if ( strlen($link) > 0 ) {
    $link_to = $link;
    $link_to_icn = '<span class="portfolio-hover-icn"><i class="icon_zoom-in_alt"></i></span>';
} else if ( ! empty( $img_link ) ) {
    $link_to = $img_link;
    $link_to_icn = '<span class="portfolio-hover-icn"><i class="icon_zoom-in_alt"></i></span>';
    if ( ! preg_match( '/^(https?\:\/\/|\/\/)/', $link_to ) ) $link_to = 'http://' . $link_to;
}

//Custom dev for overlay
if ( $overlay == 'add_overlay' ) {

   
    $overlay_start = '<div class="image-grid"><figure class="effect-sadie has-img-'.$img_style_class.'">';
    $overlay_end   = '</figure></div>';
    
    $base_image    = $thumbnail;

    $overlay_figcaption_start = '<figcaption>';
    $overlay_figcaption_end   = '</figcation>';

    //Title
    if (!empty($lightbox_title)) {
        $overlay_figcaption_title   = '<h4>'.$lightbox_title.'</h4>';    
    }
    //Subtitle
    if (!empty($lightbox_subtitle)) {
        $overlay_figcaption_subtitle   = '<p class="port-short-desc">'.$lightbox_subtitle.'</p>';    
    }
    //Overlay string
    //$image_string = $overlay_start.$base_image.$overlay_figcaption_start.$overlay_figcaption_title.$overlay_figcaption_subtitle.$overlay_figcaption_large_image.$overlay_figcaption_video.$overlay_figcaption_custom_link.$overlay_figcaption_end.$overlay_end;
    $image_string = !empty($link_to) ? '<a'.$a_class.' href="' . $link_to . '"' . ' target="' . $img_link_target . '"'. '>'.$overlay_start.$base_image.$overlay_figcaption_start.$overlay_figcaption_title.$link_to_icn.$overlay_figcaption_subtitle.$overlay_figcaption_large_image.$overlay_figcaption_video.$overlay_figcaption_custom_link.$overlay_figcaption_end.$overlay_end.'</a>' : $overlay_start.$base_image.$overlay_figcaption_start.$overlay_figcaption_title.$overlay_figcaption_subtitle.$overlay_figcaption_large_image.$overlay_figcaption_video.$overlay_figcaption_custom_link.$overlay_figcaption_end.$overlay_end;

} else {
    //$img_output = ($style=='vc_box_shadow_3d') ? '<span class="vc_box_shadow_3d_wrap">' . $img['thumbnail'] . '</span>' : $img['thumbnail'];
    $image_string = !empty($link_to) ? '<a'.$a_class.' href="' . $link_to . '"' . ' target="' . $img_link_target . '"'. '>'.$thumbnail.'</a>' : $thumbnail;

}

$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_single_image'.$has_magnific.' wpb_content_element'.$el_class, $this->settings['base']);
$css_class .= $this->getCSSAnimation($css_animation);

$css_class .= ' vc_align_'.$alignment;

$output .= "\n\t".'<div class="'.$css_class.'">';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .= "\n\t\t\t".wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_singleimage_heading'));
$output .= "\n\t\t\t".$image_string;
$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
$output .= "\n\t".'</div> '.$this->endBlockComment('.wpb_single_image');

echo $output;