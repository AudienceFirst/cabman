<?php
extract(shortcode_atts(array(
    'link'          => '',
    'title'         => __('Text on the button', "js_composer"),
    'color'         => '',
    'text_color'    => '',
    'size'          => '',
    'style'         => '',
    'block_button'  => '',
    'icon'          => '',
    'icon_align'    => '',
    'add_icon'      => '',
    'margin'        => '',
    'el_class'      => ''
), $atts));

$class = 'btn';
//parse link
$link = ($link=='||') ? '' : $link;
$link = vc_build_link($link);
$link['target'] = ( $link['target'] == '' ) ? '_self' : $link['target'];
$a_href = $link['url'];
$a_title = $link['title'];
$a_target = $link['target'];

//$class .= ($color!='') ? ' '.$color : '';
$class .= ($size!='') ? ' vc_btn_'.$size : '';
//$class .= ($style!='') ? ' vc_btn_'.$style : '';
$class .= ($block_button =='use_block_button') ? ' btn-block' : '';

switch ($style) {
  case 'rounded':
    $class .= ' btn-primary';
    break;
  case 'square':
    $class .= ' btn-primary btn-square';
    break;
  case 'round':
    $class .= ' btn-primary btn-round';
    break;
  case 'outlined':
    $class .= ' btn-default';
    break;
  case '3d':
    $class .= ' btn-primary btn-3d';
    break;
  case 'square_outlined':
    $class .= ' btn-default btn-square';
    break;          
  default:
    $class .= ' btn-default';
}


$icon_string = '';
if ($add_icon == 'use_icon') {
    $icon_string = ( $icon != '' ) ? ' <i class="'.$icon.' '.$icon_align.'"> </i>' : '';
}

$margin_string = '';
if (!empty($margin)) {
    $margin_string = ' margin: '.$margin.';';
}

$customcolor_string = '';
if ($color != '') {
    $customcolor_string = ' background:'.$color.';';
}

$outlined_string = '';
if (($style == 'outlined') || ($style == 'square_outlined')) {
    $outlined_string = ' border-color:'.$color.';';
}

$text_color_string = '';
if ($text_color != '') {
    $text_color_string = ' color:'.$text_color.';';
}

$style_string = 'style="'.$margin_string.$customcolor_string.$outlined_string.$text_color_string.'"';


$el_class = $this->getExtraClass($el_class);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' '.$class.$el_class, $this->settings['base']);
?>
<a <?php echo $style_string; ?> class="<?php echo esc_attr(trim($css_class)); ?>" href="<?php echo $a_href; ?>" title="<?php echo esc_attr($a_title); ?>" target="<?php echo $a_target; ?>">
    <?php
    if ($icon_align =='pull-left' || $icon_align =='pull-center' ) {
        echo $icon_string; 
    }
    ?>
    <?php echo $title; ?>
    <?php
    if ($icon_align =='pull-right') {
        echo $icon_string; 
    }
    ?>
</a>
<?php echo $this->endBlockComment('vc_button') . "\n";