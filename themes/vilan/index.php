<?php
/**
 * Description: Default Index template to display loop of blog posts
 *
 * @package WordPress
 * @subpackage vilan
 */
get_header(); ?>
<?php vilan_page_header_slider(); ?>

<?php
global $blog_img_width, $blog_img_height;
$blog_img_width = '850';
$blog_img_height = '360';
?>

<section id="content">
<div class="container">

    <div class="row">

        <div class="col-xs-12 col-md-9">

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

        <div class="col-xs-12 col-md-3">
            <aside class="sidebar-nav">
                <?php get_sidebar(); ?>
            </aside>
        </div>

    </div><!-- /.row .content -->

</div><!--/.container -->    
</section>
<?php gg_page_footer_message_box(); ?>
<?php get_footer(); ?>