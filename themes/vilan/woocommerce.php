<?php
/**
 * WooCommerce
 * Description: Page template with a content container and right sidebar.
 *
 * @package WordPress
 * @subpackage Vilan
 */
get_header(); ?>

<?php vilan_page_header_slider(); ?>

<?php

global $shop_page_id;

if ( is_singular( 'product' ) ) {
    $page_layout = get_theme_mod('product_page_layout', 'no_sidebar');
} else {
    $shop_page_id = woocommerce_get_page_id( 'shop' );
    $page_layout = rwmb_meta('gg_page_layout_select', '' ,$shop_page_id);
}

$page_content_class = 'col-xs-12 col-md-9';
$page_sidebar_class = 'col-xs-12 col-md-3';

switch ($page_layout) {
    case "with_right_sidebar":
        $page_content_class = 'col-xs-12 col-md-9 pull-left';
        $page_sidebar_class = 'col-xs-12 col-md-3 pull-right';
        break;
    case "with_left_sidebar":
        $page_content_class = 'col-xs-12 col-md-9 pull-right';
        $page_sidebar_class = 'col-xs-12 col-md-3 pull-left';
        break;
    case "no_sidebar":
        $page_content_class = 'col-xs-12 col-md-12';
        break;        
    case "fullscreen":
        $page_content_class = '';
        break;    
}

?>

<?php vilan_page_header(); ?>

<?php //vivido_page_header_slider(); ?>

<section id="content" <?php echo $page_layout == 'fullscreen' ? 'class="page-fullscreen"' : '' ;?>>
    <?php echo $page_layout == 'fullscreen' ? '' : '<div class="container"><div class="row">' ;?>


        <div class="<?php echo esc_attr($page_content_class); ?>">
            <?php woocommerce_content(); ?>
        </div><!-- /.col-9 col-sm-9 col-lg-9 -->

        <?php if (($page_layout !== 'no_sidebar') && ($page_layout !== 'fullscreen')) { ?>
        <div class="<?php echo esc_attr($page_sidebar_class); ?>">
            <aside class="sidebar-nav">
                <?php get_sidebar(); ?>
            </aside>
            <!--/aside .sidebar-nav -->
        </div><!-- /.col-3 col-sm-3 col-lg-3 -->
        <?php } ?>

    <?php echo $page_layout == 'fullscreen' ? '' : '</div></div>' ;?>
</section>

<?php gg_page_footer_message_box(); ?>
<?php get_footer(); ?>