<?php
/**
 * The template for displaying Archive Portfolio pages.
 *
 * @package WordPress
 * @subpackage Vilan
 */
get_header(); ?>

<?php

//Load magnific 
wp_enqueue_script('magnific');
wp_enqueue_style('magnific');

//Load isotope 
wp_enqueue_style('theme-isotope');
wp_enqueue_script( 'theme-isotope' );

global $portfolio_img_width, $portfolio_img_height;//register global variable for use of portfolio style in template part


$archive_portfolio_inner_layout = get_theme_mod('archive_portfolio_page_style','right');
switch ($archive_portfolio_inner_layout) {
    case "left":
        $archive_portfolio_content_class = 'col-xs-12 col-md-9 pull-right';
        $archive_portfolio_sidebar_class = 'col-xs-12 col-md-3 pull-left';
        break;
    case "right":
        $archive_portfolio_content_class = 'col-xs-12 col-md-9 pull-left';
        $archive_portfolio_sidebar_class = 'col-xs-12 col-md-3 pull-right';
        break;
    case "fullwidth":
        $archive_portfolio_content_class = 'col-xs-12 col-md-12';
        $archive_portfolio_sidebar_class = 'col-xs-12 col-md-12';
        break;        
}

$archive_portfolio_page_columns = get_theme_mod('archive_portfolio_page_columns','four_columns');
switch ($archive_portfolio_page_columns) {
    case "four_columns":
        $archive_portfolio_col_class = 'col-xs-6 col-md-3';
        $portfolio_img_width = '263';
        $portfolio_img_height= '293';
        break;
    case "three_columns":
        $archive_portfolio_col_class = 'col-xs-12 col-md-4';
        $portfolio_img_width = '360';
        $portfolio_img_height= '390';
        break;
    case "two_columns":
        $archive_portfolio_col_class = 'col-xs-12 col-md-6';
        $portfolio_img_width = '555';
        $portfolio_img_height= '585';
        break;           
}

?>

<?php vilan_page_header(); ?>

    <?php if (have_posts()) :
    // Queue the first post.
    the_post(); ?>

     <section id="content">
        <div class="container">
            <div class="row">
                <div class="<?php echo esc_attr($archive_portfolio_content_class); ?>">
                    <?php
                    // Rewind the loop back
                        rewind_posts();
                    ?>

                    <div class="row gg_posts_grid">
                        <ul class="image-grid" data-layout-mode="fitRows" data-gap="gap">

                        <?php while (have_posts()) : the_post(); ?>
                            <li class="<?php echo esc_attr($archive_portfolio_col_class); ?>" >
                                <?php get_template_part( 'parts/part','portfolio' ); ?>
                            </li><!-- // portfolio item column -->
                        <?php endwhile; ?>

                        </ul>
                    </div>

                    <?php if (function_exists("pagination")) {
                        pagination($wp_query->max_num_pages);
                    } ?>

                    <?php endif; ?>
                </div>
        
                <?php if ($archive_portfolio_inner_layout !== 'fullwidth') { ?>
                <div class="<?php echo esc_attr($archive_portfolio_sidebar_class); ?>">
                    <aside class="sidebar-nav">
                        <?php get_sidebar(); ?>
                    </aside>
                    <!--/aside .sidebar-nav -->
                </div>
                <?php } ?>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /#content -->
<?php get_footer(); ?>