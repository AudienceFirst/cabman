<?php
$output = $title =  $onclick = $custom_links = $img_size = $custom_links_target = $images = $el_class = $partial_view = '';
$mode = $slides_per_view = $wrap = $autoplay = $hide_pagination_control = $hide_prev_next_buttons = $speed = '';
extract(shortcode_atts(array(
    'title' => '',
    'onclick' => 'link_image',
    'custom_links' => '',
    'custom_links_target' => '',
    'img_size' => 'fullsize',
    'customsize_width' => '',
    'customsize_height' => '',
    'images' => '',
    'el_class' => '',
    'mode' => 'horizontal',
    'slides_per_view' => '1',
    'transition_style' => 'fade',
    'wrap' => '',
    'autoplay' => '',
    'hide_pagination_control' => '',
    'hide_prev_next_buttons' => '',
    'speed' => '200',
    'partial_view' => '',
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
$has_magnific = '';
$img_style_class = $img_style;

$el_class = $this->getExtraClass($el_class);
$css_animation = $this->getCSSAnimation($css_animation);

if ( $onclick == 'link_image' ) {
        
    //Load Magnific
    wp_enqueue_script( 'magnific' );
    wp_enqueue_style( 'magnific' );

    $has_magnific = 'has_magnific';
}

//Load carousel
wp_enqueue_script( 'owlcarousel' );
wp_enqueue_style( 'owlcarouselbase' );
wp_enqueue_style( 'owlcarouseltheme' );
wp_enqueue_style( 'owlcarouseltransitions' );

if ( $images == '' ) $images = '-1,-2,-3';

if ( $onclick == 'custom_link' ) { $custom_links = explode( ',', $custom_links); }

$images = explode( ',', $images);
$i = -1;
$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_images_carousel '.$css_animation.' wpb_content_element'.$el_class.' clearfix', $this->settings['base']);
$carousel_id = 'vc-images-carousel-'.WPBakeryShortCode_VC_images_carousel::getCarouselIndex();
$slider_width = $this->getSliderWidth($img_size) * $slides_per_view.'px';
//$slider_width = $slider_width * $slides_per_view; //modified

?>

<div class="<?php echo apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->settings['base']) ?>">
    <div class="wpb_wrapper">
        <?php echo  wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_gallery_heading')) ?>
        <div id="<?php echo $carousel_id ?>" 
            class="owl-carousel <?php echo $has_magnific; ?>"
            data-slides-per-view = "<?php echo $slides_per_view ?>"
            data-single-item = "<?php echo $slides_per_view === '1' ? 'true' : 'false' ?>"
            data-transition-slide = "<?php echo $transition_style ?>"
            data-navigation-owl = "false"
            data-lazyload = "true"
            data-pagination-owl = "<?php echo $hide_pagination_control !== 'yes' ? 'true' : 'false' ?>"
            data-autoplay = "<?php echo $autoplay === 'yes' ? '3000' : 'false' ?>"
            data-rewind = "<?php echo $wrap === 'yes' ? 'true' : 'false' ?>"
            data-speed = "<?php echo $speed; ?>"
            >

            <!-- Wrapper for slides -->

                    <?php foreach($images as $attach_id): ?>
                    <?php
                    $i++;
                    if ($attach_id > 0) {
                        $attachment_url = wp_get_attachment_url($attach_id , 'full');
                        $alt_text = get_the_title($attach_id);
                        if ($img_size !== 'fullsize') {
                            $thumbnail = '<img class="wp-post-image lazyOwl '.$img_style_class.'" data-src="'.gg_aq_resize( $attach_id, $customsize_width, $customsize_height, true, true ).'" src="'.gg_aq_resize( $attach_id, $customsize_width, $customsize_height, true, true ).'" alt="'.$alt_text.'" />';
                        } else {
                            $thumbnail = '<img class="wp-post-image lazyOwl '.$img_style_class.'" data-src="'.$attachment_url.'" src="'.$attachment_url.'" alt="'.$alt_text.'" />';          
                        }
                    }

                    ?>
                    <div class="item <?php echo $slides_per_view === '1' ? 'single-image' : '' ?>">

                        <?php if ( $onclick == 'link_image' ) {

                        $link_start = '<a class="lightbox-el" href="'.$attachment_url.'">';
                        $link_end = '</a>';

                        } elseif ( $onclick == 'custom_link' && isset( $custom_links[$i] ) && $custom_links[$i] != '' ) {
                            $link_start = '<a href="'.$custom_links[$i].'"' . (!empty($custom_links_target) ? ' target="'.$custom_links_target.'"' : '') . '>';
                            $link_end = '</a>';
                        }
                        
                        $gal_images = $el_start . $link_start . $thumbnail . $link_end . $el_end;
                        echo  $gal_images;
                        ?>

                    </div>
                    <?php endforeach; ?>

        </div>

    </div><?php echo $this->endBlockComment('.wpb_wrapper') ?>
</div><?php echo $this->endBlockComment('.wpb_images_carousel') ?>