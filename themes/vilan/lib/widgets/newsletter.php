<?php
/**
 * Adds gg_Newsletter_Widget widget.
 */
class gg_Newsletter_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'gg_newsletter_widget', // Base ID
			__('Newsletter Widget', 'okthemes'), // Name
			array( 'description' => __( 'Display a styled newsletter form', 'okthemes' ), 'classname' => 'newsletter', ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$text = apply_filters( 'widget_text', $instance['text'] );

		echo $args['before_widget'];

		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		?>
		
		<div class="newsletter-box"><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>

		<?php
		echo $args['after_widget'];
	}
	

	/**
	 * Back-end widget form.
	 */
	public function form( $instance ) {
		
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Newsletter', 'okthemes' );
		}

		$text = esc_textarea($instance['text']);

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'okthemes'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
		</p>
		<?php 
	}


	/**
	 * Sanitize widget form values as they are saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed

		return $instance;
	}


} // class gg_Newsletter_Widget

// register gg_Newsletter_Widget 
function register_gg_newsletter_widget() {
    register_widget( 'gg_Newsletter_Widget' );
}
add_action( 'widgets_init', 'register_gg_newsletter_widget' );