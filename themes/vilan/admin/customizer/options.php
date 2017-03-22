<?php
// Add Custom Controls
require_once PARENT_DIR . '/admin/customizer/layout/pattern-picker-custom-control.php';
require_once PARENT_DIR . '/admin/customizer/text/textarea-custom-control.php';
require_once PARENT_DIR . '/admin/customizer/text/separator-custom-control.php';
require_once PARENT_DIR . '/admin/customizer/select/google-font-dropdown-custom-control.php';
require_once PARENT_DIR . '/admin/customizer/google-fonts.php';
require_once PARENT_DIR . '/admin/customizer/system-fonts.php';
require_once PARENT_DIR . '/admin/customizer/patterns.php';
require_once PARENT_DIR . '/admin/customizer/font-weights.php';
require_once PARENT_DIR . '/admin/customizer/import-export.php';

add_action( 'customize_register', 'options_theme_customizer_register' );
function options_theme_customizer_register($wp_customize) {

	/**
	 * Layout section
	 */
    $wp_customize->add_section(
        'layout_section',
        array(
            'title' => 'General &amp; Layout',
            'description' => 'Various layout options.',
            'priority' => 1,
        )
    );

		/* Retina */
    	$wp_customize->add_setting(
		    'retina',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'retina',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/disable retina images support?',
		        'section' => 'layout_section',
		        'priority' => 2,
		        'settings'   => 'retina',
		    )
		);

		/* Layout style */
    	$wp_customize->add_setting(
		    'layout_style',
		    array(
		        'default' => 'boxed',
		    )
		);
		$wp_customize->add_control(
		    'layout_style',
		    array(
		        'type' => 'select',
		        'label' => 'Layout style',
		        'section' => 'layout_section',
		        'choices' => array(
		            'full' => 'Fullwidth',
					'boxed' => 'Boxed'
		        ),
		        'priority' => 3,
		        'settings'   => 'layout_style',
		    )
		);

		


	/**
	 * Logo section
	 */
    $wp_customize->add_section(
        'logos_section',
        array(
            'title' => 'Logos',
            'description' => 'Upload theme logos',
            'priority' => 2,
        )
    );
    	/* Tagline check */
    	$wp_customize->add_setting(
		    'tagline_check',
		    array(
		        'default' => true,
		    )
		);
		$wp_customize->add_control(
		    'tagline_check',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Display site tagline?',
		        'section' => 'title_tagline',
		        'settings'   => 'tagline_check',
		    )
		);

		/* Separator */
    	$wp_customize->add_setting('logo_separator');
		$wp_customize->add_control(
		    new Separator_Custom_Control(
		        $wp_customize,
		        'logo_separator',
		        array(
			        'section' => 'logos_section',
			        'priority' => 1,
		        )
		    )
		);
    	/* Main logo check */
    	$wp_customize->add_setting(
		    'logo_check',
		    array(
		        'default' => false,
		    )
		);
		$wp_customize->add_control(
		    'logo_check',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Display a custom image/logo image in place of title header. For retina display please upload the logo at twice the normal size.',
		        'section' => 'logos_section',
		        'priority' => 1,
		        'settings'   => 'logo_check',
		    )
		);
		
    	/* Main logo */
    	$wp_customize->add_setting(
		    'main_logo',
		    array(
		        'default'      => ''
		    )
		);
		$wp_customize->add_control(
		    new WP_Customize_Image_Control(
		        $wp_customize,
		        'main_logo',
		        array(
		            'label'    => 'Logo',
		            'settings' => 'main_logo',
		            'section'  => 'logos_section',
		            'priority' => 2,
		        )
		    )
		);
		
		/* Logo width */
		$wp_customize->add_setting(
		    'logo_width',
		    array(
		        'default' => '',
		    )
		);
		$wp_customize->add_control(
		    'logo_width',
		    array(
		        'label' => 'Logo width',
		        'section' => 'logos_section',
		        'type' => 'text',
		        'priority' => 3,
		    )
		);

		/* Logo height */
		$wp_customize->add_setting(
		    'logo_height',
		    array(
		        'default' => '',
		    )
		);
		$wp_customize->add_control(
		    'logo_height',
		    array(
		        'label' => 'Logo height',
		        'section' => 'logos_section',
		        'type' => 'text',
		        'priority' => 4,
		    )
		);

		/* Logo margin-top */
		$wp_customize->add_setting(
		    'logo_margin_top',
		    array(
		        'default' => '0',
		    )
		);
		$wp_customize->add_control(
		    'logo_margin_top',
		    array(
		        'label' => 'Logo margin top (in px)',
		        'section' => 'logos_section',
		        'type' => 'text',
		        'priority' => 5,
		    )
		);

		/* Main logo retina */
    	$wp_customize->add_setting(
		    'main_logo_retina',
		    array(
		        'default'      => ''
		    )
		);
		$wp_customize->add_control(
		    new WP_Customize_Image_Control(
		        $wp_customize,
		        'main_logo_retina',
		        array(
		            'label'    => 'Retina Logo (@2x)',
		            'settings' => 'main_logo_retina',
		            'section'  => 'logos_section',
		            'priority' => 6,
		        )
		    )
		);

		/* Separator */
    	$wp_customize->add_setting('admin_logo_separator');
		$wp_customize->add_control(
		    new Separator_Custom_Control(
		        $wp_customize,
		        'admin_logo_separator',
		        array(
			        'section' => 'logos_section',
			        'priority' => 7,
		        )
		    )
		);

		/* WP admin logo check */
    	$wp_customize->add_setting(
		    'admin_logo_check',
		    array(
		        'default' => false,
		    )
		);
		$wp_customize->add_control(
		    'admin_logo_check',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Display a custom image/logo on the wp admin login area.',
		        'section' => 'logos_section',
		        'priority' => 8,
		    )
		);
		/* WP admin logo */
    	$wp_customize->add_setting(
		    'admin_logo',
		    array(
		        'default'      => ''
		    )
		);
		$wp_customize->add_control(
		    new WP_Customize_Image_Control(
		        $wp_customize,
		        'admin_logo',
		        array(
		            'label'    => 'WP Admin Logo',
		            'settings' => 'admin_logo',
		            'section'  => 'logos_section',
		            'priority' => 9,
		        )
		    )
		);
		
		/* WP Admin Logo width */
		$wp_customize->add_setting(
		    'admin_logo_width',
		    array(
		        'default' => '',
		    )
		);
		$wp_customize->add_control(
		    'admin_logo_width',
		    array(
		        'label' => 'WP Admin Logo width',
		        'section' => 'logos_section',
		        'type' => 'text',
		        'priority' => 10,
		    )
		);

		/* WP Admin Logo height */
		$wp_customize->add_setting(
		    'admin_logo_height',
		    array(
		        'default' => '',
		    )
		);
		$wp_customize->add_control(
		    'admin_logo_height',
		    array(
		        'label' => 'WP Admin Logo height',
		        'section' => 'logos_section',
		        'type' => 'text',
		        'priority' => 11,
		    )
		);

		/* Separator */
    	$wp_customize->add_setting('favicon_separator');
		$wp_customize->add_control(
		    new Separator_Custom_Control(
		        $wp_customize,
		        'favicon_separator',
		        array(
			        'section' => 'logos_section',
			        'priority' => 12,
		        )
		    )
		);

		/* Favicon logo */
    	$wp_customize->add_setting(
		    'favicon_logo',
		    array(
		        'default'      => ''
		    )
		);
		$wp_customize->add_control(
		    new WP_Customize_Image_Control (
		        $wp_customize,
		        'favicon_logo',
		        array(
		            'label'    => 'Favicon Logo (16x16px)',
		            'settings' => 'favicon_logo',
		            'section'  => 'logos_section',
		            'priority' => 13,
		        )
		    )
		);

	/**
	 * Header section
	 */
    $wp_customize->add_section(
        'header_section',
        array(
            'title' => 'Header',
            'description' => 'Various header options.',
            'priority' => 3,
        )
    );

    	/* Header style */
    	$wp_customize->add_setting(
		    'header_style',
		    array(
		        'default' => 'default',
		    )
		);
		$wp_customize->add_control(
		    'header_style',
		    array(
		        'type' => 'select',
		        'label' => 'Header style',
		        'section' => 'header_section',
		        'choices' => array(
		            'default' => 'Inline (Default)',
					'centered' => 'Centered'
		        ),
		        'priority' => 1,
		        'settings'   => 'header_style',
		    )
		);

		/* Sticky */
    	$wp_customize->add_setting(
		    'header_sticky',
		    array(
		        'default' => false,
		    )
		);
		$wp_customize->add_control(
		    'header_sticky',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/disable sticky header?',
		        'section' => 'header_section',
		        'priority' => 2,
		        'settings'   => 'header_sticky',
		    )
		);

    	/* Header search */
    	$wp_customize->add_setting(
		    'header_search',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'header_search',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable header search.',
		        'section' => 'header_section',
		        'priority' => 3,
		    )
		);

		/* Header cart */
    	$wp_customize->add_setting(
		    'header_cart',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'header_cart',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable header cart.',
		        'section' => 'header_section',
		        'priority' => 4,
		    )
		);
    	
		/* Subheader social icons */
    	$wp_customize->add_setting(
		    'header_social_icns',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'header_social_icns',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable subheader social icons.',
		        'section' => 'header_section',
		        'priority' => 5,
		    )
		);
		
		/* WPML language box */
    	$wp_customize->add_setting(
		    'header_wpml_box',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'header_wpml_box',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable header WPML language box. WPML plugin must be installed.',
		        'section' => 'header_section',
		        'priority' => 6,
		    )
		);

	/**
	 * Footer section
	 */
    $wp_customize->add_section(
        'footer_section',
        array(
            'title' => 'Footer',
            'description' => 'Various footer options.',
            'priority' => 999,
        )
    );
		/* Footer extras */
    	$wp_customize->add_setting(
		    'footer_extras',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'footer_extras',
		    array(
		        'type' => 'checkbox',
		        'label' => ' Enable/Disable footer extras (Copyright).',
		        'section' => 'footer_section',
		        'priority' => 2,
		    )
		);
		/* Footer copyright */
		$wp_customize->add_setting(
		    'footer_extras_copyright',
		    array(
		        'default' => 'Copyright 2014 - All rights reserved Vilan',
		    )
		);
		$wp_customize->add_control(
		    'footer_extras_copyright',
		    array(
		        'label' => 'Footer copyright',
		        'section' => 'footer_section',
		        'type' => 'text',
		        'priority' => 3,
		    )
		);

	/**
	 * Comments section
	 */
    $wp_customize->add_section(
        'comments_section',
        array(
            'title' => 'Comments',
            'description' => 'Choose to enable/disable comments on all pages or posts.',
            'priority' => 998,
        )
    );
    	/* Page comments */
    	$wp_customize->add_setting(
		    'general_page_comments'
		);
		$wp_customize->add_control(
		    'general_page_comments',
		    array(
		        'type' => 'checkbox',
		        'label' => ' Enable/Disable comments on all pages.',
		        'section' => 'comments_section',
		        'priority' => 1,
		    )
		);
		/* Posts comments */
    	$wp_customize->add_setting(
		    'general_post_comments',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'general_post_comments',
		    array(
		        'type' => 'checkbox',
		        'label' => ' Enable/Disable comments on all posts..',
		        'section' => 'comments_section',
		        'priority' => 2,
		    )
		);

	/**
	 * Custom CSS section
	 */
    $wp_customize->add_section(
        'css_section',
        array(
            'title' => 'Custom CSS',
            'description' => 'Your custom CSS goes here. Do not include the style tag.This is already done for you.',
            'priority' => 998,
        )
    );
		
		$wp_customize->add_setting( 
			'custom_css' 
		);
		$wp_customize->add_control(
		    new Textarea_Custom_Control(
		        $wp_customize,
		        'custom_css',
		        array(
		            'label' => 'CSS',
		            'section' => 'css_section',
		            'priority' => 1
		        )
		    )
		);

	/**
	 * Custom Scripts section
	 */
    $wp_customize->add_section(
        'js_section',
        array(
            'title' => 'Custom Scripts',
            'description' => 'Add custom footer scripts such as Google Analytics. Do not include the script tag. This is already done for you.',
            'priority' => 997,
        )
    );
		
		$wp_customize->add_setting( 
			'custom_js' 
		);
		$wp_customize->add_control(
		    new Textarea_Custom_Control(
		        $wp_customize,
		        'custom_js',
		        array(
		            'label' => 'JS',
		            'section' => 'js_section',
		            'priority' => 1
		        )
		    )
		);

	/**
	 * Forum section
	 */
    $wp_customize->add_section(
        'forum_section',
        array(
            'title' => 'Forum(bbPress)',
            'description' => 'Customize the forum. bbPress plugin must be installed.',
            'priority' => 4,
        )
    );
    	/* Forum page layout */
    	$wp_customize->add_setting(
		    'forum_page_layout',
		    array(
		        'default' => 'with_right_sidebar',
		    )
		);
		$wp_customize->add_control(
		    'forum_page_layout',
		    array(
		        'type' => 'select',
		        'label' => 'Forum page layout',
		        'section' => 'forum_section',
		        'choices' => array(
		            'with_right_sidebar' => 'With right sidebar',
					'with_left_sidebar' => 'With left sidebar',
					'no_sidebar' => 'Without sidebar'
		        ),
		        'priority' => 1,
		    )
		);

		/* Forum page search */
    	$wp_customize->add_setting(
		    'forum_index_search',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'forum_index_search',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable search on the main forum page. ',
		        'section' => 'forum_section',
		        'priority' => 2,
		    )
		);	

	/**
	 * Store section
	 */
    $wp_customize->add_section(
        'store_section',
        array(
            'title' => 'Store',
            'description' => 'Customize store. WooCommerce plugin must be installed.',
            'priority' => 4,
        )
    );
    	/* Separator */
    	$wp_customize->add_setting('general_store_separator');
		$wp_customize->add_control(
		    new Separator_Custom_Control(
		        $wp_customize,
		        'general_store_separator',
		        array(
		        	'label' => 'General options',
			        'section' => 'store_section',
			        'priority' => 1,
		        )
		    )
		);
		/* Catalog mode */
    	$wp_customize->add_setting(
		    'store_catalog_mode'
		);
		$wp_customize->add_control(
		    'store_catalog_mode',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable catalog mode. This will disable: add to cart, checkout and buy functions.',
		        'section' => 'store_section',
		        'priority' => 2,
		    )
		);

		/* Shop product columns */
    	$wp_customize->add_setting(
		    'shop_product_columns',
		    array(
		        'default' => '3',
		    )
		);
		$wp_customize->add_control(
		    'shop_product_columns',
		    array(
		        'type' => 'select',
		        'label' => 'Shop product columns',
		        'section' => 'store_section',
		        'choices' => array(
		            '2' => '2 columns',
					'3' => '3 columns',
					'4' => '4 columns',
		        ),
		        'priority' => 3,
		    )
		);
		/* Number of products per page */
		$wp_customize->add_setting(
		    'product_per_page',
		    array(
		        'default' => '12',
		    )
		);
		$wp_customize->add_control(
		    'product_per_page',
		    array(
		        'label' => 'Number of products per page',
		        'section' => 'store_section',
		        'type' => 'text',
		        'priority' => 4,
		    )
		);
		/* Wishlist button */
    	$wp_customize->add_setting(
		    'store_add_to_wishlist',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'store_add_to_wishlist',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable wishlist button on product.',
		        'section' => 'store_section',
		        'priority' => 5,
		    )
		);
		/* Compare button */
    	$wp_customize->add_setting(
		    'store_add_to_compare',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'store_add_to_compare',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable compare button on product.',
		        'section' => 'store_section',
		        'priority' => 6,
		    )
		);
		/* Sale flash */
    	$wp_customize->add_setting(
		    'store_sale_flash',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'store_sale_flash',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable sale flash on products.',
		        'section' => 'store_section',
		        'priority' => 7,
		    )
		);
		/* Products price */
    	$wp_customize->add_setting(
		    'store_products_price',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'store_products_price',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable products price.',
		        'section' => 'store_section',
		        'priority' => 8,
		    )
		);
		/* Products Add to cart */
    	$wp_customize->add_setting(
		    'store_add_to_cart',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'store_add_to_cart',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable add to cart button.',
		        'section' => 'store_section',
		        'priority' => 9,
		    )
		);
		
		/* Separator */
    	$wp_customize->add_setting('product_store_separator');
		$wp_customize->add_control(
		    new Separator_Custom_Control(
		        $wp_customize,
		        'product_store_separator',
		        array(
		        	'label' => 'Product options',
			        'section' => 'store_section',
			        'priority' => 10,
		        )
		    )
		);
		/* Product page layout */
    	$wp_customize->add_setting(
		    'product_page_layout',
		    array(
		        'default' => 'no_sidebar',
		    )
		);
		$wp_customize->add_control(
		    'product_page_layout',
		    array(
		        'type' => 'select',
		        'label' => 'Product page layout',
		        'section' => 'store_section',
		        'choices' => array(
		            'with_right_sidebar' => 'With right sidebar',
					'with_left_sidebar' => 'With left sidebar',
					'no_sidebar' => 'Without sidebar'
		        ),
		        'priority' => 11,
		    )
		);
		/* Sale flash */
    	$wp_customize->add_setting(
		    'product_sale_flash',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'product_sale_flash',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable sale flash on products.',
		        'section' => 'store_section',
		        'priority' => 12,
		    )
		);
		/* Products price */
    	$wp_customize->add_setting(
		    'product_products_price',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'product_products_price',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable products price.',
		        'section' => 'store_section',
		        'priority' => 13,
		    )
		);
		/* Product excerpt */
    	$wp_customize->add_setting(
		    'product_products_excerpt',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'product_products_excerpt',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable product excerpt(short description).',
		        'section' => 'store_section',
		        'priority' => 14,
		    )
		);
		/* Product meta */
    	$wp_customize->add_setting(
		    'product_products_meta',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'product_products_meta',
		    array(
		        'type' => 'checkbox',
		        'label' => ' Enable/Disable product meta(sku, category, tag).',
		        'section' => 'store_section',
		        'priority' => 15,
		    )
		);
		/* Product add to cart */
    	$wp_customize->add_setting(
		    'product_add_to_cart',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'product_add_to_cart',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable add to cart button',
		        'section' => 'store_section',
		        'priority' => 16,
		    )
		);
		/* Product Related products*/
    	$wp_customize->add_setting(
		    'product_related_products',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'product_related_products',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable Related products',
		        'section' => 'store_section',
		        'priority' => 17,
		    )
		);
		/* Product Up sells products*/
    	$wp_customize->add_setting(
		    'product_upsells_products',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'product_upsells_products',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable Up Sells products',
		        'section' => 'store_section',
		        'priority' => 18,
		    )
		);
		/* Product Reviews tab */
    	$wp_customize->add_setting(
		    'product_reviews_tab',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'product_reviews_tab',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable reviews tab',
		        'section' => 'store_section',
		        'priority' => 19,
		    )
		);
		/* Product Description tab */
    	$wp_customize->add_setting(
		    'product_description_tab',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'product_description_tab',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable description tab',
		        'section' => 'store_section',
		        'priority' => 20,
		    )
		);
		/* Product Attributes tab */
    	$wp_customize->add_setting(
		    'product_attributes_tab',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'product_attributes_tab',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable attributes tab',
		        'section' => 'store_section',
		        'priority' => 21,
		    )
		);
		/* Separator */
    	$wp_customize->add_setting('cart_store_separator');
		$wp_customize->add_control(
		    new Separator_Custom_Control(
		        $wp_customize,
		        'cart_store_separator',
		        array(
		        	'label' => 'Cart options',
			        'section' => 'store_section',
			        'priority' => 22,
		        )
		    )
		);
		/* Cross Sells products */
    	$wp_customize->add_setting(
		    'product_crosssells_products',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'product_crosssells_products',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable Cross Sells products',
		        'section' => 'store_section',
		        'priority' => 23,
		    )
		);	

	/**
	 * Social Media section
	 */
    $wp_customize->add_section(
        'social_section',
        array(
            'title' => 'Social Media',
            'description' => 'Add your social icons.',
            'priority' => 996,
        )
    );
    	/* RSS link */
		$wp_customize->add_setting(
		    'rss_link'
		);
		$wp_customize->add_control(
		    'rss_link',
		    array(
		        'label' => 'RSS Link (Widget)',
		        'section' => 'social_section',
		        'type' => 'text',
		        'priority' => 1,
		    )
		);
		/* RSS link in header */
    	$wp_customize->add_setting(
		    'rss_link_header',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'rss_link_header',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable icon in header',
		        'section' => 'social_section',
		        'priority' => 2,
		    )
		);

		/* Facebook Link (Widget) */
		$wp_customize->add_setting(
		    'facebook_link'
		);
		$wp_customize->add_control(
		    'facebook_link',
		    array(
		        'label' => 'Facebook Link (Widget)',
		        'section' => 'social_section',
		        'type' => 'text',
		        'priority' => 3,
		    )
		);
		/* Facebook Link in header */
    	$wp_customize->add_setting(
		    'facebook_link_header',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'facebook_link_header',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable icon in header',
		        'section' => 'social_section',
		        'priority' => 4,
		    )
		);

		/* Twitter Link (Widget) */
		$wp_customize->add_setting(
		    'twitter_link',
		    array(
		        'default' => 'okwpthemes',
		    )
		);
		$wp_customize->add_control(
		    'twitter_link',
		    array(
		        'label' => 'Twitter Link (Widget)',
		        'section' => 'social_section',
		        'type' => 'text',
		        'priority' => 5,
		    )
		);
		/* Twitter Link in header */
    	$wp_customize->add_setting(
		    'twitter_link_header',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'twitter_link_header',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable icon in header',
		        'section' => 'social_section',
		        'priority' => 6,
		    )
		);
		/* Twitter Link (Widget) */
		$wp_customize->add_setting(
		    'twitter_link',
		    array(
		        'default' => 'okwpthemes',
		    )
		);
		$wp_customize->add_control(
		    'twitter_link',
		    array(
		        'label' => 'Twitter Link (Widget)',
		        'section' => 'social_section',
		        'type' => 'text',
		        'priority' => 5,
		    )
		);

		/* Skype Link (Widget) */
		$wp_customize->add_setting(
		    'skype_link'
		);
		$wp_customize->add_control(
		    'skype_link',
		    array(
		        'label' => 'Skype Link (Widget)',
		        'section' => 'social_section',
		        'type' => 'text',
		        'priority' => 7,
		    )
		);
		/* Skype Link in header */
    	$wp_customize->add_setting(
		    'skype_link_header',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'skype_link_header',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable icon in header',
		        'section' => 'social_section',
		        'priority' => 8,
		    )
		);

		/* Vimeo Link (Widget) */
		$wp_customize->add_setting(
		    'vimeo_link'
		);
		$wp_customize->add_control(
		    'vimeo_link',
		    array(
		        'label' => 'Vimeo Link (Widget)',
		        'section' => 'social_section',
		        'type' => 'text',
		        'priority' => 9,
		    )
		);
		/* Vimeo Link in header */
    	$wp_customize->add_setting(
		    'vimeo_link_header',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'vimeo_link_header',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable icon in header',
		        'section' => 'social_section',
		        'priority' => 10,
		    )
		);

		/* LinkedIn Link (Widget) */
		$wp_customize->add_setting(
		    'linkedin_link'
		);
		$wp_customize->add_control(
		    'linkedin_link',
		    array(
		        'label' => 'LinkedIn Link (Widget)',
		        'section' => 'social_section',
		        'type' => 'text',
		        'priority' => 11,
		    )
		);
		/* LinkedIn Link in header */
    	$wp_customize->add_setting(
		    'linkedin_link_header',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'linkedin_link_header',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable icon in header',
		        'section' => 'social_section',
		        'priority' => 12,
		    )
		);

		/* Dribble Link (Widget) */
		$wp_customize->add_setting(
		    'dribble_link'
		);
		$wp_customize->add_control(
		    'dribble_link',
		    array(
		        'label' => 'Dribble Link (Widget)',
		        'section' => 'social_section',
		        'type' => 'text',
		        'priority' => 13,
		    )
		);
		/* Dribble Link in header */
    	$wp_customize->add_setting(
		    'dribble_link_header',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'dribble_link_header',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable icon in header',
		        'section' => 'social_section',
		        'priority' => 14,
		    )
		);

		/* Forrst Link (Widget) */
		$wp_customize->add_setting(
		    'forrst_link'
		);
		$wp_customize->add_control(
		    'forrst_link',
		    array(
		        'label' => 'Forrst Link (Widget)',
		        'section' => 'social_section',
		        'type' => 'text',
		        'priority' => 15,
		    )
		);
		/* Forrst Link in header */
    	$wp_customize->add_setting(
		    'forrst_link_header',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'forrst_link_header',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable icon in header',
		        'section' => 'social_section',
		        'priority' => 16,
		    )
		);

		/* Flickr Link (Widget) */
		$wp_customize->add_setting(
		    'flickr_link'
		);
		$wp_customize->add_control(
		    'flickr_link',
		    array(
		        'label' => 'Flickr Link (Widget)',
		        'section' => 'social_section',
		        'type' => 'text',
		        'priority' => 17,
		    )
		);
		/* Flickr Link in header */
    	$wp_customize->add_setting(
		    'flickr_link_header',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'flickr_link_header',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable icon in header',
		        'section' => 'social_section',
		        'priority' => 18,
		    )
		);

		/* Google Link (Widget) */
		$wp_customize->add_setting(
		    'google_link'
		);
		$wp_customize->add_control(
		    'google_link',
		    array(
		        'label' => 'Google Link (Widget)',
		        'section' => 'social_section',
		        'type' => 'text',
		        'priority' => 19,
		    )
		);
		/* Google Link in header */
    	$wp_customize->add_setting(
		    'google_link_header',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'google_link_header',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable icon in header',
		        'section' => 'social_section',
		        'priority' => 20,
		    )
		);

		/* Youtube Link (Widget) */
		$wp_customize->add_setting(
		    'youtube_link'
		);
		$wp_customize->add_control(
		    'youtube_link',
		    array(
		        'label' => 'Youtube Link (Widget)',
		        'section' => 'social_section',
		        'type' => 'text',
		        'priority' => 21,
		    )
		);
		/* Youtube Link in header */
    	$wp_customize->add_setting(
		    'youtube_link_header',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'youtube_link_header',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable icon in header',
		        'section' => 'social_section',
		        'priority' => 22,
		    )
		);

		/* Tumblr Link (Widget) */
		$wp_customize->add_setting(
		    'tumblr_link'
		);
		$wp_customize->add_control(
		    'tumblr_link',
		    array(
		        'label' => 'Tumblr Link (Widget)',
		        'section' => 'social_section',
		        'type' => 'text',
		        'priority' => 23,
		    )
		);
		/* Tumblr Link in header */
    	$wp_customize->add_setting(
		    'tumblr_link_header',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'tumblr_link_header',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable icon in header',
		        'section' => 'social_section',
		        'priority' => 24,
		    )
		);

		/* Pinterest Link (Widget) */
		$wp_customize->add_setting(
		    'pinterest_link',
		    array(
		        'default' => '',
		    )
		);
		$wp_customize->add_control(
		    'pinterest_link',
		    array(
		        'label' => 'Pinterest Link (Widget)',
		        'section' => 'social_section',
		        'type' => 'text',
		        'priority' => 25,
		    )
		);
		/* Pinterest Link in header */
    	$wp_customize->add_setting(
		    'pinterest_link_header',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'pinterest_link_header',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable icon in header',
		        'section' => 'social_section',
		        'priority' => 26,
		    )
		);

		/* Deviantart Link (Widget) */
		$wp_customize->add_setting(
		    'deviantart_link',
		    array(
		        'default' => '',
		    )
		);
		$wp_customize->add_control(
		    'deviantart_link',
		    array(
		        'label' => 'deviantart Link (Widget)',
		        'section' => 'social_section',
		        'type' => 'text',
		        'priority' => 27,
		    )
		);
		/* Deviantart Link in header */
    	$wp_customize->add_setting(
		    'deviantart_link_header',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'deviantart_link_header',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable icon in header',
		        'section' => 'social_section',
		        'priority' => 28,
		    )
		);

		/* Foursquare Link (Widget) */
		$wp_customize->add_setting(
		    'foursquare_link',
		    array(
		        'default' => '',
		    )
		);
		$wp_customize->add_control(
		    'foursquare_link',
		    array(
		        'label' => 'foursquare Link (Widget)',
		        'section' => 'social_section',
		        'type' => 'text',
		        'priority' => 29,
		    )
		);
		/* Foursquare Link in header */
    	$wp_customize->add_setting(
		    'foursquare_link_header',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'foursquare_link_header',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable icon in header',
		        'section' => 'social_section',
		        'priority' => 30,
		    )
		);

		/* Github Link (Widget) */
		$wp_customize->add_setting(
		    'github_link',
		    array(
		        'default' => '',
		    )
		);
		$wp_customize->add_control(
		    'github_link',
		    array(
		        'label' => 'github Link (Widget)',
		        'section' => 'social_section',
		        'type' => 'text',
		        'priority' => 31,
		    )
		);
		/* Github Link in header */
    	$wp_customize->add_setting(
		    'github_link_header',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'github_link_header',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable icon in header',
		        'section' => 'social_section',
		        'priority' => 32,
		    )
		);

	/**
	 * Page templates section
	 */
    $wp_customize->add_section(
        'templates_section',
        array(
            'title' => 'Page templates',
            'description' => 'Customize the style of different pages',
            'priority' => 4,
        )
    );
    	/* Portfolio slug */
		$wp_customize->add_setting(
		    'portfolio_cpt_slug',
		    array(
		        'default' => 'portfolio-item',
		    )
		);
		$wp_customize->add_control(
		    'portfolio_cpt_slug',
		    array(
		        'label' => 'Portfolio slug',
		        'section' => 'templates_section',
		        'type' => 'text',
		        'priority' => 1,
		    )
		);

		/* Separator */
    	$wp_customize->add_setting('portfolio_archive_separator');
		$wp_customize->add_control(
		    new Separator_Custom_Control(
		        $wp_customize,
		        'portfolio_archive_separator',
		        array(
		        	'label' => 'Portfolio Category/Archive page',
			        'section' => 'templates_section',
			        'priority' => 2,
		        )
		    )
		);
		/* Category/archive portfolio layout */
    	$wp_customize->add_setting(
		    'archive_portfolio_page_style',
		    array(
		        'default' => 'fullwidth',
		    )
		);
		$wp_customize->add_control(
		    'archive_portfolio_page_style',
		    array(
		        'type' => 'select',
		        'label' => 'Category/archive portfolio layout',
		        'section' => 'templates_section',
		        'choices' => array(
		            'left' => 'Left sidebar',
					'right' => 'Right sidebar',
					'fullwidth' => 'Fullwidth',
		        ),
		        'priority' => 3,
		    )
		);
		/* Category/archive portfolio columns */
    	$wp_customize->add_setting(
		    'archive_portfolio_page_columns',
		    array(
		        'default' => 'four_columns',
		    )
		);
		$wp_customize->add_control(
		    'archive_portfolio_page_columns',
		    array(
		        'type' => 'select',
		        'label' => 'Category/archive portfolio columns',
		        'section' => 'templates_section',
		        'choices' => array(
		            'four_columns' => '4 Columns',
					'three_columns' => '3 Columns',
					'two_columns' => '2 Columns',
		        ),
		        'priority' => 4,
		    )
		);
		
		/* Separator */
    	$wp_customize->add_setting('portfolio_inner_separator');
		$wp_customize->add_control(
		    new Separator_Custom_Control(
		        $wp_customize,
		        'portfolio_inner_separator',
		        array(
		        	'label' => 'Portfolio inner (single) page',
			        'section' => 'templates_section',
			        'priority' => 5,
		        )
		    )
		);
		
		/* Related posts */
    	$wp_customize->add_setting(
		    'portfolio_related_posts',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'portfolio_related_posts',
		    array(
		        'type' => 'checkbox',
		        'label' => ' Enable/Disable related posts on portfolio inner page',
		        'section' => 'templates_section',
		        'priority' => 9,
		    )
		);
		/* Related posts title */
		$wp_customize->add_setting(
		    'portfolio_related_posts_title',
		    array(
		        'default' => 'Related posts',
		    )
		);
		$wp_customize->add_control(
		    'portfolio_related_posts_title',
		    array(
		        'label' => 'Related posts title',
		        'section' => 'templates_section',
		        'type' => 'text',
		        'priority' => 10,
		    )
		);
		/* Number of related posts to show */
    	$wp_customize->add_setting(
		    'portfolio_related_posts_number',
		    array(
		        'default' => '3',
		    )
		);
		$wp_customize->add_control(
		    'portfolio_related_posts_number',
		    array(
		        'type' => 'select',
		        'label' => 'Number of related posts to show',
		        'section' => 'templates_section',
		        'choices' => array(
		            '2' => '2',
					'3' => '3',
					'4' => '4',
		        ),
		        'priority' => 11,
		    )
		);
		/* Separator */
    	$wp_customize->add_setting('blog_inner_separator');
		$wp_customize->add_control(
		    new Separator_Custom_Control(
		        $wp_customize,
		        'blog_inner_separator',
		        array(
		        	'label' => 'Blog inner (single) page',
			        'section' => 'templates_section',
			        'priority' => 12,
		        )
		    )
		);
		/* Blog inner(single) page style */
    	$wp_customize->add_setting(
		    'blog_inner_page_style',
		    array(
		        'default' => 'right',
		    )
		);
		$wp_customize->add_control(
		    'blog_inner_page_style',
		    array(
		        'type' => 'select',
		        'label' => 'Blog inner(single) page style',
		        'section' => 'templates_section',
		        'choices' => array(
		            'left' => 'Left sidebar',
					'right' => 'Right sidebar',
					'fullwidth' => 'Fullwidth',
		        ),
		        'priority' => 13,
		    )
		);
		
		/* Inner page image */
    	$wp_customize->add_setting(
		    'blog_inner_image',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'blog_inner_image',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable blog page inner image',
		        'section' => 'templates_section',
		        'priority' => 16,
		    )
		);
		/* Share box */
    	$wp_customize->add_setting(
		    'blog_share_box',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'blog_share_box',
		    array(
		        'type' => 'checkbox',
		        'label' => ' Enable/Disable share box on blog inner page',
		        'section' => 'templates_section',
		        'priority' => 16,
		    )
		);
		/* Separator */
    	$wp_customize->add_setting('blog_archive_separator');
		$wp_customize->add_control(
		    new Separator_Custom_Control(
		        $wp_customize,
		        'blog_archive_separator',
		        array(
		        	'label' => 'Blog category/archive page',
			        'section' => 'templates_section',
			        'priority' => 17,
		        )
		    )
		);
		/* Category/archive page style */
    	$wp_customize->add_setting(
		    'archive_page_style',
		    array(
		        'default' => 'right',
		    )
		);
		$wp_customize->add_control(
		    'archive_page_style',
		    array(
		        'type' => 'select',
		        'label' => 'Category/Archive page style',
		        'section' => 'templates_section',
		        'choices' => array(
		            'left' => 'Left sidebar',
					'right' => 'Right sidebar',
					'fullwidth' => 'Fullwidth',
		        ),
		        'priority' => 18,
		    )
		);
		/* Separator */
    	$wp_customize->add_setting('search_separator');
		$wp_customize->add_control(
		    new Separator_Custom_Control(
		        $wp_customize,
		        'search_separator',
		        array(
		        	'label' => 'Search page',
			        'section' => 'templates_section',
			        'priority' => 19,
		        )
		    )
		);
		/* Search page style */
    	$wp_customize->add_setting(
		    'search_page_style',
		    array(
		        'default' => 'right',
		    )
		);
		$wp_customize->add_control(
		    'search_page_style',
		    array(
		        'type' => 'select',
		        'label' => 'Search page style',
		        'section' => 'templates_section',
		        'choices' => array(
		            'left' => 'Left sidebar',
					'right' => 'Right sidebar',
					'fullwidth' => 'Fullwidth',
		        ),
		        'priority' => 20,
		    )
		);
		/* Separator */
    	$wp_customize->add_setting('not_found_separator');
		$wp_customize->add_control(
		    new Separator_Custom_Control(
		        $wp_customize,
		        'not_found_separator',
		        array(
		        	'label' => '404 page',
			        'section' => 'templates_section',
			        'priority' => 21,
		        )
		    )
		);
		/* Not found title */
		$wp_customize->add_setting(
		    'not_found_page_title',
		    array(
		        'default' => 'Ooops page not found ...',
		    )
		);
		$wp_customize->add_control(
		    'not_found_page_title',
		    array(
		        'label' => 'Not found title',
		        'section' => 'templates_section',
		        'type' => 'text',
		        'priority' => 22,
		    )
		);
		/* Not found description */
		$wp_customize->add_setting( 
			'not_found_page_description',
			array(
		        'default' => 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.',
		    ) 
		);
		$wp_customize->add_control(
		    new Textarea_Custom_Control(
		        $wp_customize,
		        'not_found_page_description',
		        array(
		            'label' => 'Not found description',
		            'section' => 'templates_section',
		            'priority' => 23
		        )
		    )
		);
		/* Contact button link */
		$wp_customize->add_setting(
		    'not_found_contact_btn_link',
		    array(
		        'default' => '#',
		    )
		);
		$wp_customize->add_control(
		    'not_found_contact_btn_link',
		    array(
		        'label' => 'Contact button link',
		        'section' => 'templates_section',
		        'type' => 'text',
		        'priority' => 24,
		    )
		);
		/* Search form */
    	$wp_customize->add_setting(
		    'not_found_page_search',
		    array(
		        'default' => '1',
		    )
		);
		$wp_customize->add_control(
		    'not_found_page_search',
		    array(
		        'type' => 'checkbox',
		        'label' => 'Enable/Disable search form on not found page',
		        'section' => 'templates_section',
		        'priority' => 25,
		    )
		);
	
	

    	
		/* Primary color */
		$wp_customize->add_setting(
		    'primary-color',
		    array(
		        'default' => '#33c3ff',
		        'sanitize_callback' => 'sanitize_hex_color'
		    )
		);

		$wp_customize->add_control(
		    new WP_Customize_Color_Control(
		        $wp_customize,
		        'primary-color',
		        array(
		            'label' => 'Primary color',
		            'section' => 'colors',
		            'settings' => 'primary-color',
		            'priority' => 1,
		        )
		    )
		);

		/* Primary accent color */
		$wp_customize->add_setting(
		    'primary-accent-color',
		    array(
		        'default' => '#ff5454',
		        'sanitize_callback' => 'sanitize_hex_color'
		    )
		);

		$wp_customize->add_control(
		    new WP_Customize_Color_Control(
		        $wp_customize,
		        'primary-accent-color',
		        array(
		            'label' => 'Primary accent color',
		            'section' => 'colors',
		            'settings' => 'primary-accent-color',
		            'priority' => 2,
		        )
		    )
		);

		/* Secondary color */
		$wp_customize->add_setting(
		    'secondary-color',
		    array(
		        'default' => '#3b4044',
		        'sanitize_callback' => 'sanitize_hex_color'
		    )
		);

		$wp_customize->add_control(
		    new WP_Customize_Color_Control(
		        $wp_customize,
		        'secondary-color',
		        array(
		            'label' => 'Secondary color',
		            'section' => 'colors',
		            'settings' => 'secondary-color',
		            'priority' => 3,
		        )
		    )
		);

		/* Tertiary color */
		$wp_customize->add_setting(
		    'tertiary-color',
		    array(
		        'default' => '#d9e2e9',
		        'sanitize_callback' => 'sanitize_hex_color'
		    )
		);

		$wp_customize->add_control(
		    new WP_Customize_Color_Control(
		        $wp_customize,
		        'tertiary-color',
		        array(
		            'label' => 'Tertiary color',
		            'section' => 'colors',
		            'settings' => 'tertiary-color',
		            'priority' => 4,
		        )
		    )
		);

		/* Tertiary accent color */
		$wp_customize->add_setting(
		    'tertiary-accent-color',
		    array(
		        'default' => '#f7f8f8',
		        'sanitize_callback' => 'sanitize_hex_color'
		    )
		);

		$wp_customize->add_control(
		    new WP_Customize_Color_Control(
		        $wp_customize,
		        'tertiary-accent-color',
		        array(
		            'label' => 'Tertiary accent color',
		            'section' => 'colors',
		            'settings' => 'tertiary-accent-color',
		            'priority' => 5,
		        )
		    )
		);

		/* Special accent color */
		$wp_customize->add_setting(
		    'special-accent-color',
		    array(
		        'default' => '#33c3ff',
		        'sanitize_callback' => 'sanitize_hex_color'
		    )
		);

		$wp_customize->add_control(
		    new WP_Customize_Color_Control(
		        $wp_customize,
		        'special-accent-color',
		        array(
		            'label' => 'Special accent color',
		            'section' => 'colors',
		            'settings' => 'special-accent-color',
		            'priority' => 6,
		        )
		    )
		);

		/* Separator */
    	$wp_customize->add_setting('font_colors_separator');
		$wp_customize->add_control(
		    new Separator_Custom_Control(
		        $wp_customize,
		        'font_colors_separator',
		        array(
		        	'label' => 'Font colors',
			        'section' => 'colors',
			        'priority' => 7,
		        )
		    )
		);

		/* Text color */
		$wp_customize->add_setting(
		    'text-color',
		    array(
		        'default' => '#999999',
		        'sanitize_callback' => 'sanitize_hex_color'
		    )
		);

		$wp_customize->add_control(
		    new WP_Customize_Color_Control(
		        $wp_customize,
		        'text-color',
		        array(
		            'label' => 'Text color',
		            'section' => 'colors',
		            'settings' => 'text-color',
		            'priority' => 8,
		        )
		    )
		);

		/* Link color */
		$wp_customize->add_setting(
		    'link-color',
		    array(
		        'default' => '#33c3ff',
		        'sanitize_callback' => 'sanitize_hex_color'
		    )
		);

		$wp_customize->add_control(
		    new WP_Customize_Color_Control(
		        $wp_customize,
		        'link-color',
		        array(
		            'label' => 'Link color',
		            'section' => 'colors',
		            'settings' => 'link-color',
		            'priority' => 9,
		        )
		    )
		);

		/* Headings color */
		$wp_customize->add_setting(
		    'headings-color',
		    array(
		        'default' => '#000000',
		        'sanitize_callback' => 'sanitize_hex_color'
		    )
		);

		$wp_customize->add_control(
		    new WP_Customize_Color_Control(
		        $wp_customize,
		        'headings-color',
		        array(
		            'label' => 'Headings color',
		            'section' => 'colors',
		            'settings' => 'headings-color',
		            'priority' => 10,
		        )
		    )
		);

		/* Menu color */
		$wp_customize->add_setting(
		    'menu-color',
		    array(
		        'default' => '#b6bbbf',
		        'sanitize_callback' => 'sanitize_hex_color'
		    )
		);

		$wp_customize->add_control(
		    new WP_Customize_Color_Control(
		        $wp_customize,
		        'menu-color',
		        array(
		            'label' => 'Menu/Footer color',
		            'section' => 'colors',
		            'settings' => 'menu-color',
		            'priority' => 11,
		        )
		    )
		);
		/* Separator */
    	$wp_customize->add_setting('background_color_separator');
		$wp_customize->add_control(
		    new Separator_Custom_Control(
		        $wp_customize,
		        'background_color_separator',
		        array(
		        	'label' => 'Background color',
			        'section' => 'colors',
			        'priority' => 13,
		        )
		    )
		);

	/**
	 * Fonts section
	 */
	global $fontWeightsArrays;

    $wp_customize->add_section(
        'fonts_section',
        array(
            'title' => 'Fonts',
            'description' => 'You have the possibility to select from 650 google fonts and from 6 system fonts (you find them at the beginning of the list).',
            'priority' => 5,
        )
    );
        
        $wp_customize->add_setting( 
        	'body_font', 
        	array(
            	'default' => 'Arial,+sans-serif',
        	) 
        );
        $wp_customize->add_control( 
        	new Google_Font_Dropdown_Custom_Control( 
        		$wp_customize, 
        		'body_font', 
        		array(
		            'label'   => 'Body font family. Default: Arial',
		            'section' => 'fonts_section',
		            'settings'   => 'body_font',
		            'priority' => 1,
		        ) 
		    )
		);

		$wp_customize->add_setting( 
        	'body_font_style', 
        	array(
            	'default' => '400',
        	) 
        );
		$wp_customize->add_control(
		    'body_font_style',
		    array(
		        'type' => 'select',
		        'label' => 'Body font style. Default: 400 (Normal)',
		        'section' => 'fonts_section',
		        'choices' => $fontWeightsArrays,
		        'priority' => 2,
		    )
		);

		//Logo
		$wp_customize->add_setting( 
        	'logo_font', 
        	array(
            	'default' => 'Pacifico',
        	) 
        );

        $wp_customize->add_control( 
        	new Google_Font_Dropdown_Custom_Control( 
        		$wp_customize, 
        		'logo_font', 
        		array(
		            'label'   => 'Logo font. Default: Pacifico',
		            'section' => 'fonts_section',
		            'settings'   => 'logo_font',
		            'priority' => 7,
		        ) 
		    )
		);

		$wp_customize->add_setting( 
        	'logo_font_style', 
        	array(
            	'default' => '400',
        	) 
        );
		$wp_customize->add_control(
		    'logo_font_style',
		    array(
		        'type' => 'select',
		        'label' => 'Logo font style. Default: Normal',
		        'section' => 'fonts_section',
		        'choices' => $fontWeightsArrays,
		        'priority' => 8,
		    )
		);

	/**
	 * Background section
	 */
	$wp_customize->get_section('background_image')->title = __( 'Background', 'okthemes');

		/* Select background type */
    	$wp_customize->add_setting(
		    'background_type_select',
		    array(
		        'default' => 'none',
		    )
		);
		$wp_customize->add_control(
		    'background_type_select',
		    array(
		        'type' => 'select',
		        'label' => 'Background type',
		        'section' => 'background_image',
		        'choices' => array(
		        	'none' => 'None',
		            'image' => 'Background image',
					'pattern' => 'Background pattern'
		        ),
		        'priority' => 1,
		    )
		);

		/* Patterns */
    	$wp_customize->add_setting('background_type_patterns');
		$wp_customize->add_control(
		    new Pattern_Picker_Custom_Control(
		        $wp_customize,
		        'background_type_patterns',
		        array(
		        	'label'   => 'Background pattern',
			        'section' => 'background_image',
			        'priority' => 3,
		        )
		    )
		);

}

/**
 * Registers the Theme Customizer Admin script with WordPress.
 */
function vilan_customizer_scripts() {

	wp_enqueue_script(
		'vilan-theme-customizer-admin',
		get_template_directory_uri() . '/admin/customizer/js/admin-theme-customizer.js',
		array( 'jquery' ),
		'NULL',
		true
	);

}
add_action( 'customize_controls_print_footer_scripts', 'vilan_customizer_scripts' );


function vilan_customizer_style()
{
    ?>
	<style type="text/css">
		
		hr {
			border-width: 8px;
			margin: 0;
		}
		.customizer-separator span.customize-control-title {
			background: #F7FCFE;
			font-size: 12px;
			text-align: center;
			color:#2EA2CC;
			padding: 8px 0;
			margin: 0;
		}
		.customize-layout-list ul li {
			display: inline-block;
		    text-align: center;
		    width: 78px;
		}
		.customize-layout-list ul li img{
			width: 100%;
		}
		#customize-control-background_type_patterns label {
			width: 50px;
			height: 50px;
			float: left;
			text-align: center;
		}

	</style>
    <?php
}

add_action( 'customize_controls_print_footer_scripts', 'vilan_customizer_style');


function mytheme_customize_css()
{
    ?>

    <?php
    global $systemFontTrimmedArrays;
    $body_font = get_theme_mod('body_font','Arial,+sans-serif');
    $logo_font = get_theme_mod('logo_font','Pacifico');

    $body_font_style = get_theme_mod('body_font_style','400');
    $logo_font_style = get_theme_mod('logo_font_style','400');


    $body_font_trimmed = str_replace('+', '', $body_font);
    $logo_font_trimmed = str_replace('+', '', $logo_font);
    ?>
    

	<?php if ( !in_array( $logo_font_trimmed, $systemFontTrimmedArrays ) ) { ?>
		<link href='//fonts.googleapis.com/css?family=<?php echo $logo_font; ?>:<?php echo $logo_font_style; ?>' rel='stylesheet' type='text/css'>
	<?php } ?>


	<style type="text/css">

		body {
			<?php if ( $body_font != 'Arial,+sans-serif' ) { ?>
			font-family: <?php echo str_replace('+', ' ', $body_font); ?>;
			<?php } ?>

			font-weight: <?php echo str_replace('italic', '', get_theme_mod('body_font_style','400')); ?>;
			<?php if (strpos(get_theme_mod('body_font_style','400'), 'italic') !== false) echo "font-style:italic;"; else echo "font-style:normal;"; ?>
			
			color: <?php echo get_theme_mod('text-color','#999999'); ?>;
			<?php 
			global $paternArray;
			if (get_theme_mod('background_type_select') == 'pattern') {
				$pattern = get_theme_mod('background_type_patterns');
				$pattern_url = $paternArray[$pattern];
			?>
			background: url('<?php echo $pattern_url; ?>') repeat left top !important;
			<?php } ?>
		}

		#site-title a.brand {
			font-family: <?php echo str_replace('+', ' ', $logo_font); ?>;
			font-weight: <?php echo str_replace('italic', '', get_theme_mod('logo_font_style','400')); ?>;
			<?php if (strpos(get_theme_mod('logo_font_style','400'), 'italic') !== false) echo "font-style:italic;"; else echo "font-style:normal;"; ?>
		}

		/* Link colors */
		<?php if (get_theme_mod('link-color','#33c3ff') != '#33c3ff') { ?>
			a,
			.btn-default,
			.woocommerce .product-category .gg-category-meta mark.count,
			aside.sidebar-nav .widget.twitter-widget ul li a,
			aside.sidebar-nav .widget.twitter-widget ul li a:hover,
			footer.site-footer a i,
			footer.site-footer a:hover,
			aside.sidebar-nav .widget a:hover,
			.wpb-js-composer .wpb_content_element .widget a:hover,
			aside.sidebar-nav .widget.contact a,
			.pagination > li > a,
			.pagination > li > span,
			.woocommerce .woocommerce-error:before,
			.woocommerce .woocommerce-info:before,
			.woocommerce .woocommerce-message:before,
			.woocommerce-page .woocommerce-error:before,
			.woocommerce-page .woocommerce-info:before,
			.woocommerce-page .woocommerce-message:before {
				color: <?php echo get_theme_mod('link-color','#33c3ff'); ?>;
			}

			a:hover,
			a:focus,
			article.post footer ul.post-tags li a:hover,
			p.meta a:hover {
				color:  <?php echo gg_hex_shift( get_theme_mod('link-color','#33c3ff'), 'darker', 30 ); ?>;
			}
		<?php } ?>

		/* Menu - Footer colors */
		<?php if (get_theme_mod('menu-color','#b6bbbf') != '#b6bbbf') { ?>
			footer.site-footer,
			#main-menu.nav > li > a,
			#main-menu.nav ul li a,
			footer.site-footer .widget ul li,
			.header_mini_cart ul.mini-cart li ul.cart_list li,
			.header-toolbar-wrapper .navbar-nav > li > a {
				color: <?php echo get_theme_mod('menu-color','#b6bbbf'); ?>;
			}
			.main-menu-wrapper ul.navbar-form li ul li input.search-field.form-control::-moz-placeholder {
			  color: <?php echo get_theme_mod('menu-color','#b6bbbf'); ?>;
			}
			.main-menu-wrapper ul.navbar-form li ul li input.search-field.form-control::-webkit-input-placeholder {
			  color: <?php echo get_theme_mod('menu-color','#b6bbbf'); ?>;
			}
			.main-menu-wrapper ul.navbar-form li ul li input.search-field.form-control::-ms-input-placeholder {
			  color: <?php echo get_theme_mod('menu-color','#b6bbbf'); ?>;
			}
		<?php } ?>

		/* Headings colors */
		<?php if (get_theme_mod('headings-color','#000000') != '#000000') { ?>
			h1,
			h2,
			h3,
			h4,
			h5,
			h6,
			.featured-icon-box h3.media-heading,
			.featured-icon-box h3.media-heading a,
			article.post h2.entry-title,
			article.post h2.entry-title a,
			article.post h2.entry-title a:hover,
			body.search article.page h2.entry-title,
			body.search article.page h2.entry-title a,
			body.search article.page h2.entry-title a:hover,
			#subheader .page-title h1,
			aside.sidebar-nav .widget h4.widget-title {
				color: <?php echo get_theme_mod('headings-color','#000000'); ?>;
			}
		<?php } ?>

		/* Primary colors */
		<?php if (get_theme_mod('primary-color','#33c3ff') != '#33c3ff') { ?>

			.page-footer-message,
			.woocommerce #content input.button,
			.woocommerce #respond input#submit,
			.woocommerce a.button,
			.woocommerce button.button,
			.woocommerce input.button,
			.woocommerce-page #content input.button,
			.woocommerce-page #respond input#submit,
			.woocommerce-page a.button,
			.woocommerce-page button.button,
			.woocommerce-page input.button,
			.woocommerce #content input.button.alt,
			.woocommerce #respond input#submit.alt,
			.woocommerce a.button.alt,
			.woocommerce button.button.alt,
			.woocommerce input.button.alt,
			.woocommerce-page #content input.button.alt,
			.woocommerce-page #respond input#submit.alt,
			.woocommerce-page a.button.alt,
			.woocommerce-page button.button.alt,
			.woocommerce-page input.button.alt,
			.btn-primary,
			.btn-default:hover,
			.btn-default:focus,
			.btn-default:active,
			.btn-default.active,
			.open > .dropdown-toggle.btn-default,
			.header_mini_cart ul.mini-cart li ul.cart_list li.buttons .minicart-btn,
			.nav-pills > li.active > a,
			.nav-pills > li.active > a:hover,
			.nav-pills > li.active > a:focus,
			.testimonials-grid blockquote.bubble:hover cite:before,
			.wpb-js-composer .wpb_toggle:before,
			.wpb-js-composer #content h4.wpb_toggle:before,
			.wpb-js-composer .wpb_toggle.wpb_toggle_title_active, 
			.wpb-js-composer #content h4.wpb_toggle.wpb_toggle_title_active,
			.woocommerce #content .quantity .minus,
			.woocommerce #content .quantity .plus,
			.woocommerce .quantity .minus,
			.woocommerce .quantity .plus,
			.woocommerce-page #content .quantity .minus,
			.woocommerce-page #content .quantity .plus,
			.woocommerce-page .quantity .minus,
			.woocommerce-page .quantity .plus,
			#bbpress-forums div.bbp-the-content-wrapper input,
			.bbp-pagination-links a:hover,
			.bbp-pagination-links span.current,
			.pagination > li > span.current,
			.pagination > li > a:hover,
			.pagination > li > span:hover,
			.pagination > li > a:focus,
			.pagination > li > span:focus,
			article.format-link,
			.wpb-js-composer .invert-faq .wpb_toggle.wpb_toggle_title_active,
			.wpb-js-composer .invert-faq #content h4.wpb_toggle.wpb_toggle_title_active,
			.wpb-js-composer .wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header.ui-accordion-header-active,
			.wpb-js-composer .wpb_content_element .wpb_tabs_nav li.ui-tabs-active a,
			.wpb-js-composer .wpb_accordion .wpb_accordion_wrapper .ui-state-default .ui-icon:before,
			.post-social ul li a:hover,
			.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active,
			.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
			.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active,
			.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active,
			#bbpress-forums #bbp-single-user-details,
			.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
			.woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle,
			.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content,
			.woocommerce-page .widget_price_filter .price_slider_wrapper .ui-widget-content {
				background-color: <?php echo get_theme_mod('primary-color','#33c3ff'); ?>;
			}

			/* Jplayer */
			div.jp-play-bar,
			div.jp-volume-bar-value {
				background-color: <?php echo get_theme_mod('primary-color','#33c3ff'); ?> !important;
			}

			.btn-primary,
			.btn-default,
			.btn-default:hover,
			.btn-default:focus,
			.btn-default:active,
			.btn-default.active,
			.open > .dropdown-toggle.btn-default,
			.testimonials-grid blockquote.bubble:hover,
			.woocommerce #content .quantity .minus,
			.woocommerce #content .quantity .plus,
			.woocommerce .quantity .minus,
			.woocommerce .quantity .plus,
			.woocommerce-page #content .quantity .minus,
			.woocommerce-page #content .quantity .plus,
			.woocommerce-page .quantity .minus,
			.woocommerce-page .quantity .plus,
			.bbp-pagination-links a:hover,
			.bbp-pagination-links span.current,
			.pagination > li > span.current,
			.pagination > li > a:hover,
			.pagination > li > span:hover,
			.pagination > li > a:focus,
			.pagination > li > span:focus,
			.team-grid .team-box:hover .thumbnail .caption,
			.form-control,
			.form-control:focus {
				border-color: <?php echo get_theme_mod('primary-color','#33c3ff'); ?>;
			}

			.testimonials-grid blockquote.bubble:hover:before {
				border-top-color: <?php echo get_theme_mod('primary-color','#33c3ff'); ?>;
			}

			#main-menu.nav > li.current-menu-item > a:hover,
			#main-menu.nav > li.current-menu-item:hover > a,
			#main-menu.nav li.current-menu-item > a,
			#main-menu.nav > li > a:hover,
			#main-menu.nav > li > a:focus,
			#main-menu.nav > li > a:active,
			#main-menu.nav > li:hover > a,
			.main-menu-wrapper ul.navbar-form li.icn-preview:hover,
			.header_mini_cart ul.mini-cart li:hover a.cart-parent {
			  box-shadow: inset 0 3px 0 0 <?php echo get_theme_mod('primary-color','#33c3ff'); ?>;
			  -webkit-box-shadow: inset 0 3px 0 0 <?php echo get_theme_mod('primary-color','#33c3ff'); ?>;
			}

			.wpb-js-composer .wpb_toggle.wpb_toggle_title_active:before, 
			.wpb-js-composer #content h4.wpb_toggle.wpb_toggle_title_active:before,
			.woocommerce #content .quantity .minus:hover,
			.woocommerce #content .quantity .plus:hover,
			.woocommerce .quantity .minus:hover,
			.woocommerce .quantity .plus:hover,
			.woocommerce-page #content .quantity .minus:hover,
			.woocommerce-page #content .quantity .plus:hover,
			.woocommerce-page .quantity .minus:hover,
			.woocommerce-page .quantity .plus:hover,
			#bbpress-forums .gg-forum-icon,
			article.format-quote .quote-container blockquote:before,
			#main-menu.nav > li.menu-item-has-children > a:hover:after,
			#main-menu.nav > li.menu-item-has-children:hover > a:after,
			#main-menu.nav ul li.menu-item-has-children > a:hover:after,
			.woocommerce .star-rating, .woocommerce-page .star-rating,
			.counter-holder .counter {
				color: <?php echo get_theme_mod('primary-color','#33c3ff'); ?>;
			}

			/* RGBA color */
			figure.effect-sadie figcaption:before,
			.woocommerce .product-category figure.effect-sadie figcaption:before,
			.woocommerce .product .thumbnail figure.effect-sadie figcaption:before {
				background: rgba(<?php echo gg_hex_r( get_theme_mod('primary-color','#33c3ff'), 'darker', 30 ); ?>, 0.5);
			}

			/* Darker color */

			.btn-primary:hover,
			.btn-primary:focus,
			.btn-primary:active,
			.btn-primary.active,
			.open > .dropdown-toggle.btn-primary,
			.woocommerce #content input.button:hover,
			.woocommerce #respond input#submit:hover,
			.woocommerce a.button:hover,
			.woocommerce button.button:hover,
			.woocommerce input.button:hover,
			.woocommerce-page #content input.button:hover,
			.woocommerce-page #respond input#submit:hover,
			.woocommerce-page a.button:hover,
			.woocommerce-page button.button:hover,
			.woocommerce-page input.button:hover,
			.woocommerce #content input.button.alt:hover,
			.woocommerce #respond input#submit.alt:hover,
			.woocommerce a.button.alt:hover,
			.woocommerce button.button.alt:hover,
			.woocommerce input.button.alt:hover,
			.woocommerce-page #content input.button.alt:hover,
			.woocommerce-page #respond input#submit.alt:hover,
			.woocommerce-page a.button.alt:hover,
			.woocommerce-page button.button.alt:hover,
			.woocommerce-page input.button.alt:hover {
				background-color:  <?php echo gg_hex_shift( get_theme_mod('primary-color','#33c3ff'), 'darker', 30 ); ?>;
			}

			.btn-primary:hover,
			.btn-primary:focus,
			.btn-primary:active,
			.btn-primary.active,
			.open > .dropdown-toggle.btn-primary {
				border-color:  <?php echo gg_hex_shift( get_theme_mod('primary-color','#33c3ff'), 'darker', 30 ); ?>;
			}

			.wpb-js-composer .btn.btn-3d {
				box-shadow: 0 5px 0 <?php echo gg_hex_shift( get_theme_mod('primary-color','#33c3ff'), 'darker', 30 ); ?>;
			}


		<?php } ?>

		<?php if (get_theme_mod('secondary-color','#3b4044') != '#3b4044') { ?>
			.navbar-default,
			footer.site-footer {
				background-color: <?php echo get_theme_mod('secondary-color','#3b4044'); ?>;
			}
			.navbar-default {
				border-color: <?php echo get_theme_mod('secondary-color','#3b4044'); ?>;
			}

			/* Jplayer */
			div.jp-interface {
				background-color: <?php echo get_theme_mod('secondary-color','#3b4044'); ?> !important;
			}
			div.jp-progress,
			div.jp-volume-bar {
				background-color:  <?php echo gg_hex_shift( get_theme_mod('secondary-color','#3b4044'), 'lighter', 30 ); ?> !important;
			}

			/* Darker color */

			#main-menu.nav > li.menu-item-has-children:hover, 
			#main-menu.nav li.current-menu-item > a,
			.navbar-default .navbar-nav > li > a:hover,
			.navbar-default .navbar-nav > li > a:focus,
			#main-menu.nav ul,
			.header_mini_cart ul.mini-cart li ul.cart_list,
			.header_mini_cart ul.mini-cart li:hover a.cart-parent,
			.main-menu-wrapper ul.navbar-form li.icn-preview:hover,
			.main-menu-wrapper ul.navbar-form li ul,
			footer.site-footer .widget.twitter-widget ul li,
			.navbar-default .navbar-nav > .active > a,
			.navbar-default .navbar-nav > .active > a:hover,
			.navbar-default .navbar-nav > .active > a:focus {
				background-color:  <?php echo gg_hex_shift( get_theme_mod('secondary-color','#3b4044'), 'darker', 30 ); ?>;
			}

			footer.site-footer .widget.twitter-widget ul li:before,
			footer.site-footer .widget.twitter-widget ul li:after {
				border-top-color: <?php echo gg_hex_shift( get_theme_mod('secondary-color','#3b4044'), 'darker', 30 ); ?>;
			}

			/* Lighten color */

			#main-menu.nav ul li a:hover,
			.header_mini_cart ul.mini-cart li ul.cart_list li.buttons .minicart-btn.checkout,
			.main-menu-wrapper ul.navbar-form li ul li input.search-field,
			#main-menu.nav ul.sub-menu > li.current-menu-item:hover > a,
			#main-menu.nav ul.sub-menu li.current-menu-item > a {
				background-color:  <?php echo gg_hex_shift( get_theme_mod('secondary-color','#3b4044'), 'lighter', 30 ); ?>;
				color: <?php echo gg_hex_shift( get_theme_mod('secondary-color','#3b4044'), 'lighter', 80 ); ?>;
			}

			#main-menu.nav ul li a,
			.header_mini_cart ul.mini-cart li ul.cart_list li {
				border-bottom-color: <?php echo gg_hex_shift( get_theme_mod('secondary-color','#3b4044'), 'lighter', 10 ); ?>;
			}

		<?php } ?>

		<?php if (get_theme_mod('tertiary-color','#d9e2e9') != '#d9e2e9') { ?>
			aside.sidebar-nav .widget,
			.widget.twitter-widget ul li .post-date,
			#comments .comment,
			.project-description-holder .list-group-item .project-meta-type,
			.team-grid .team-box .thumbnail .caption,
			.testimonials-grid blockquote.bubble,
			.pagination > .disabled > span,
			.pagination > .disabled > span:hover,
			.pagination > .disabled > span:focus,
			.pagination > .disabled > a,
			.pagination > .disabled > a:hover, 
			.pagination > .disabled > a:focus,
			.pagination > li > a,
			.pagination > li > span,
			.panel-body,
			.wpb-js-composer .wpb_content_element .wpb_tabs_nav li,
			.wpb-js-composer .wpb_content_element .wpb_tabs_nav,
			.wpb-js-composer .wpb_tour .wpb_tour_tabs_wrapper .wpb_tab,
			.wpb-js-composer .wpb_content_element.wpb_tabs .wpb_tour_tabs_wrapper .wpb_tab,
			.owl-theme .owl-controls .owl-page span,
			blockquote,
			.table > thead > tr > th,
			.form-control,
			select,
			.panel-default,
			.panel-default > .panel-heading,
			.thumbnail,
			#subheader .header-page-description,
			body.search article.page,
			article.post .article-wrapper,
			.vc_inline-link,
			.post-social,
			article header.entry-header .article-header-body,
			article.post footer,
			article.format-quote .quote-container,
			.woocommerce .product .thumbnail .caption,
			.woocommerce #content .quantity input.qty,
			.woocommerce .quantity input.qty,
			.woocommerce-page #content .quantity input.qty,
			.woocommerce-page .quantity input.qty,
			.woocommerce #content div.product .woocommerce-tabs .panel,
			.woocommerce div.product .woocommerce-tabs .panel,
			.woocommerce-page #content div.product .woocommerce-tabs .panel,
			.woocommerce-page div.product .woocommerce-tabs .panel,
			.woocommerce .woocommerce-error,
			.woocommerce .woocommerce-info,
			.woocommerce .woocommerce-message,
			.woocommerce-page .woocommerce-error,
			.woocommerce-page .woocommerce-info,
			.woocommerce-page .woocommerce-message,
			.woocommerce table.shop_table,
			.woocommerce-page table.shop_table,
			.woocommerce table.shop_table td,
			.woocommerce-page table.shop_table td,
			.woocommerce form.checkout_coupon,
			.woocommerce form.login,
			.woocommerce form.register,
			.woocommerce-page form.checkout_coupon,
			.woocommerce-page form.login,
			.woocommerce-page form.register,
			.woocommerce .product-category .gg-category-meta,
			#bbpress-forums li.bbp-header,
			.single-forum #bbpress-forums ul.bbp-forums,
			#bbpress-forums ul.bbp-topics,
			#bbpress-forums ul.bbp-forums ul.forum,
			.single-forum #bbpress-forums ul.bbp-forums,
			#bbpress-forums ul.bbp-topics,
			#bbpress-forums ul.bbp-forums ul.forum,
			#bbpress-forums ul.bbp-replies li.bbp-body,
			#bbpress-forums #bbp-single-user-details #bbp-user-navigation {
				border-color: <?php echo get_theme_mod('tertiary-color','#d9e2e9'); ?>;
			}

			.testimonials-grid blockquote.bubble:before,
			.woocommerce #payment div.form-row,
			.woocommerce-page #payment div.form-row,
			.woocommerce ul.products li .thumbnail .caption .gg-product-meta,
			.woocommerce .widget_shopping_cart .total,
			.woocommerce-page .widget_shopping_cart .total,
			.woocommerce-page.widget_shopping_cart .total,
			.woocommerce.widget_shopping_cart .total,
			#bbpress-forums .bbp-forums-list li.odd-forum-row,
			#bbpress-forums .bbp-forums-list li.even-forum-row,
			#bbpress-forums li.bbp-body ul.topic,
			.single-forum #bbpress-forums ul.bbp-forums .bbp-body ul.forum,
			#bbpress-forums .bbp-forums-list li.odd-forum-row,
			#bbpress-forums .bbp-forums-list li.even-forum-row,
			#bbpress-forums li.bbp-body ul.topic,
			#bbpress-forums #bbp-single-user-details #bbp-user-navigation li {
				border-top-color: <?php echo get_theme_mod('tertiary-color','#d9e2e9'); ?>;
			}

			aside.sidebar-nav .widget ul li,
			.wpb-js-composer .wpb_content_element .widget ul li,
			#bbpress-forums li.bbp-header,
			.bbp-forum-header,
			.bbp-topic-header,
			.bbp-reply-header,
			#bbpress-forums li.bbp-header {
				border-bottom-color: <?php echo get_theme_mod('tertiary-color','#d9e2e9'); ?>;
			}

			.woocommerce #payment div.payment_box:after,
			.woocommerce-page #payment div.payment_box:after {
				border-color: transparent transparent <?php echo get_theme_mod('tertiary-color','#d9e2e9'); ?>;
			}

			.woocommerce .product_meta .sku_wrapper,
			.woocommerce .product_meta .posted_in,
			.woocommerce .product_meta .tagged_as {
			  border-bottom: 1px solid <?php echo get_theme_mod('tertiary-color','#d9e2e9'); ?>;
			  border-top: 1px solid <?php echo get_theme_mod('tertiary-color','#d9e2e9'); ?>;
			}

			span.post-format,
			.post-format,
			.testimonials-grid blockquote.bubble cite:before,
			.title-subtitle-box hr,
			.counter-holder em:before,
			.nav > li > a:hover, .nav > li > a:focus,
			.post-social ul li a,
			.woocommerce #content div.product .woocommerce-tabs ul.tabs li,
			.woocommerce div.product .woocommerce-tabs ul.tabs li,
			.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li,
			.woocommerce-page div.product .woocommerce-tabs ul.tabs li,
			.woocommerce #payment div.payment_box,
			.woocommerce-page #payment div.payment_box,
			.woocommerce ul.products li .thumbnail .caption .gg-product-meta a.add_to_cart_button:before,
			.woocommerce ul.products li .thumbnail .caption .gg-product-meta a.add_to_wishlist:before,
			.woocommerce ul.products li .thumbnail .caption .gg-product-meta .yith-wcwl-wishlistexistsbrowse a:before,
			.woocommerce ul.products li .thumbnail .caption .gg-product-meta .yith-wcwl-wishlistaddedbrowse a:before,
			.woocommerce ul.products li .thumbnail .caption .gg-product-meta a.compare:before,
			.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
			.woocommerce-page .widget_price_filter .ui-slider .ui-slider-range {
				background-color: <?php echo get_theme_mod('tertiary-color','#d9e2e9'); ?>;
			}

			.single-product.woocommerce .thumbnails #slider-prev,
			.single-product.woocommerce .thumbnails #slider-next {
				background: <?php echo get_theme_mod('tertiary-color','#d9e2e9'); ?> !important;
			}

			#recentcomments li:before,
			.widget.widget_archive li:before,
			.widget.contact h5,
			.widget.contact i,
			.testimonials-grid blockquote.bubble i,
			.testimonials-grid blockquote.bubble cite,
			.pagination > .disabled,
			.pagination > .disabled span,
			.counter-holder em,
			.counter-holder i,
			.main-menu-wrapper ul.navbar-form li ul li input.search-field,
			#subheader .page-title h1 .category-archive-meta p,
			#subheader .gg-breadcrumbs,
			aside.sidebar-nav .widget .social-icons-widget ul li a,
			.social-icons-widget ul li a,
			aside.sidebar-nav .widget ul ul.children li:before,
			footer.site-footer .widget ul ul.children li:before,
			.post-edit-link,
			.vc_inline-link,
			article.post footer ul.post-tags li a,
			p.meta,
			p.meta a,
			.woocommerce .products .star-rating, 
			.woocommerce-page .products .star-rating,
			.woocommerce .woocommerce-product-rating,
			.woocommerce-page .woocommerce-product-rating,
			.woocommerce ul.products li.product .price del,
			.woocommerce-page ul.products li.product .price del,
			.widget.widget_display_forums li:before,
			.widget.widget_display_topics li:before {
				color: <?php echo get_theme_mod('tertiary-color','#d9e2e9'); ?>;
			}
		<?php } ?>

		<?php if (get_theme_mod('primary-accent-color','#ff5454') != '#ff5454') { ?>
			.header_mini_cart ul.mini-cart li a.cart-parent .badge,
			.woocommerce span.onsale,
			.woocommerce-page span.onsale {
				background-color: <?php echo get_theme_mod('primary-accent-color','#ff5454'); ?>;
			}
			.header_mini_cart ul.mini-cart span.amount {
				color: <?php echo get_theme_mod('primary-accent-color','#ff5454'); ?>;
			}
			aside.sidebar-nav .widget.bbp_widget_login {
				border-color: <?php echo get_theme_mod('primary-accent-color','#ff5454'); ?>;
			}
		<?php } ?>

		<?php if (get_theme_mod('tertiary-accent-color','#f7f8f8') != '#f7f8f8') { ?>
			#subheader,
			article.format-quote .quote-container,
			.widget.twitter-widget ul li,
			.related-projects,
			.widget.widget_tag_cloud ul.wp-tag-cloud li,
			article.format-chat .entry-content p:nth-of-type(even),
			.project-description .post-social ul li a,
			aside .widget .post-format,
			.wpb-js-composer .wpb_content_element .wpb_tour_tabs_wrapper .wpb_tabs_nav a,
			.wpb-js-composer .wpb_content_element .wpb_accordion_header a,
			.wpb-js-composer .vc_call_to_action,
			.woocommerce .cart-collaterals .cart_totals table,
			.woocommerce-page .cart-collaterals .cart_totals table,
			.woocommerce #content div.product form.cart .variations,
			.woocommerce div.product form.cart .variations,
			.woocommerce-page #content div.product form.cart .variations,
			.woocommerce-page div.product form.cart .variations,
			mark,
			.mark {
				background-color: <?php echo get_theme_mod('tertiary-accent-color','#f7f8f8'); ?>;
			}
			.widget.twitter-widget ul li:after {
			  border-top-color: <?php echo get_theme_mod('tertiary-accent-color','#f7f8f8'); ?>;
			}
			.widget.twitter-widget ul li:before {
			  border-top-color: <?php echo get_theme_mod('tertiary-accent-color','#f7f8f8'); ?>;
			}
			.error404 #content .gg-404 {
				color: <?php echo get_theme_mod('tertiary-accent-color','#f7f8f8'); ?>;
			}
			.wpb-js-composer .vc_call_to_action {
				border-color: <?php echo get_theme_mod('tertiary-accent-color','#f7f8f8'); ?>;
			}

			.bbp-topics-front ul.super-sticky,
			.bbp-topics ul.super-sticky,
			.bbp-topics ul.sticky,
			.bbp-forum-content ul.sticky {
				background-color: <?php echo get_theme_mod('tertiary-accent-color','#f7f8f8'); ?> !important;
			}
		<?php } ?>

		<?php if (get_theme_mod('special-accent-color','#9ce2ff') != '#9ce2ff') { ?>
			.featured-icon-box i,
			.single-icon-box i {
			  color: <?php echo get_theme_mod('special-accent-color','#9ce2ff'); ?>;
			}
			.featured-icon-box.icn_has_border .icn-holder,
			.single-icon-box.icn_has_border .icn-holder {
				border-color: <?php echo get_theme_mod('special-accent-color','#9ce2ff'); ?>; 
			}
		<?php } ?>

		<?php 
		//Always at the end of the file
		if (get_theme_mod('custom_css') != '') {
			echo get_theme_mod('custom_css');
		} 
		?>

	</style>
    <?php
}

if ( ! is_admin() ) {
	add_action( 'wp_head', 'mytheme_customize_css');
}


