<?php
/**
 * bbPress
 * Description: The Template for displaying all bbp forums, topics and single posts.
 *
 * @package WordPress
 * @subpackage vilan
 */
get_header(); ?>
<?php vilan_page_header_slider(); ?>

<?php
$page_layout = get_theme_mod('forum_page_layout', 'with_right_sidebar');

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

<?php $vc_is_active = get_post_meta( get_the_ID(), '_wpb_vc_js_status', true ); ?>

<?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>

    <?php if (( $vc_is_active === 'true' ) && ($page_layout == 'fullscreen')) : ?>

        <div id="content" <?php post_class( 'visual-composer-page' ); ?>>

            <?php the_content(); ?>

        </div>

    <?php else : ?>

    <section id="content">
        <div class="container">
            <div class="row">
                <div class="<?php echo esc_attr($page_content_class); ?>">
                    <?php get_template_part( 'parts/part', 'page' ); ?>
                    <?php comments_template( '', true ); ?>
                </div><!-- /.col-9 col-sm-9 col-lg-9 -->

                <?php if ($page_layout !== 'no_sidebar') { ?>
                <div class="<?php echo esc_attr($page_sidebar_class); ?>">
                    <aside class="sidebar-nav">
                        <?php get_sidebar(); ?>
                    </aside>
                    <!--/aside .sidebar-nav -->
                </div><!-- /.col-3 col-sm-3 col-lg-3 -->
                <?php } ?>
            </div>
        </div>    
    </section>

    <?php endif; ?>

<?php endwhile; endif; ?>

<?php gg_page_footer_message_box(); ?>
<?php get_footer(); ?>