<?php
/**
 * The template for displaying posts in the Image post format
 *
 * @package WordPress
 * @subpackage vilan
 */
?>

<?php 
global $blog_img_width, $blog_img_height; 
if ( gg_is_in_vc() ) {
	$blog_img_width = '540';
	$blog_img_height = '360';
}
wp_enqueue_script('magnific');
wp_enqueue_style('magnific');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php 
	if ( has_post_thumbnail() && get_theme_mod('blog_inner_image', 1) == 1) {
		$thumbnail_id = get_post_thumbnail_id( $post->ID );
		$full_image_url = wp_get_attachment_image_src( $thumbnail_id, 'full' );
		$img_src = gg_aq_resize( $thumbnail_id, $blog_img_width, $blog_img_height, true, true );
	?>
	<figure class="effect-sadie">
		<img class="wp-post-image img-rounded" src="<?php echo esc_url($img_src); ?>" alt="<?php echo get_the_title( $thumbnail_id ); ?>" />
		<figcaption>
			<a class="lightbox-el link-wrapper" href="<?php echo esc_url($full_image_url['0']); ?>"></a>
        	<span class="portfolio-hover-icn"><i class="icon_zoom-in_alt"></i></span>
		</figcaption>
	</figure>
	<?php } ?>

	<?php if ( !gg_is_in_vc() ) : ?>
		<?php edit_post_link( __( 'Edit', 'okthemes' ), '<span class="edit-link">', '</span>' ); ?>
	<?php endif; ?>
</article><!-- #post -->
