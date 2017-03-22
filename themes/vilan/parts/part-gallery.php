<?php
/**
 * The template for displaying posts images in the Gallery post format
 *
 * @package WordPress
 * @subpackage vilan
 */
?>

<?php 
global $blog_img_width, $blog_img_height;
$content = get_the_content();
if ( gg_is_in_vc() ) {
	$blog_img_width = '540';
	$blog_img_height = '360';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		//Load carousel
		wp_enqueue_script('owlcarousel');
		
		wp_enqueue_script('magnific');
		wp_enqueue_style('magnific');

		$post_format_gallery_images = rwmb_meta( 'gg_post_format_gallery_images', 'type=image_advanced&size=full');
		?>

		<?php if($post_format_gallery_images){ ?>

		<div id="post-format-gallery-owl" class="owl-carousel" data-lazyload = "true" data-slides-per-view = "1" data-single-item = "true" data-transition-slide = "fade" data-navigation-owl = "false" data-pagination-owl = "true" data-autoplay = "false" data-rewind = "true" data-speed = "5000" data-height = "true">

			<?php foreach($post_format_gallery_images as $post_format_gallery_image){
			$image_url = aq_resize( $post_format_gallery_image['full_url'], $blog_img_width, $blog_img_height, true, true);	
			?>

			<figure class="effect-sadie">
				<img class="img-rounded lazyOwl" data-src="<?php echo esc_url($image_url); ?>" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr_e($post_format_gallery_image['alt']); ?>" />
				<figcaption>
					<a class="lightbox-el link-wrapper" href="<?php echo esc_url($post_format_gallery_image['full_url']); ?>"></a>
		        	<span class="portfolio-hover-icn"><i class="icon_zoom-in_alt"></i></span>
				</figcaption>
			</figure>

			<?php } ?>
		</div>

	<?php } ?>

	<div class="article-wrapper">
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


