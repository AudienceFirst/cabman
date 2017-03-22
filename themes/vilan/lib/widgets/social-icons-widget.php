<?php
/**
 * Adds gg_Social_Icons_Widget widget.
 */
class gg_Social_Icons_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'gg_social_icons_widget', // Base ID
			__('Social Icons Widget', 'okthemes'), // Name
			array( 'description' => __( 'Display a list of social icons', 'okthemes' ), 'classname' => 'social-icons', ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];

		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		?>
				
		<div class="social-icons-widget">
			<ul class="list-inline">
				<?php if(get_theme_mod('rss_link')): ?>
                <li><a class="symbol social-rss" title="roundedrss" href="<?php echo esc_url(get_theme_mod('rss_link')); ?>" target="_blank"></a></li>
                <?php endif; ?>
                <?php if(get_theme_mod('facebook_link')): ?>
                <li><a class="symbol social-facebook" title="roundedfacebook" href="<?php echo esc_url(get_theme_mod('facebook_link')); ?>" target="_blank"></a></li>
                <?php endif; ?>
                <?php if(get_theme_mod('twitter_link','okwpthemes')): ?>
                <li><a class="symbol social-twitter" title="roundedtwitter" href="<?php echo esc_url(get_theme_mod('twitter_link')); ?>" target="_blank"></a></li>
                <?php endif; ?>
                <?php if(get_theme_mod('skype_link')): ?>
                <li><a class="symbol social-skype" title="roundedskype" href="<?php echo esc_url(get_theme_mod('skype_link')); ?>" target="_blank"></a></li>
                <?php endif; ?>
                <?php if(get_theme_mod('vimeo_link')): ?>
                <li><a class="symbol social-vimeo" title="roundedvimeo" href="<?php echo esc_url(get_theme_mod('vimeo_link')); ?>" target="_blank"></a></li>
                <?php endif; ?>
                <?php if(get_theme_mod('linkedin_link')): ?>
                <li><a class="symbol social-linkedin" title="roundedlinkedin" href="<?php echo esc_url(get_theme_mod('linkedin_link')); ?>" target="_blank"></a></li>
                <?php endif; ?>
                <?php if(get_theme_mod('dribble_link')): ?>
                <li><a class="symbol social-dribble" title="roundeddribble" href="<?php echo esc_url(get_theme_mod('dribble_link')); ?>" target="_blank"></a></li>
                <?php endif; ?>
                <?php if(get_theme_mod('flickr_link')): ?>
                <li><a class="symbol social-flickr" title="roundedflickr" href="<?php echo esc_url(get_theme_mod('flickr_link')); ?>" target="_blank"></a></li>
                <?php endif; ?>
                <?php if(get_theme_mod('google_link')): ?>
                <li><a class="symbol social-google" title="roundedgoogleplus" href="<?php echo esc_url(get_theme_mod('google_link')); ?>" target="_blank"></a></li>
                <?php endif; ?>
                <?php if(get_theme_mod('youtube_link')): ?>
                <li><a class="symbol social-youtube" title="roundedyoutube" href="<?php echo esc_url(get_theme_mod('youtube_link')); ?>" target="_blank"></a></li>
                <?php endif; ?>
			</ul>
		
		<div class="clearfix"></div>
		</div>

		<?php
		echo $args['after_widget'];
	}
	

	/**
	 * Back-end widget form.
	 */
	public function form( $instance ) {
		
		$title = isset( $instance['title'] ) ? $instance['title'] : __( 'Contact us', 'okthemes' );

		?>
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'okthemes'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" class="widefat" />
		</p>
		
		<?php 
	}


	/**
	 * Sanitize widget form values as they are saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
		return $instance;
	}


} // class gg_Social_Icons_Widget

// register gg_Social_Icons_Widget 
function register_gg_social_icons_widget() {
    register_widget( 'gg_Social_Icons_Widget' );
}
add_action( 'widgets_init', 'register_gg_social_icons_widget' );