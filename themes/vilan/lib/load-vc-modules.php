<?php
//Remove default vc modules
include PARENT_DIR.'/lib/visualcomposer/gg-remove-default.php';

//Default arrays
include PARENT_DIR.'/lib/visualcomposer/default-arrays.php';

include PARENT_DIR.'/lib/visualcomposer/gg-testimonials.php';
include PARENT_DIR.'/lib/visualcomposer/gg-portfolio.php';
include PARENT_DIR.'/lib/visualcomposer/gg-team.php';
include PARENT_DIR.'/lib/visualcomposer/gg-posts.php';
include PARENT_DIR.'/lib/visualcomposer/gg-featured-image.php';
include PARENT_DIR.'/lib/visualcomposer/gg-featured-icon.php';
include PARENT_DIR.'/lib/visualcomposer/gg-single-icon.php';
include PARENT_DIR.'/lib/visualcomposer/gg-title-subtitle.php';
include PARENT_DIR.'/lib/visualcomposer/gg-panel.php';
include PARENT_DIR.'/lib/visualcomposer/gg-counter.php';
include PARENT_DIR.'/lib/visualcomposer/gg-contact-form.php';
include PARENT_DIR.'/lib/visualcomposer/gg-lists.php';
include PARENT_DIR.'/lib/visualcomposer/gg-blockquote.php';
include PARENT_DIR.'/lib/visualcomposer/gg-bw-map.php';

//Widgets
include PARENT_DIR.'/lib/visualcomposer/gg-widget-contact-us.php';
include PARENT_DIR.'/lib/visualcomposer/gg-widget-newsletter.php';
include PARENT_DIR.'/lib/visualcomposer/gg-widget-recent-posts-thumb.php';
include PARENT_DIR.'/lib/visualcomposer/gg-widget-twitter.php';

//Overwrites
//include PARENT_DIR.'/lib/visualcomposer/gg-overwrite-button.php';
include PARENT_DIR.'/lib/visualcomposer/gg-overwrite-button2.php';
include PARENT_DIR.'/lib/visualcomposer/gg-overwrite-cta.php';
include PARENT_DIR.'/lib/visualcomposer/gg-overwrite-row.php';
include PARENT_DIR.'/lib/visualcomposer/gg-overwrite-column.php';
include PARENT_DIR.'/lib/visualcomposer/gg-overwrite-image-carousel.php';
include PARENT_DIR.'/lib/visualcomposer/gg-overwrite-image-gallery.php';
include PARENT_DIR.'/lib/visualcomposer/gg-overwrite-single-image.php';

include PARENT_DIR.'/lib/visualcomposer/gg-woocommerce.php';

//Deregister styles
add_action( 'wp_enqueue_scripts', 'remove_vc_styles', 99 );
function remove_vc_styles() {
	wp_deregister_style( 'nivo-slider-css' );
	wp_deregister_style( 'nivo-slider-theme' );
	wp_deregister_style( 'flexslider' );
	wp_deregister_style( 'prettyphoto' );
	wp_deregister_style( 'isotope-css' );
}

//Deregister scripts
add_action( 'wp_enqueue_scripts', 'remove_vc_scripts', 99 );
function remove_vc_scripts() {
	wp_deregister_script( 'prettyphoto' );
	wp_deregister_script( 'nivo-slider' );
	wp_deregister_script( 'flexslider' );
	wp_deregister_script( 'prettyphoto' );
	wp_deregister_script( 'isotope' );
	wp_deregister_script( 'jcarousellite' );
}

?>