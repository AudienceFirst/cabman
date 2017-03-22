<?php
/**
 * The template for displaying posts in the Link post format
 *
 * @package WordPress
 * @subpackage Vilan
 */
?>
	<?php $post_format_link_url = rwmb_meta( 'gg_post_format_link_url'); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header media">
			<span class="post-format-icn pull-left"><i class="icon_link"></i></span>
			<div class="article-header-body media-body">
				<h2 class="entry-title">
					<a href="<?php echo esc_url($post_format_link_url); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'okthemes' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
			</div>
		</header>

		<?php if ( !gg_is_in_vc() ) : ?>
		<?php edit_post_link( __( 'Edit', 'okthemes' ), '<span class="edit-link">', '</span>' ); ?>
		<?php endif; ?>

	</article><!-- #post -->
