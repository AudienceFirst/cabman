<?php
/**
 * Template Name: Portfolio page
 *
 * @package WordPress
 * @subpackage vilan
 */
get_header(); ?>

<?php
//Portfolio Page Layout 
global $portfolio_style, $portfolio_img_width, $portfolio_img_height, $disable_image_resize;//register global variable for use of portfolio style in template part

$portfolio_style = rwmb_meta('gg_portfolio_posts_style');
$page_layout = rwmb_meta('gg_page_layout_select');
$grid_layout_mode = rwmb_meta('gg_portfolio_grid_layout_mode');
$grid_layout_style = rwmb_meta('gg_portfolio_grid_layout_style');
$page_content_class = 'col-xs-12 col-md-9';
$page_sidebar_class = 'col-xs-12 col-md-3';
$page_layout_width = 'sidebar';
$is_unlimited = '';
$class_html = '';

if ($page_layout == 'with_right_sidebar') {

    $page_content_class = 'col-xs-12 col-md-9 pull-left';
    $page_sidebar_class = 'col-xs-12 col-md-3 pull-right';
    $page_layout_width = 'sidebar';

} elseif ($page_layout == 'with_left_sidebar') {

    $page_content_class = 'col-xs-12 col-md-9 pull-right';
    $page_sidebar_class = 'col-xs-12 col-md-3 pull-left';
    $page_layout_width = 'sidebar';

} elseif ($page_layout == 'no_sidebar') {

    $page_content_class = 'col-xs-12 col-md-12';
    $page_layout_width = 'fullwidth';

} elseif ($page_layout == 'fullscreen') {

    $page_content_class = 'page-fullscreen';
    $class_html = 'page-fullscreen';
} 

//Portfolio Post Layout
$portfolio_cat_filter = rwmb_meta('gg_portfolio_cat_filter');
$disable_image_resize = rwmb_meta('gg_disable_image_resize');
$portfolio_col_class = 'col-xs-12 col-sm-6 col-md-3';
$portfolio_col_select = rwmb_meta('gg_portfolio_col_select');
$portfolio_no_posts = rwmb_meta('gg_portfolio_no_posts');
$terms = rwmb_meta( 'gg_portfolio_tax', 'type=taxonomy&taxonomy=portfolio_category' );

//Verify if a term is selected in the backend and get the slug
if (!empty($terms)) {
    $term_slug = $terms[0]->slug;
} else {
    $term_slug = '';
}

//Apply columns class based on column selection 
switch ($portfolio_col_select) {
    case "four_columns":
        $portfolio_col_class = 'col-xs-6 col-md-3';
        $portfolio_img_width = '263';
        $portfolio_img_height= '293';
        $carousel_column= '4';
        break;
    case "three_columns":
        $portfolio_col_class = 'col-xs-6 col-md-4';
        $portfolio_img_width = '360';
        $portfolio_img_height= '390';
        $carousel_column= '3';
        break;
    case "two_columns":
        $portfolio_col_class = 'col-xs-6 col-md-6';
        $portfolio_img_width = '555';
        $portfolio_img_height= '585';
        $carousel_column= '2';
        break;        
}

//Add 30px to the images for nogap mode 
if ($grid_layout_style == 'nogap') {
    $is_unlimited = 'nogap-cols';
    $portfolio_img_width = $portfolio_img_width + 30;
}

//If masonry do not calculate height on images 
if ($grid_layout_mode == 'masonry') {
    $portfolio_img_height = false;
}

if ( $grid_layout_mode == 'fitRows' || $grid_layout_mode == 'masonry') {
    //Enqueue isotope
    wp_enqueue_style('theme-isotope');
    wp_enqueue_script( 'theme-isotope' );
} 

?>

<?php vilan_page_header(); ?>


<section id="content" class="<?php echo esc_attr($class_html); ?>">
    <?php if ($page_layout != 'fullscreen') echo '<div class="container"><div class="row">'; ?>

        <div class="<?php echo esc_attr($page_content_class); ?>">
        <!-- Begin portfolio posts -->
        <?php
            //Load magnific 
            wp_enqueue_script('magnific');
            wp_enqueue_style('magnific');

            $paged = get_query_var('paged') ? get_query_var('paged') : 1;

            // WP_Query arguments
            $args = array (
                'post_type'              => 'portfolio_cpt',
                'portfolio_category'     => $term_slug,
                'taxonomy'               => 'portfolio_category',
                'posts_per_page'         => $portfolio_no_posts, 
                'ignore_sticky_posts'    => true,
                'paged'                  => $paged,
            );

            // The Query
            $portfolio_query = new WP_Query( $args );

            // The Loop
            if ( $portfolio_query->have_posts() ) { ?>
            <!-- Verify row class for isotope -->
            <div class="row gg_posts_grid">

            <?php if (($portfolio_cat_filter == '1') && (empty($terms))) { ?>    
            <ul class="categories_filter clearfix nav nav-pills">
                <li class="active"><a href="#" data-filter="*"><?php echo esc_attr__("All", "okthemes"); ?></a></li>

                <?php
                $terms = get_terms('portfolio_category');
                foreach ( $terms as $term ) {
                    echo '<li><a data-filter=".grid-cat-'.esc_attr($term->slug).'">' . esc_attr($term->name) . ' </a></li>';
                }
                ?>
            </ul>
            <?php } ?>

            <ul class="image-grid <?php echo esc_attr($is_unlimited); ?>" data-layout-mode="<?php echo esc_attr($grid_layout_mode); ?>" data-gap="<?php echo esc_attr($grid_layout_style); ?>">

                <?php while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post(); ?>

                    <li class="<?php echo esc_attr($portfolio_col_class); ?> isotope-item <?php echo esc_attr(gg_tax_terms_slug('portfolio_category')); ?>" >
                        <?php get_template_part( 'parts/part','portfolio' ); ?>
                    </li><!-- // portfolio item column -->

                <?php endwhile; ?>
            </ul>
            </div>    

            <?php } else { ?>

                <div class="no-posts-created"> 
                    <h3><?php _e( 'Not Found', 'okthemes' ); ?></h3>  
                    <p><?php _e( 'Sorry, No portfolio posts created yet.', 'okthemes' ); ?></p>  
                </div>
                
            <?php } ?>

            <?php if (function_exists("pagination")) {pagination($portfolio_query->max_num_pages);} ?>

            <?php 
            // Restore original Post Data    
            wp_reset_postdata();
            ?> 

        </div><!-- /.col-8 col-sm-8 col-lg-8 -->

        <?php if (($page_layout !== 'no_sidebar') && ($page_layout !== 'fullscreen')) { ?>
        <div class="<?php echo esc_attr($page_sidebar_class); ?>">
            <aside class="sidebar-nav">
                <?php get_sidebar(); ?>
            </aside>
            <!--/aside .sidebar-nav -->
        </div><!-- /.col-4 col-sm-4 col-lg-4 -->
        <?php } ?>

    <?php if ($page_layout != 'fullscreen') echo '</div></div>'; ?>   
</section>

<?php gg_page_footer_message_box(); ?>
<?php get_footer(); ?>