<?php

/*
 * Hook in on activation
 */
function gg_woocommerce_image_dimensions() {

        global $pagenow;
 
        if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
            return;
        }

        $catalog = array(
            'width'     => '360',   // px
            'height'    => '360',   // px
            'crop'      => 1        // true
        );
     
        $single = array(
            'width'     => '547',   // px
            'height'    => '547',   // px
            'crop'      => 1        // true
        );
     
        $thumbnail = array(
            'width'     => '90',   // px
            'height'    => '90',   // px
            'crop'      => 1        // false
        );

        // Image sizes
        update_option( 'shop_catalog_image_size', $catalog );       // Product category thumbs
        update_option( 'shop_single_image_size', $single );         // Single product image
        update_option( 'shop_thumbnail_image_size', $thumbnail );   // Image gallery thumbs
}

add_action( 'after_switch_theme', 'gg_woocommerce_image_dimensions', 1 );

/**
 * Load JavaScript and jQuery files for theme.
 *
 */
if ( version_compare( WOOCOMMERCE_VERSION, '2.3', '>=' ) ) {
    function gg_wc_scripts_loader() {
        wp_enqueue_script('woo-inputs', get_template_directory_uri() . '/js/woocommerce.js', array('jquery'), OKTHEMES_THEMEVERSION, true); 
    }
    add_action('wp_enqueue_scripts', 'gg_wc_scripts_loader');
}

/**
 * Hide shop page title
 */
add_filter('woocommerce_show_page_title', 'remove_shop_page_title' );
function remove_shop_page_title() {
    return false;
}

/*
 * Add custom pagination
 */
remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
function woocommerce_pagination() {
        pagination();       
    }
add_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10);

/*
 * Allow shortcodes in product excerpts
 */
if (!function_exists('woocommerce_template_single_excerpt')) {
   function woocommerce_template_single_excerpt( $post ) {
       global $post;
       if ($post->post_excerpt) echo '<div itemprop="description">' . do_shortcode(wpautop(wptexturize($post->post_excerpt))) . '</div>';
   }
}


/*
 * Add category on products page
 */
if (!function_exists('woocommerce_display_product_category')) {
   function woocommerce_display_product_category( $post ) {
       global $post, $product;
       $cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
       echo $product->get_categories( ', ', '<span class="posted_in">' . _n( '', '', $cat_count, 'woocommerce' ) . ' ', '.</span>' );
   }
}
//add_action('woocommerce_after_shop_loop_item_title','woocommerce_display_product_category', 5);


/*
 * Change number of products per row
 */
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
    function loop_columns() {
        return get_theme_mod('shop_product_columns','3');
    }
}

/*
 * Products per page
 */
add_filter('loop_shop_per_page',  'show_products_per_page');
function show_products_per_page() {
    $product_per_page = get_theme_mod('product_per_page','12');
    return $product_per_page;
}

/**
 * Add search fragment
 */
function woocommerceframework_add_search_fragment ( $settings ) {
    $settings['add_fragment'] = '?post_type=product';
    return $settings;
}

/**
 * Enable/Disable Sale Flash
 */
if ( get_theme_mod('store_sale_flash', 1) == 0 ) {
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
}
else {
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
    add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
}

/**
 * Enable/Disable Products price
 */
if ( get_theme_mod('store_products_price', 1) == 0 ) {
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
}
else {
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
    add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
}

/**
 * Options for product page
 */

if ( get_theme_mod('product_sale_flash', 1) == 0 ) {    
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
}

if ( get_theme_mod('product_products_price', 1) == 0 ) {    
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
}

if ( get_theme_mod('product_products_excerpt', 1) == 0 ) {  
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
}

if ( get_theme_mod('product_add_to_cart', 1) == 0 ) {
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
}

if ( get_theme_mod('product_products_meta', 1) == 0 ) {
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
}

/**
 * Enable/Disable Review tab
 */
if ( get_theme_mod('product_reviews_tab', 1) == 0 ) {
add_filter( 'woocommerce_product_tabs', 'gg_woo_remove_reviews_tab', 98);
    function gg_woo_remove_reviews_tab($tabs) {
        unset($tabs['reviews']);
        return $tabs;
    }
}

/**
 * Enable/Disable Description tab
 */
if ( get_theme_mod('product_description_tab', 1) == 0 ) {
add_filter( 'woocommerce_product_tabs', 'gg_woo_remove_description_tab', 98);
    function gg_woo_remove_description_tab($tabs) {
        unset($tabs['description']);
        return $tabs;
    }
}

/**
 * Enable/Disable Attributes tab
 */
if ( get_theme_mod('product_attributes_tab', 1) == 0 ) {
add_filter( 'woocommerce_product_tabs', 'gg_woo_remove_attributes_tab', 98);
    function gg_woo_remove_attributes_tab($tabs) {
        unset($tabs['attributes']);
        return $tabs;
    }
}

/**
 * Enable/Disable Related products
 */
if ( get_theme_mod('product_related_products', 1) == 0 ) {
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
} else {
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
    add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
}

//Display related products based on the number of columns the page has
add_filter( 'woocommerce_output_related_products_args', 'gg_related_products' );
function gg_related_products() {
    $page_layout = get_theme_mod('product_page_layout', 'no_sidebar');
    switch ($page_layout) {
        case "with_right_sidebar":
        case "with_left_sidebar":
            $args = array('posts_per_page' => 3, 'columns' => 3,);
            break;
        case "no_sidebar":
            $args = array('posts_per_page' => 4, 'columns' => 4,);
            break;           
    }
    return $args;
}

/**
 * Enable/Disable Up Sells products
 */
if ( get_theme_mod('product_upsells_products', 1) == 0 ) {
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
} else {
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
    add_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
}

add_filter( 'woocommerce_upsell_display_args', 'gg_woocommerce_upsell_display_args' );

function gg_woocommerce_upsell_display_args( $args ) {
  $page_layout = get_theme_mod('product_page_layout', 'no_sidebar');
    switch ($page_layout) {
        case "with_right_sidebar":
        case "with_left_sidebar":
            $args = array('posts_per_page' => 3, 'columns' => 3,);
            break;
        case "no_sidebar":
            $args = array('posts_per_page' => 4, 'columns' => 4,);
            break;           
    }
    return $args;
}

// Display Cross Sells on 1 column instead of default
add_filter( 'woocommerce_cross_sells_columns', 'gg_cross_sells_columns' );
function gg_cross_sells_columns( $columns ) {
    return 1;
}
add_filter( 'woocommerce_cross_sells_total', 'gg_cross_sells_total' );
function gg_cross_sells_total( $posts_per_page ) {
    return 2;
}

// Remove WooCommerce Catalog Ordering Dropdown
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

/**
 * Enable/Disable Cross Sells products
 */
if ( get_theme_mod('product_crosssells_products' , 1) == 0) {
    remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
    //remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 20 );
}



/**
 * Catalog mode functions (must be always the last function)
 **/

if (get_theme_mod('store_catalog_mode' , 0) == 1) {
    // Remove add to cart button from the product loop
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart',10);
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

    // Remove add to cart button from the product details page
    remove_action( 'woocommerce_before_add_to_cart_form', 'woocommerce_template_single_product_add_to_cart', 10, 2);
     
    //disabled actions (add to cart, checkout and pay)
    remove_action( 'init', 'woocommerce_add_to_cart_action', 10);
    remove_action( 'init', 'woocommerce_checkout_action', 10 );
    remove_action( 'init', 'woocommerce_pay_action', 10 );

}

/* This snippet removes the action that inserts thumbnails to products in teh loop
 * and re-adds the function customized with our wrapper in it.
 * It applies to all archives with products.
 *
 * @original plugin: WooCommerce
 * @author of snippet: Brian Krogsard
 */
 
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
 
/**
 * WooCommerce Loop Product Thumbs
 **/
 
 if ( ! function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) {
 
    function woocommerce_template_loop_product_thumbnail() {
        echo woocommerce_get_product_thumbnail();
    } 
 }

/**
 * WooCommerce Breadcrubs
 **/

if ( version_compare( WOOCOMMERCE_VERSION, '2.3', '>=' ) ) {
    function gg_woocommerce_breadcrumbs() {
        return array(
                'delimiter'   => '<span class="delimiter"><i class="arrow_carrot-right"></i></span>',
                'wrap_before' => '<div class="gg-breadcrumbs"><i class="icon_house_alt"></i> ',
                'wrap_after'  => '</div>',
                'before'      => '',
                'after'       => '',
                'home'        => _x('Home', 'breadcrumb', 'woocommerce'),
            );
    }
} else {
    function gg_woocommerce_breadcrumbs() {
        return array(
                'delimiter'   => '<span class="delimiter"><i class="arrow_carrot-right"></i></span>',
                'wrap_before' => '<div class="gg-breadcrumbs"><i class="icon_house_alt"></i> ',
                'wrap_after'  => '</div>',
                'before'      => '',
                'after'       => '',
                'home'        => _x( '<span class="home"><i class="icon_house_alt"></i>  Home</span>', 'breadcrumb', 'woocommerce' ),
            );
    }
}
add_filter( 'woocommerce_breadcrumb_defaults', 'gg_woocommerce_breadcrumbs' );
 
 
/**
 * WooCommerce Product Thumbnail
 **/
 if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {
    
    function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
        global $post, $woocommerce;

            $shop_catalog   = wc_get_image_size( 'shop_catalog' );
            
            $output = '<div class="imagewrapper">';
            $output .= '<figure class="effect-sadie">';
 
            if ( has_post_thumbnail() ) {
                $thumbnail_id = get_post_thumbnail_id( $post->ID );
                $img_src = gg_aq_resize( get_post_thumbnail_id(), $shop_catalog['width'], $shop_catalog['height'], true, true );
                $output .= '<img src="'.esc_url($img_src).'" alt="'.get_the_title( $thumbnail_id ).'" />';
            }
            
            $output .= '<figcaption>';
            $output .= '<a class="link-wrapper" href="'.esc_url(get_permalink()).'"></a>';
            $output .= '<span class="woo-category-hover-icn"><i class="icon_cart"></i></span>';
            $output .= '</figcaption>';

            $output .= '</figure>';    
            $output .= '</div>';
            
            return $output;
    }
 }

 // Handle cart in header fragment for ajax add to cart
add_filter('add_to_cart_fragments', 'woocommerceframework_header_add_to_cart_fragment');
function woocommerceframework_header_add_to_cart_fragment( $fragments ) {
    ob_start();
    ?>

    <ul class="mini-cart">
        <li>
            <a href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'okthemes'); ?>" class="cart-parent">
                <i class="icon_cart_alt"></i>
                <span class="badge <?php if (WC()->cart->cart_contents_count == 0) echo 'gg-cart-empty'; ?>"><?php echo esc_html(WC()->cart->cart_contents_count); ?></span>
                <?php 
                if (WC()->cart->cart_contents_count > 0) {
                    echo WC()->cart->get_cart_total();
                } 
                ?>
            </a>
            <?php
    
            echo '<ul class="cart_list hidden-xs hidden-sm">';
               if (sizeof(WC()->cart->cart_contents)>0) : foreach (WC()->cart->cart_contents as $cart_item_key => $cart_item) :
                   $_product = $cart_item['data'];
                   if ($_product->exists() && $cart_item['quantity']>0) :
                        echo '<li class="cart_list_product"><a href="'.esc_url(get_permalink($cart_item['product_id'])).'">';
                       
                        if (has_post_thumbnail($cart_item['product_id'])) { 
                            $img_src = gg_aq_resize( get_post_thumbnail_id($cart_item['product_id']), 90, 90, true, true );
                            echo '<img src="'.esc_url($img_src).'" />';
                        }
                       
                       echo apply_filters('woocommerce_cart_widget_product_title', $_product->get_title(), $_product).'</a>';
                       
                       if($_product instanceof woocommerce_product_variation && is_array($cart_item['variation'])) :
                           echo woocommerce_get_formatted_variation( $cart_item['variation'] );
                         endif;
                       
                       echo '<span class="quantity">' .esc_html($cart_item['quantity']).' &times; '.woocommerce_price($_product->get_price()).'</span></li>';
                   endif;
               endforeach;
    
                else: echo '<li class="empty">'.esc_html__('No products in the cart.','okthemes').'</li>'; endif;
                if (sizeof(WC()->cart->cart_contents)>0) :
                echo '<li class="total"><strong>';
    
                if (get_option('js_prices_include_tax')=='yes') :
                    _e('Total', 'okthemes');
                else :
                    _e('Subtotal', 'okthemes');
                endif;

                echo ':</strong>'.WC()->cart->get_cart_total();'</li>';
    
                echo '<li class="buttons"><a href="'.esc_url(WC()->cart->get_cart_url()).'" class="minicart-btn">'.esc_html__('View Cart','okthemes').'</a> <a href="'.esc_url(WC()->cart->get_checkout_url()).'" class="minicart-btn checkout">'.esc_html__('Checkout','okthemes').'</a></li>';
            endif;
            
            echo '</ul>';
    
        ?>
        </li>
    </ul>
    <?php
    $fragments['ul.mini-cart'] = ob_get_clean();
    return $fragments;
}

/**
 * Minicart function
 **/
if (!function_exists('header_mini_cart')) { 
function header_mini_cart() { ?>
<div class="header_mini_cart cart-contents woocommerce">
<ul class="mini-cart">
    <li>
        <a href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'okthemes'); ?>" class="cart-parent">
            <i class="icon_cart_alt"></i>
            <span class="badge <?php if (WC()->cart->cart_contents_count == 0) echo 'gg-cart-empty'; ?>"><?php echo esc_html(WC()->cart->cart_contents_count); ?></span>
            <?php 
            if (WC()->cart->cart_contents_count > 0) {
                echo WC()->cart->get_cart_total();
            } 
            ?>
        </a>
        <?php
            
            echo '<ul class="cart_list hidden-xs hidden-sm">';
               if (sizeof(WC()->cart->cart_contents)>0) : foreach (WC()->cart->cart_contents as $cart_item_key => $cart_item) :
                   $_product = $cart_item['data'];
                   if ($_product->exists() && $cart_item['quantity']>0) :
                       echo '<li class="cart_list_product"><a href="'.esc_url(get_permalink($cart_item['product_id'])).'">';
                       
                       if (has_post_thumbnail($cart_item['product_id'])) { 
                            $img_src = gg_aq_resize( get_post_thumbnail_id($cart_item['product_id']), 90, 90, true, true );
                            echo '<img src="'.esc_url($img_src).'" />';
                        }
                       
                       echo apply_filters('woocommerce_cart_widget_product_title', $_product->get_title(), $_product).'</a>';
                       
                       if($_product instanceof woocommerce_product_variation && is_array($cart_item['variation'])) :
                           echo woocommerce_get_formatted_variation( $cart_item['variation'] );
                         endif;
                       
                       echo '<span class="quantity">' .esc_html($cart_item['quantity']).' &times; '.woocommerce_price($_product->get_price()).'</span></li>';
                   endif;
               endforeach;

                else: echo '<li class="empty">'.esc_html__('No products in the cart.','okthemes').'</li>'; endif;
                if (sizeof(WC()->cart->cart_contents)>0) :
                echo '<li class="total"><strong>';

                if (get_option('js_prices_include_tax')=='yes') :
                    _e('Total', 'okthemes');
                else :
                    _e('Subtotal', 'okthemes');
                endif;
                echo '</strong>'.WC()->cart->get_cart_total();'</li>';

                echo '<li class="buttons"><a href="'.esc_url(WC()->cart->get_cart_url()).'" class="minicart-btn">'.esc_html__('View Cart','okthemes').'</a> <a href="'.esc_url(WC()->cart->get_checkout_url()).'" class="minicart-btn checkout">'.esc_html__('Checkout','okthemes').'</a></li>';
            endif;
            echo '</ul>';
        ?>
    </li>
</ul>
</div>

<?php } 

}


/* Wishlist Yith */
if ( class_exists( 'YITH_WCWL_Init' ) ) { 
    if (get_theme_mod('store_add_to_wishlist', 1 ) == 1) { 

        function yit_change_wishlist_label() {
            return __( 'Add to Wishlist', 'okthemes' );
        }    

        function yit_change_browse_wishlist_label() {
            return __( 'View Wishlist', 'okthemes' );
        }

        add_filter( 'yith_wcwl_button_label', 'yit_change_wishlist_label' );
        add_filter( 'yith-wcwl-browse-wishlist-label', 'yit_change_browse_wishlist_label' );

        update_option( 'yith_wcwl_use_button', 'no' );
        update_option( 'yith_wcwl_button_position', 'shortcode' );
        update_option ('yith_wcwl_wishlist_title', '');

        update_option ('yith_wcwl_share_fb', '0');
        update_option ('yith_wcwl_share_twitter', '0');
        update_option ('yith_wcwl_share_pinterest', '0');
        update_option ('yith_wcwl_share_googleplus', '0');
        update_option ('yith_wcwl_share_email', '0');

        /* Extend Wishlist class to remove some things*/
        class GG_YITH extends YITH_WCWL_UI {

            public static function add_to_wishlist_button( $url, $product_type, $exists ) {
                global $yith_wcwl, $product;

                $label_option = get_option( 'yith_wcwl_add_to_wishlist_text' );
                $localize_label = function_exists( 'icl_translate' ) ? icl_translate( 'Plugins', 'plugin_yit_wishlist_button', $label_option ) : $label_option;

                $label = apply_filters( 'yith_wcwl_button_label', $localize_label );
                $icon = get_option( 'yith_wcwl_add_to_wishlist_icon' ) != 'none' ? '<i class="' . get_option( 'yith_wcwl_add_to_wishlist_icon' ) . '"></i>' : '';

                $classes = get_option( 'yith_wcwl_use_button' ) == 'yes' ? 'class="add_to_wishlist single_add_to_wishlist button alt"' : 'class="add_to_wishlist"';

                $html  = '<div class="yith-wcwl-add-to-wishlist">';
                $html .= '<div class="yith-wcwl-add-button';  // the class attribute is closed in the next row

                $html .= $exists ? ' hide" style="display:none;"' : ' show"';

                $html .= '><a href="' . esc_url( $yith_wcwl->get_addtowishlist_url() ) . '" data-product-id="' . $product->id . '" data-product-type="' . $product_type . '" ' . $classes . ' >' . $icon . $label . '</a>';
                $html .= '<img src="' . esc_url( get_template_directory_uri() . '/images/wpspin_light.gif' ) . '" class="ajax-loading" alt="Loading" width="16" height="16" style="visibility:hidden" />';
                $html .= '</div>';

                $html .= '<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><span class="feedback">' . __( 'Product added!','yit' ) . '</span> <a href="' . esc_url( $url ) . '">' . apply_filters( 'yith-wcwl-browse-wishlist-label', __( 'Browse Wishlist', 'yit' ) ) . '</a></div>';
                $html .= '<div class="yith-wcwl-wishlistexistsbrowse ' . ( $exists ? 'show' : 'hide' ) . '" style="display:' . ( $exists ? 'block' : 'none' ) . '"><span class="feedback">' . __( 'The product is already in the wishlist!', 'yit' ) . '</span> <a href="' . esc_url( $url ) . '">' . apply_filters( 'yith-wcwl-browse-wishlist-label', __( 'Browse Wishlist', 'yit' ) ) . '</a></div>';
                $html .= '<div style="clear:both"></div><div class="yith-wcwl-wishlistaddresponse"></div>';

                $html .= '</div>';
                $html .= '<div class="clear"></div>';

                return $html;
            }
        }
        /* End extend Wishlist class */

    }
}


/* Compare Yith */
if ( class_exists( 'YITH_Woocompare' ) ) { 
    if (get_theme_mod('store_add_to_compare', 1 ) == 1) {
        remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link' ), 20 );
        remove_action( 'woocommerce_single_product_summary', array( $yith_woocompare->obj, 'add_compare_link' ), 35 );
        update_option( 'yith_woocompare_is_button', 'link' );
    }
}


add_action( 'woocommerce_single_product_summary', 'add_wishlist_compare', 35 );
function add_wishlist_compare() { ?>

<div class="btn-group product-helpers">
    <?php if ( class_exists( 'YITH_WCWL_Init' ) ) { 
            if (get_theme_mod('store_add_to_wishlist', 1 ) == 1) { ?>
            <div class="btn-group">
                <span class="btn btn-default">
                    <?php 
                    global $yith_wcwl, $product;
                    echo GG_YITH::add_to_wishlist_button( $yith_wcwl->get_wishlist_url(), $product->product_type, $yith_wcwl->is_product_in_wishlist( $product->id ) ); ?>
                </span>
            </div>
    <?php } } ?>

    <?php if ( class_exists( 'YITH_Woocompare' ) ) { 
            if (get_theme_mod('store_add_to_compare', 1 ) == 1) { ?>
            <div class="btn-group">
                <span class="btn btn-default">
                    <?php echo do_shortcode('[yith_compare_button container="no"]'); ?>
                </span>
            </div>
    <?php } } ?>
</div>

<?php } ?>