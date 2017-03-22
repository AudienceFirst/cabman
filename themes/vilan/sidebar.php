<?php
/**
 * The Right Sidebar displayed on page templates.
 *
 * @package WordPress
 * @subpackage vilan
 */
?>

<?php 
if (function_exists('dynamic_sidebar')) {
	
	if( is_page_template('theme-templates/portfolio.php') ) {
		
		$dynamic_sidebar = 'sidebar-portfolio';

	} elseif( is_page_template('theme-templates/contact.php') ) {
		
		$dynamic_sidebar = 'sidebar-contact';

	} elseif( is_woocommerce_activated() && is_woocommerce() ) {
		
		$dynamic_sidebar = 'sidebar-shop';

	} elseif (class_exists( 'bbPress' ) && is_bbpress() ) {

		$dynamic_sidebar = 'sidebar-bbpress';

	} elseif (defined( 'APP_ECWID_COM' ) && ecwid_page_has_productbrowser() && ecwid_is_store_page_available() ) {

		$dynamic_sidebar = 'sidebar-ecwid';

	} elseif( is_search() ) {
		
		$dynamic_sidebar = 'sidebar-search';			

	} elseif( is_single() || is_home() || is_category() || is_archive() ) {
		
		$dynamic_sidebar = 'sidebar-posts';

	} else { //else default sidebar
		
		$dynamic_sidebar = 'sidebar-page';

	}
}
?>

<?php if ( is_active_sidebar( $dynamic_sidebar ) ) : ?>
    <?php dynamic_sidebar( $dynamic_sidebar ); ?>
<?php endif; ?>