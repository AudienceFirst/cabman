<?php
if ( ! class_exists( 'Team_Post_Type' ) ) :

class Team_Post_Type {

	public function __construct() {

		// Runs when the plugin is activated
		register_activation_hook( __FILE__, array( &$this, 'plugin_activation' ) );

		// Adds the team post type and taxonomies
		add_action( 'init', array( &$this, 'team_init' ) );

		// Thumbnail support for team posts
		add_theme_support( 'post-thumbnails', array( 'team' ) );

		// Adds columns in the admin view for thumbnail and taxonomies
		add_filter( 'manage_edit-team_cpt_columns', array( &$this, 'team_edit_columns' ), 10, 1 );
		add_action( 'manage_posts_custom_column', array( &$this, 'team_column_display' ), 10, 1 );

		// Allows filtering of posts by taxonomy in the admin view
		add_action( 'restrict_manage_posts', array( &$this, 'add_taxonomy_filters' ) );

		// Show team post counts in the dashboard
		add_action( 'right_now_content_table_end', array( &$this, 'add_team_counts' ) );

        // Add taxonomy terms as body classes
        add_filter( 'body_class', array( $this, 'add_body_classes' ) );
	}

	/**
     * Flushes rewrite rules on plugin activation to ensure team posts don't 404.
     *
     * @link http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
     *
     * @uses Team_Post_Type::team_init()
     */
    public function plugin_activation() {
            $this->load_textdomain();
            $this->team_init();
            flush_rewrite_rules();
    }

    /**
     * Initiate registrations of post type and taxonomies.
     *
     * @uses Team_Post_Type::register_post_type()
     * @uses Team_Post_Type::register_taxonomy_category()
     */
    public function team_init() {
            $this->register_post_type();
            $this->register_taxonomy_category();
    }

    /**
     * Get an array of all taxonomies this plugin handles.
     *
     * @return array Taxonomy slugs.
     */
    protected function get_taxonomies() {
            return array( 'team_category' );
    }

	protected function register_post_type() {

		/**
		 * Enable the team custom post type
		 * http://codex.wordpress.org/Function_Reference/register_post_type
		 */

		$labels = array(
			'name' 				 => __( 'Team', 'okthemes' ),
			'singular_name' 	 => __( 'Team member', 'okthemes' ),
			'add_new' 			 => __( 'Add New member', 'okthemes' ),
			'add_new_item' 		 => __( 'Add New team member', 'okthemes' ),
			'edit_item' 		 => __( 'Edit team member', 'okthemes' ),
			'new_item' 			 => __( 'Add new team member', 'okthemes' ),
			'view_item' 		 => __( 'View member', 'okthemes' ),
			'search_items' 		 => __( 'Search team', 'okthemes' ),
			'not_found' 		 => __( 'No team items found', 'okthemes' ),
			'not_found_in_trash' => __( 'No team items found in trash', 'okthemes' )
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
			'rewrite' 			=> array("slug" => get_theme_mod('team_cpt_slug','team-member')), // Permalinks format
			'menu_position' 	=> 25,
			'hierarchical' 		=> false,
			'has_archive' 		=> false
		); 

		$args = apply_filters( 'teamposttype_args', $args );

		register_post_type( 'team_cpt', $args );

	}

	/**
     * Register a taxonomy for team Categories.
     *
     * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
     */
    protected function register_taxonomy_category() {

	    $labels = array(
			'name' 							=> __( 'Team Categories', 'okthemes' ),
			'singular_name' 				=> __( 'Team Category', 'okthemes' ),
			'search_items' 					=> __( 'Search team Categories', 'okthemes' ),
			'popular_items' 				=> __( 'Popular team Categories', 'okthemes' ),
			'all_items' 					=> __( 'All team Categories', 'okthemes' ),
			'parent_item' 					=> __( 'Parent team Category', 'okthemes' ),
			'parent_item_colon' 			=> __( 'Parent team Category:', 'okthemes' ),
			'edit_item' 					=> __( 'Edit team Category', 'okthemes' ),
			'update_item' 					=> __( 'Update team Category', 'okthemes' ),
			'add_new_item' 					=> __( 'Add New team Category', 'okthemes' ),
			'new_item_name' 				=> __( 'New team Category Name', 'okthemes' ),
			'separate_items_with_commas' 	=> __( 'Separate team categories with commas', 'okthemes' ),
			'add_or_remove_items' 			=> __( 'Add or remove team categories', 'okthemes' ),
			'choose_from_most_used' 		=> __( 'Choose from the most used team categories', 'okthemes' ),
			'menu_name' 					=> __('Team Categories', 'okthemes' ),
	    );

	    $args = array(
			'labels' 				=> $labels,
			'public' 				=> true,
			'show_in_nav_menus' 	=> false,
			'show_ui' 				=> true,
			'show_tagcloud' 		=> true,
			'hierarchical' 			=> true,
			'rewrite' 				=> array( 'slug' => 'team_category' ),
			'query_var' 			=> true
	    );

	    $args = apply_filters( 'teamposttype_category_args', $args );

	    register_taxonomy( 'team_category', array( 'team_cpt' ), $args );

	}

	/**
     * Add taxonomy terms as body classes.
     *
     * If the taxonomy doesn't exist (has been unregistered), then get_the_terms() returns WP_Error, which is checked
     * for before adding classes.
     *
     * @param array $classes Existing body classes.
     *
     * @return array Amended body classes.
     */
    public function add_body_classes( $classes ) {

            // Only single posts should have the taxonomy body classes
            if ( ! is_single() )
                    return $classes;

            $taxonomies = $this->get_taxonomies();
            foreach( $taxonomies as $taxonomy ) {
                    $terms = get_the_terms( get_the_ID(), $taxonomy );
                    if ( $terms && ! is_wp_error( $terms ) ) {
                            foreach( $terms as $term ) {
                                    $classes[] = sanitize_html_class( str_replace( '_', '-', $taxonomy ) . '-' . $term->slug );
                            }
                    }
            }

            return $classes;
    }

	/**
	 * Add Columns to team Edit Screen
	 * http://wptheming.com/2010/07/column-edit-pages/
	 */

	public function team_edit_columns( $team_columns ) {
		$team_columns = array(
			"cb"					=> "<input type=\"checkbox\" />",
			"title" 				=> __('Title', 'okthemes'),
			"team_thumbnail" 		=> __('Thumbnail', 'okthemes'),
			"team_category" 		=> __('Category', 'okthemes'),
			"team_member_position"	=> __('Position', 'okthemes'),
			"author" 				=> __('Author', 'okthemes'),
			"date" 					=> __('Date', 'okthemes'),
		);

		return $team_columns;
	}

	public function team_column_display( $team_columns) {

		// Code from: http://wpengineer.com/display-post-thumbnail-post-page-overview
		global $post;
		$team_member_position = rwmb_meta('gg_team_member_position');
		switch ( $team_columns ) {

			// Display the team tags in the column view
			case "team_member_position":

				if ( $team_member_position != '') {
					echo $team_member_position;
				} else {
					echo __('None', 'okthemes');
				}
				break;
			
			case 'team_thumbnail':
				$width = (int) 50;
				$height = (int) 50;
				// Display the featured image in the column view if possible
				if ( has_post_thumbnail()) {
					the_post_thumbnail( array($width, $height) );
				} else {
					echo 'None';
				}
				break;

			// Display the team tags in the column view
			case "team_category":

				if ( $category_list = get_the_term_list( $post->ID, 'team_category', '', ', ', '' ) ) {
					echo $category_list;
				} else {
					echo __('None', 'okthemes');
				}
				break;	

			/* Just break out of the switch statement for everything else. */
			default :
				break;				
		}
	}

	/**
	 * Adds taxonomy filters to the team admin page
	 * Code artfully lifed from http://pippinsplugins.com
	 */

	public function add_taxonomy_filters() {
		global $typenow;

		// An array of all the taxonomies you want to display. Use the taxonomy name or slug
        $taxonomies = $this->get_taxonomies();

        // Must set this to the post type you want the filter(s) displayed on
        if ( 'team_cpt' != $typenow ) {
                return;
        }

		foreach ( $taxonomies as $tax_slug ) {
			$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
			$tax_obj = get_taxonomy( $tax_slug );
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			
			if ( 0 == count( $terms ) ) {
                    return;
            }

			echo '<select name="' . esc_attr( $tax_slug ) . '" id="' . esc_attr( $tax_slug ) . '" class="postform">';
            echo '<option value="0">' . esc_html( $tax_name ) .'</option>';
            foreach ( $terms as $term ) {
                    printf(
                            '<option value="%s"%s />%s</option>',
                            esc_attr( $term->slug ),
                            selected( $current_tax_slug, $term->slug ),
                            esc_html( $term->name . '(' . $term->count . ')' )
                    );
            }
            echo '</select>';

		}

	}

	/**
     * Add team count to "Right Now" dashboard widget.
     *
     * @return null Return early if team post type does not exist.
     */
    public function add_team_counts() {
            if ( ! post_type_exists( 'team' ) ) {
                    return;
            }

            $num_posts = wp_count_posts( 'team' );

            // Published items
            $href = 'edit.php?post_type=team';
            $num  = number_format_i18n( $num_posts->publish );
            $num  = $this->link_if_can_edit_posts( $num, $href );
            $text = _n( 'team Item', 'team Items', intval( $num_posts->publish ) );
            $text = $this->link_if_can_edit_posts( $text, $href );
            $this->display_dashboard_count( $num, $text );

            if ( 0 == $num_posts->pending ) {
                    return;
            }

            // Pending items
            $href = 'edit.php?post_status=pending&amp;post_type=team';
            $num  = number_format_i18n( $num_posts->pending );
            $num  = $this->link_if_can_edit_posts( $num, $href );
            $text = _n( 'team Item Pending', 'team Items Pending', intval( $num_posts->pending ) );
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
                    <td class="first b b-team"><?php echo $number; ?></td>
                    <td class="t team"><?php echo $label; ?></td>
            </tr>
            <?php
    }   

}

new Team_Post_Type;

endif;
?>