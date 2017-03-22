<?php
/**
 * Search Results Template
 *
 * @package WordPress
 * @subpackage vilan
 */
get_header(); ?>

<?php
global $blog_img_width, $blog_img_height;
$search_inner_layout = get_theme_mod('search_page_style','right');
switch ($search_inner_layout) {
    case "left":
        $search_content_class = 'col-xs-12 col-md-9 pull-right';
        $search_sidebar_class = 'col-xs-12 col-md-3 pull-left';
        $blog_img_width = '850';
        $blog_img_height = '360';
        break;
    case "right":
        $search_content_class = 'col-xs-12 col-md-9 pull-left';
        $search_sidebar_class = 'col-xs-12 col-md-3 pull-right';
        $blog_img_width = '850';
        $blog_img_height = '360';
        break;
    case "fullwidth":
        $search_content_class = 'col-xs-12 col-md-12';
        $blog_img_width = '1140';
        $blog_img_height = '547';
        break;        
}

?>

<section id="subheader">
    <div class="container">
        <div class="row">

            <div class="col-xs-9 col-sm-9 col-md-9">
                <?php if (have_posts()) : ?>
                <header class="page-title">
                    <h1><?php printf( __('Search Results for: %s', 'okthemes'),'<span>' . get_search_query() . '</span>'); ?></h1>
                </header>
                <?php else: ?>
                <header class="page-title">
                    <h1><?php _e( 'Nothing Found', 'okthemes' ); ?></h1>
                </header>    
                <?php endif; ?>

                <?php if (function_exists('gg_breadcrumbs')) {
                    gg_breadcrumbs();
                } ?>
            </div><!--/.col-9 col-sm-9 col-lg-9 -->

            <div class="col-xs-3 col-sm-3 col-md-3">
                <!-- Begin social-media -->
                    <?php include PARENT_DIR . '/lib/headers/social-media.php';?>    
                <!-- End social-media -->
            </div><!--/.col-3 col-sm-3 col-lg-3 -->

        </div><!--/.row -->
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="row">

        <div class="<?php echo esc_attr($search_content_class); ?>">

    		<?php if( 'product' == get_post_type() ) echo '<div class="row"><div class="woocommerce"><ul class="products">'; ?>

            <?php while ( have_posts() ) : the_post(); ?>

                <?php if( 'product' == get_post_type() ): ?>      
                    <?php wc_get_template_part( 'content', 'product' ); ?>
                <?php // for any other post type ?>
                <?php else : ?>
                    <?php get_template_part( 'parts/part', get_post_format() ); ?>      
                <?php endif; ?>
                
            <?php endwhile; ?>

            <?php if( 'product' == get_post_type() ) echo '</ul></div></div>'; ?>

            <?php if (!have_posts()) : ?>

                <article id="post-0" class="post no-results not-found">
                <div class="article-wrapper">
                    <header class="entry-header">
                        <div class="article-header-body">
                            <h2 class="entry-title">
                                <?php _e( 'Nothing Found', 'okthemes' ); ?>
                            </h2>
                        </div>
                    </header><!-- .entry-header -->
                    <div class="entry-content">
                            <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'okthemes' ); ?></p>
                            <?php get_search_form(); ?>
                    </div><!-- .entry-content -->
                </div>
                </article><!-- #post-0 -->

            <?php endif; ?>

             <?php if (function_exists("pagination")) {
                pagination($wp_query->max_num_pages);
            } ?>

        </div>

        <?php if ($search_inner_layout !='fullwidth') { ?>
        <div class="<?php echo esc_attr($search_sidebar_class); ?>">
            <aside class="sidebar-nav search">
                <?php get_sidebar(); ?>
            </aside>
            <!--/aside .sidebar-nav -->
        </div><!-- /.col-4 col-sm-4 col-lg-4 -->
        <?php } ?>

    </div><!-- /.row .content -->

</div><!--/.container -->    
</section>

<?php get_footer(); ?>