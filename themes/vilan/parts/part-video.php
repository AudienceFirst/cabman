<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage vilan
 */
?>

<?php 
	$postid = $post->ID;
	$video = rwmb_meta( 'gg_post_format_video_embedded');
	$m4v = rwmb_meta( 'gg_post_format_video_m4v');
	$ogv = rwmb_meta( 'gg_post_format_video_ogv');
	$webmv = rwmb_meta( 'gg_post_format_video_webmv');
	$poster = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

	$content = get_the_content();

	wp_enqueue_script('jplayer');
	wp_enqueue_style('jplayer');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<script type="text/javascript">				
		jQuery(document).ready(function(){

			if(jQuery().jPlayer) {
				jQuery("#jquery_jplayer<?php if (is_single()) { echo '_single'; } echo $postid; ?>").jPlayer({
					ready: function () {
						jQuery(this).jPlayer("setMedia", {
							<?php if($m4v != '') : ?>
                            m4v: "<?php echo esc_url($m4v); ?>",
                            <?php endif; ?>
							<?php if($ogv != '') : ?>
                            ogv: "<?php echo esc_url($ogv); ?>",
                            <?php endif; ?>
                            <?php if($webmv != '') : ?>
                            webmv: "<?php echo esc_url($webmv); ?>",
                            <?php endif; ?>
							<?php if($poster != '') : ?>
                            poster: "<?php echo esc_url($poster); ?>"
                            <?php endif; ?>
						});
					},
					size: {
			          width: "100%",
			          height: "auto"
			        },
					swfPath: "<?php echo get_template_directory_uri(); ?>/files/jplayer",
					cssSelectorAncestor: "#jp_interface<?php echo $postid; ?>",
					supplied: "<?php if($ogv != '') : ?>ogv,<?php endif; ?><?php if($m4v != '') : ?>m4v,<?php endif; ?><?php if($webmv != '') : ?>webmv,<?php endif; ?>all",
					smoothPlayBar: true,
					keyEnabled: true,
					remainingDuration: true,
					toggleDuration: true,
					cssSelector: {
						videoPlay: '.jp-video-play'
					}
				});
			}
		});
    </script>

    <div id="jquery_jplayer<?php if (is_single()) { echo '_single'; } echo $postid; ?>" class="jp-jplayer jp-jplayer-video"></div>

    <div class="jp-video-container">
        <div class="jp-video">
            <div class="jp-type-single">

            <div class="jp-gui">

                <div id="jp_interface<?php echo $postid; ?>" class="jp-interface">

                <!--<div class="jp-video-play">
					<a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>
				</div> -->

                    <ul class="jp-controls">

                        <li><div class="seperator-first"></div></li>
                        <li><div class="seperator-second"></div></li>
                        <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                        <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                        <li><a href="#" class="jp-stop" tabindex="1">stop</a></li>
                        <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                        <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                    </ul>

                    <div class="jp-toggles-container">
	                    <ul class="jp-toggles">
							<li><a href="#" class="jp-full-screen" tabindex="1" title="full screen">full screen</a></li>
							<li><a href="#" class="jp-restore-screen" tabindex="1" title="restore screen">restore screen</a></li>
						</ul>
					</div>

                    <div class="jp-progress-container">
                    	<div class="jp-current-time"></div>
                        <div class="jp-progress">
                            <div class="jp-seek-bar">
                                <div class="jp-play-bar"></div>
                            </div>
                        </div>
						<div class="jp-duration"></div>
                    </div>

                    <div class="jp-volume-bar-container">
                        <div class="jp-volume-bar">
                            <div class="jp-volume-bar-value"></div>
                        </div>
                    </div>

                    

                </div>
            </div>    
            </div>
        </div>
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
