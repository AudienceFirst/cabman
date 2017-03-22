<?php
/**
 * Description: Default Home template to display loop of blog posts
 *
 * @package WordPress
 * @subpackage vilan
 */
get_header(); ?>

<?php
global $blog_img_width, $blog_img_height;
//Get the ID of the page used for Blog posts
$page_id = ( 'page' == get_option( 'show_on_front' ) ? get_option( 'page_for_posts' ) : get_the_ID() );

$page_layout = rwmb_meta('gg_page_layout_select','',$page_id);
$page_heading_position = rwmb_meta('gg_page_heading_pos_select','',$page_id);

$page_content_class = 'col-xs-12 col-md-9';
$page_sidebar_class = 'col-xs-12 col-md-3';
$page_heading_position_align = 'text-align-left';

switch ($page_layout) {
    case "with_right_sidebar":
        $page_content_class = 'col-xs-12 col-md-9 pull-left';
        $page_sidebar_class = 'col-xs-12 col-md-3 pull-right';
        $blog_img_width = '850';
        $blog_img_height = '360';
        break;
    case "with_left_sidebar":
        $page_content_class = 'col-xs-12 col-md-9 pull-right';
        $page_sidebar_class = 'col-xs-12 col-md-3 pull-left';
        $blog_img_width = '850';
        $blog_img_height = '360';
        break;
    case "no_sidebar":
        $page_content_class = 'col-xs-12 col-md-12';
        $blog_img_width = '1140';
        $blog_img_height = '537';
        break;        
    case "fullscreen":
        $page_content_class = '';
        $blog_img_width = '';
        $blog_img_height = '537';
        break;    
}
?>

<?php vilan_page_header(); ?>

<?php vilan_page_header_slider(); ?>

<section id="content" <?php echo $page_layout == 'fullscreen' ? 'class="page-fullscreen"' : '' ;?>>
    <?php echo $page_layout == 'fullscreen' ? '' : '<div class="container"><div class="row">' ;?>

        <div class="<?php echo esc_attr($page_content_class); ?>">

        <?php if ( have_posts() ) : ?>

            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'parts/part', get_post_format() ); ?>
            <?php endwhile; ?>

            <?php if (function_exists("pagination")) {
                pagination($wp_query->max_num_pages);
            } ?>

        <?php else : ?>

            <?php get_template_part( 'parts/part', 'none' ); ?>

        <?php endif; // end have_posts() check ?>
        </div>

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