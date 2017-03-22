<?php
/**
 * Adds gg_Contact_Widget widget.
 */
class gg_Contact_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'gg_contact_widget', // Base ID
			__('Contact Widget', 'okthemes'), // Name
			array( 'description' => __( 'Contact us Widget', 'okthemes' ), 'classname' => 'contact', ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$address = ! empty( $instance['address'] ) ? $instance['address'] : '';
		$address_directions = ! empty( $instance['address_directions'] ) ? $instance['address_directions'] : '';
		$phone = ! empty( $instance['phone'] ) ? $instance['phone'] : '';
		$fax = ! empty( $instance['fax'] ) ? $instance['fax'] : '';
		$email = ! empty( $instance['email'] ) ? $instance['email'] : '';
		$skype = ! empty( $instance['skype'] ) ? $instance['skype'] : '';
		$call_area_title = ! empty( $instance['call_area_title'] ) ? $instance['call_area_title'] : '';
		$write_area_title = ! empty( $instance['write_area_title'] ) ? $instance['write_area_title'] : '';
		$address_area_title = ! empty( $instance['address_area_title'] ) ? $instance['address_area_title'] : '';

		echo $args['before_widget'];

		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		echo '<div class="call-area">';
			if ( $call_area_title )
				echo '<h5>'.$call_area_title.' </h5>';
			if ( $phone )
				echo '<p class="call-area-phone"><i class="icon_phone"></i>'.$phone.' </p>';
			if ( $fax )
				echo '<p class="call-area-fax"><i class="icon_printer-alt"></i>'.$fax.' </p>';
		echo '</div>';

		echo '<div class="write-area">';
			if ( $write_area_title )
				echo '<h5>'.$write_area_title.' </h5>';
			if ( $email )
				echo '<p class="write-area-email"><i class="icon_mail_alt"></i><a href="mailto:'.antispambot($email,1).'">'.antispambot($email).'</a></p>';
			if ( $skype )
				echo '<p class="write-area-skype"><i class="social_skype"></i><a href="skype:'.$skype.'?chat">'.$skype.'</a></p>';
		echo '</div>';

		echo '<div class="address-area">';
			if ( $address_area_title )
				echo '<h5>'.$address_area_title.' </h5>';
			if ( $address )
				echo '<p class="address-area-address"><i class="icon_pin_alt"></i>'.$address.' </p>';
				if ( $address_directions )
				echo '<p class="address-get-directions"><a class="btn btn-default" href="//www.google.com/maps/dir/Current+Location/'.$address_directions.'">' . __('Get directions') . '</a></p>';
		echo '</div>';

		echo $args['after_widget'];
	}
	

	/**
	 * Back-end widget form.
	 */
	public function form( $instance ) {
		
		$title     			= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$address     		= isset( $instance['address'] ) ? esc_textarea( $instance['address'] ) : '';

		$call_area_title	= isset( $instance['call_area_title'] ) ? esc_attr( $instance['call_area_title'] ) : '';
		$write_area_title	= isset( $instance['write_area_title'] ) ? esc_attr( $instance['write_area_title'] ) : '';
		$address_area_title	= isset( $instance['address_area_title'] ) ? esc_attr( $instance['address_area_title'] ) : '';

		$phone				= isset( $instance['phone'] ) ? esc_attr( $instance['phone'] ) : '';
		$fax				= isset( $instance['fax'] ) ? esc_attr( $instance['fax'] ) : '';
		$email				= isset( $instance['email'] ) ? esc_attr( $instance['email'] ) : '';
		$skype				= isset( $instance['skype'] ) ? esc_attr( $instance['skype'] ) : '';

		$address_directions	= isset( $instance['address_directions'] ) ? esc_attr( $instance['address_directions'] ) : '';
		
		?>
		
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'okthemes'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" class="widefat" />
		</p>
		
		<!-- Phone / Fax title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'call_area_title' ); ?>"><?php _e('Phone/Fax title:', 'okthemes'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'call_area_title' ); ?>" name="<?php echo $this->get_field_name( 'call_area_title' ); ?>" value="<?php echo $call_area_title; ?>" class="widefat" />
		</p>
		
		<!-- Your Phone: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e('Your Phone:', 'okthemes'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" value="<?php echo $phone; ?>" class="widefat" />
		</p>
		<!-- Your Fax: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'fax' ); ?>"><?php _e('Your Fax:', 'okthemes'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'fax' ); ?>" name="<?php echo $this->get_field_name( 'fax' ); ?>" value="<?php echo $fax; ?>" class="widefat" />
		</p>

		<!-- Email / Skype title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'write_area_title' ); ?>"><?php _e('Email/Skype title:', 'okthemes'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'write_area_title' ); ?>" name="<?php echo $this->get_field_name( 'write_area_title' ); ?>" value="<?php echo $write_area_title; ?>" class="widefat" />
		</p>

		<!-- Your E-mail: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e('Your Email:', 'okthemes'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo $email; ?>" class="widefat" />
		</p>
		<!-- Your Skype: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'skype' ); ?>"><?php _e('Your skype link:', 'okthemes'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'skype' ); ?>" name="<?php echo $this->get_field_name( 'skype' ); ?>" value="<?php echo $skype; ?>" class="widefat" />
		</p>

		<!-- Address title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'address_area_title' ); ?>"><?php _e('Address title:', 'okthemes'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'address_area_title' ); ?>" name="<?php echo $this->get_field_name( 'address_area_title' ); ?>" value="<?php echo $address_area_title; ?>" class="widefat" />
		</p>
		<!-- Your Address: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e('Your Address:', 'okthemes'); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>"><?php echo $address; ?></textarea>
		</p>
		<!-- Address: Directions -->
		<p>
			<label for="<?php echo $this->get_field_id( 'address_directions' ); ?>"><?php _e('Directions:', 'okthemes'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'address_directions' ); ?>" name="<?php echo $this->get_field_name( 'address_directions' ); ?>" value="<?php echo $address_directions; ?>" class="widefat" />
			<span><?php _e('Insert the longitude and latitude coordinates separated by comma. E.g.: 43.2238916,-76.2575936','okthemes'); ?></span>
		</p>

		<?php 
	}


	/**
	 * Sanitize widget form values as they are saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['call_area_title'] = ( ! empty( $new_instance['call_area_title'] ) ) ? strip_tags( $new_instance['call_area_title'] ) : '';
		$instance['write_area_title'] = ( ! empty( $new_instance['write_area_title'] ) ) ? strip_tags( $new_instance['write_area_title'] ) : '';
		$instance['address_area_title'] = ( ! empty( $new_instance['address_area_title'] ) ) ? strip_tags( $new_instance['address_area_title'] ) : '';
		$instance['address_directions'] =  $new_instance['address_directions'];
		$instance['address'] =  $new_instance['address'];
		$instance['phone'] = ( ! empty( $new_instance['phone'] ) ) ? $new_instance['phone'] : '';
		$instance['fax'] = ( ! empty( $new_instance['fax'] ) ) ? $new_instance['fax'] : '';
		$instance['email'] = ( ! empty( $new_instance['email'] ) ) ? $new_instance['email'] : '';
		$instance['skype'] = ( ! empty( $new_instance['skype'] ) ) ? $new_instance['skype'] : '';
		
		return $instance;
	}


} // class gg_Contact_Widget

// register gg_Contact_Widget 
function register_gg_contact_widget() {
    register_widget( 'gg_Contact_Widget' );
}
add_action( 'widgets_init', 'register_gg_contact_widget' );