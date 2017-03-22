<?php
/**
 * Default Post Template
 * Description: Post template with a content container and right sidebar.
 *
 * @package WordPress
 * @subpackage vilan
 */
get_header(); ?>

<?php
global $blog_img_width, $blog_img_height;
$blog_inner_layout = get_theme_mod('blog_inner_page_style', 'right');
$blog_share_box = get_theme_mod('blog_share_box', 1);

switch ($blog_inner_layout) {
    case "left":
        $blog_content_class = 'col-xs-12 col-md-9 pull-right';
        $blog_sidebar_class = 'col-xs-12 col-md-3 pull-left';
        $blog_img_width = '850';
        $blog_img_height = '360';
        break;
    case "right":
        $blog_content_class = 'col-xs-12 col-md-9 pull-left';
        $blog_sidebar_class = 'col-xs-12 col-md-3 pull-right';
        $blog_img_width = '850';
        $blog_img_height = '360';
        break;
    case "fullwidth":
        $blog_content_class = 'col-xs-12 col-md-12';
        $blog_sidebar_class = 'col-xs-12 col-md-12';
        $blog_img_width = '1130';
        $blog_img_height = '537';
        break;        
}

?>

<?php while (have_posts()) : the_post(); ?>

<?php vilan_page_header(); ?>

<section id="content">
    <div class="container">
        <div class="row">
            <div class="<?php echo esc_attr($blog_content_class); ?>">

                <?php get_template_part( 'parts/part', get_post_format() ); ?>
                
                <?php endwhile; // end of the loop. ?>
                
                <?php if ($blog_share_box == 1) { 
                    get_template_part( 'parts/part', 'socialshare' );
                } ?>

                <?php comments_template( '', true ); ?>

            </div><!-- /.col-9 col-sm-9 col-lg-9 -->

            <?php if ($blog_inner_layout !='fullwidth') { ?>
            <div class="<?php echo esc_attr($blog_sidebar_class); ?>">
                <aside class="sidebar-nav">
                    <?php get_sidebar(); ?>
                </aside>
                <!--/aside .sidebar-nav -->
            </div><!-- /.col-3 col-sm-3 col-lg-3 -->
            <?php } ?>

        </div><!-- /.row -->

    </div><!--/.container -->    
</section>

<?php gg_page_footer_message_box(); ?>
<?php get_footer(); ?>