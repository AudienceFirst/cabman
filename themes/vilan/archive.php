<?php
/**
 * The template for displaying Archive pages.
 *
 * @package WordPress
 * @subpackage vilan
 */
get_header(); ?>

<?php

global $blog_img_width, $blog_img_height;

$archive_inner_layout = get_theme_mod('archive_page_style','right');
switch ($archive_inner_layout) {
    case "left":
        $archive_content_class = 'col-xs-12 col-md-9 pull-right';
        $archive_sidebar_class = 'col-xs-12 col-md-3 pull-left';
        $blog_img_width = '850';
        $blog_img_height = '360';
        break;
    case "right":
        $archive_content_class = 'col-xs-12 col-md-9 pull-left';
        $archive_sidebar_class = 'col-xs-12 col-md-3 pull-right';
        $blog_img_width = '850';
        $blog_img_height = '360';
        break;
    case "fullwidth":
        $archive_content_class = 'col-xs-12 col-md-12';
        $archive_sidebar_class = 'col-xs-12 col-md-12';
        $blog_img_width = '1140';
        $blog_img_height = '537';
        break;        
}

?>

    <?php if (have_posts()) :
    // Queue the first post.
    the_post(); ?>

    <section id="subheader">
        <div class="container">
            <div class="row">

                <div class="col-xs-9 col-sm-9 col-md-9">
                    <header class="page-title">
                        <h1><?php
                            if (is_day()) {
                                printf(__('Daily Archives: %s', 'okthemes'), '<span>' . get_the_date() . '</span>');
                            } elseif (is_month()) {
                                printf(
                                    __('Monthly Archives: %s', 'okthemes'),
                                    '<span>' . get_the_date(_x('F Y', 'monthly archives date format', 'okthemes')) . '</span>'
                                );
                            } elseif (is_year()) {
                                printf(
                                    __('Yearly Archives: %s', 'okthemes'),
                                    '<span>' . get_the_date(_x('Y', 'yearly archives date format', 'okthemes')) . '</span>'
                                );
                            } elseif (is_tag()) {
                                printf(__('Tag Archives: %s', 'okthemes'), '<span>' . single_tag_title('', false) . '</span>');
                                // Show an optional tag description
                                $tag_description = tag_description();
                                if ($tag_description) {
                                    echo apply_filters(
                                        'tag_archive_meta',
                                        '<div class="tag-archive-meta">' . $tag_description . '</div>'
                                    );
                                }
                            } elseif (is_category()) {
                                printf(
                                    __('Category Archives: %s', 'okthemes'),
                                    '<span>' . single_cat_title('', false) . '</span>'
                                );
                                // Show an optional category description
                                $category_description = category_description();
                                if ($category_description) {
                                    echo apply_filters(
                                        'category_archive_meta',
                                        '<div class="category-archive-meta">' . $category_description . '</div>'
                                    );
                                }
                            } else {
                                _e('Blog Archives', 'okthemes');
                            }
                            ?></h1>
                    </header>

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

                <div class="<?php echo esc_attr($archive_content_class); ?>">
                    <?php
                    // Rewind the loop back
                        rewind_posts();
                    ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part( 'parts/part', get_post_format() ); ?>
                    <?php endwhile; ?>

                    <?php if (function_exists("pagination")) {
                        pagination($wp_query->max_num_pages);
                    } ?>
                <?php endif; ?>
                </div>
                
                <?php if ($archive_inner_layout !='fullwidth') { ?>
                <div class="<?php echo esc_attr($archive_sidebar_class); ?>">
                    <aside class="sidebar-nav">
                        <?php get_sidebar(); ?>
                    </aside>
                    <!--/aside .sidebar-nav -->
                </div><!-- /.col-3 col-sm-3 col-lg-3 -->
                <?php } ?>

            </div><!-- /.row -->
        </div><!-- /.row .container -->
    </section>
<?php get_footer(); ?>