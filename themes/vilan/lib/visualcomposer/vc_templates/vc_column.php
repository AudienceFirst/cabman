<?php
$output = $padding_string = $el_class = $width = $style = $column_background_color = $padding = '';
extract(shortcode_atts(array(
    'el_class' => '',
    'column_background_color' =>'',
    'padding' => '',
    'margin_bottom' => '',
    'width' => '1/1'
), $atts));

$el_class = $this->getExtraClass($el_class);


$fraction = array('whole' => 0);
preg_match('/^((?P<whole>\d+)(?=\s))?(\s*)?(?P<numerator>\d+)\/(?P<denominator>\d+)$/', $width, $fraction);
$decimal_width = $fraction['whole'] + $fraction['numerator'] / $fraction['denominator'];

$desktop_size = floor( $decimal_width * 12 );

$column_classes = array();
$column_classes[] = 'col-md-'. $desktop_size;
$column_classes[] = $el_class;

if( $padding != '' ) {
    $padding_string = ' padding: '.(preg_match('/(px|em|\%|pt|cm)$/', $padding) ? $padding : $padding.'px').';';
}

if( $column_background_color != '' ) {
	$column_background_color = ' background:'.$column_background_color.';';
}

$style = 'style="'.$column_background_color.$padding_string.'"';

$output .= '<div class="' . implode( ' ', $column_classes ) . ' ">';

$output .= "\n\t\t".'<div class="wpb_wrapper" '.$style.'>';
$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
$output .= "\n\t".'</div> '.$this->endBlockComment($el_class) . "\n";

echo $output;