<?php
/**
 * Default Page Header
 *
 * @package WP-Bootstrap
 * @subpackage WP-Bootstrap
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>

    <?php if (get_theme_mod('favicon_logo')) { ?>
        <link rel="shortcut icon" href="<?php echo esc_url(get_theme_mod('favicon_logo')); ?>">
    <?php } ?>  
       
    <?php wp_head(); ?>

<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>

</head>
<body <?php body_class(); ?>>

<?php
//Default layout style
$layout_style = 'container boxed-container';
if ( 'boxed' === get_theme_mod( 'layout_style', 'boxed') ) {
  $layout_style = 'container boxed-container';
} else { 
  $layout_style = 'full-container';
}
?>

<div id="layout-mode" class="<?php echo esc_attr($layout_style); ?>">

<?php include PARENT_DIR . '/lib/headers/header-default.php'; ?>