<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'okthemes' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<?php if ( !is_search() ) : ?>
	<footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'okthemes' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
	<?php endif; ?>
</article><!-- #post -->