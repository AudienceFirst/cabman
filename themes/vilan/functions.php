<?php
/**
 * Theme Functions
 *
 * @author Gogoneata Cristian <cristian.gogoneata@gmail.com>
 * @package WordPress
 * @subpackage vilan
 */

global $theme_name, $dependency_css;
$theme_name = "vilan";
$dependency_css = array();

define("OKTHEMES_TEXTDOMAIN","okthemes");
define("OKTHEMES_THEMEVERSION","1.2");

@define( 'PARENT_DIR', get_template_directory() );
@define( 'CHILD_DIR', get_stylesheet_directory() );

@define( 'PARENT_URL', get_template_directory_uri() );
@define( 'CHILD_URL', get_stylesheet_directory_uri() );

// Re-define meta box path and URL
define( 'RWMB_URL', trailingslashit( get_template_directory_uri() . '/admin/meta-box/' ) );
define( 'RWMB_DIR', trailingslashit( get_template_directory(). '/admin/meta-box/' ) );

// Load plugins
require_once PARENT_DIR . '/lib/class-tgm-plugin-activation.php';
include PARENT_DIR . '/lib/register-tgm-plugins.php';

// Include the meta box script
require_once RWMB_DIR . 'meta-box.php';
    // Include the meta box options
    include PARENT_DIR.'/lib/metaboxes-new.php';

include get_template_directory() . '/admin/customizer/options.php';

//Fix the autoupdate in VC
function gg_vilan_enable_vc_auto_theme_update() {
  if( function_exists('vc_updater') ) {
    $vc_updater = vc_updater();
    remove_filter( 'upgrader_pre_download', array( $vc_updater, 'preUpgradeFilter' ), 10 );
    if( function_exists( 'vc_license' ) ) {
      if( !vc_license()->isActivated() ) {
        remove_filter( 'pre_set_site_transient_update_plugins', array( $vc_updater->updateManager(), 'check_update' ), 10 );
      }
    }
  }
}
add_action('vc_after_init', 'gg_vilan_enable_vc_auto_theme_update');

// Set VC as part of the theme
if(function_exists('vc_set_as_theme')) {
    vc_set_as_theme($disable_updater = true);
    vc_set_shortcodes_templates_dir(PARENT_DIR.'/lib/visualcomposer/vc_templates/');
    require_once (PARENT_DIR . '/lib/load-vc-modules.php');
    $dependency_css[] = 'js_composer_front';
}

// Hide activation and update specific parts of Slider Revolution
if(function_exists('set_revslider_as_theme')) {
    add_action( 'init', 'gg_rev_slider' );
    function gg_rev_slider() {
        set_revslider_as_theme();
    }
}

// Verify if woocommerce is active
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
    function is_woocommerce_activated() {
        if ( class_exists( 'woocommerce' ) ) { 
            return true;
        } else { 
            return false;
        }
    }
}

// Verify if WPML is active
if ( ! function_exists( 'is_wpml_activated' ) ) {
    function is_wpml_activated() {
        if ( class_exists( 'SitePressLanguageSwitcher' ) ) { 
            return true; 
        } else { 
            return false;
        }
    }
}

if (is_wpml_activated()) {
    function language_selector_flags(){
        $languages = icl_get_languages('skip_missing=0&orderby=custom');
        if(!empty($languages)){
            echo '<ul class="list-inline">';
            foreach($languages as $l){
                echo '<li>';
                if(!$l['active']) echo '<a href="'.esc_url($l['url']).'">';
                echo '<img src="'.esc_url($l['country_flag_url']).'" height="12" alt="'.esc_attr($l['language_code']).'" width="18" />';
                if(!$l['active']) echo '</a>';
                echo '</li>';
            }
            echo '</ul>';
        }
    }
}

// Check if element comes from VC
function gg_is_in_vc() {
    $classes = get_body_class();
    if (in_array('blog',$classes) || in_array('single',$classes) || in_array('search',$classes) || in_array('archive',$classes) || in_array('category',$classes)) {
        return false;
    } else {
        return true;
    }
}

// Include breadcrumbs
require_once (PARENT_DIR . '/lib/breadcrumbs.php');

// Include post types
require_once (PARENT_DIR . '/lib/custom-post-types.php');

// Include widgets
require_once (PARENT_DIR . '/lib/widgets.php');

// Include aq resize
include (PARENT_DIR . '/lib/aq_resizer.php');


/**
 * Load woocommerce functions
 */
if (is_woocommerce_activated()) {
    require_once PARENT_DIR . '/lib/theme-woocommerce.php';
}

/**
* Load bbPress functions
*/
if ( class_exists( 'bbPress' ) ) {
    require_once PARENT_DIR . '/lib/theme-bbpress.php';
}

/**
 * Load ECWID functions
 */
if ( defined( 'APP_ECWID_COM' ) ) {
    require_once PARENT_DIR . '/lib/theme-ecwid.php';
}

/**
 * Maximum allowed width of content within the theme.
 */
if (!isset($content_width)) {
    $content_width = 1170;
}

/**
 * Setup Theme Functions
 *
 */
if (!function_exists('gg_theme_setup')):
    function gg_theme_setup() {

        load_theme_textdomain(OKTHEMES_TEXTDOMAIN, get_template_directory() . '/lang');

        /**
        * If BBPress is active, add theme support
        */
        if ( class_exists( 'bbPress' ) ) {
            add_theme_support( 'bbpress' );
        }
        add_theme_support('automatic-feed-links');
        add_theme_support('post-thumbnails');
        add_theme_support('post-formats', array( 'aside', 'image', 'gallery', 'link', 'quote', 'status', 'video', 'audio', 'chat' ));
        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
        
        $defaults = array(
            'default-color'          => 'd9e2e9',
            'default-image'          => '',
            'default-repeat'         => '',
            'default-position-x'     => '',
        );
        add_theme_support( 'custom-background', $defaults);
        add_theme_support( 'woocommerce' );

        register_nav_menus(
            array(
                'main-menu' => __('Main Menu', OKTHEMES_TEXTDOMAIN),
                'header-toolbar' => __('Header Toolbar', OKTHEMES_TEXTDOMAIN)
            ));
        // load custom walker menu class file
        require (PARENT_DIR . '/lib/nav/class-bootstrapwp_walker_nav_menu.php');

        set_post_thumbnail_size('full');
    }
endif;
add_action('after_setup_theme', 'gg_theme_setup');


/**
 * Load CSS styles for theme.
 *
 */
function gg_styles_loader() {
    wp_enqueue_style('vilan-bootstrap', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css', false, OKTHEMES_THEMEVERSION, 'all');
    wp_enqueue_style('vilan-font-elegant', get_template_directory_uri() . '/assets/elegant-font/style.css', false, OKTHEMES_THEMEVERSION, 'all');
    wp_enqueue_style('vilan-font-social', get_template_directory_uri() . '/assets/social-font/stylesheets.css', false, OKTHEMES_THEMEVERSION, 'all');
    wp_enqueue_style('theme-isotope', get_template_directory_uri() . '/styles/isotope.css', false, OKTHEMES_THEMEVERSION, 'all');
    wp_enqueue_style('magnific', get_template_directory_uri() . '/styles/magnific-popup.css', false, OKTHEMES_THEMEVERSION, 'all');
    wp_enqueue_style('jplayer', get_template_directory_uri() . '/styles/jplayer/jplayer.css', false, OKTHEMES_THEMEVERSION, 'all');
    wp_enqueue_style('owlcarouselbase', get_template_directory_uri() . '/styles/owl.carousel.css', false, OKTHEMES_THEMEVERSION, 'all');
    wp_enqueue_style('owlcarouseltheme', get_template_directory_uri() . '/styles/owl.theme.css', false, OKTHEMES_THEMEVERSION, 'all');
    wp_enqueue_style('owlcarouseltransitions', get_template_directory_uri() . '/styles/owl.transitions.css', false, OKTHEMES_THEMEVERSION, 'all');

    if (is_woocommerce_activated()) {
        wp_enqueue_style('gg-woocommerce', get_template_directory_uri() . '/styles/gg-woocommerce.css', false, OKTHEMES_THEMEVERSION, 'all');
    }
    
    if ( class_exists( 'bbPress' ) ) {
        wp_enqueue_style('gg-bbpress', get_template_directory_uri() . '/styles/gg-bbpress.css', false, OKTHEMES_THEMEVERSION, 'all');
    }

    if ( defined( 'APP_ECWID_COM' ) ) {
        wp_enqueue_style('gg-ecwid', get_template_directory_uri() . '/styles/gg-ecwid.css', false, OKTHEMES_THEMEVERSION, 'all');
    }

    wp_enqueue_style('vilan-default', get_stylesheet_uri());

}
add_action('wp_enqueue_scripts', 'gg_styles_loader');

/**
 * Load JavaScript and jQuery files for theme.
 *
 */
function vilan_scripts_loader() {

    $setBase = (is_ssl()) ? "https://" : "http://";

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array('jquery'),OKTHEMES_THEMEVERSION,true);
    wp_enqueue_script('hoverintent', get_template_directory_uri() . '/js/hoverintent.js', array('jquery'), OKTHEMES_THEMEVERSION, true);
    wp_register_script('theme-isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array('jquery'), OKTHEMES_THEMEVERSION, true);
    wp_register_script('magnific', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array('jquery'), OKTHEMES_THEMEVERSION, true);
    wp_register_script('owlcarousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), OKTHEMES_THEMEVERSION, true);
    wp_register_script('countto', get_template_directory_uri() . '/js/jquery.countto.js', array('jquery'), OKTHEMES_THEMEVERSION, true);
    
    if( 1 == get_theme_mod( 'retina', 1 ) ) {
        wp_enqueue_script('retinajs', get_template_directory_uri() . '/js/retina.min.js', array('jquery'), OKTHEMES_THEMEVERSION, true);
    }

    wp_register_script('jplayer',get_template_directory_uri() ."/js/jquery.jplayer.min.js",array('jquery'),OKTHEMES_THEMEVERSION,true);
    wp_register_script('gmaps',get_template_directory_uri() ."/js/jquery.gmap.min.js",array('jquery'),OKTHEMES_THEMEVERSION,true);
    wp_register_script('google-map',$setBase."maps.google.com/maps/api/js?sensor=false");
    wp_register_script('jvalidate',get_template_directory_uri() ."/js/jquery.validate.min.js",array('jquery'),OKTHEMES_THEMEVERSION,true);
    wp_register_script('videobackground',get_template_directory_uri() ."/js/jquery.videobackground.js",array('jquery'),OKTHEMES_THEMEVERSION,true);
    wp_enqueue_script('custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), OKTHEMES_THEMEVERSION, true);

}
add_action('wp_enqueue_scripts', 'vilan_scripts_loader');

//Admin enque script for metabox
function vilan_admin_metabox_script_loader() {
    wp_enqueue_script( 'jquery-custom-admin', get_template_directory_uri() . '/js/jquery.custom.admin.js', array( 'jquery' ), OKTHEMES_THEMEVERSION, true );
}
add_action( 'admin_enqueue_scripts', 'vilan_admin_metabox_script_loader' );


/**
 * Function for aq_resize
 */
if (!function_exists('gg_aq_resize')) :
function gg_aq_resize( $attachment_id, $width = null, $height = null, $crop = true, $single = true ) {

    if ( is_null( $attachment_id ) ) 
        return null;

    $image = wp_get_attachment_image_src( $attachment_id, 'full' );

    $return = aq_resize( $image[0], $width, $height, $crop, $single );

    if ( $return ) {
        return $return;
    }
    else {
        return $image[0];
    }
}
endif;

/**
 * Define theme's widget areas.
 *
 */
function vilan_widgets_init() {

    register_sidebar(
        array(
            'name'          => __('Page Sidebar', OKTHEMES_TEXTDOMAIN),
            'id'            => 'sidebar-page',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => "</div>",
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        )
    );

    register_sidebar(
        array(
            'name'          => __('Posts Sidebar', OKTHEMES_TEXTDOMAIN),
            'id'            => 'sidebar-posts',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => "</div>",
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        )
    );

    register_sidebar(
        array(
            'name'          => __('Search Sidebar', OKTHEMES_TEXTDOMAIN),
            'id'            => 'sidebar-search',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => "</div>",
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        )
    );

    register_sidebar(
        array(
            'name'          => __('Portfolio Sidebar', OKTHEMES_TEXTDOMAIN),
            'id'            => 'sidebar-portfolio',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        )
    );

    register_sidebar(
        array(
            'name'          => __('Shop Sidebar', OKTHEMES_TEXTDOMAIN),
            'id'            => 'sidebar-shop',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        )
    );

    register_sidebar(
        array(
            'name'          => __('bbPress Sidebar', OKTHEMES_TEXTDOMAIN),
            'id'            => 'sidebar-bbpress',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        )
    );

    register_sidebar(
        array(
            'name'          => __('Ecwid Sidebar', OKTHEMES_TEXTDOMAIN),
            'id'            => 'sidebar-ecwid',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        )
    );

    register_sidebar(
        array(
            'name'          => __('Contact Sidebar', OKTHEMES_TEXTDOMAIN),
            'id'            => 'sidebar-contact',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        )
    );

    register_sidebar(
        array(
            'name'          => __('Footer First Sidebar', OKTHEMES_TEXTDOMAIN),
            'id'            => 'sidebar-footer-first',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        )
    );

    register_sidebar(
        array(
            'name'          => __('Footer Second Sidebar', OKTHEMES_TEXTDOMAIN),
            'id'            => 'sidebar-footer-second',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        )
    );

    register_sidebar(
        array(
            'name'          => __('Footer Third Sidebar', OKTHEMES_TEXTDOMAIN),
            'id'            => 'sidebar-footer-third',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        )
    );

    register_sidebar(
        array(
            'name'          => __('Footer Fourth Sidebar', OKTHEMES_TEXTDOMAIN),
            'id'            => 'sidebar-footer-fourth',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        )
    );
}
add_action('init', 'vilan_widgets_init');


/**
 * Display template for comments and pingbacks.
 *
 */
if (!function_exists('vilan_comment')) :
    function vilan_comment($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' : ?>

                <li <?php comment_class('media, comment'); ?> id="comment-<?php comment_ID(); ?>">
                    <div class="media-body">
                        <p>
                            <?php _e('Pingback:', OKTHEMES_TEXTDOMAIN); ?> <?php comment_author_link(); ?>
                        </p>
                    </div><!--/.media-body -->
                <?php
                break;
            default :
                // Proceed with normal comments.
                global $post; ?>

                <li <?php comment_class('media'); ?> id="li-comment-<?php comment_ID(); ?>">
                        <a href="<?php echo esc_url($comment->comment_author_url); ?>" class="pull-left avatar-holder">
                            <?php echo get_avatar($comment, 42); ?>
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading comment-author vcard">
                                <?php
                                printf('<cite class="fn">%1$s %2$s</cite>',
                                    get_comment_author_link(),
                                    // If current post author is also comment author, make it known visually.
                                    ($comment->user_id === $post->post_author) ? '<span class="label"> ' . __(
                                        'Post author',
                                        OKTHEMES_TEXTDOMAIN
                                    ) . '</span> ' : ''); ?>
                            </h4>
                            <p class="meta">
                                <?php printf('<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
                                        esc_url(get_comment_link($comment->comment_ID)),
                                        get_comment_time('c'),
                                        sprintf(
                                            __('%1$s at %2$s', OKTHEMES_TEXTDOMAIN),
                                            get_comment_date(),
                                            get_comment_time()
                                        )
                                    ); ?>
                            </p>
                            <p class="reply">
                                <?php comment_reply_link( array_merge($args, array(
                                            'reply_text' => __('<i class="arrow_back"></i> Reply', OKTHEMES_TEXTDOMAIN),
                                            'depth'      => $depth,
                                            'max_depth'  => $args['max_depth']
                                        )
                                    )); ?>
                            </p>

                            <?php if ('0' == $comment->comment_approved) : ?>
                                <p class="comment-awaiting-moderation"><?php _e(
                                    'Your comment is awaiting moderation.',
                                    OKTHEMES_TEXTDOMAIN
                                ); ?></p>
                            <?php endif; ?>

                            <?php comment_text(); ?>
                                                    
                        </div>
                        <!--/.media-body -->
                <?php
                break;
        endswitch;
    }
endif;

/**
 * Display template for post meta information.
 *
 */
if (!function_exists('vilan_posted_on')) :
    function vilan_posted_on() {
    // Translators: used between list items, there is a space after the comma.
    $categories_list = get_the_category_list( __( ', ', OKTHEMES_TEXTDOMAIN ) );

    $date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
        esc_url( get_permalink() ),
        esc_attr( get_the_time() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() )
    );

    // Translators: 1 is category, 2 is the date, 3 is the author's name
    if ( $categories_list && !gg_is_in_vc() ) {
        $utility_text = __( '<span class="post-date"><i class="icon_clock_alt"></i> %2$s</span> <span class="post-category"><i class="icon_menu-square_alt2"></i> %1$s</span>', OKTHEMES_TEXTDOMAIN );
    } else {
        $utility_text = __( '<span class="post-date"><i class="icon_clock_alt"></i> %2$s</span>', OKTHEMES_TEXTDOMAIN );
    }

    printf(
        $utility_text,
        $categories_list,
        $date
    );    

    //Show comments
    $num_comments = get_comments_number(); // get_comments_number returns only a numeric value

    if ( comments_open() ) {
        if ( $num_comments == 0 ) {
            $comments = __('No Comments',OKTHEMES_TEXTDOMAIN);
        } elseif ( $num_comments > 1 ) {
            $comments = $num_comments . __(' Comments',OKTHEMES_TEXTDOMAIN);
        } else {
            $comments = __('1 Comment',OKTHEMES_TEXTDOMAIN);
        }
        $write_comments = '<a href="' . esc_url(get_comments_link()) .'">'. $comments.'</a>';
    } else {
        $write_comments =  __('Comments off',OKTHEMES_TEXTDOMAIN);
    }

    if ( !gg_is_in_vc() ) {
        echo '<span class="post-comments"><i class="icon_comment_alt"></i> '.wp_kses( $write_comments, array('a' => array('href')) ).'</span>';
    }

}

endif;


if ( ! function_exists( 'gg_page_footer_message_box' ) ) :
/**
 * Display page footer message box
*/
function gg_page_footer_message_box() {
    global $post;
    
    if ( is_woocommerce_activated() && (is_woocommerce() || is_product_category()) ) {
        $shop_page_id = woocommerce_get_page_id( 'shop' );
        $post_id = $shop_page_id;
    } elseif (is_home()) {
        $post_id = get_option('page_for_posts');
    } elseif (is_front_page()) {
        $post_id = get_option('page_on_front');    
    } else {
        $post_id = $post->ID;
    }

    ?>
    
    <?php
    $page_footer_box = rwmb_meta('gg_page_footer_box','',$post_id);
    $page_footer_heading = rwmb_meta('gg_page_footer_heading','',$post_id);
    $page_footer_desc = rwmb_meta('gg_page_footer_desc','',$post_id);
    $page_footer_first_button_name = rwmb_meta('gg_page_footer_first_button_name','',$post_id);
    $page_footer_first_button_link = rwmb_meta('gg_page_footer_first_button_link','',$post_id);
    $page_footer_second_button_name = rwmb_meta('gg_page_footer_second_button_name','',$post_id);
    $page_footer_second_button_link = rwmb_meta('gg_page_footer_second_button_link','',$post_id);
    ?>

    <?php if ($page_footer_box) { ?>
    <section class="page-footer-message">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><?php echo esc_html($page_footer_heading); ?></h1>
                    <a class="btn btn-default-inverse" href="<?php echo esc_url($page_footer_first_button_link); ?>"><?php echo esc_html($page_footer_first_button_name); ?></a>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>

    <?php
}
endif;


if ( ! function_exists( 'vilan_page_header' ) ) :
/**
 * Display page header
*/
function vilan_page_header() {
    global $post;

    if (is_home()) {
        $post_id = get_option('page_for_posts');
    } elseif (is_woocommerce_activated() && (is_woocommerce() || is_product_category())) {
        $shop_page_id = woocommerce_get_page_id( 'shop' );
        $post_id = $shop_page_id;
    } else {
        $post_id = $post->ID;
    }

    ?>
    
    <?php
    $page_header = rwmb_meta('gg_page_header','',$post_id); 
    $page_heading_position = rwmb_meta('gg_page_heading_pos_select','',$post_id);
    $page_title = rwmb_meta('gg_page_title','',$post_id);
    $page_description = rwmb_meta('gg_page_description','',$post_id);
    $page_header_image_overlay = rwmb_meta('gg_page_header_image_overlay','',$post_id);
    ?>

    <?php if (!is_front_page()) { ?>
        
        <?php if ($page_header == 1 || $page_header == '' ) { ?>

        <section id="subheader" class="<?php if ( has_post_thumbnail($post_id) && !is_single() && !is_tax('portfolio_category') ) { echo 'has_header_image'; } ?>">
            
            <?php if ( has_post_thumbnail($post_id) && !is_single() && !is_tax('portfolio_category') ) { ?>
            <div class="page-header-image">
                <?php if ( $page_header_image_overlay == '1' ) echo '<div class="gg-image-overlay"></div>'; ?>
                    <?php
                        $thumbnail_id = get_post_thumbnail_id( $post_id );    
                        $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($thumbnail_id), 'full');  
                        $img_src = gg_aq_resize( get_post_thumbnail_id($post_id), 1270, 256, true, true );
                        if (is_woocommerce_activated() && ( is_shop() || is_product_category() ) ) {
                            echo '<a href="' . esc_url($large_image_url[0]) . '" title="' . the_title_attribute('echo=0') . '" >';
                            echo '<img class="wp-post-image" src="'.esc_url($img_src).'" alt="'.get_the_title( $thumbnail_id ).'" />'; 
                            echo '</a>';
                        //check for blog page   
                        } elseif (is_home()) {
                            echo '<img class="wp-post-image" src="'.esc_url($img_src).'" alt="'.get_the_title( $thumbnail_id ).'" />';
                        } else {
                            echo '<img class="wp-post-image" src="'.esc_url($img_src).'" alt="'.get_the_title( $thumbnail_id ).'" />';
                        } 
                    ?>
            </div>
            <?php } ?>

            <div class="container <?php echo esc_attr($page_heading_position); ?>">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-8">
                        
                        <header class="page-title">
                            <?php if (is_woocommerce_activated() && (is_shop() || is_product_category())) { ?>
                                
                                <h1><?php woocommerce_page_title(); ?></h1>
                            
                            <?php } elseif (is_home()) { ?>

                            <h1><?php echo get_the_title($post_id);?></h1>

                            <?php } else { ?>

                                <h1><?php the_title();?></h1>
                            
                            <?php } ?>
                        </header>

                        <?php if (function_exists('gg_breadcrumbs')) {
                            gg_breadcrumbs();
                        } ?>

                    </div><!--/.col-8 col-sm-8 col-lg-8 -->

                    <div class="col-xs-6 col-sm-6 col-md-4">
                        <!-- Begin social-media -->
                            <?php include PARENT_DIR . '/lib/headers/social-media.php';?>    
                        <!-- End social-media -->
                    </div><!--/.col-4 col-sm-4 col-lg-4 -->

                </div><!--/.row -->
            </div>

            <?php if ($page_description != '') { ?>
            <div class="container header-page-description">
                <div class="row">
                    <div class="col-md-12">
                        <p class="lead"><?php echo esc_html($page_description); ?></p>
                    </div>
                </div>
            </div>
            <?php } ?>

            <?php 
            if ( class_exists('bbPress') ) {
                if ( bbp_is_forum_archive() ) {
                    if( 1 == get_theme_mod( 'forum_index_search', 1 ) ) { ?>
                        <div class="container bbp-search-form">
                            <?php bbp_get_template_part( 'form', 'search' ); ?>
                        </div>
                    <?php } ?>
                <?php 
            } }
            ?>

        </section>
        <?php } ?>

<?php
    }
}
endif;

if ( ! function_exists( 'vilan_page_header_slider' ) ) :
/**
 * Display page header
*/
function vilan_page_header_slider() {
    global $post;
    

    if (is_home()) {
        $post_id = get_option('page_for_posts');
    } elseif (is_woocommerce_activated() && (is_woocommerce() || is_product_category())) {
        $shop_page_id = woocommerce_get_page_id( 'shop' );
        $post_id = $shop_page_id;
    } else {
        $post_id = $post->ID;
    }


    ?>
    
    <?php
    $page_header_slider = rwmb_meta('gg_page_header_slider','',$post_id);
    $rev_slider_alias = rwmb_meta('gg_page_header_slider_select','',$post_id);
    ?>

    <?php if ($page_header_slider) { ?>
    <section id="subheader-slider">
        <?php echo do_shortcode('[rev_slider '.esc_html($rev_slider_alias).']'); ?>
    </section>
    <?php } ?>

    <?php
}
endif;

/**
 * Excerpt read more
 *
 */

function gg_excerpt_more( $more ) {
    return '<br class="read-more-spacer"> <a class="more-link btn btn-default clearfix" href="'. esc_url(get_permalink( get_the_ID() )) . '">' . __('Read More', OKTHEMES_TEXTDOMAIN) . '</a>';
}
add_filter( 'excerpt_more', 'gg_excerpt_more' );

/**
 * Read more
 *
 */
function wpse63748_add_morelink_class( $link, $text )
{
    return str_replace(
         'more-link'
        ,'more-link btn btn-default clearfix'
        ,$link
    );
}
add_action( 'the_content_more_link', 'wpse63748_add_morelink_class', 10, 2 );

/**
 * Tags widget style
 *
 */

function gg_vilan_tag_cloud_widget($args) {
    $args['number'] = 0; //adding a 0 will display all tags
    $args['largest'] = 12; //largest tag
    $args['smallest'] = 12; //smallest tag
    $args['unit'] = 'px'; //tag font unit
    $args['format'] = 'list'; //ul with a class of wp-tag-cloud
    return $args;
}
add_filter( 'widget_tag_cloud_args', 'gg_vilan_tag_cloud_widget',10,1);


/**
 * Display template for post footer information (in single.php).
 *
 */
if (!function_exists('vilan_posted_in')) :
    function vilan_posted_in() {

    // Translators: used between list items, there is a space after the comma.
    $tag_list = get_the_tag_list('<ul class="list-inline post-tags"><li>','</li><li>','</li></ul>');

    // Translators: 1 is the tags
    if ( $tag_list ) {
        $utility_text = __( '%1$s', OKTHEMES_TEXTDOMAIN );
    } 

    printf($tag_list);

}

endif;


/**
 * Adds custom classes to the array of body classes.
 *
 */
if (!function_exists('gg_theme_body_classes')) :
    function gg_theme_body_classes($classes) {


        if ( 'boxed' === get_theme_mod( 'layout_style', 'boxed') ) {
          $classes[] = 'has-boxed-layout';
        } else { 
          $classes[] = 'has-full-layout';
        }


        if (!is_multi_author()) {
            $classes[] = 'single-author';
        }

        if (is_page_template('theme-templates/portfolio.php')) {
            $classes[] = 'gg-portfolio-template';
        }
        if (is_page_template('theme-templates/team.php')) {
            $classes[] = 'gg-team-template';
        }
        if (is_page_template('theme-templates/testimonials.php')) {
            $classes[] = 'gg-testimonials-template';
        }
        if (is_page_template('theme-templates/contact.php')) {
            $classes[] = 'gg-contact-template';
        }
        
        // current language code if wpml is installed
        if( function_exists( 'icl_get_home_url' ) ) {
              $classes[] = ICL_LANGUAGE_CODE;
        }

        if ( get_theme_mod('product_add_to_cart', 1) == 0 ) {
            $classes[] = 'gg-single-add-to-cart-removed';
        }

        if ( get_theme_mod( 'header_sticky', false) === true ) {
            $classes[] = 'gg-header-is-sticky';
        }

        if ( get_theme_mod( 'header_style', 'default') == 'centered' ) {
            $classes[] = 'gg-header-is-centered';
        }    

        return $classes;
    }
    add_filter('body_class', 'gg_theme_body_classes');
endif;


/**
 * Define default page titles.
 *
 */
if (!function_exists('vilan_wp_title')) :
    function vilan_wp_title($title, $sep) {
        global $paged, $page;
        if (is_feed()) {
            return $title;
        }
        // Add the site name.
        $title .= get_bloginfo('name');
        // Add the site description for the home/front page.
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && (is_home() || is_front_page())) {
            $title = "$title $sep $site_description";
        }
        // Add a page number if necessary.
        if ($paged >= 2 || $page >= 2) {
            $title = "$title $sep " . sprintf(__('Page %s', OKTHEMES_TEXTDOMAIN), max($paged, $page));
        }
        return $title;
    }
    add_filter('wp_title', 'vilan_wp_title', 10, 2);
endif;

/**
 * Display template for pagination.
 *
 */
if (!function_exists('pagination')) :
function pagination($pages = '', $range = 2)
{ 
     $showitems = ($range * 2)+1; 

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }  

     if(1 != $pages)
     {
         echo "<ul class=\"pagination\">";
         echo "<li class=\"disabled\"><span class=\"img-rounded page-of\">Page ".esc_html($paged)." of ".esc_html($pages)."</span></li>";

         if($paged > 2 && $paged > $range+1 && $showitems < $pages) {
            echo "<li><a class=\"img-rounded\" href='".esc_url(get_pagenum_link(1))."'>&laquo; First</a></li>";
         }
         if($paged > 1 && $showitems < $pages) {
            echo "<li><a class=\"img-rounded\" href='".esc_url(get_pagenum_link($paged - 1))."'>&lsaquo; Previous</a></li>";
         }

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                if ($paged == $i) {
                    echo "<li><span class=\"current img-rounded\">".esc_html($i)."</span></li>";
                } else {
                    echo "<li><a href='".esc_url(get_pagenum_link($i))."' class=\"img-rounded inactive\">".esc_html($i)."</a></li>";
                }
             }
         }

         if ($paged < $pages && $showitems < $pages) {
            echo "<li><a class=\"img-rounded\" href=\"".esc_url(get_pagenum_link($paged + 1))."\">Next &rsaquo;</a></li>"; 
         }
            
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) {
            echo "<li><a class=\"img-rounded\" href='".esc_url(get_pagenum_link($pages))."'>Last &raquo;</a></li>";
         }
            
         echo "</ul>\n";
     }
}
endif;


add_filter( 'the_password_form', 'custom_password_form' );
function custom_password_form() {
 
    global $post;
 
    $label = 'pwbox-'.(empty($post->ID) ? rand() : $post->ID);
 
    $output = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
 
    <p>' . __("This post is password protected. To view it please enter your password below:","okthemes") . '</p>
 
    <div class="input-group"><span class="input-group-addon"><i class="icon_lock_alt"></i></span><label class="sr-only" for="' . esc_attr($label) . '">' . esc_attr__("Password","okthemes") . '</label><input name="post_password" id="' . esc_attr($label) . '" type="password" placeholder=' . esc_attr__("Password","okthemes") . ' size="20" /><span class="input-group-btn"><input type="submit" name="Submit" value="' . esc_attr__("Submit","okthemes") . '" /></span></div></form>'; 
    return $output;
 
}

/**
 * Get tax term slug
 */
if (!function_exists('gg_tax_terms_slug')) :
    function gg_tax_terms_slug($taxonomy) {
        global $post, $post_id;

        $return = '';
        // get post by post id
        $post = get_post($post->ID);
        // get post type by post
        $post_type = $post->post_type;
        // get post type taxonomies
        $terms = get_the_terms( $post->ID, $taxonomy );
        if ( !empty( $terms ) ) {
            $out = array();
            foreach ( $terms as $term )
                $out[] = 'grid-cat-' . $term->slug;
            $return = join( ' ', $out );
        }
        return $return;
    }
endif;

// get taxonomies terms links
if (!function_exists('portfolio_taxonomies_terms_links')) :
    function portfolio_taxonomies_terms_links(){
      global $post;
      // get post by post id
      $post = get_post( $post->ID );

      // get post type by post
      $post_type = 'portfolio_cpt';

      // get post type taxonomies
      $taxonomy_slug = 'portfolio_category';

      $out = array();
        // get the terms related to post
        $terms = get_the_terms( $post->ID, $taxonomy_slug );

        if ( !empty( $terms ) ) {
          //$out[] = "<p class='meta'><span class='post-comments'><i class='icon_menu-square_alt2'>";
          foreach ( $terms as $term ) {
            //$out[] = $term->name;
            $out[] =
              '  <a href="'
            .    get_term_link( $term->slug, $taxonomy_slug ) .'">'
            .    $term->name
            . "</a>\n";
          }
          //$out[] = "</span></p>\n";
        }

      return implode(',', $out );
    }
endif;

add_filter('wpb_widget_title', 'override_widget_title', 10, 2);
function override_widget_title($output = '', $params = array('')) {
  $extraclass = (isset($params['extraclass'])) ? " ".$params['extraclass'] : "";
  return '<h3 class="entry-title'.$extraclass.'">'.$params['title'].'</h3>';
}

function add_wpb_to_body_if_shortcode($classes) {
    global $post;
    if (isset($post->post_content) && false !== stripos($post->post_content, '[vc_row')) {
        array_push($classes, 'wpb-is-on');
    } else {
        array_push($classes, 'wpb-is-off');
    }
    return $classes;
}

add_filter('body_class', 'add_wpb_to_body_if_shortcode', 100, 1);

/**
 * Replaces the login header logo
 */
if (!function_exists('wp_admin_login_style')) :
    add_action( 'login_head', 'wp_admin_login_style' );
    function wp_admin_login_style() {
        if ( get_theme_mod( 'admin_logo' ) ) {
            echo '<style>
            .login h1 a { 
                background-image: url( '.esc_url(get_theme_mod('admin_logo')).' ) !important; 
                background-size:'.esc_attr(get_theme_mod('admin_logo_width')).'px '.esc_attr(get_theme_mod('admin_logo_height')).'px;
                width:'.esc_attr(get_theme_mod('admin_logo_width')).'px;
                height:'.esc_attr(get_theme_mod('admin_logo_height')).'px;
                margin-bottom:15px; 
            }
            </style>'; 
        }
    }
endif;

/**
 * Color shift a hex value by a specific percentage factor
 *
 * @param string $supplied_hex Any valid hex value. Short forms e.g. #333 accepted.
 * @param string $shift_method How to shift the value e.g( +,up,lighter,>)
 * @param integer $percentage Percentage in range of [0-100] to shift provided hex value by
 * @return string shifted hex value
 * @version 1.0 2008-03-28
 */
if (!function_exists('gg_hex_shift')) :
    function gg_hex_shift( $supplied_hex, $shift_method, $percentage = 50 ) {
        $shifted_hex_value = null;
        $valid_shift_option = FALSE;
        $current_set = 1;
        $RGB_values = array( );
        $valid_shift_up_args = array( 'up', '+', 'lighter', '>' );
        $valid_shift_down_args = array( 'down', '-', 'darker', '<' );
        $shift_method = strtolower( trim( $shift_method ) );

        // Check Factor
        if ( !is_numeric( $percentage ) || ($percentage = ( int ) $percentage) < 0 || $percentage > 100 ) {
            trigger_error( "Invalid factor", E_USER_ERROR );
        }

        // Check shift method
        foreach ( array( $valid_shift_down_args, $valid_shift_up_args ) as $options ) {
            foreach ( $options as $method ) {
                if ( $method == $shift_method ) {
                    $valid_shift_option = !$valid_shift_option;
                    $shift_method = ( $current_set === 1 ) ? '+' : '-';
                    break 2;
                }
            }
            ++$current_set;
        }

        if ( !$valid_shift_option ) {
            trigger_error( "Invalid shift method", E_USER_ERROR );
        }

        // Check Hex string
        switch ( strlen( $supplied_hex = ( str_replace( '#', '', trim( $supplied_hex ) ) ) ) ) {
            case 3:
                if ( preg_match( '/^([0-9a-f])([0-9a-f])([0-9a-f])/i', $supplied_hex ) ) {
                    $supplied_hex = preg_replace( '/^([0-9a-f])([0-9a-f])([0-9a-f])/i', '\\1\\1\\2\\2\\3\\3', $supplied_hex );
                } else {
                    trigger_error( "Invalid hex color value", E_USER_ERROR );
                }
                break;
            case 6:
                if ( !preg_match( '/^[0-9a-f]{2}[0-9a-f]{2}[0-9a-f]{2}$/i', $supplied_hex ) ) {
                    trigger_error( "Invalid hex color value", E_USER_ERROR );
                }
                break;
            default:
                trigger_error( "Invalid hex color length", E_USER_ERROR );
        }

        // Start shifting
        $RGB_values['R'] = hexdec( $supplied_hex{0} . $supplied_hex{1} );
        $RGB_values['G'] = hexdec( $supplied_hex{2} . $supplied_hex{3} );
        $RGB_values['B'] = hexdec( $supplied_hex{4} . $supplied_hex{5} );

        foreach ( $RGB_values as $c => $v ) {
            switch ( $shift_method ) {
                case '-':
                    $amount = round( ((255 - $v) / 100) * $percentage ) + $v;
                    break;
                case '+':
                    $amount = $v - round( ($v / 100) * $percentage );
                    break;
                default:
                    trigger_error( "Oops. Unexpected shift method", E_USER_ERROR );
            }

            $shifted_hex_value .= $current_value = (
                strlen( $decimal_to_hex = dechex( $amount ) ) < 2
                ) ? '0' . $decimal_to_hex : $decimal_to_hex;
        }

        return '#' . $shifted_hex_value;
    }
endif;

if (! function_exists('gg_hex_r')) :
function gg_hex_r($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return implode(",", $rgb); // returns the rgb values separated by commas
   //return $rgb; // returns an array with the rgb values
}
endif;