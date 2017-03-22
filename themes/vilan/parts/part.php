<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage vilan
 */
?>

<?php 
global $blog_img_width, $blog_img_height;
$content = get_the_content();
$has_pt = ''; 
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
		$has_pt = 'has-post-thumbnail';
	?>
	<figure class="effect-sadie">
		<img class="wp-post-image" src="<?php echo esc_url($img_src); ?>" alt="<?php echo get_the_title( $thumbnail_id ); ?>" />
		<figcaption>
			<a class="lightbox-el link-wrapper" href="<?php echo esc_url($full_image_url['0']); ?>"></a>
        	<span class="portfolio-hover-icn"><i class="icon_zoom-in_alt"></i></span>
		</figcaption>
	</figure>
	<?php } ?>

	<div class="article-wrapper <?php echo $has_pt; ?>">
		<header class="entry-header">
			<div class="article-header-body <?php if(trim($content) == "") echo 'no-border'; ?>">
				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'okthemes' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
				<p class="meta"><?php echo vilan_posted_on();?></p>
			</div>
		</header><!-- .entry-header -->

		<?php if ( is_search() ) : ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

		<?php elseif ( gg_is_in_vc() ) : ?>
			<!-- do not display anything -->
		<?php else : ?>
			<?php if(trim($content) != "") : ?>
				<div class="entry-content">
					<?php the_content( __( 'Continue reading', 'okthemes' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'okthemes' ), 'after' => '</div>' ) ); ?>
				</div><!-- .entry-content -->
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( !gg_is_in_vc() ) : ?>
		<footer class="entry-meta">
			<?php echo vilan_posted_in();?>
			<?php edit_post_link( __( 'Edit', 'okthemes' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
		<?php endif; ?>
	</div><!-- .article-wrapper -->
</article><!-- #post -->
