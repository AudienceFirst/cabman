<?php

/**
 * Replies Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_replies_loop' ); ?>


<div class="topic-header clearfix">

<?php if (is_single()) { ?>
	<h1 class="topic-title"><?php the_title(); ?></h1>

	<?php if ( is_user_logged_in() ) { ?>
	<div class="topic-actions btn-group">
		<div class="btn-group">
			<span class="btn-default btn">
				<?php 
				
				$args = array (
				'subscribe'   => __( 'Subscribe',   'bbpress' ),
				'unsubscribe' => __( 'Unsubscribe', 'bbpress' ),
				'user_id'     => 0,
				'topic_id'    => 0,
				'before'      => '',
				'after'       => ''
				);
				bbp_user_subscribe_link( $args ); ?>
			</span>
		</div>

		<div class="btn-group">
			<span class="btn-default btn">
				<?php bbp_user_favorites_link(); ?>
			</span>
		</div>
	</div><!-- ."topic-actions -->
	<?php } ?>
	
	</div>
<?php } ?>

<ul id="topic-<?php bbp_topic_id(); ?>-replies" class="forums bbp-replies">


	<li class="bbp-body">

		<?php while ( bbp_replies() ) : bbp_the_reply(); ?>

			<?php bbp_get_template_part( 'loop', 'single-reply' ); ?>

		<?php endwhile; ?>

	</li><!-- .bbp-body -->

</ul><!-- #topic-<?php bbp_topic_id(); ?>-replies -->

<?php do_action( 'bbp_template_after_replies_loop' ); ?>
