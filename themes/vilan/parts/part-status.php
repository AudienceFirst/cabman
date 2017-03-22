<?php
/**
 * The template for displaying posts in the Status post format
 *
 * @package WordPress
 * @subpackage vilan
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="article-wrapper">	
		<header class="entry-header">
			<div class="article-header-body media">
				<div class="avatar-icn pull-left">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'vilan_status_avatar', '60' ) ); ?>
				</div>
				<div class="media-body">
					<h2 class="entry-title">
						<?php the_author(); ?>
					</h2>
					<p class="meta"><?php echo vilan_posted_on();?></p>
				</div>
			</div>
		</header><!-- .entry-header -->

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

		<?php else : ?>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading', 'okthemes' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>

		<?php if ( !gg_is_in_vc() ) : ?>
		<footer class="entry-meta">
			<?php echo vilan_posted_in();?>
			<?php edit_post_link( __( 'Edit', 'okthemes' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
		<?php endif; ?>
	</div><!-- .article-wrapper -->
</article><!-- #post -->	
