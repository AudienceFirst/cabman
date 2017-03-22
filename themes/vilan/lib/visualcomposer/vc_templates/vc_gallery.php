<?php
$output = $has_magnific = $title = $type = $onclick = $custom_links = $img_size = $custom_links_target = $images = $el_class = $interval = '';
extract(shortcode_atts(array(
    'title' => '',
    'type' => 'slider',
    'onclick' => 'link_image',
    'custom_links' => '',
    'custom_links_target' => '',
    'img_size' => 'thumbnail',
    'images' => '',
    'speed' => '200',
    'hide_pagination_control' => '',
    'hide_prev_next_buttons' => '',
    'autoplay' => '',
    'wrap' => '',
    'transition_style' => 'fade',
    'el_class' => '',
    'css_animation'         => '',
    'img_style' => 'default'
), $atts));
$gal_images = '';
$link_start = '';
$link_end = '';
$el_start = '';
$el_end = '';
$slides_wrap_start = '';
$slides_wrap_end = '';
$img_style_class = $img_style;

$el_class = $this->getExtraClass($el_class);
$css_animation = $this->getCSSAnimation($css_animation);

    //Load isotope
    wp_enqueue_script( 'theme-isotope' );
    wp_enqueue_style( 'theme-isotope' );

    $el_start = '<li class="isotope-item">';
    $el_end = '</li>';
    $slides_wrap_start = '<ul class="wpb_image_grid_ul">';
    $slides_wrap_end = '</ul>';

    $type = ' wpb_image_grid';

//if ( $images == '' ) return null;
if ( $images == '' ) $images = '-1,-2,-3';

if ( $onclick == 'custom_link' ) { $custom_links = explode( ',', $custom_links); }
$images = explode( ',', $images);
$i = -1;

foreach ( $images as $attach_id ) {
    $i++;
    if ($attach_id > 0) {
        $post_thumbnail = wpb_getImageBySize(array( 'attach_id' => $attach_id, 'thumb_size' => $img_size, 'class' => 'wp-post-image '.$img_style_class.'' ));
    }
    else {
        $different_kitten = 400 + $i;
        $post_thumbnail = array();
        $post_thumbnail['thumbnail'] = '<img src="http://placekitten.com/g/'.$different_kitten.'/300" />';
        $post_thumbnail['p_img_large'][0] = 'http://placekitten.com/g/1024/768';
    }

    $thumbnail = $post_thumbnail['thumbnail'];
    $p_img_large = $post_thumbnail['p_img_large'];
    $link_start = $link_end = '';

    if ( $onclick == 'link_image' ) {
        
        //Load Magnific
        wp_enqueue_script( 'magnific' );
        wp_enqueue_style( 'magnific' );

        $type = ' wpb_image_grid has_magnific';

        $link_start = '<a class="lightbox-el" href="'.$p_img_large[0].'">';
        $link_end = '</a>';
    } elseif ( $onclick == 'custom_link' && isset( $custom_links[$i] ) && $custom_links[$i] != '' ) {
        $link_start = '<a href="'.$custom_links[$i].'"' . (!empty($custom_links_target) ? ' target="'.$custom_links_target.'"' : '') . '>';
        $link_end = '</a>';
    }

    $gal_images .= $el_start . $link_start . $thumbnail . $link_end . $el_end;
}
$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_gallery wpb_content_element'.$el_class.' '.$css_animation.' '.$has_magnific.' clearfix', $this->settings['base']);
$output .= "\n\t".'<div class="'.$css_class.'">';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_gallery_heading'));

$output .= '<div class="wpb_gallery_slides'.$type.'">'.$slides_wrap_start.$gal_images.$slides_wrap_end.'</div>';

$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
$output .= "\n\t".'</div> '.$this->endBlockComment('.wpb_gallery');

echo $output;