<?php
$output = $clsss_css_animation = $parallax_background_cover = $text_align_style = $el_class = $padding = $margin_bottom = $css = $parallax_css = $parallax_height_data = $video_height = $video_height_data = $data_attr = $video_html = $video_overlay_html = $parallax_overlay_html = $parallax_class = $video_class = '';
extract(shortcode_atts(array(
  	'el_class'        => '',
    'bg_image'        => '',
    'bg_color'        => '',
    'bg_image_repeat' => '',
    'parallax' => '',
    'parallax_height' => '',
    'parallax_overlay' => '',
	'row_type' => 'row',
	'type' => '',
	'video' => '',
	'video_overlay' => '',
	'video_webm' => '',
	'video_mp4' => '',
	'video_ogv' => '',
	'video_image' => '',
	'video_height' => '',
	'video_overlay_bg_color' => '',
	'parallax_overlay_bg_color' => '',
	'css' => ''
), $atts));

wp_enqueue_script( 'wpb_composer_front_js' );

//Parallax options
if($parallax == "use_parallax"){

	$parallax_class = ' parallax-container';

	if($parallax_height != ""){
		$data_attr .= ' parallax-data-height="'.$parallax_height.'"';
	}

	if($parallax_overlay == "use_parallax_overlay"){
		$parallax_overlay_html = '<div class="gg-parallax-overlay" style="background: '.$parallax_overlay_bg_color.';"></div>';
	}
}


//Video options
if($video == "use_video"){
	//Enqueue script
	wp_enqueue_script('videobackground');
	//Create html

	$video_class = ' video-container';

	if($video_height != ""){
		$data_attr .= ' video-data-height="'.$video_height.'"';
	}

	if($video_mp4 != ""){
		$data_attr .= ' video-data-mp4="'.$video_mp4.'"';
	}

	if($video_webm != ""){
		$data_attr .= ' video-data-webm="'.$video_webm.'"';
	}

	if($video_ogv != ""){
		$data_attr .= ' video-data-ogv="'.$video_ogv.'"';
	}
	
	if($video_overlay == "use_video_overlay"){
		$video_overlay_html = '<div class="gg-video-overlay" style="background: '.$video_overlay_bg_color.';"></div>';
	}

}

$el_class = $this->getExtraClass($el_class);
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'row vc_row vc_row-fluid '. ( $this->settings('base')==='vc_row_inner' ? 'vc_inner ' : '' ) . $el_class . $parallax_class . $video_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
$style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $padding, $margin_bottom, $text_align_style);

//Row type = row
if($row_type == "row") {
	
	$output .= '<div '.$data_attr.' class=" in_row ' . $css_class . '" '.$style.' >';
	$output .= $video_overlay_html.$parallax_overlay_html;

//Row type = section
} elseif ($row_type == "section") {
	
	if($type != "fullwidth"){
		$css_class_type =  " in_container_section";
	} else {
		$css_class_type =  " fullwidth_section";
	}

	$output .= '<section '.$data_attr.' class="section '. $css_class . $css_class_type . '">';

	$output .= $video_overlay_html.$parallax_overlay_html;

	if($type != "fullwidth"){
		$output .= '<div class="container clearfix">';
	} else {
		$output .= '<div class="container-fluid clearfix">';

	}

} 

	$output .= wpb_js_remove_wpautop($content);

//Row type = row
if($row_type == "row") {
	$output .= '</div>'.$this->endBlockComment('row');
//Row type = section
} elseif($row_type == "section") {
	$output .= '</div></section>';
	//$output .= '</div>'.$this->endBlockComment('row');
}

echo $output;