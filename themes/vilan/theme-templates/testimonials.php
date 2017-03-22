<?php
/**
 * Template Name: Testimonials page
 *
 * @package WordPress
 * @subpackage vilan
 */
get_header(); ?>

<?php
//testimonials Page Layout 
global $testimonials_style, $testimonials_img_width, $testimonials_img_height;//register global variable for use of testimonials style in template part

$page_layout = rwmb_meta('gg_page_layout_select');
$grid_layout_mode = rwmb_meta('gg_grid_layout_mode');
$grid_layout_style = rwmb_meta('gg_grid_layout_style');
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

//testimonials Post Layout
$testimonials_col_class = 'col-xs-12 col-sm-6 col-md-3';
$testimonials_col_select = rwmb_meta('gg_testimonials_col_select');
$testimonials_no_posts = rwmb_meta('gg_testimonials_no_posts');

//Apply columns class based on column selection 
switch ($testimonials_col_select) {
    case "three_columns":
        $testimonials_col_class = 'col-xs-6 col-md-4';
        break;
    case "two_columns":
        $testimonials_col_class = 'col-xs-6 col-md-6';
        break;
    case "one_column":
        $testimonials_col_class = 'col-xs-12 col-md-12';
        break;            
}

//Add 30px to the images for nogap mode 
if ($grid_layout_style == 'nogap') {
    $is_unlimited = 'nogap-cols';
}

if ( $grid_layout_mode == 'fitRows' || $grid_layout_mode == 'masonry') {
    //Enqueue isotope
    wp_enqueue_style('theme-isotope');
    wp_enqueue_script( 'theme-isotope' );
} 

?>

<?php vilan_page_header(); ?>

<?php //gg_page_header_slider(); ?>

<section id="content" class="<?php echo esc_attr($class_html); ?>">
    <?php if ($page_layout != 'fullscreen') echo '<div class="container"><div class="row">'; ?>

        <div class="<?php echo esc_attr($page_content_class); ?>">
        <!-- Begin testimonials posts -->
        <?php

            $paged = get_query_var('paged') ? get_query_var('paged') : 1;

            // WP_Query arguments
            $args = array (
                'post_type'              => 'testimonials_cpt',
                'posts_per_page'         => $testimonials_no_posts, 
                'ignore_sticky_posts'    => true,
                'paged'                  => $paged,
            );

            // The Query
            $testimonials_query = new WP_Query( $args );

            // The Loop
            if ( $testimonials_query->have_posts() ) { ?>
            <!-- Verify row class for isotope -->
            <div class="row gg_posts_grid">

            <ul class="testimonials-grid <?php echo esc_attr($is_unlimited); ?>" data-layout-mode="<?php echo esc_attr($grid_layout_mode); ?>" data-gap="<?php echo esc_attr($grid_layout_style); ?>">

                <?php while ( $testimonials_query->have_posts() ) : $testimonials_query->the_post(); ?>

                    <li class="<?php echo esc_attr($testimonials_col_class); ?> isotope-item" >
                        <?php get_template_part( 'parts/part','testimonials' ); ?>
                    </li><!-- // testimonials item column -->

                <?php endwhile; ?>
            </ul>    

            <?php } else { ?>

                <div class="no-posts-created"> 
                    <h3><?php _e( 'Not Found', 'okthemes' ); ?></h3>  
                    <p><?php _e( 'Sorry, No testimonials posts created yet.', 'okthemes' ); ?></p>  
                </div>
                
            <?php } ?>

            <?php if (function_exists("pagination")) {pagination($testimonials_query->max_num_pages);} ?>

            <?php 
            // Restore original Post Data    
            wp_reset_postdata();
            ?>
            </div> 

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