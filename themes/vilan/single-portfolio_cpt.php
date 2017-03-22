<?php
/**
 * Default Portfolio Post Template
 * Description: Post template with a content container and right sidebar.
 *
 * @package WordPress
 * @subpackage vilan
 */
get_header(); ?>

<?php while (have_posts()) : the_post(); 
$port_item_short_desc = rwmb_meta('gg_port_item_short_desc');
$port_post_meta_details_date = rwmb_meta('gg_port_post_meta_details_date');
$port_post_meta_details_client = rwmb_meta('gg_port_post_meta_details_client');
$port_post_meta_details_skills = rwmb_meta('gg_port_post_meta_details_skills');

$port_post_e_d_meta = rwmb_meta( 'gg_port_post_e_d_meta');
?>

<?php vilan_page_header(); ?>

<section id="content">
    <div class="container">
        <div class="row">

            <?php get_template_part( 'parts/part', 'singleportfolio' ); ?>
            
            <?php endwhile; // end of the loop. ?>
                
        </div><!-- /.row .content -->

    </div><!--/.container -->

</section>

<?php get_template_part( 'parts/part', 'portfoliorelated' ); ?>

<?php gg_page_footer_message_box(); ?>
<?php get_footer(); ?>