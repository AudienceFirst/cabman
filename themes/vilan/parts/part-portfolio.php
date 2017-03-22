<?php
/**
 * The loop that displays the portfolio posts.
 */
?>

<?php
    //Retrieve variables from the metabox
    global $post, $portfolio_img_width, $portfolio_img_height, $disable_image_resize;

    $port_item_short_desc = rwmb_meta('gg_port_item_short_desc');
    $select_portfolio_open_type = rwmb_meta('gg_select_portfolio_open_type');

    $port_item_lightbox_image = rwmb_meta( 'gg_port_item_lightbox_image', 'type=image_advanced' );
    $port_item_lightbox_video = rwmb_meta('gg_port_item_lightbox_video');
    $port_item_custom_url = rwmb_meta('gg_port_item_custom_url');

    $gg_port_post_e_d_share = rwmb_meta('gg_port_post_e_d_share');

    switch ($select_portfolio_open_type) {
    case "lightbox_image":
       if (!empty($port_item_lightbox_image)) { //check if array is empty
          $port_item_lightbox_image_values = array_values($port_item_lightbox_image);
          $port_item_lightbox_image_key = array_shift($port_item_lightbox_image_values);
       }
       $link_html = '<a class="lightbox-el link-wrapper" title="'.esc_attr($port_item_lightbox_image_key["title"]).'" href="'.esc_url($port_item_lightbox_image_key["full_url"]).'"></a>';
       $portfolio_hover_icn = '<i class="icon_zoom-in_alt"></i>';
       break;
    case "lightbox_video":
       $link_html = '<a class="lightbox-el link-wrapper lightbox-video" href="'.esc_url($port_item_lightbox_video).'"></a>';
       $portfolio_hover_icn = '<i class="icon_film"></i>';
       break;
    case "custom_url":
       $link_html = '<a class="link-wrapper" href="'.esc_url($port_item_custom_url).'"></a>';
       $portfolio_hover_icn = '<i class="icon_link_alt"></i>';
       break;  
    case "separate_page":
       $link_html = '<a class="link-wrapper" href="'.esc_url(get_permalink()).'"></a>';
       $portfolio_hover_icn = '<i class="icon_document_alt"></i>';
       break;    
    }
?>

<figure class="effect-sadie">
    <?php
    if (!$disable_image_resize) {
        $thumbnail_id = get_post_thumbnail_id( $post->ID );
        $img_src = gg_aq_resize( $thumbnail_id, $portfolio_img_width, $portfolio_img_height, true, true );
        echo '<img class="wp-post-image" src="'.esc_url($img_src).'" alt="'.get_the_title( $thumbnail_id ).'" />';
    } else {
        echo get_the_post_thumbnail($post->ID, 'full');          
    } 
    ?>

    <figcaption>
      <?php echo $link_html; ?>
      <h4><?php echo get_the_title(); ?></h4>
      <span class="portfolio-hover-icn"><?php echo $portfolio_hover_icn; ?></span>
      <p class="port-short-desc"><?php echo esc_html($port_item_short_desc); ?></p>
    </figcaption>
</figure>