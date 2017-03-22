<?php
/**
 * Adds gg_Recent_Posts_Widget widget.
 */
class gg_Recent_Posts_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'gg_recent_posts_widget', // Base ID
			__('Recent posts with thumbnails', 'okthemes'), // Name
			array( 'description' => __( 'Recent posts with thumbnails', 'okthemes' ), 'classname' => 'recent_post_thumbnails', ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		if ( !$number = (int) $instance['number'] ) $number = 10;
		else if ( $number < 1 ) $number = 1;
		else if ( $number > 15 ) $number = 15;

		echo $args['before_widget'];

		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		?>

		<ul class="media-list">
		  	<?php
		  	global $post;
		  	$recent_posts_thumb_query = new WP_Query( array ( 'posts_per_page' => $number ) );
		  	
			  	if($recent_posts_thumb_query->have_posts()):
				while($recent_posts_thumb_query->have_posts()):
			  	$recent_posts_thumb_query->the_post();
			  	
			 ?>
			 
			 <li class="media">
			 
			 	<a class="pull-left" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				 	<?php 
				 	if ( has_post_thumbnail() ) {
				 		$thumbnail_id = get_post_thumbnail_id( $post->ID );
				 		echo '<img class="media-object img-rounded" src="'.gg_aq_resize( $thumbnail_id, 50, 50, true, true ).'" alt="'.get_the_title( $thumbnail_id ).'" />';
				 	} else {  
					     echo '<span class="post-format standard pull-left img-rounded"><i class="icon_pencil-edit"></i></span>';
				 	} ?>
				</a>

				<div class="media-body">
			      <h4 class="media-heading"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo get_the_title(); ?></a></h4>
			      <span class="post-date"><?php echo get_the_date(); ?></span>
			    </div>
								 
			 </li>
		  	
		  	<?php endwhile;
		  		  endif; 
		  		  /* Restore original Post Data */
		  		  wp_reset_postdata();
		    ?>
		  	</ul>
		  	<div class="clearfix"></div>
		<?php  		
		echo $args['after_widget'];
	}
	

	/**
	 * Back-end widget form.
	 */
	public function form( $instance ) {
		
		$title = isset( $instance['title'] ) ? $instance['title'] : __( 'Contact us', 'okthemes' );

		if ( !$number = (int) $instance['number'] ) $number = 10;
		else if ( $number < 1 ) $number = 1;
		else if ( $number > 15 ) $number = 15;

		?>
		
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'okthemes'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" class="widefat" />
		</p>
		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:', 'okthemes'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /><br />
		<small><?php _e('(at most 15)', 'okthemes'); ?></small></p>
		<?php 
	}


	/**
	 * Sanitize widget form values as they are saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['number'] = (int) $new_instance['number'];
		
		return $instance;
	}


} // class gg_Recent_Posts_Widget

// register gg_Recent_Posts_Widget 
function register_gg_recent_posts_widget() {
    register_widget( 'gg_Recent_Posts_Widget' );
}
add_action( 'widgets_init', 'register_gg_recent_posts_widget' );