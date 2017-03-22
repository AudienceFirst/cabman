<?php
class YITH_WCMG_Frontend_Mod extends YITH_WCMG_Frontend {

        public function render() {
            if( yith_wcmg_is_enabled() && ! $this->is_video_featured_enabled() ) {
                //change the templates
                remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
                remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
                add_action( 'woocommerce_before_single_product_summary', array($this, 'show_product_images'), 20 );
                add_action( 'woocommerce_product_thumbnails', array($this, 'show_product_thumbnails'), 20 );

                //custom styles and javascripts
                add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );

                //add attributes to product variations
                add_filter( 'woocommerce_available_variation', array( $this, 'available_variation' ), 10, 3);
            }
        }

	public function show_product_images() {

        return 'woot';
	}
	
}
?>