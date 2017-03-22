<?php
add_action( 'tgmpa_register', 'vilan_register_required_plugins' );

function vilan_register_required_plugins() {
    $plugins = array(
        array(
            'name'               => 'WPBakery Visual Composer', // The plugin name
            'slug'               => 'js_composer', // The plugin slug (typically the folder name)
            'source'             => get_stylesheet_directory() . '/plugins/js_composer.zip', // The plugin source
            'required'           => true, // If false, the plugin is only 'recommended' instead of required
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'       => '', // If set, overrides default API URL and points to an external URL
            'version'            => '4.12',
        ),

        array(
            'name'               => 'Slider Revolution', // The plugin name
            'slug'               => 'revslider', // The plugin slug (typically the folder name)
            'source'             => get_stylesheet_directory() . '/plugins/revslider.zip', // The plugin source
            'required'           => false, // If false, the plugin is only 'recommended' instead of required
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'       => '', // If set, overrides default API URL and points to an external URL
            'version'            => '5.2.5.4',
        ),
        array(
            'name'      => 'WooCommerce',
            'slug'      => 'woocommerce',
            'required'  => false,
        ),
        array(
            'name'      => 'Ecwid Shopping Cart',
            'slug'      => 'ecwid-shopping-cart',
            'required'  => false,
        ),
        array(
            'name'      => 'YITH WooCommerce Wishlist',
            'slug'      => 'yith-woocommerce-wishlist',
            'required'  => false,
        ),
        array(
            'name'      => 'YITH WooCommerce Compare',
            'slug'      => 'yith-woocommerce-compare',
            'required'  => false,
        ),
        array(
            'name'      => 'YITH WooCommerce Zoom Magnifier',
            'slug'      => 'yith-woocommerce-zoom-magnifier',
            'required'  => false,
        ),
        array(
            'name'      => 'bbPress',
            'slug'      => 'bbpress',
            'required'  => false,
        )
    );

    $config = array(
        'id'           => 'okthemes',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',
    );
    tgmpa( $plugins, $config );
}
?>