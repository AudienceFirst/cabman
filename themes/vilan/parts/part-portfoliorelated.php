<?php  if (get_theme_mod('portfolio_related_posts', 1) == 1) { 
wp_enqueue_script('magnific');
wp_enqueue_style('magnific');

?>

<?php

if ( 'portfolio_cpt' == get_post_type() ) {

$taxs = wp_get_post_terms( $post->ID, 'portfolio_tag' );

if ( !empty($taxs) ) {

    $tax_ids = array();
    foreach( $taxs as $individual_tax ) {
        $tax_ids[] = $individual_tax->term_id;
    }

    $args = array(
        'tax_query' => array(
            array(
            'taxonomy'  => 'portfolio_tag',
            'terms'     => $tax_ids,
            'operator'  => 'IN'
            )
        ),
        'post__not_in'          => array( $post->ID ),
        'posts_per_page'        => get_theme_mod('portfolio_related_posts_number','3'),
        'ignore_sticky_posts'   => 1
    );

    switch (get_theme_mod('portfolio_related_posts_number','3')) {
        case "4":
            $portfolio_related_col_class = 'col-xs-6 col-md-3';
            $portfolio_img_width = '263';
            $portfolio_img_height= '293';
            break;
        case "3":
            $portfolio_related_col_class = 'col-xs-4 col-md-4';
            $portfolio_img_width = '360';
            $portfolio_img_height= '390';
            break;
        case "2":
            $portfolio_related_col_class = 'col-xs-6 col-md-6';
            $portfolio_img_width = '555';
            $portfolio_img_height= '585';
            break;            
    }

$portfolio_tags_query = new wp_query( $args );

if( $portfolio_tags_query->have_posts() ) { ?>

<section class="related-projects">
    <div class="container">

        <h4 class="entry-title"><?php echo get_theme_mod('portfolio_related_posts_title','Related posts'); ?></h4>
        <span class="title-underline"></span>

        <ul class="row image-grid">
        <?php 

        while ( $portfolio_tags_query->have_posts() ) : $portfolio_tags_query->the_post();

        ?>    

            <li class="<?php echo $portfolio_related_col_class; ?>">
            <?php
                //Retrieve variables from the metabox
                global $post;

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
                      $thumbnail_id = get_post_thumbnail_id( $post->ID );
                      $img_src = gg_aq_resize( $thumbnail_id, $portfolio_img_width, $portfolio_img_height, true, true );
                      echo '<img class="wp-post-image" src="'.esc_url($img_src).'" alt="'.get_the_title( $thumbnail_id ).'" />';
                  ?>

                  <figcaption>
                    <?php echo $link_html; ?>
                    <h4><?php echo get_the_title(); ?></h4>
                    <span class="portfolio-hover-icn"><?php echo $portfolio_hover_icn; ?></span>
                    <p class="port-short-desc"><?php echo $port_item_short_desc; ?></p>
                  </figcaption>
              </figure>
            </li><!-- // portfolio item column -->

        <?php endwhile; ?>
        </ul>

    </div>

</section>

<?php } ?>

<?php } //end check for portfolio tags ?>

<?php } //end check for portfolio post type ?>

<?php wp_reset_postdata(); ?> 

<?php } ?>