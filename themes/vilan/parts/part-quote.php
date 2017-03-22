<?php
/**
 * The template for displaying posts in the Quote post format
 *
 * @package WordPress
 * @subpackage Vilan
 */
?>

<?php 
	$post_format_blockquote = rwmb_meta( 'gg_post_format_blockquote');
	$post_format_blockquote_author = rwmb_meta( 'gg_post_format_blockquote_author');

	$content = get_the_content();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="quote-container">
		<blockquote>
			<?php echo $post_format_blockquote; ?>
			<cite><?php echo $post_format_blockquote_author; ?></cite>
		</blockquote>
	</div>

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