<?php
if ( ! class_exists( 'Testimonials_Post_Type' ) ) :

class Testimonials_Post_Type {

	public function __construct() {

		// Runs when the plugin is activated
		register_activation_hook( __FILE__, array( &$this, 'plugin_activation' ) );

		// Adds the testimonials post type and taxonomies
		add_action( 'init', array( &$this, 'testimonials_init' ) );

		// Thumbnail support for testimonials posts
		add_theme_support( 'post-thumbnails', array( 'testimonials' ) );

		// Adds columns in the admin view for thumbnail and taxonomies
		add_filter( 'manage_edit-testimonials_cpt_columns', array( &$this, 'testimonials_edit_columns' ), 10, 1 );
		add_action( 'manage_posts_custom_column', array( &$this, 'testimonials_column_display' ), 10, 1 );

		// Show testimonials post counts in the dashboard
		add_action( 'right_now_content_table_end', array( &$this, 'add_testimonials_counts' ) );

	}

	/**
     * Flushes rewrite rules on plugin activation to ensure testimonials posts don't 404.
     *
     * @link http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
     *
     * @uses Testimonials_Post_Type::testimonials_init()
     */
    public function plugin_activation() {
            $this->load_textdomain();
            $this->testimonials_init();
            flush_rewrite_rules();
    }

    /**
     * Initiate registrations of post type and taxonomies.
     *
     * @uses Testimonials_Post_Type::register_post_type()
     * @uses Testimonials_Post_Type::register_taxonomy_category()
     */
    public function testimonials_init() {
            $this->register_post_type();
    }

	protected function register_post_type() {

		/**
		 * Enable the testimonials custom post type
		 * http://codex.wordpress.org/Function_Reference/register_post_type
		 */

		$labels = array(
			'name' 				 => __( 'Testimonials', 'okthemes' ),
			'singular_name' 	 => __( 'Testimonial', 'okthemes' ),
			'add_new' 			 => __( 'Add New testimonial', 'okthemes' ),
			'add_new_item' 		 => __( 'Add New testimonial', 'okthemes' ),
			'edit_item' 		 => __( 'Edit testimonial', 'okthemes' ),
			'new_item' 			 => __( 'Add new testimonial', 'okthemes' ),
			'view_item' 		 => __( 'View testimonial', 'okthemes' ),
			'search_items' 		 => __( 'Search testimonials', 'okthemes' ),
			'not_found' 		 => __( 'No testimonials items found', 'okthemes' ),
			'not_found_in_trash' => __( 'No testimonials items found in trash', 'okthemes' )
		);

		$args = array(
	    	'labels' 			=> $labels,
	    	'public' 			=> true,
	    	'show_in_nav_menus' => false,
			'supports' 			=> array( 
					'title', 
					'thumbnail'
			),
			'capability_type' 	=> 'post',
			'rewrite' 			=> array("slug" => get_theme_mod('testimonials_cpt_slug','testimonials-member')), // Permalinks format
			'menu_position' 	=> 25,
			'hierarchical' 		=> false,
			'has_archive' 		=> false
		); 

		$args = apply_filters( 'testimonialsposttype_args', $args );

		register_post_type( 'testimonials_cpt', $args );

	}

	/**
	 * Add Columns to testimonials Edit Screen
	 * http://wptheming.com/2010/07/column-edit-pages/
	 */

	public function testimonials_edit_columns( $testimonials_columns ) {
		$testimonials_columns = array(
			"cb"					=> "<input type=\"checkbox\" />",
			"title" 				=> __('Title', 'okthemes'),
			"testimonials_thumbnail" 		=> __('Thumbnail', 'okthemes'),
			"author" 				=> __('Author', 'okthemes'),
			"date" 					=> __('Date', 'okthemes'),
		);

		return $testimonials_columns;
	}

	public function testimonials_column_display( $testimonials_columns) {

		// Code from: http://wpengineer.com/display-post-thumbnail-post-page-overview
		global $post;
		switch ( $testimonials_columns ) {
			
			case 'testimonials_thumbnail':
				$width = (int) 50;
				$height = (int) 50;
				// Display the featured image in the column view if possible
				if ( has_post_thumbnail()) {
					the_post_thumbnail( array($width, $height) );
				} else {
					echo 'None';
				}
				break;

			/* Just break out of the switch statement for everything else. */
			default :
				break;				
		}
	}

	/**
     * Add testimonials count to "Right Now" dashboard widget.
     *
     * @return null Return early if testimonials post type does not exist.
     */
    public function add_testimonials_counts() {
            if ( ! post_type_exists( 'testimonials' ) ) {
                    return;
            }

            $num_posts = wp_count_posts( 'testimonials' );

            // Published items
            $href = 'edit.php?post_type=testimonials';
            $num  = number_format_i18n( $num_posts->publish );
            $num  = $this->link_if_can_edit_posts( $num, $href );
            $text = _n( 'testimonials Item', 'testimonials Items', intval( $num_posts->publish ) );
            $text = $this->link_if_can_edit_posts( $text, $href );
            $this->display_dashboard_count( $num, $text );

            if ( 0 == $num_posts->pending ) {
                    return;
            }

            // Pending items
            $href = 'edit.php?post_status=pending&amp;post_type=testimonials';
            $num  = number_format_i18n( $num_posts->pending );
            $num  = $this->link_if_can_edit_posts( $num, $href );
            $text = _n( 'testimonials Item Pending', 'testimonials Items Pending', intval( $num_posts->pending ) );
            $text = $this->link_if_can_edit_posts( $text, $href );
            $this->display_dashboard_count( $num, $text );
    }

    /**
     * Wrap a dashboard number or text value in a link, if the current user can edit posts.
     *
     * @param  string $value Value to potentially wrap in a link.
     * @param  string $href  Link target.
     *
     * @return string        Value wrapped in a link if current user can edit posts, or original value otherwise.
     */
    protected function link_if_can_edit_posts( $value, $href ) {
            if ( current_user_can( 'edit_posts' ) ) {
                    return '<a href="' . esc_url( $href ) . '">' . $value . '</a>';
            }
            return $value;
    }

    /**
     * Display a number and text with table row and cell markup for the dashboard counters.
     *
     * @param  string $number Number to display. May be wrapped in a link.
     * @param  string $label  Text to display. May be wrapped in a link.
     */
    protected function display_dashboard_count( $number, $label ) {
            ?>
            <tr>
                    <td class="first b b-testimonials"><?php echo $number; ?></td>
                    <td class="t testimonials"><?php echo $label; ?></td>
            </tr>
            <?php
    }   

}

new Testimonials_Post_Type;

endif;
?>