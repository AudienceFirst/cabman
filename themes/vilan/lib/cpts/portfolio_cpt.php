<?php
if ( ! class_exists( 'Portfolio_Post_Type' ) ) :

class Portfolio_Post_Type {

	public function __construct() {

		// Runs when the plugin is activated
		register_activation_hook( __FILE__, array( &$this, 'plugin_activation' ) );

		// Adds the portfolio post type and taxonomies
		add_action( 'init', array( &$this, 'portfolio_init' ) );

		// Thumbnail support for portfolio posts
		add_theme_support( 'post-thumbnails', array( 'portfolio' ) );

		// Adds columns in the admin view for thumbnail and taxonomies
		add_filter( 'manage_edit-portfolio_cpt_columns', array( &$this, 'portfolio_edit_columns' ), 10, 1 );
		add_action( 'manage_posts_custom_column', array( &$this, 'portfolio_column_display' ), 10, 1 );

		// Allows filtering of posts by taxonomy in the admin view
		add_action( 'restrict_manage_posts', array( &$this, 'add_taxonomy_filters' ) );

		// Show portfolio post counts in the dashboard
		add_action( 'right_now_content_table_end', array( &$this, 'add_portfolio_counts' ) );

        // Add taxonomy terms as body classes
        add_filter( 'body_class', array( $this, 'add_body_classes' ) );
	}

	/**
     * Flushes rewrite rules on plugin activation to ensure portfolio posts don't 404.
     *
     * @link http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
     *
     * @uses Portfolio_Post_Type::portfolio_init()
     */
    public function plugin_activation() {
            $this->load_textdomain();
            $this->portfolio_init();
            flush_rewrite_rules();
    }

    /**
     * Initiate registrations of post type and taxonomies.
     *
     * @uses Portfolio_Post_Type::register_post_type()
     * @uses Portfolio_Post_Type::register_taxonomy_tag()
     * @uses Portfolio_Post_Type::register_taxonomy_category()
     */
    public function portfolio_init() {
            $this->register_post_type();
            $this->register_taxonomy_category();
            $this->register_taxonomy_tag();
    }

    /**
     * Get an array of all taxonomies this plugin handles.
     *
     * @return array Taxonomy slugs.
     */
    protected function get_taxonomies() {
            return array( 'portfolio_category', 'portfolio_tag' );
    }

	protected function register_post_type() {

		/**
		 * Enable the Portfolio custom post type
		 * http://codex.wordpress.org/Function_Reference/register_post_type
		 */

		$labels = array(
			'name' 				 => __( 'Portfolio', 'okthemes' ),
			'singular_name' 	 => __( 'Portfolio Item', 'okthemes' ),
			'add_new' 			 => __( 'Add New Item', 'okthemes' ),
			'add_new_item' 		 => __( 'Add New Portfolio Item', 'okthemes' ),
			'edit_item' 		 => __( 'Edit Portfolio Item', 'okthemes' ),
			'new_item' 			 => __( 'Add New Portfolio Item', 'okthemes' ),
			'view_item' 		 => __( 'View Item', 'okthemes' ),
			'search_items' 		 => __( 'Search Portfolio', 'okthemes' ),
			'not_found' 		 => __( 'No portfolio items found', 'okthemes' ),
			'not_found_in_trash' => __( 'No portfolio items found in trash', 'okthemes' )
		);

		$args = array(
	    	'labels' 			=> $labels,
	    	'public' 			=> true,
	    	'show_in_nav_menus' => true,
			'supports' 			=> array( 
					'title',
					'editor', 
					'thumbnail', 
					'revisions' 
			),
			'capability_type' 	=> 'post',
			'rewrite' 			=> array("slug" => get_theme_mod('portfolio_cpt_slug','portfolio-item')), // Permalinks format
			'menu_position' 	=> 25,
			'hierarchical' 		=> false,
			'has_archive' 		=> true
		); 

		$args = apply_filters( 'portfolioposttype_args', $args );

		register_post_type( 'portfolio_cpt', $args );

	}

    /**
     * Register a taxonomy for Portfolio Tags.
     *
     * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
     */
    protected function register_taxonomy_tag() {

		$labels = array(
			'name' 							=> __( 'Portfolio Tags', 'okthemes' ),
			'singular_name' 				=> __( 'Portfolio Tag', 'okthemes' ),
			'search_items' 					=> __( 'Search Portfolio Tags', 'okthemes' ),
			'popular_items' 				=> __( 'Popular Portfolio Tags', 'okthemes' ),
			'all_items' 					=> __( 'All Portfolio Tags', 'okthemes' ),
			'parent_item' 					=> __( 'Parent Portfolio Tag', 'okthemes' ),
			'parent_item_colon' 			=> __( 'Parent Portfolio Tag:', 'okthemes' ),
			'edit_item' 					=> __( 'Edit Portfolio Tag', 'okthemes' ),
			'update_item' 					=> __( 'Update Portfolio Tag', 'okthemes' ),
			'add_new_item' 					=> __( 'Add New Portfolio Tag', 'okthemes' ),
			'new_item_name' 				=> __( 'New Portfolio Tag Name', 'okthemes' ),
			'separate_items_with_commas' 	=> __( 'Separate portfolio tags with commas', 'okthemes' ),
			'add_or_remove_items' 			=> __( 'Add or remove portfolio tags', 'okthemes' ),
			'choose_from_most_used' 		=> __( 'Choose from the most used portfolio tags', 'okthemes' ),
			'menu_name' 					=> __( 'Portfolio Tags', 'okthemes' )
		);

		$args = array(
			'labels' 				=> $labels,
			'public' 				=> true,
			'show_in_nav_menus' 	=> false,
			'show_ui' 				=> true,
			'show_tagcloud' 		=> true,
			'hierarchical' 			=> false,
			'rewrite' 				=> array( 'slug' => 'portfolio_tag' ),
			'query_var' 			=> true
		);

		$args = apply_filters( 'portfolioposttype_tag_args', $args );

		register_taxonomy( 'portfolio_tag', array( 'portfolio_cpt' ), $args );

	}

	/**
     * Register a taxonomy for Portfolio Categories.
     *
     * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
     */
    protected function register_taxonomy_category() {

	    $labels = array(
			'name' 							=> __( 'Portfolio Categories', 'okthemes' ),
			'singular_name' 				=> __( 'Portfolio Category', 'okthemes' ),
			'search_items' 					=> __( 'Search Portfolio Categories', 'okthemes' ),
			'popular_items' 				=> __( 'Popular Portfolio Categories', 'okthemes' ),
			'all_items' 					=> __( 'All Portfolio Categories', 'okthemes' ),
			'parent_item' 					=> __( 'Parent Portfolio Category', 'okthemes' ),
			'parent_item_colon' 			=> __( 'Parent Portfolio Category:', 'okthemes' ),
			'edit_item' 					=> __( 'Edit Portfolio Category', 'okthemes' ),
			'update_item' 					=> __( 'Update Portfolio Category', 'okthemes' ),
			'add_new_item' 					=> __( 'Add New Portfolio Category', 'okthemes' ),
			'new_item_name' 				=> __( 'New Portfolio Category Name', 'okthemes' ),
			'separate_items_with_commas' 	=> __( 'Separate portfolio categories with commas', 'okthemes' ),
			'add_or_remove_items' 			=> __( 'Add or remove portfolio categories', 'okthemes' ),
			'choose_from_most_used' 		=> __( 'Choose from the most used portfolio categories', 'okthemes' ),
			'menu_name' 					=> __('Portfolio Categories', 'okthemes' ),
	    );

	    $args = array(
			'labels' 				=> $labels,
			'public' 				=> true,
			'show_in_nav_menus' 	=> true,
			'show_ui' 				=> true,
			'show_tagcloud' 		=> true,
			'hierarchical' 			=> true,
			'rewrite' 				=> array( 'slug' => 'portfolio_category' ),
			'query_var' 			=> true
	    );

	    $args = apply_filters( 'portfolioposttype_category_args', $args );

	    register_taxonomy( 'portfolio_category', array( 'portfolio_cpt' ), $args );

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
	 * Add Columns to Portfolio Edit Screen
	 * http://wptheming.com/2010/07/column-edit-pages/
	 */

	public function portfolio_edit_columns( $portfolio_columns ) {
		$portfolio_columns = array(
			"cb"					=> "<input type=\"checkbox\" />",
			"title" 				=> __('Title', 'okthemes'),
			"portfolio_thumbnail" 	=> __('Thumbnail', 'okthemes'),
			"portfolio_category" 	=> __('Category', 'okthemes'),
			"portfolio_tag" 		=> __('Tags', 'okthemes'),
			"author" 				=> __('Author', 'okthemes'),
			"date" 					=> __('Date', 'okthemes'),
		);

		return $portfolio_columns;
	}

	public function portfolio_column_display( $portfolio_columns) {

		// Code from: http://wpengineer.com/display-post-thumbnail-post-page-overview
		global $post;
		switch ( $portfolio_columns ) {
			
			case 'portfolio_thumbnail':
				$width = (int) 50;
				$height = (int) 50;
				// Display the featured image in the column view if possible
				if ( has_post_thumbnail()) {
					the_post_thumbnail( array($width, $height) );
				} else {
					echo 'None';
				}
				break;

			// Display the portfolio tags in the column view
			case "portfolio_category":

				if ( $category_list = get_the_term_list( $post->ID, 'portfolio_category', '', ', ', '' ) ) {
					echo $category_list;
				} else {
					echo __('None', 'okthemes');
				}
				break;	

			// Display the portfolio tags in the column view
			case "portfolio_tag":

				if ( $tag_list = get_the_term_list( $post->ID, 'portfolio_tag', '', ', ', '' ) ) {
					echo $tag_list;
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
	 * Adds taxonomy filters to the portfolio admin page
	 * Code artfully lifed from http://pippinsplugins.com
	 */

	public function add_taxonomy_filters() {
		global $typenow;

		// An array of all the taxonomies you want to display. Use the taxonomy name or slug
        $taxonomies = $this->get_taxonomies();

        // Must set this to the post type you want the filter(s) displayed on
        if ( 'portfolio_cpt' != $typenow ) {
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
     * Add Portfolio count to "Right Now" dashboard widget.
     *
     * @return null Return early if portfolio post type does not exist.
     */
    public function add_portfolio_counts() {
            if ( ! post_type_exists( 'portfolio' ) ) {
                    return;
            }

            $num_posts = wp_count_posts( 'portfolio' );

            // Published items
            $href = 'edit.php?post_type=portfolio';
            $num  = number_format_i18n( $num_posts->publish );
            $num  = $this->link_if_can_edit_posts( $num, $href );
            $text = _n( 'Portfolio Item', 'Portfolio Items', intval( $num_posts->publish ) );
            $text = $this->link_if_can_edit_posts( $text, $href );
            $this->display_dashboard_count( $num, $text );

            if ( 0 == $num_posts->pending ) {
                    return;
            }

            // Pending items
            $href = 'edit.php?post_status=pending&amp;post_type=portfolio';
            $num  = number_format_i18n( $num_posts->pending );
            $num  = $this->link_if_can_edit_posts( $num, $href );
            $text = _n( 'Portfolio Item Pending', 'Portfolio Items Pending', intval( $num_posts->pending ) );
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
                    <td class="first b b-portfolio"><?php echo $number; ?></td>
                    <td class="t portfolio"><?php echo $label; ?></td>
            </tr>
            <?php
    }   

}

new Portfolio_Post_Type;

endif;
?>